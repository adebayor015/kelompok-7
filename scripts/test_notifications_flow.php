<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Question;
use App\Models\User;
use App\Models\Answer;

// find a question with owner
$question = Question::with('user')->first();
if (!$question) { echo "No question found\n"; exit(1); }
$owner = $question->user;
if (!$owner) { echo "Question owner not found\n"; exit(1); }

// pick or create another user to post an answer
$other = User::where('id','<>',$owner->id)->first();
if (!$other) {
    $other = User::create([ 'name' => 'TempAnswerer', 'email' => 'temp.answerer'.time().'@example.test', 'password' => bcrypt('secret123')]);
}

// create answer as other user
$answer = Answer::create(['question_id' => $question->id, 'user_id' => $other->id, 'content' => 'Test answer at '.now()]);

echo "Created answer id={$answer->id} by user {$other->id} on question {$question->id}\n";
echo "Answer created_at: {$answer->created_at}\n";

// simulate owner session and call notifications
session(['user_id' => $owner->id]);
$response = app()->call(\App\Http\Controllers\ProfileController::class . '@notifications');
if ($response instanceof Illuminate\Http\Response || $response instanceof Illuminate\Http\RedirectResponse) {
    // try to render view by calling view helper isn't straightforward, but ProfileController returns View
    echo "Notifications controller returned response type: " . get_class($response) . "\n";
}

// Instead, directly query the notifications query used in controller
$sessionCutoff = session('last_seen_notifications_at');
$dbCutoff = $owner->last_seen_notifications_at;
$cutoff = null;
if ($sessionCutoff) { $cutoff = \Carbon\Carbon::parse($sessionCutoff); }
elseif ($dbCutoff) { $cutoff = \Carbon\Carbon::parse($dbCutoff); }
else { $cutoff = $owner->created_at ?? now()->subYears(5); }

$answers = Answer::whereHas('question', function($q) use ($owner) { $q->where('user_id', $owner->id); })
    ->where('user_id','<>',$owner->id)
    ->where('created_at','>=',$cutoff)
    ->with(['question','user'])
    ->latest()
    ->get();

echo "Cutoff: {$cutoff}\n";
echo "Answers found since cutoff: " . $answers->count() . "\n";
foreach($answers as $a) {
    echo " - A{$a->id} by U{$a->user_id} at {$a->created_at}\n";
}

// check direct comparison for the last created answer
$lastAns = Answer::latest()->first();
if ($lastAns) {
     $cmp = (\Carbon\Carbon::parse($lastAns->created_at) >= \Carbon\Carbon::parse($cutoff));
     echo "Last answer id={$lastAns->id} created_at={$lastAns->created_at} >= cutoff? " . ($cmp ? 'YES' : 'NO') . "\n";
}

// show owner's last_seen before and after calling controller
$owner->refresh();
echo "Owner last_seen_notifications_at (DB): {$owner->last_seen_notifications_at}\n";

// Done

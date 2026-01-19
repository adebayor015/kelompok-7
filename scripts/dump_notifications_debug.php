<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;

$uid = 1; // adjust if needed
$user = User::find($uid);
if (!$user) { echo "User $uid not found\n"; exit(1); }

echo "User id={$user->id} name={$user->name}\n";
echo "last_login_at: " . ($user->last_login_at ?? 'NULL') . "\n";
echo "last_seen_notifications_at: " . ($user->last_seen_notifications_at ?? 'NULL') . "\n";

$questions = Question::where('user_id', $user->id)->pluck('id')->toArray();
if (empty($questions)) { echo "User has no questions\n"; exit(0); }

echo "User questions ids: " . implode(',', $questions) . "\n";

$answers = Answer::whereIn('question_id', $questions)->with('question','user')->latest()->take(20)->get();
if ($answers->isEmpty()) { echo "No answers on user's questions\n"; exit(0); }

foreach ($answers as $a) {
    echo "Answer id={$a->id} question_id={$a->question_id} by={$a->user_id} at={$a->created_at} content_snippet='".substr($a->content,0,40)."'\n";
}

// compute cutoff
$sessionCutoff = session('last_seen_notifications_at');
$dbCutoff = $user->last_seen_notifications_at;
$cutoff = null;
if ($sessionCutoff) {
    $cutoff = \Carbon\Carbon::parse($sessionCutoff);
    echo "session cutoff: {$sessionCutoff}\n";
}
if ($dbCutoff) {
    echo "db cutoff: {$dbCutoff}\n";
    if (!$cutoff) $cutoff = \Carbon\Carbon::parse($dbCutoff);
}
if (!$cutoff) echo "no cutoff (null)\n";

// list answers newer than/equal cutoff
if ($cutoff) {
    $new_all = Answer::whereIn('question_id', $questions)->where('created_at','>=',$cutoff)->get();
    $new_excluding_owner = Answer::whereIn('question_id', $questions)->where('user_id','<>',$user->id)->where('created_at','>=',$cutoff)->get();
    echo "Answers >= cutoff (all): " . $new_all->count() . "\n";
    foreach($new_all as $a) echo " - A{$a->id} at {$a->created_at} by {$a->user_id}\n";
    echo "Answers >= cutoff (excluding owner): " . $new_excluding_owner->count() . "\n";
    foreach($new_excluding_owner as $a) echo " - (ex) A{$a->id} at {$a->created_at} by {$a->user_id}\n";
}

echo "Done\n";

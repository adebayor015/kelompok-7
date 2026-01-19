<?php
// Bootstrap Laravel and call ProfileController::update for user_id=1
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// set session user
session(['user_id' => 1]);

// prepare request data
$data = [
    'name' => 'Test Updated Name',
    'email' => 'testupdated@example.com',
    'bio' => 'Bio updated via script',
    'avatar_choice' => 'avatars/choice3.svg'
];

$request = new Illuminate\Http\Request($data);
$response = app()->call(\App\Http\Controllers\ProfileController::class . '@update', ['request' => $request]);

// fetch user after update
$user = App\Models\User::find(1);

echo "Controller response type: " . get_class($response) . PHP_EOL;
if ($response instanceof Illuminate\Http\RedirectResponse) {
    echo "Redirect to: " . $response->getTargetUrl() . PHP_EOL;
}

echo "User after update:\n";
echo json_encode([ 'id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'bio' => $user->bio, 'avatar' => $user->avatar ], JSON_PRETTY_PRINT) . PHP_EOL;

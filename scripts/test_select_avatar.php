<?php
// Bootstrap Laravel and call ProfileController::selectAvatar for user_id=1
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Ensure session store is available
session(['user_id' => 1]);

$request = new Illuminate\Http\Request(['avatar_choice' => 'avatars/choice2.svg']);
$response = app()->call(\App\Http\Controllers\ProfileController::class . '@selectAvatar', ['request' => $request]);

if ($response instanceof Illuminate\Http\JsonResponse) {
    echo $response->getContent() . PHP_EOL;
} else if ($response instanceof Symfony\Component\HttpFoundation\Response) {
    echo $response->getContent() . PHP_EOL;
} else {
    var_export($response);
}

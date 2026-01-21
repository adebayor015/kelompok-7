<?php

require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = app();
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$topics = \DB::table('topics')->get();

echo "Total Topics: " . count($topics) . "\n\n";
foreach($topics as $t) {
    echo "ID: {$t->id}, Name: {$t->name}, Slug: {$t->slug}\n";
}

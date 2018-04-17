<?php

use App\Jobs\ProcessTask;
use App\Task;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('downloader:add {url}', function ($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $this->info("$url is not a valid URL");
        return;
    }

    $task = Task::create([
        'link'   => $url,
        'status' => 'pending'
    ]);

    ProcessTask::dispatch($task);
    $this->info("$url added to download queue");
});

Artisan::command('downloader:status', function () {
    $headers = ['id', 'link', 'status', 'file url'];
    $data = [];

    $tasks = Task::orderBy('created_at', 'DESC')->get();

    foreach ($tasks as $task) {
        $data[] = [
            "id"   => $task->id,
            "link" => $task->link,
            "status" => $task->status,
            "file_url" => $task->file_url
        ];
    }

    $this->table($headers, $data);
});
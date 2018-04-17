<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ProcessTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->task->update(['status' => 'in progress']);
            sleep(10);
            ini_set('memory_limit', '-1');  // Turn off limit for downloading
            $fileName = $this->task->id . "-" . str_random(2) . "-" . preg_replace('/\?.*/', '', last(explode("/", $this->task->link)));
            $filePath = "downloads/" . $fileName;

            Storage::put($filePath, fopen($this->task->link, 'r'), [
                'visibility' => 'public'
            ]);

            $this->task->update([
                'file_url' => $fileName,
                'status' => 'completed'
            ]);
        } catch (\Exception $e) {
            $this->task->update(['status' => 'error']);
            \Log::error($e->getMessage());
        }
    }
}

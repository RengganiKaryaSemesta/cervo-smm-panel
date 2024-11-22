<?php

namespace App\Jobs;

use App\Models\InstagramService;
use App\Enums\InstagramServiceType;
use App\Notifications\TaskAssigned;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class InstagramServiceJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // public InstagramService $instagramService;
    public function __construct(public InstagramService $instagramService, public $comments = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $instagramServiceProcess = new \App\Services\Instagram\InstagramService;
        if ($this->instagramService->type == InstagramServiceType::Like) {
            $instagramServiceProcess->like($this->instagramService);
        }
        if ($this->instagramService->type == InstagramServiceType::Comment) {
            $instagramServiceProcess->comment(
                $this->instagramService,
                $this->comments
            );
        }
        if ($this->instagramService->type == InstagramServiceType::Follow) {
            $instagramServiceProcess->follow(
                $this->instagramService
            );
        }
       Notification::sendNow($this->instagramService->creator, new TaskAssigned(['title' => 'Process Completed', 'detail' => 'Please check your report at Instagram Report -> '.$this->instagramService->type->value]));
    }
}

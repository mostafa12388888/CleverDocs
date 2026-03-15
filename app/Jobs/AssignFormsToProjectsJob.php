<?php

namespace App\Jobs;

use App\Services\Form\TemplateFormProjectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignFormsToProjectsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $projectId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        App(TemplateFormProjectService::class)->attachPrimaryFormsToProject($this->projectId);
    }
}

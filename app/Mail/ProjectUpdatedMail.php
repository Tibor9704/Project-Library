<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $changes;

    public function __construct($project, $changes)
    {
        $this->project = $project;
        $this->changes = $changes;
    }

    public function build()
    {
        return $this->view('emails.project_updated')
                    ->with([
                        'project' => $this->project,
                        'changes' => $this->changes,
                    ]);
    }
}

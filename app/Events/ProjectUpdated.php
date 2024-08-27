<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Queue\SerializesModels;

class ProjectUpdated
{
    use SerializesModels;

    public $project;
    public $original;
    public $changes;

    public function __construct(Project $project, $original, $changes)
    {
        $this->project = $project;
        $this->original = $original;
        $this->changes = $changes;
    }
}

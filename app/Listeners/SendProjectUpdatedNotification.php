<?php

namespace App\Listeners;

use App\Events\ProjectUpdated;
use Illuminate\Support\Facades\Log;

class SendProjectUpdateNotification
{
    public function handle(ProjectUpdated $event)
    {
        $project = $event->project;
        $original = $event->original;
        $changes = $event->changes;

        $contacts = $project->contacts;

        foreach ($contacts as $contact) {
            $emailContent = view('emails.project_updated', [
                'project' => $project,
                'changes' => $changes
            ])->render();

            Log::info("Pretend sending email to {$contact->email} with subject: Módosítás a projektben: {$project->name}");
            Log::info("Email content:\n{$emailContent}");
        }
    }
}

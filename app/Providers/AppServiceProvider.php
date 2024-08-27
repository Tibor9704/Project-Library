<?php

namespace App\Providers;

use App\Models\Project;
use Illuminate\Support\ServiceProvider;
use App\Events\ProjectUpdated;
use App\Listeners\SendProjectUpdateNotification;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        Project::updating(function ($project) {
            $original = $project->getOriginal();
            $changes = $project->getDirty();

            if (!empty($changes)) {
                Event::dispatch(new ProjectUpdated($project, $original, $changes));
            }
        });

        Event::listen(
            ProjectUpdated::class,
            SendProjectUpdateNotification::class
        );
    }
}

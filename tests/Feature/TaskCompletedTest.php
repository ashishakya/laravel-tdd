<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_task_status_can_be_changed()
    {
        $task = Task::factory()->create();

        $this->patchJson(
            route("api.tasks.update", $task->id),
            ["status" => Task::STARTED]
        );

        $this->assertDatabaseHas("tasks", [
            "status" => Task::STARTED,
        ]);
    }
}

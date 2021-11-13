<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class TaskController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(TodoList $todoList)
    {
        return TaskResource::collection($todoList->tasks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     */
    public function store(Request $request, TodoList $todoList)
    {
        $task = $todoList->tasks()->create($request->all());
        return new TaskResource($task);
    }

    /**
     * @param \App\Models\Task $task
     *
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response("", Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, Task $task)
    {
        return $task->update($request->all());
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
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
    public function index()
    {
        $tasks = Task::all();

        return response($tasks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->all());

        return response([], 201);
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
}

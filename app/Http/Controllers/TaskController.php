<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response($tasks);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        return response(auth()->user()->todoLists);
    }

    public function show($id)
    {
        $list = TodoList::findOrFail($id);

        return response($list);
    }

    public function store(TodoListRequest $request)
    {
        return auth()->user()->todoLists()->create($request->validated());
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();

        return response("", Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todoList->update($request->all());
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class LabelController extends Controller
{

    public function index()
    {
        return auth()->user()->labels;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(LabelRequest $request)
    {
        return auth()->user()->labels()->create($request->validated());
    }

    /**
     * @param \App\Models\Label $label
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $label->delete();

        return response("", Response::HTTP_NO_CONTENT);
    }

    public function update(LabelRequest $request, Label $label)
    {
        return $label->update($request->validated());
    }

}

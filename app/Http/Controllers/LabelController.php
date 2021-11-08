<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

/**
 *
 */
class LabelController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                "title" => "required",
                "colour" => "required",
            ]
        );
        return Label::create($request->all());
    }
}

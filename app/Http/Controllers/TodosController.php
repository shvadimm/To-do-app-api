<?php

namespace App\Http\Controllers;

use App\Models\todos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $current_user_id = Auth::user()->id;
        $todos = todos::where("user_id", $current_user_id)->get();
        return $todos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $todo = todos::create($request->all());
        if (!$todo) return response(['message' => "mising data"], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(todos $todos, $id)
    {
        return todos::where("id", $id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, todos $todos)
    {
        return todos::where("id", $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(todos $todos, $id)
    {
        return todos::where("id", $id)->delete();
    }
}

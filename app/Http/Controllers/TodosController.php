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
        $current_user_id = Auth::id();
        $todos = todos::where("user_id", $current_user_id)->get();
        return $todos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string'
        ]);

        $todo = todos::create($request->all());
        return $todo;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = todos::find($id);
        if (!$todo) {
            return response(['message' => "Todo not found"], 404);
        }
        return $todo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = todos::find($id);
        if (!$todo) {
            return response(['message' => "Todo not found"], 404);
        }

        $todo->update($request->all());
        return $todo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = todos::find($id);
        if (!$todo) {
            return response(['message' => "Todo not found"], 404);
        }

        $todo->delete();
        return response(['message' => "Todo deleted successfully"], 200);
    }
}

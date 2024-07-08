<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruction;

class InstructionController extends Controller
{
    public function showInstructions()
    {
        $instructions = Instruction::all();
        return response()->json($instructions);
    }
    public function index()
    {
        $instructions = Instruction::all(); // Fetch all instructions from the database

        return view('admin.instructions.index', compact('instructions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);

        Instruction::create($request->all());

        return redirect()->route('admin.instructions.index')->with('success', 'Instruction added successfully.');
    }

    public function edit($id)
{
    $instruction = Instruction::findOrFail($id);
    return view('admin.instructions.edit', compact('instruction')); // Pass only $instruction, not $instructions
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);

        $instruction = Instruction::findOrFail($id);
        $instruction->update($request->all());

        return redirect()->route('admin.instructions.index')->with('success', 'Instruction updated successfully.');
    }

    public function destroy($id)
    {
        $instruction = Instruction::findOrFail($id);
        $instruction->delete();

        return redirect()->route('admin.instructions.index')->with('success', 'Instruction deleted successfully.');
    }
}

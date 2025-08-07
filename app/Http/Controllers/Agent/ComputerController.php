<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index()
    {
        $computers = Computer::all(); // o filtrado según agente
        return view('agent.computers.index', compact('computers'));
    }

    public function show(Computer $computer)
    {
        return view('agent.computers.show', compact('computer'));
    }

    public function edit(Computer $computer)
    {
        return view('agent.computers.edit', compact('computer'));
    }

    public function update(Request $request, Computer $computer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            // otros campos...
        ]);

        $computer->update($data);

        return redirect()->route('agent.computers.index')->with('success', 'Computadora actualizada.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SystemStatus;
use App\Models\SystemStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemStatusController extends Controller
{
    public function index()
    {
        $systemStatuses = SystemStatus::orderBy('service_name')->get();
        return view('admin.system-status.index', compact('systemStatuses'));
    }

    public function create()
    {
        return view('admin.system-status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'status' => 'required|in:operational,degraded,outage,maintenance',
            'description' => 'nullable|string'
        ]);

        $systemStatus = SystemStatus::create([
            'service_name' => $request->service_name,
            'status' => $request->status,
            'description' => $request->description,
            'last_updated' => now()
        ]);

        // Registrar log de creación
        SystemStatusLog::create([
            'system_status_id' => $systemStatus->id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => now(),
        ]);

        return redirect()->route('admin.system-status.index')
            ->with('success', 'Estado del sistema creado exitosamente.');
    }

    public function edit(SystemStatus $systemStatus)
    {
        return view('admin.system-status.edit', compact('systemStatus'));
    }

    public function update(Request $request, SystemStatus $systemStatus)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'status' => 'required|in:operational,degraded,outage,maintenance',
            'description' => 'nullable|string'
        ]);

        $systemStatus->update([
            'service_name' => $request->service_name,
            'status' => $request->status,
            'description' => $request->description,
            'last_updated' => now()
        ]);

        // Registrar log de cambio
        SystemStatusLog::create([
            'system_status_id' => $systemStatus->id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => now(),
        ]);

        return redirect()->route('admin.system-status.index')
            ->with('success', 'Estado del sistema actualizado exitosamente.');
    }

    public function destroy(SystemStatus $systemStatus)
    {
        $systemStatus->delete();
        return redirect()->route('admin.system-status.index')
            ->with('success', 'Estado del sistema eliminado exitosamente.');
    }

    public function quickUpdate(Request $request, SystemStatus $systemStatus)
    {
        $request->validate([
            'status' => 'required|in:operational,degraded,outage,maintenance',
            'description' => 'nullable|string'
        ]);

        $systemStatus->update([
            'status' => $request->status,
            'description' => $request->description,
            'last_updated' => now()
        ]);

        // Registrar log de cambio rápido
        SystemStatusLog::create([
            'system_status_id' => $systemStatus->id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente',
            'status' => $systemStatus->status,
            'status_text' => $systemStatus->status_text,
            'status_color' => $systemStatus->status_color
        ]);
    }
}

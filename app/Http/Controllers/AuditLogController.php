<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view audit logs');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditLogs = AuditLog::with('user')->orderBy('created_at', 'desc')->paginate(50);
        return view('audit-logs.index', compact('auditLogs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        return view('audit-logs.show', compact('auditLog'));
    }

    /**
     * Show the form for creating a new resource.
     * Not allowed for audit logs.
     */
    public function create()
    {
        abort(403, 'Audit logs cannot be created manually.');
    }

    /**
     * Store a newly created resource in storage.
     * Not allowed for audit logs.
     */
    public function store(Request $request)
    {
        abort(403, 'Audit logs cannot be created manually.');
    }

    /**
     * Show the form for editing the specified resource.
     * Not allowed for audit logs.
     */
    public function edit(AuditLog $auditLog)
    {
        abort(403, 'Audit logs cannot be edited.');
    }

    /**
     * Update the specified resource in storage.
     * Not allowed for audit logs.
     */
    public function update(Request $request, AuditLog $auditLog)
    {
        abort(403, 'Audit logs cannot be updated.');
    }

    /**
     * Remove the specified resource from storage.
     * Not allowed for audit logs.
     */
    public function destroy(AuditLog $auditLog)
    {
        abort(403, 'Audit logs cannot be deleted.');
    }
}

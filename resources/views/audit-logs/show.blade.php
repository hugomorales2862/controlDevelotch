<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('audit-logs.index') }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                Detalle del Registro de <span class="text-[#00f6ff]">Auditoría</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Tarjeta de Metadatos -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-6 border-b border-[#1e293b]">
                    <div>
                        <p class="text-xs font-bold tracking-widest text-[#00f6ff] uppercase mb-1">Modelo Afectado</p>
                        <h3 class="text-xl font-semibold text-white">{{ $auditLog->model_type }} <span class="text-slate-500">#{{ $auditLog->model_id }}</span></h3>
                    </div>
                    
                    <div class="text-left md:text-right">
                        <p class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Acción Realizada</p>
                        @if($auditLog->action === 'created')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">CREACIÓN DE REGISTRO</span>
                        @elseif($auditLog->action === 'updated')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">ACTUALIZACIÓN DE RÉCORD</span>
                        @elseif($auditLog->action === 'deleted')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">ELIMINACIÓN DE DATOS</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-500/10 text-slate-400 border border-slate-500/20">{{ strtoupper($auditLog->action) }}</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#0B1120] p-4 rounded-xl border border-[#1e293b]">
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-1">Usuario / Actor</p>
                        <p class="font-medium text-white">{{ $auditLog->user ? $auditLog->user->name : 'N/A' }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $auditLog->user ? $auditLog->user->email : 'Sistema Automatizado' }}</p>
                    </div>
                    
                    <div class="bg-[#0B1120] p-4 rounded-xl border border-[#1e293b]">
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-1">Fecha y Hora</p>
                        <p class="font-medium text-white">{{ $auditLog->created_at->format('d M, Y') }}</p>
                        <p class="text-xs text-[#00f6ff] mt-1">{{ $auditLog->created_at->format('H:i:s') }}</p>
                    </div>

                    <div class="bg-[#0B1120] p-4 rounded-xl border border-[#1e293b]">
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-1">Dirección IP</p>
                        <p class="font-mono text-sm text-white mt-1">{{ $auditLog->ip_address ?: '127.0.0.1' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Cambios (JSON Delta) -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="px-6 py-4 bg-[#0B1120] border-b border-[#1e293b]">
                <h3 class="font-semibold text-white tracking-wide">Carga Útil del Evento (Delta)</h3>
            </div>
            <div class="p-0">
                @php
                    $old = is_string($auditLog->old_values) ? json_decode($auditLog->old_values, true) : ($auditLog->old_values ?? []);
                    $new = is_string($auditLog->new_values) ? json_decode($auditLog->new_values, true) : ($auditLog->new_values ?? []);
                    $old = is_array($old) ? $old : [];
                    $new = is_array($new) ? $new : [];
                    $allKeys = array_unique(array_merge(array_keys($old), array_keys($new)));
                @endphp
                
                @if(empty($allKeys))
                    <div class="p-8 text-center text-slate-500">
                        <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p>No se registraron deltas en los atributos.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="text-[10px] uppercase tracking-wider bg-[#0f172a] text-slate-400 border-b border-[#1e293b]">
                                <tr>
                                    <th class="px-6 py-3 w-1/4">Campo Atributo</th>
                                    <th class="px-6 py-3 w-3/8 text-rose-400 border-l border-[#1e293b]">Valor Anterior (Old)</th>
                                    <th class="px-6 py-3 w-3/8 text-emerald-400 border-l border-[#1e293b]">Valor Nuevo (New)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1e293b]">
                                @foreach($allKeys as $key)
                                    @php
                                        $valOld = array_key_exists($key, $old) ? $old[$key] : null;
                                        $valNew = array_key_exists($key, $new) ? $new[$key] : null;
                                        // Highlight si cambió
                                        $hasChanged = (string)$valOld !== (string)$valNew && $auditLog->action === 'updated';
                                    @endphp
                                    <tr class="hover:bg-[#0B1120] transition-colors {{ $hasChanged ? 'bg-[#00f6ff]/5' : '' }}">
                                        <td class="px-6 py-4 font-mono text-xs {{ $hasChanged ? 'text-[#00f6ff]' : 'text-slate-400' }}">
                                            {{ $key }}
                                        </td>
                                        <td class="px-6 py-4 border-l border-[#1e293b] break-all">
                                            @if(is_array($valOld) || is_object($valOld))
                                                <pre class="text-[11px] text-rose-300 bg-rose-500/10 p-2 rounded">{{ json_encode($valOld, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                <span class="{{ $valOld === null ? 'text-slate-600 italic' : 'text-rose-200' }}">
                                                    {{ $valOld === null ? 'null' : (string)$valOld }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 border-l border-[#1e293b] break-all">
                                            @if(is_array($valNew) || is_object($valNew))
                                                <pre class="text-[11px] text-emerald-300 bg-emerald-500/10 p-2 rounded">{{ json_encode($valNew, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                <span class="{{ $valNew === null ? 'text-slate-600 italic' : 'text-emerald-200' }}">
                                                    {{ $valNew === null ? 'null' : (string)$valNew }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</x-app-layout>

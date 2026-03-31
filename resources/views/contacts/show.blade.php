<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Detalles del Contacto') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('clients.contacts.index', $client) }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                <a href="{{ route('clients.contacts.edit', [$client, $contact]) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Contact Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">{{ $contact->name }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                        Contacto
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Cliente</p>
                        <p class="text-sm font-medium text-white">{{ $client->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Cargo / Rol</p>
                        <p class="text-sm font-medium text-white">{{ $contact->role ?: 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Correo Electrónico</p>
                        <p class="text-sm font-medium text-white">
                            @if($contact->email)
                                <a href="mailto:{{ $contact->email }}" class="hover:text-[#00f6ff] transition-colors">{{ $contact->email }}</a>
                            @else
                                No registrado
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Teléfono</p>
                        <p class="text-sm font-medium text-white">{{ $contact->phone ?: 'No registrado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
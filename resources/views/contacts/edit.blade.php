<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">{{ __('Editar Contacto de ') . $client->name }}</h2>
    </x-slot>
    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('clients.contacts.update', [$client, $contact]) }}" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre</label>
                            <input id="name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="name" value="{{ old('name', $contact->name) }}" required />
                        </div>
                        <div>
                            <label for="email" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Correo</label>
                            <input id="email" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="email" name="email" value="{{ old('email', $contact->email) }}" />
                        </div>
                        <div>
                            <label for="phone" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Teléfono</label>
                            <input id="phone" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="phone" value="{{ old('phone', $contact->phone) }}" />
                        </div>
                        <div>
                            <label for="role" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Cargo / Rol</label>
                            <input id="role" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="role" value="{{ old('role', $contact->role) }}" placeholder="Ej: Gerente, CTO, Contador..." />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('clients.contacts.index', $client) }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">Actualizar Contacto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                        <div class="md:col-span-2">
                            <label for="role" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Cargo / Rol</label>
                            <input id="role" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="role" value="{{ old('role', $contact->role) }}" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('clients.contacts.index', $client) }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">Actualizar Contacto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

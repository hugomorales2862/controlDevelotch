<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                Envío Manual de <span class="text-[#00f6ff]">Correos</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form action="{{ route('emails.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Seleccionar Cliente -->
                        <div>
                            <label for="client_id" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Cliente Destino
                            </label>
                            <select name="client_id" id="client_id" 
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white font-medium py-3 px-4 transition-colors" required>
                                <option value="" disabled selected>-- Elija un cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}">{{ $client->name }} ({{ $client->email }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Asunto -->
                        <div>
                            <label for="subject" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Asunto del Correo
                            </label>
                            <input type="text" name="subject" id="subject" 
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4 transition-colors" 
                                required placeholder="Ej: Recordatorio de pago" value="{{ old('subject') }}">
                            <x-input-error :messages="$errors->get('subject')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Mensaje -->
                        <div>
                            <label for="message" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Mensaje a Enviar
                            </label>
                            <textarea name="message" id="message" rows="6" 
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4 font-mono text-sm transition-colors" 
                                required placeholder="Escriba el cuerpo del correo aquí...">{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] shadow-[0_0_15px_rgba(0,246,255,0.2)] focus:outline-none transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"/></svg>
                            Enviar Correo Confirmado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

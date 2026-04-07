<div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }} animate-in fade-in slide-in-from-bottom-2 duration-300">
    <div class="max-w-[85%] sm:max-w-[70%] rounded-2xl p-4 {{ $message->user_id == Auth::id() ? 'bg-indigo-600/20 border border-indigo-500/30 text-white' : 'bg-[#1e293b] border border-white/5 text-slate-300' }}">
        <div class="flex items-center gap-3 mb-1.5 opacity-80">
            <span class="text-[9px] font-black uppercase tracking-widest">{{ $message->user->name }}</span>
            <span class="text-[8px] font-bold text-slate-500 italic">{{ $message->created_at->format('H:i') }}</span>
        </div>
        <div class="text-sm leading-relaxed">
            {!! nl2br(e($message->message)) !!}
        </div>
    </div>
</div>

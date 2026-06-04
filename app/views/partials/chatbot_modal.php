<!-- ═══════════════════════════════════════════════════════════
     MODAL DEL CHATBOT — se incluye en el layout global
     Se abre con: openChatbotModal()
     ═══════════════════════════════════════════════════════════ -->

<div id="chatbotModal" class="fixed inset-0 z-50 hidden flex-col justify-end" role="dialog" aria-modal="true" aria-labelledby="chatbotTitle">
    <!-- Backdrop oscuro -->
    <div id="chatbotBackdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeChatbotModal()"></div>

    <!-- Drawer Inferior -->
    <div class="relative w-full max-w-3xl mx-auto bg-white rounded-t-[32px] shadow-[0_-8px_40px_rgba(0,0,0,0.12)] p-6 md:p-10 transform translate-y-0 animate-[slideUp_0.3s_ease-out]">
        
        <!-- Botón cerrar (Esquina) -->
        <button onclick="closeChatbotModal()" class="absolute top-6 right-6 p-2 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors focus:outline-none">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>

        <!-- Handle (Visual, como en móviles) -->
        <div class="flex justify-center mb-8">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full cursor-pointer" onclick="closeChatbotModal()"></div>
        </div>
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <h2 id="chatbotTitle" class="font-headline-md text-on-surface mb-2 text-2xl font-bold">Hola, ¿en qué te puedo ayudar hoy?</h2>
            <p class="text-tertiary font-body-sm text-slate-500">Selecciona una de las opciones frecuentes para comenzar.</p>
        </div>
        
        <!-- Interactive Grid Buttons -->
        <div class="grid grid-cols-2 gap-4 md:gap-6">
            <!-- Agenda Cita -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[32px]">calendar_month</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center font-semibold">Agenda Cita</span>
            </button>
            
            <!-- Cancelar Cita -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[32px]">cancel</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center font-semibold">Cancelar Cita</span>
            </button>
            
            <!-- Reprogramar -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[32px]">sync</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center font-semibold">Reprogramar</span>
            </button>
            
            <!-- Recursos de ayuda -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[32px]">auto_stories</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center text-balance font-semibold">Recursos de ayuda</span>
            </button>
        </div>
        
        <!-- Bottom Spacer -->
        <div class="h-8"></div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
</style>

<script>
    function openChatbotModal() {
        const m = document.getElementById('chatbotModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeChatbotModal() {
        const m = document.getElementById('chatbotModal');
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeChatbotModal();
    });
</script>

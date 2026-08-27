<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Presentación 2 (Vacía)
     ═══════════════════════════════════════════════════════════ -->
<style>
    @keyframes nebula-flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-nebula {
        background: linear-gradient(270deg, #10b981, #2563eb, #34d399, #3b82f6);
        background-size: 300% 300%;
        animation: nebula-flow 8s ease infinite;
    }
</style>
<section class="min-h-screen py-16 px-6 bg-nebula flex flex-col items-center justify-center w-full relative">
    
    <!-- Botón para volver atrás -->
    <div class="w-full max-w-6xl mb-6">
        <a href="<?= URL_BASE ?>pages/presentacion" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm w-max">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Volver</span>
        </a>
    </div>

    <!-- Tarjeta de Objetivo del Proyecto -->
    <div class="w-full max-w-6xl min-h-[60vh] bg-white rounded-3xl shadow-2xl border-4 border-solid border-slate-200 p-12 md:p-20 flex flex-col items-center justify-center text-center space-y-10">
        
        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-full mb-4">
            <span class="material-symbols-outlined text-[40px]">target</span>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-emerald-500 bg-clip-text text-transparent">Objetivo General</h2>
        
        <p class="text-2xl md:text-3xl text-slate-700 leading-relaxed max-w-4xl font-medium" style="font-family: 'Canva Sans', sans-serif;">
            Desarrollar un aplicativo web para la gestión y agendamiento de citas psicológicas en la I.E. Barrio Santa Margarita, mediante un stack tecnológico integral, librerías de código y APIs variadas, a raíz de las limitaciones del sistema actual, con el fin de optimizar la asignación de consultas, automatizar recordatorios y garantizar un acompañamiento continuo y confidencial.
        </p>
        
    </div>

</section>

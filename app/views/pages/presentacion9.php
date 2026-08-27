<!-- PSYCO — Presentación 9 -->
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
<section class="min-h-screen py-16 px-6 bg-nebula flex flex-col items-center justify-center w-full">

    <!-- Tarjeta vacía -->
    <div class="w-full max-w-6xl min-h-[60vh] bg-white rounded-3xl shadow-2xl border-4 border-solid border-slate-200 p-12 flex flex-col items-center justify-center">
    </div>

    <!-- Navegación -->
    <div class="w-full max-w-6xl mt-6 flex justify-between items-center">
        <a href="<?= URL_BASE ?>pages/presentacion8" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Volver</span>
        </a>
        <a href="<?= URL_BASE ?>pages/presentacion10" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="font-bold">Siguiente</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>

</section>

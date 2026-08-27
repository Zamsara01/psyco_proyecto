<!-- PSYCO — Presentación 4 -->
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
    .text-nebula {
        background: linear-gradient(270deg, #10b981, #2563eb, #34d399, #3b82f6);
        background-size: 300% 300%;
        animation: nebula-flow 8s ease infinite;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
    }
</style>
<section class="min-h-screen py-16 px-6 bg-nebula flex flex-col items-center justify-center w-full">

    <!-- Tarjeta Objetivo Económico -->
    <div class="w-full max-w-6xl min-h-[60vh] bg-white rounded-3xl shadow-2xl border-4 border-solid border-slate-200 p-12 md:p-16 flex flex-col justify-center space-y-10">

        <!-- Título Objetivo Económico -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-nebula tracking-wide mb-6" style="font-family: 'Canva Sans', sans-serif;">
                ◆ OBJETIVO ECONÓMICO
            </h2>
            <p class="text-xl md:text-2xl font-bold text-slate-800 leading-relaxed uppercase" style="font-family: 'Canva Sans', sans-serif;">
                OPTIMIZAR LOS RECURSOS ECONÓMICOS Y ADMINISTRATIVOS DE LA I.E. BARRIO SANTA MARGARITA MEDIANTE LA DIGITALIZACIÓN Y AUTOMATIZACIÓN DE LOS PROCESOS RELACIONADOS CON LA GESTIÓN DE CITAS PSICOLÓGICAS.
            </p>
        </div>

        <hr class="border-slate-200">

        <!-- Componentes -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-nebula tracking-wide mb-8" style="font-family: 'Canva Sans', sans-serif;">
                ◆ COMPONENTES
            </h2>
            <ul class="space-y-6">
                <li class="flex items-start gap-4">
                    <span class="text-4xl">💰</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Reducir costos operativos.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-4xl">🖥️</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Implementar la digitalización.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-4xl">⚙️</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Optimizar procesos administrativos.</span>
                </li>
            </ul>
        </div>

    </div>

    <!-- Navegación -->
    <div class="w-full max-w-6xl mt-6 flex justify-between items-center">
        <a href="<?= URL_BASE ?>pages/presentacion3" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Volver</span>
        </a>
        <a href="<?= URL_BASE ?>pages/presentacion5" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="font-bold">Siguiente</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>

</section>

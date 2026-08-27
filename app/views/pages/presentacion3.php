<!-- PSYCO — Presentación 3 -->
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

    <!-- Tarjeta Objetivo Académico -->
    <div class="w-full max-w-6xl min-h-[60vh] bg-white rounded-3xl shadow-2xl border-4 border-solid border-slate-200 p-12 md:p-16 flex flex-col justify-center space-y-10">

        <!-- Título Objetivo Académico -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-nebula tracking-wide mb-6" style="font-family: 'Canva Sans', sans-serif;">
                ◆ OBJETIVO ACADÉMICO
            </h2>
            <p class="text-xl md:text-2xl font-bold text-slate-800 leading-relaxed uppercase" style="font-family: 'Canva Sans', sans-serif;">
                DESARROLLAR COMPETENCIAS TÉCNICAS EN EL DISEÑO E IMPLEMENTACIÓN DE UN SISTEMA DIGITAL PARA LA GESTIÓN DE CITAS PSICOLÓGICAS.
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
                    <span class="text-4xl">📚</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Adquirir conocimientos técnicos.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-4xl">💻</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Aplicar herramientas digitales.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-4xl">🧠</span>
                    <span class="text-xl md:text-2xl font-semibold text-slate-700" style="font-family: 'Canva Sans', sans-serif;">Fortalecer el aprendizaje práctico.</span>
                </li>
            </ul>
        </div>

    </div>

    <!-- Navegación -->
    <div class="w-full max-w-6xl mt-6 flex justify-between items-center">
        <a href="<?= URL_BASE ?>pages/presentacion2" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Volver</span>
        </a>
        <a href="<?= URL_BASE ?>pages/presentacion4" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="font-bold">Siguiente</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>

</section>

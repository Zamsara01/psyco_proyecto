<!-- PSYCO — Presentación 7 -->
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

    <!-- Tarjeta Objetivo Técnico -->
    <div class="w-full max-w-6xl min-h-[60vh] bg-white rounded-3xl shadow-2xl border-4 border-solid border-slate-200 p-12 md:p-16 flex flex-col justify-center space-y-10">

        <!-- Título Objetivo Técnico -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-nebula tracking-wide mb-6" style="font-family: 'Canva Sans', sans-serif;">
                ◆ OBJETIVO TÉCNICO
            </h2>
            <p class="text-xl md:text-2xl font-bold text-slate-800 leading-relaxed uppercase" style="font-family: 'Canva Sans', sans-serif;">
                Desarrollar un aplicativo web funcional y seguro utilizando tecnologías como HTML, CSS, Bootstrap, JavaScript y PHP, que permita la asignación automática de citas, el registro organizado de consultas y el seguimiento eficiente de los procesos psicológicos.
            </p>
        </div>

        <hr class="border-slate-200">

        <!-- Componentes en Tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="flex flex-col items-center text-center bg-slate-50 rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <span class="text-5xl mb-4">🛠️</span>
                <h3 class="text-xl md:text-2xl font-extrabold text-nebula mb-3" style="font-family: 'Canva Sans', sans-serif;">Tecnologías Clave</h3>
                <p class="text-base md:text-lg font-semibold text-slate-600" style="font-family: 'Canva Sans', sans-serif;">Utilizando HTML, CSS, Bootstrap, JavaScript y PHP.</p>
            </div>
            
            <div class="flex flex-col items-center text-center bg-slate-50 rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <span class="text-5xl mb-4">🤖</span>
                <h3 class="text-xl md:text-2xl font-extrabold text-nebula mb-3" style="font-family: 'Canva Sans', sans-serif;">Asignación Automática</h3>
                <p class="text-base md:text-lg font-semibold text-slate-600" style="font-family: 'Canva Sans', sans-serif;">Permite la asignación automática de citas.</p>
            </div>

            <div class="flex flex-col items-center text-center bg-slate-50 rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <span class="text-5xl mb-4">📁</span>
                <h3 class="text-xl md:text-2xl font-extrabold text-nebula mb-3" style="font-family: 'Canva Sans', sans-serif;">Registro Organizado</h3>
                <p class="text-base md:text-lg font-semibold text-slate-600" style="font-family: 'Canva Sans', sans-serif;">Para el registro organizado de consultas.</p>
            </div>

            <div class="flex flex-col items-center text-center bg-slate-50 rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <span class="text-5xl mb-4">📈</span>
                <h3 class="text-xl md:text-2xl font-extrabold text-nebula mb-3" style="font-family: 'Canva Sans', sans-serif;">Seguimiento Eficiente</h3>
                <p class="text-base md:text-lg font-semibold text-slate-600" style="font-family: 'Canva Sans', sans-serif;">Y el seguimiento eficiente de los procesos psicológicos.</p>
            </div>
            
        </div>

    </div>

    <!-- Navegación -->
    <div class="w-full max-w-6xl mt-6 flex justify-between items-center">
        <a href="<?= URL_BASE ?>pages/presentacion6" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Volver</span>
        </a>
        <a href="<?= URL_BASE ?>pages/presentacion8" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/30 px-5 py-2.5 rounded-2xl backdrop-blur-sm">
            <span class="font-bold">Siguiente</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>

</section>

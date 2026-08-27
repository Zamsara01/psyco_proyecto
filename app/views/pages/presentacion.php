<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Presentación
     ═══════════════════════════════════════════════════════════ -->
<style>
    @keyframes nebula-flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
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
    .bg-nebula {
        background: linear-gradient(270deg, #10b981, #2563eb, #34d399, #3b82f6);
        background-size: 300% 300%;
        animation: nebula-flow 8s ease infinite;
    }
</style>
<section id="presentacion" class="min-h-screen py-16 px-6 bg-nebula flex flex-col items-center justify-center w-full">
    <div class="flex flex-row gap-6 w-full max-w-6xl items-stretch justify-center">
        <!-- Tarjeta Principal (Información) -->
        <div class="w-[70%] p-12 space-y-8 bg-white text-center flex flex-col items-center justify-center rounded-3xl shadow-xl border-4 border-solid border-cyan-200 shrink-0">
            <h2 class="text-[250px] font-bold mb-6 tracking-tight text-nebula drop-shadow-sm leading-none" style="font-family: 'Canva Sans', sans-serif;">Psyco</h2>

            <div class="space-y-8 w-full max-w-lg mx-auto text-black">
                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🧠</span> Integrantes
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">Matías Arboleda · Simón Atehortúa · David Bedoya · Ayleen Martínez</p>
                </div>

                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🏫</span> Institución
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">I.E. Barrio Santa Margarita Medellín<br>17 de abril de 2026</p>
                </div>

                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🧑‍🏫</span> Profesores
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">Jairo Cano - Arnaldo Dominguez - Iván Castro - William Montoya</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta Secundaria (Logos pequeños) -->
        <div class="w-[30%] bg-white p-8 flex flex-col items-center justify-center text-center space-y-8 rounded-3xl shadow-xl border-4 border-solid border-slate-200 shrink-0">

            <img src="<?= URL_BASE ?>public/img/psyco.png" alt="Psyco" class="w-24 h-24 object-contain drop-shadow-md">

            <p class="text-base font-normal text-black underline decoration-black decoration-1 underline-offset-4 px-2" style="font-family: 'Canva Sans', sans-serif;">
                Un sistema ordenado para un bienestar adecuado
            </p>

            <div class="flex flex-col items-center justify-center gap-6 w-full mt-4">
                <img src="<?= URL_BASE ?>public/img/sena.png" alt="Sena" class="w-24 h-24 object-contain">
                <img src="<?= URL_BASE ?>public/img/logo.png" alt="Logo IE" class="w-24 h-24 object-contain">
            </div>

        </div>
    </div>

    <!-- Globo con flecha para avanzar -->
    <div class="w-full flex justify-center mt-12">
        <a href="<?= URL_BASE ?>pages/presentacion2" 
           class="flex items-center justify-center w-20 h-20 bg-white hover:bg-slate-50 text-blue-600 rounded-full shadow-2xl border-4 border-cyan-200 transform hover:scale-110 hover:-translate-y-2 transition-all duration-300 animate-bounce">
            <span class="material-symbols-outlined text-[40px]">arrow_forward</span>
        </a>
    </div>

</section>

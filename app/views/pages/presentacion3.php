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
            <p class="text-xl md:text-2xl font-bold text-slate-800 leading-relaxed" style="font-family: 'Canva Sans', sans-serif;">
                Desarrollar competencias técnicas en el diseño e implementación de un sistema digital para la gestión de citas psicológicas.
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

    



<div class="fixed bottom-6 right-8 z-[9999] flex items-center gap-4">
    <a id="btn-v3" href="<?= URL_BASE ?>pages/presentacion2" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
    </a>
    <a id="btn-s3" href="<?= URL_BASE ?>pages/presentacion4" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
    </a>
</div>
</section>
<!-- TRANSICIONES DE DIAPOSITIVAS -->

<style>
body { overflow-x: hidden; perspective: 1200px; }
section { transform-style: preserve-3d; }

/* 1. Slide Horizontal */
.fx-1-out-next { animation: fx1ON 0.6s ease forwards; }
.fx-1-in-next { animation: fx1IN 0.6s ease forwards; }
.fx-1-out-prev { animation: fx1OP 0.6s ease forwards; }
.fx-1-in-prev { animation: fx1IP 0.6s ease forwards; }
@keyframes fx1ON { to { transform: translateX(-100vw); opacity: 0; } }
@keyframes fx1IN { from { transform: translateX(100vw); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes fx1OP { to { transform: translateX(100vw); opacity: 0; } }
@keyframes fx1IP { from { transform: translateX(-100vw); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

/* 2. Slide Vertical */
.fx-2-out-next { animation: fx2ON 0.6s ease forwards; }
.fx-2-in-next { animation: fx2IN 0.6s ease forwards; }
.fx-2-out-prev { animation: fx2OP 0.6s ease forwards; }
.fx-2-in-prev { animation: fx2IP 0.6s ease forwards; }
@keyframes fx2ON { to { transform: translateY(-100vh); opacity: 0; } }
@keyframes fx2IN { from { transform: translateY(100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fx2OP { to { transform: translateY(100vh); opacity: 0; } }
@keyframes fx2IP { from { transform: translateY(-100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* 3. Scale Down & Slide */
.fx-3-out-next { animation: fx3ON 0.6s ease forwards; }
.fx-3-in-next { animation: fx3IN 0.6s ease forwards; }
.fx-3-out-prev { animation: fx3OP 0.6s ease forwards; }
.fx-3-in-prev { animation: fx3IP 0.6s ease forwards; }
@keyframes fx3ON { to { transform: scale(0.8) translateX(-100vw); opacity: 0; } }
@keyframes fx3IN { from { transform: scale(0.8) translateX(100vw); opacity: 0; } to { transform: scale(1) translateX(0); opacity: 1; } }
@keyframes fx3OP { to { transform: scale(0.8) translateX(100vw); opacity: 0; } }
@keyframes fx3IP { from { transform: scale(0.8) translateX(-100vw); opacity: 0; } to { transform: scale(1) translateX(0); opacity: 1; } }

/* 4. 3D Flip Y */
.fx-4-out-next { animation: fx4ON 0.6s ease forwards; }
.fx-4-in-next { animation: fx4IN 0.6s ease forwards; }
.fx-4-out-prev { animation: fx4OP 0.6s ease forwards; }
.fx-4-in-prev { animation: fx4IP 0.6s ease forwards; }
@keyframes fx4ON { to { transform: rotateY(-90deg); opacity: 0; } }
@keyframes fx4IN { from { transform: rotateY(90deg); opacity: 0; } to { transform: rotateY(0); opacity: 1; } }
@keyframes fx4OP { to { transform: rotateY(90deg); opacity: 0; } }
@keyframes fx4IP { from { transform: rotateY(-90deg); opacity: 0; } to { transform: rotateY(0); opacity: 1; } }

/* 5. 3D Flip X */
.fx-5-out-next { animation: fx5ON 0.6s ease forwards; }
.fx-5-in-next { animation: fx5IN 0.6s ease forwards; }
.fx-5-out-prev { animation: fx5OP 0.6s ease forwards; }
.fx-5-in-prev { animation: fx5IP 0.6s ease forwards; }
@keyframes fx5ON { to { transform: rotateX(90deg); opacity: 0; } }
@keyframes fx5IN { from { transform: rotateX(-90deg); opacity: 0; } to { transform: rotateX(0); opacity: 1; } }
@keyframes fx5OP { to { transform: rotateX(-90deg); opacity: 0; } }
@keyframes fx5IP { from { transform: rotateX(90deg); opacity: 0; } to { transform: rotateX(0); opacity: 1; } }

/* 6. Push (Z depth) */
.fx-6-out-next { animation: fx6ON 0.6s ease forwards; }
.fx-6-in-next { animation: fx6IN 0.6s ease forwards; }
.fx-6-out-prev { animation: fx6OP 0.6s ease forwards; }
.fx-6-in-prev { animation: fx6IP 0.6s ease forwards; }
@keyframes fx6ON { to { transform: translateZ(-800px); opacity: 0; } }
@keyframes fx6IN { from { transform: translateZ(800px); opacity: 0; } to { transform: translateZ(0); opacity: 1; } }
@keyframes fx6OP { to { transform: translateZ(800px); opacity: 0; } }
@keyframes fx6IP { from { transform: translateZ(-800px); opacity: 0; } to { transform: translateZ(0); opacity: 1; } }

/* 7. Newspaper Spin */
.fx-7-out-next { animation: fx7ON 0.7s ease forwards; }
.fx-7-in-next { animation: fx7IN 0.7s ease forwards; }
.fx-7-out-prev { animation: fx7OP 0.7s ease forwards; }
.fx-7-in-prev { animation: fx7IP 0.7s ease forwards; }
@keyframes fx7ON { to { transform: scale(0) rotate(720deg); opacity: 0; } }
@keyframes fx7IN { from { transform: scale(0) rotate(-720deg); opacity: 0; } to { transform: scale(1) rotate(0); opacity: 1; } }
@keyframes fx7OP { to { transform: scale(0) rotate(-720deg); opacity: 0; } }
@keyframes fx7IP { from { transform: scale(0) rotate(720deg); opacity: 0; } to { transform: scale(1) rotate(0); opacity: 1; } }

/* 8. Fall / Drop */
.fx-8-out-next { animation: fx8ON 0.6s ease forwards; }
.fx-8-in-next { animation: fx8IN 0.6s ease forwards; }
.fx-8-out-prev { animation: fx8OP 0.6s ease forwards; }
.fx-8-in-prev { animation: fx8IP 0.6s ease forwards; }
@keyframes fx8ON { to { transform: translateZ(-300px) rotateX(20deg); opacity: 0; } }
@keyframes fx8IN { from { transform: translateY(-100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fx8OP { to { transform: translateY(-100vh); opacity: 0; } }
@keyframes fx8IP { from { transform: translateZ(-300px) rotateX(20deg); opacity: 0; } to { transform: translateZ(0) rotateX(0); opacity: 1; } }

/* 9. Blur & Fade */
.fx-9-out-next { animation: fx9ON 0.6s ease forwards; }
.fx-9-in-next { animation: fx9IN 0.6s ease forwards; }
.fx-9-out-prev { animation: fx9OP 0.6s ease forwards; }
.fx-9-in-prev { animation: fx9IP 0.6s ease forwards; }
@keyframes fx9ON { to { filter: blur(30px); opacity: 0; transform: scale(1.1); } }
@keyframes fx9IN { from { filter: blur(30px); opacity: 0; transform: scale(0.9); } to { filter: blur(0); opacity: 1; transform: scale(1); } }
@keyframes fx9OP { to { filter: blur(30px); opacity: 0; transform: scale(0.9); } }
@keyframes fx9IP { from { filter: blur(30px); opacity: 0; transform: scale(1.1); } to { filter: blur(0); opacity: 1; transform: scale(1); } }

/* 10. Swing Hinge */
.fx-10-out-next { animation: fx10ON 0.7s ease forwards; transform-origin: top left; }
.fx-10-in-next { animation: fx10IN 0.7s ease forwards; transform-origin: top right; }
.fx-10-out-prev { animation: fx10OP 0.7s ease forwards; transform-origin: top right; }
.fx-10-in-prev { animation: fx10IP 0.7s ease forwards; transform-origin: top left; }
@keyframes fx10ON { to { transform: rotate(90deg); opacity: 0; } }
@keyframes fx10IN { from { transform: rotate(-90deg); opacity: 0; } to { transform: rotate(0); opacity: 1; } }
@keyframes fx10OP { to { transform: rotate(-90deg); opacity: 0; } }
@keyframes fx10IP { from { transform: rotate(90deg); opacity: 0; } to { transform: rotate(0); opacity: 1; } }

/* 11. Super Zoom */
.fx-11-out-next { animation: fx11ON 0.6s ease forwards; }
.fx-11-in-next { animation: fx11IN 0.6s ease forwards; }
.fx-11-out-prev { animation: fx11OP 0.6s ease forwards; }
.fx-11-in-prev { animation: fx11IP 0.6s ease forwards; }
@keyframes fx11ON { to { transform: scale(3); opacity: 0; } }
@keyframes fx11IN { from { transform: scale(0.1); opacity: 0; } to { transform: scale(1); opacity: 1; } }
@keyframes fx11OP { to { transform: scale(0.1); opacity: 0; } }
@keyframes fx11IP { from { transform: scale(3); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const CURRENT_PAGE = 3;
    const urlParams = new URLSearchParams(window.location.search);
    const fx = urlParams.get('fx');
    const dir = urlParams.get('dir');
    const section = document.querySelector('section');
    
    if (section) {
        if (fx && dir) {
            section.classList.add(`fx-${fx}-in-${dir}`);
            section.addEventListener('animationend', () => {
                section.className = section.className.replace(/fx-\d+-in-(next|prev)/g, '').trim();
            }, {once: true});
        } else {
            section.style.opacity = '0';
            section.style.animation = 'pFadeIn 0.8s ease forwards';
        }
    }

    const btnS = document.querySelector('[id^="btn-s"]');
    const btnV = document.querySelector('[id^="btn-v"]');

    if (btnS) {
        btnS.addEventListener('click', (e) => {
            e.preventDefault();
            const fxId = CURRENT_PAGE; // Effect from N to N+1 is N
            const href = btnS.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=next`;
            
            if(section) section.classList.add(`fx-${fxId}-out-next`);
            setTimeout(() => { window.location.href = finalHref; }, 550); // increased timeout to allow animations to finish
        });
    }

    if (btnV) {
        btnV.addEventListener('click', (e) => {
            e.preventDefault();
            const fxId = CURRENT_PAGE - 1; // Effect from N to N-1 is N-1
            const href = btnV.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=prev`;
            
            if(section) section.classList.add(`fx-${fxId}-out-prev`);
            setTimeout(() => { window.location.href = finalHref; }, 550);
        });
    }
});

if(!document.getElementById('pfade-style')) {
    const style = document.createElement('style');
    style.id = 'pfade-style';
    style.innerHTML = `@keyframes pFadeIn { to { opacity: 1; } }`;
    document.head.appendChild(style);
}
</script>

<!-- FIN TRANSICIONES -->
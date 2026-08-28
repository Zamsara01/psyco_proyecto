<?php
// Ocultar sidebar en esta página
$hideSidebar = true;
?>
<script>
(function() {
    const sidebar = document.getElementById('app-sidebar');
    const mainContent = document.getElementById('main-content');
    if (sidebar) sidebar.style.display = 'none';
    if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.classList.remove('lg:ml-64'); }
    window.addEventListener('pagehide', () => {
        if (sidebar) sidebar.style.display = '';
        if (mainContent) { mainContent.style.marginLeft = ''; mainContent.classList.add('lg:ml-64'); }
    });
})();
</script>

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
    .agenda-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 16px;
        padding: 24px 16px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        text-decoration: none;
        cursor: pointer;
    }
    .agenda-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 32px rgba(0,0,0,0.2);
        background: #ffffff;
    }
    .agenda-card .icon {
        font-size: 2.5rem;
        line-height: 1;
        margin-bottom: 8px;
    }
    .agenda-card h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        font-family: 'Canva Sans', sans-serif;
    }
</style>

<section class="min-h-screen py-16 px-6 bg-nebula flex flex-col items-center justify-center w-full relative">
    <div class="w-full max-w-6xl z-10 flex flex-col items-center">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-wide mb-12 drop-shadow-lg uppercase text-center" style="font-family: 'Canva Sans', sans-serif;">
            AGENDA
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
            <a href="<?= URL_BASE ?>pages/presentacion2?fx=2&dir=next" class="agenda-card">
                <span class="icon">🎯</span>
                <h3>Objetivo General</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion3?fx=3&dir=next" class="agenda-card">
                <span class="icon">🎓</span>
                <h3>Objetivo Académico</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion4?fx=4&dir=next" class="agenda-card">
                <span class="icon">💰</span>
                <h3>Objetivo Económico</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion5?fx=5&dir=next" class="agenda-card">
                <span class="icon">🤝</span>
                <h3>Objetivo Social</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion6?fx=6&dir=next" class="agenda-card">
                <span class="icon">🌱</span>
                <h3>Objetivo Ambiental</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion7?fx=7&dir=next" class="agenda-card">
                <span class="icon">💻</span>
                <h3>Objetivo Técnico</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion8?fx=8&dir=next" class="agenda-card">
                <span class="icon">📊</span>
                <h3>Modelo Relacional</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion9?fx=9&dir=next" class="agenda-card">
                <span class="icon">🔀</span>
                <h3>Modelo Entidad-Relación</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion10?fx=10&dir=next" class="agenda-card">
                <span class="icon">🏗️</span>
                <h3>Diagrama de Clases</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion11?fx=11&dir=next" class="agenda-card">
                <span class="icon">👤</span>
                <h3>Casos de Uso</h3>
            </a>
            <a href="<?= URL_BASE ?>pages/presentacion12?fx=11&dir=next" class="agenda-card">
                <span class="icon">🚀</span>
                <h3>Cierre y Demo</h3>
            </a>
        </div>
    </div>
    
    <!-- Controles de navegación fijos -->
    <div class="fixed bottom-6 right-8 z-[9999] flex items-center gap-4">
        <a id="btn-v1_5" href="<?= URL_BASE ?>pages/presentacion" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
            <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
        </a>
        <a id="btn-s1_5" href="<?= URL_BASE ?>pages/presentacion2" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
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
    const CURRENT_PAGE = 1;
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
            const fxId = CURRENT_PAGE;
            const href = btnS.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=next`;
            
            if(section) section.classList.add(`fx-${fxId}-out-next`);
            setTimeout(() => { window.location.href = finalHref; }, 550);
        });
    }

    if (btnV) {
        btnV.addEventListener('click', (e) => {
            e.preventDefault();
            const fxId = CURRENT_PAGE - 1; // 0
            const href = btnV.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=prev`;
            
            if(section) section.classList.add(`fx-${fxId}-out-prev`);
            setTimeout(() => { window.location.href = finalHref; }, 550);
        });
    }

    // Para los botones de las tarjetas también agregar la transición si se quiere, 
    // pero como ya están hardcodeados con el href completo y el fx en la URL, 
    // podemos capturarlos para hacer la animación de salida.
    const cards = document.querySelectorAll('.agenda-card');
    cards.forEach(card => {
        card.addEventListener('click', (e) => {
            e.preventDefault();
            const href = card.getAttribute('href');
            // Sacar el fx de la url
            const url = new URL(href, window.location.origin);
            const fxId = url.searchParams.get('fx') || 1;
            
            if(section) section.classList.add(`fx-${fxId}-out-next`);
            setTimeout(() => { window.location.href = href; }, 550);
        });
    });
});

if(!document.getElementById('pfade-style')) {
    const style = document.createElement('style');
    style.id = 'pfade-style';
    style.innerHTML = `@keyframes pFadeIn { to { opacity: 1; } }`;
    document.head.appendChild(style);
}
</script>

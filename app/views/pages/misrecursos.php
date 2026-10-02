<?php
/**
 * Vista: Mis Recursos de Acompañamiento (paciente) — Nueva UI
 * Variables: $recursos[], $notas[]
 */
function getYoutubeEmbed(string $url): string {
    $id = '';
    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $m)) {
        $id = $m[1];
    }
    return $id ? "https://www.youtube.com/embed/{$id}" : $url;
}
$videos   = array_filter($recursos, fn($r) => ($r['tipo'] ?? 'video') === 'video');
$mensajes = array_filter($recursos, fn($r) => ($r['tipo'] ?? '') === 'mensaje');
$imagenes = array_filter($recursos, fn($r) => ($r['tipo'] ?? '') === 'imagen');
?>

<style>
    /* Fondo de página sincronizado con miscitas */
    #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
    }
    .dark #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg') !important;
    }
    #main-content::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(244, 247, 246, 0.55);
        pointer-events: none;
        z-index: 0;
    }
    .dark #main-content::before { background: transparent; }

    /* Tarjetas de recursos (Frosted Glass) */
    .recurso-card {
        background: rgba(255,255,255,0.88) !important;
        backdrop-filter: blur(6px);
        transition: box-shadow .2s, transform .2s, border-color .2s;
    }
    .dark .recurso-card {
        background-color: rgba(42, 41, 38, 0.85) !important;
        backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4) !important;
    }
    .dark .recurso-card, .dark .recurso-card h3, .dark .recurso-card p, .dark .recurso-card span:not(.material-symbols-outlined) {
        color: #E4EAE6 !important;
    }
    .recurso-card:hover {
        box-shadow: 0 8px 28px rgba(0,0,0,0.10) !important;
        transform: translateY(-2px);
    }

    /* Avatar circular con iniciales */
    .psico-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 0.9rem;
        flex-shrink: 0;
        color: white;
        background: linear-gradient(135deg, #E8824A, #D96B30);
        box-shadow: 0 2px 8px rgba(232,130,74,0.35);
    }

    /* Iconos de sección */
    .sec-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white;
        background: #6B8CAE; /* Azul pizarra de la paleta */
        box-shadow: 0 2px 8px rgba(107,140,174,0.3);
    }
</style>

<div class="relative z-10 p-6 md:p-8 max-w-5xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 dark:text-slate-100">Recursos de Acompañamiento</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Contenido personalizado de tu psicóloga para apoyar tu proceso</p>
    </div>

    <?php if (empty($recursos) && empty($notas)): ?>
    <div class="recurso-card rounded-3xl p-12 text-center border border-white/60 dark:border-slate-700/50">
        <span class="material-symbols-outlined text-[56px] text-slate-300 dark:text-slate-600 block mb-3">folder_open</span>
        <p class="text-slate-600 dark:text-slate-400 font-semibold">Aún no tienes recursos asignados</p>
        <p class="text-slate-500 dark:text-slate-500 text-sm mt-1">Tu psicóloga agregará recursos aquí cuando los considere útiles para tu proceso</p>
    </div>
    <?php else: ?>

    <!-- ══════════ VIDEOS ══════════ -->
    <?php if (!empty($videos)): ?>
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-5">
            <div class="sec-icon shrink-0">
                <span class="material-symbols-outlined text-[20px]">play_circle</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Videos Recomendados</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Seleccionados especialmente para ti</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <?php foreach ($videos as $r):
                $url = $r['url_video'] ?? '';
                $esYoutube = preg_match('/(?:youtu\.be\/|youtube\.com\/)/i', $url);
            ?>
            <div class="recurso-card rounded-2xl border border-white/60 dark:border-slate-700/50 overflow-hidden flex flex-col group">
                <?php if ($esYoutube): ?>
                <!-- Esqueleto oEmbed -->
                <div class="oembed-video-placeholder relative aspect-video bg-slate-900/10 dark:bg-slate-900/50 flex items-center justify-center border-b border-white/40 dark:border-slate-700/50 transition-all" data-url="<?= htmlspecialchars($url) ?>" data-title="<?= htmlspecialchars($r['titulo']) ?>">
                    <div class="flex flex-col items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined animate-spin text-[32px]">progress_activity</span>
                        <span class="text-xs font-semibold">Cargando video...</span>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?= htmlspecialchars($r['url_video']) ?>" target="_blank" rel="noopener"
                   class="flex items-center justify-center h-44 bg-slate-900/10 dark:bg-slate-900/50 hover:bg-slate-900/20 transition-colors border-b border-white/40 dark:border-slate-700/50">
                    <span class="material-symbols-outlined text-[56px] text-[#6B8CAE] group-hover:scale-110 transition-transform drop-shadow-md">play_circle</span>
                </a>
                <?php endif; ?>
                <div class="p-5">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 mb-1 line-clamp-1"><?= htmlspecialchars($r['titulo']) ?></h3>
                    <?php if (!empty($r['descripcion'])): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-3"><?= htmlspecialchars($r['descripcion']) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200/60 dark:border-slate-700/40">
                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-[#6B8CAE]">person</span>
                            <?= htmlspecialchars($r['psicologo_nombre']) ?>
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-[#6B8CAE]">calendar_today</span>
                            <?= date('d M Y', strtotime($r['fecha_creacion'])) ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ══════════ IMÁGENES ══════════ -->
    <?php if (!empty($imagenes)): ?>
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-5">
            <div class="sec-icon shrink-0" style="background:#8DA399; box-shadow: 0 2px 8px rgba(141,163,153,0.3);">
                <span class="material-symbols-outlined text-[20px]">image</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Imágenes Compartidas</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Material visual de apoyo</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <?php foreach ($imagenes as $r): ?>
            <div class="group relative recurso-card rounded-2xl border border-white/60 dark:border-slate-700/50 overflow-hidden cursor-pointer flex flex-col"
                 onclick="verImagen('<?= URL_BASE . htmlspecialchars($r['imagen_ruta'] ?? '') ?>', '<?= htmlspecialchars(addslashes($r['titulo'])) ?>')">
                <img src="<?= URL_BASE . htmlspecialchars($r['imagen_ruta'] ?? '') ?>"
                     alt="<?= htmlspecialchars($r['titulo']) ?>"
                     class="w-full h-60 object-cover border-b border-white/40 dark:border-slate-700/50">
                <div class="p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate"><?= htmlspecialchars($r['titulo']) ?></p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px] text-[#8DA399]">calendar_today</span>
                        <?= date('d M Y', strtotime($r['fecha_creacion'])) ?>
                    </p>
                </div>
                <div class="absolute inset-0 flex items-center justify-center bg-slate-900/0 group-hover:bg-slate-900/30 backdrop-blur-[0px] group-hover:backdrop-blur-[2px] transition-all duration-300">
                    <span class="material-symbols-outlined text-white text-[42px] opacity-0 group-hover:opacity-100 transition-all drop-shadow-xl scale-50 group-hover:scale-100">zoom_in</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ══════════ MENSAJES ══════════ -->
    <?php if (!empty($mensajes)): ?>
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-5">
            <div class="sec-icon shrink-0" style="background:#5a7e9f; box-shadow: 0 2px 8px rgba(90,126,159,0.3);">
                <span class="material-symbols-outlined text-[20px]">chat_bubble</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Mensajes de tu Psicóloga</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Orientaciones y mensajes personalizados</p>
            </div>
        </div>
        <div class="space-y-4">
            <?php foreach ($mensajes as $r): 
                $partes = explode(' ', trim($r['psicologo_nombre']));
                $iniciales = strtoupper(($partes[0][0] ?? '') . ($partes[1][0] ?? ''));
            ?>
            <div class="recurso-card border border-white/60 dark:border-slate-700/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-4 border-b border-slate-200/60 dark:border-slate-700/40 pb-3">
                    <div class="psico-avatar"><?= $iniciales ?></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100"><?= htmlspecialchars($r['psicologo_nombre']) ?></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px] text-[#E8824A]">calendar_today</span>
                            <?= date('d M Y', strtotime($r['fecha_creacion'])) ?>
                        </p>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-2 text-md"><?= htmlspecialchars($r['titulo']) ?></h4>
                <?php if (!empty($r['descripcion'])): ?>
                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($r['descripcion']) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ══════════ NOTAS DE LA PSICÓLOGA ══════════ -->
    <?php if (!empty($notas)): ?>
    <section>
        <div class="flex items-center gap-3 mb-5">
            <div class="sec-icon shrink-0" style="background:#E8824A; box-shadow: 0 2px 8px rgba(232,130,74,0.3);">
                <span class="material-symbols-outlined text-[20px]">sticky_note_2</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Notas de tu Psicóloga</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Recomendaciones y notas de sesión</p>
            </div>
        </div>
        <div class="space-y-4">
            <?php foreach ($notas as $nota): 
                $partes = explode(' ', trim($nota['psicologo_nombre']));
                $iniciales = strtoupper(($partes[0][0] ?? '') . ($partes[1][0] ?? ''));
            ?>
            <div class="recurso-card border border-white/60 dark:border-slate-700/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-4 border-b border-slate-200/60 dark:border-slate-700/40 pb-3">
                    <div class="psico-avatar"><?= $iniciales ?></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100"><?= htmlspecialchars($nota['psicologo_nombre']) ?></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px] text-[#E8824A]">calendar_today</span>
                            <?= date('d M Y, H:i', strtotime($nota['fecha_creacion'])) ?>
                        </p>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-2 text-md"><?= htmlspecialchars($nota['titulo']) ?></h4>
                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($nota['contenido']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php endif; // end if empty check ?>
</div>

<!-- Lightbox -->
<div id="lb" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-900/90 backdrop-blur-md" onclick="cerrarLb()">
    <div class="relative max-w-4xl max-h-[90vh] mx-4" onclick="event.stopPropagation()">
        <button onclick="cerrarLb()" class="absolute -top-12 right-0 text-white/70 hover:text-white transition-colors">
            <span class="material-symbols-outlined text-[32px]">close</span>
        </button>
        <img id="lbImg" src="#" alt="" class="max-w-full max-h-[80vh] rounded-xl object-contain shadow-2xl ring-1 ring-white/20">
        <p id="lbCaption" class="text-white text-sm font-semibold text-center mt-4"></p>
    </div>
</div>
<script>
function verImagen(src, caption) {
    document.getElementById('lbImg').src = src;
    document.getElementById('lbCaption').textContent = caption;
    const lb = document.getElementById('lb');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
}
function cerrarLb() {
    const lb = document.getElementById('lb');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
}

// ── Renderizado asíncrono de YouTube oEmbed ─────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    const placeholders = document.querySelectorAll('.oembed-video-placeholder');
    
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                obs.unobserve(el);
                loadOEmbed(el, BASE);
            }
        });
    }, { rootMargin: '100px' });

    placeholders.forEach(el => observer.observe(el));
});

async function loadOEmbed(el, BASE) {
    const url = el.getAttribute('data-url');
    const title = el.getAttribute('data-title');
    
    try {
        const res = await fetch(BASE + 'api/oembed/youtube?link=' + encodeURIComponent(url));
        const json = await res.json();
        
        if (json.ok) {
            let html = json.data.html;
            html = html.replace(/width="\d+"/, 'width="100%"').replace(/height="\d+"/, 'height="100%"');
            el.innerHTML = html;
            
            const iframe = el.querySelector('iframe');
            if (iframe) iframe.className = 'absolute inset-0 w-full h-full';
            el.className = 'relative aspect-video bg-slate-900 border-b border-slate-100 dark:border-slate-700';
        } else {
            throw new Error(json.error);
        }
    } catch (e) {
        el.className = 'relative aspect-video bg-slate-900/10 dark:bg-slate-900/50 border-b border-white/40 flex items-center justify-center';
        el.innerHTML = `
            <div class="text-center p-4">
                <span class="material-symbols-outlined text-[48px] text-slate-400 mb-2 block">broken_image</span>
                <p class="text-xs text-slate-500 font-semibold mb-2">No se pudo incrustar el video</p>
                <a href="${url.replace(/"/g, '"')}" target="_blank" rel="noopener" class="inline-block bg-[#6B8CAE] text-white hover:bg-[#5a7e9f] px-4 py-1.5 rounded-full text-xs font-bold transition-colors">
                    Ver en YouTube
                </a>
            </div>
        `;
    }
}
</script>

<?php
/**
 * Vista: Mis Recursos de Acompañamiento (paciente)
 * Variables: $recursos[], $notas[]
 */
function getYoutubeEmbed(string $url): string {
    $id = '';
    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $m)) {
        $id = $m[1];
    }
    return $id ? "https://www.youtube.com/embed/{$id}" : $url;
}
// Separar recursos por tipo
$videos   = array_filter($recursos, fn($r) => ($r['tipo'] ?? 'video') === 'video');
$mensajes = array_filter($recursos, fn($r) => ($r['tipo'] ?? '') === 'mensaje');
$imagenes = array_filter($recursos, fn($r) => ($r['tipo'] ?? '') === 'imagen');
?>

<div class="p-6 md:p-8 max-w-5xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900">Recursos de Acompañamiento</h1>
        <p class="text-slate-500 text-sm mt-1">Contenido personalizado de tu psicóloga para apoyar tu proceso</p>
    </div>

    <?php if (empty($recursos) && empty($notas)): ?>
    <div class="bg-slate-50 rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
        <span class="material-symbols-outlined text-[56px] text-slate-300 block mb-3">folder_open</span>
        <p class="text-slate-500 font-semibold">Aún no tienes recursos asignados</p>
        <p class="text-slate-400 text-sm mt-1">Tu psicóloga agregará recursos aquí cuando los considere útiles para tu proceso</p>
    </div>
    <?php else: ?>

    <!-- ══════════ VIDEOS ══════════ -->
    <?php if (!empty($videos)): ?>
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">play_circle</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Videos Recomendados</h2>
                <p class="text-xs text-slate-500">Seleccionados especialmente para ti</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <?php foreach ($videos as $r):
                $url = $r['url_video'] ?? '';
                $esYoutube = preg_match('/(?:youtu\.be\/|youtube\.com\/)/i', $url);
            ?>
            <div class="bg-white rounded-2xl border-2 border-slate-100 overflow-hidden hover:border-red-200 hover:shadow-md transition-all flex flex-col group">
                <?php if ($esYoutube): ?>
                <!-- Esqueleto oEmbed -->
                <div class="oembed-video-placeholder relative aspect-video bg-slate-100 flex items-center justify-center border-b border-slate-100 transition-all" data-url="<?= htmlspecialchars($url) ?>" data-title="<?= htmlspecialchars($r['titulo']) ?>">
                    <div class="flex flex-col items-center gap-2 text-slate-400">
                        <span class="material-symbols-outlined animate-spin text-[32px]">progress_activity</span>
                        <span class="text-xs font-semibold">Cargando video...</span>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?= htmlspecialchars($r['url_video']) ?>" target="_blank" rel="noopener"
                   class="flex items-center justify-center h-40 bg-gradient-to-br from-red-50 to-orange-50 hover:from-red-100 transition-colors">
                    <span class="material-symbols-outlined text-[56px] text-red-400 group-hover:scale-110 transition-transform">play_circle</span>
                </a>
                <?php endif; ?>
                <div class="p-4">
                    <h3 class="font-bold text-slate-800 mb-1 truncate"><?= htmlspecialchars($r['titulo']) ?></h3>
                    <?php if (!empty($r['descripcion'])): ?>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-2"><?= htmlspecialchars($r['descripcion']) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-slate-400">Por <strong><?= htmlspecialchars($r['psicologo_nombre']) ?></strong></p>
                        <p class="text-xs text-slate-400"><?= date('d M Y', strtotime($r['fecha_creacion'])) ?></p>
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
            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">image</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Imágenes Compartidas</h2>
                <p class="text-xs text-slate-500">Material visual de apoyo</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <?php foreach ($imagenes as $r): ?>
            <div class="group relative bg-white rounded-2xl border-2 border-slate-100 overflow-hidden hover:border-emerald-200 hover:shadow-md transition-all cursor-pointer"
                 onclick="verImagen('<?= URL_BASE . htmlspecialchars($r['imagen_ruta'] ?? '') ?>', '<?= htmlspecialchars(addslashes($r['titulo'])) ?>')">
                <img src="<?= URL_BASE . htmlspecialchars($r['imagen_ruta'] ?? '') ?>"
                     alt="<?= htmlspecialchars($r['titulo']) ?>"
                     class="w-full h-64 sm:h-72 object-cover">
                <div class="p-4">
                    <p class="text-sm font-bold text-slate-700 truncate"><?= htmlspecialchars($r['titulo']) ?></p>
                    <p class="text-xs text-slate-400 mt-0.5"><?= date('d M Y', strtotime($r['fecha_creacion'])) ?></p>
                </div>
                <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/10 transition-all">
                    <span class="material-symbols-outlined text-white text-[36px] opacity-0 group-hover:opacity-100 transition-all drop-shadow-lg">zoom_in</span>
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
            <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">chat_bubble</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Mensajes de tu Psicóloga</h2>
                <p class="text-xs text-slate-500">Orientaciones y mensajes personalizados</p>
            </div>
        </div>
        <div class="space-y-4">
            <?php foreach ($mensajes as $r): ?>
            <div class="bg-gradient-to-br from-purple-50 to-violet-50 border-2 border-purple-100 rounded-2xl p-5 hover:border-purple-200 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 font-bold text-sm shrink-0">
                        <?= strtoupper(mb_substr($r['psicologo_nombre'], 0, 1)) ?>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-purple-800"><?= htmlspecialchars($r['psicologo_nombre']) ?></p>
                        <p class="text-xs text-purple-400"><?= date('d M Y', strtotime($r['fecha_creacion'])) ?></p>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 mb-2"><?= htmlspecialchars($r['titulo']) ?></h4>
                <?php if (!empty($r['descripcion'])): ?>
                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($r['descripcion']) ?></p>
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
            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">sticky_note_2</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Notas de tu Psicóloga</h2>
                <p class="text-xs text-slate-500">Recomendaciones y notas de sesión</p>
            </div>
        </div>
        <div class="space-y-4">
            <?php foreach ($notas as $nota): ?>
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-100 rounded-2xl p-5 hover:border-amber-200 hover:shadow-md transition-all">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-amber-200 flex items-center justify-center text-amber-700 font-bold text-sm shrink-0">
                            <?= strtoupper(mb_substr($nota['psicologo_nombre'], 0, 1)) ?>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-amber-800"><?= htmlspecialchars($nota['psicologo_nombre']) ?></p>
                            <p class="text-xs text-amber-400"><?= date('d M Y, H:i', strtotime($nota['fecha_creacion'])) ?></p>
                        </div>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 mb-2"><?= htmlspecialchars($nota['titulo']) ?></h4>
                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($nota['contenido']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php endif; // end if empty check ?>
</div>

<!-- Lightbox -->
<div id="lb" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/80 backdrop-blur-sm" onclick="cerrarLb()">
    <div class="relative max-w-4xl max-h-[90vh] mx-4" onclick="event.stopPropagation()">
        <button onclick="cerrarLb()" class="absolute -top-10 right-0 text-white/70 hover:text-white">
            <span class="material-symbols-outlined text-[28px]">close</span>
        </button>
        <img id="lbImg" src="#" alt="" class="max-w-full max-h-[85vh] rounded-2xl object-contain shadow-2xl">
        <p id="lbCaption" class="text-white/70 text-sm text-center mt-3"></p>
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
    
    // Configuración para Intersection Observer (lazy load)
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                obs.unobserve(el);
                loadOEmbed(el, BASE);
            }
        });
    }, { rootMargin: '100px' }); // Cargar 100px antes de que entre a pantalla

    placeholders.forEach(el => observer.observe(el));
});

async function loadOEmbed(el, BASE) {
    const url = el.getAttribute('data-url');
    const title = el.getAttribute('data-title');
    
    try {
        const res = await fetch(BASE + 'api/oembed/youtube?link=' + encodeURIComponent(url));
        const json = await res.json();
        
        if (json.ok) {
            // El DTO devuelve html con el iframe configurado
            // Modificamos el HTML devuelto para asegurar que el iframe ocupa el 100% de nuestro contenedor
            let html = json.data.html;
            html = html.replace(/width="\d+"/, 'width="100%"').replace(/height="\d+"/, 'height="100%"');
            
            el.innerHTML = html;
            
            // Añadir estilos al iframe inyectado
            const iframe = el.querySelector('iframe');
            if (iframe) {
                iframe.className = 'absolute inset-0 w-full h-full';
            }
            
            // Quitar animación de carga y clases previas
            el.className = 'relative aspect-video bg-slate-900 border-b border-slate-100';
            
        } else {
            throw new Error(json.error);
        }
    } catch (e) {
        // Fallback en caso de error
        el.className = 'relative aspect-video bg-gradient-to-br from-red-50 to-orange-50 border-b border-slate-100 flex items-center justify-center';
        el.innerHTML = `
            <div class="text-center p-4">
                <span class="material-symbols-outlined text-[48px] text-red-300 mb-2 block">broken_image</span>
                <p class="text-xs text-red-600 font-semibold mb-2">No se pudo incrustar el video</p>
                <a href="${url.replace(/"/g, '&quot;')}" target="_blank" rel="noopener" class="inline-block bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-xs font-bold hover:bg-red-200 transition-colors">
                    Ver en YouTube
                </a>
            </div>
        `;
    }
}
</script>

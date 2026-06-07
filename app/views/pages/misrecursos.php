<?php
/**
 * Vista: Mis Recursos de Acompañamiento (paciente)
 * Variables: $recursos[], $notas[]
 */
// Helper para extraer YouTube embed URL
function getYoutubeEmbed(string $url): string {
    $id = '';
    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $m)) {
        $id = $m[1];
    }
    return $id ? "https://www.youtube.com/embed/{$id}" : $url;
}
?>

<div class="p-6 md:p-8 max-w-5xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900">Recursos de Acompañamiento</h1>
        <p class="text-slate-500 text-sm mt-1">Videos y notas personalizadas de tu psicóloga para apoyar tu proceso</p>
    </div>

    <!-- ══════════ VIDEOS RECOMENDADOS ══════════ -->
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">play_circle</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Videos Recomendados</h2>
                <p class="text-xs text-slate-500">Seleccionados especialmente para ti por tu psicóloga</p>
            </div>
        </div>

        <?php if (empty($recursos)): ?>
            <div class="bg-slate-50 rounded-2xl p-10 text-center border-2 border-dashed border-slate-200">
                <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-3">video_library</span>
                <p class="text-slate-500 font-medium">Aún no tienes videos recomendados</p>
                <p class="text-slate-400 text-sm mt-1">Tu psicóloga agregará recursos aquí cuando los considere útiles para tu proceso</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <?php foreach ($recursos as $recurso):
                    $embedUrl = getYoutubeEmbed($recurso['url_video']);
                    $esYoutube = str_contains($embedUrl, 'youtube.com/embed');
                ?>
                <div class="bg-white rounded-2xl border-2 border-slate-100 overflow-hidden hover:border-orange-200 hover:shadow-md transition-all group">
                    <!-- Miniatura / Iframe -->
                    <?php if ($esYoutube): ?>
                    <div class="relative aspect-video bg-slate-900">
                        <iframe src="<?= htmlspecialchars($embedUrl) ?>"
                            class="absolute inset-0 w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="<?= htmlspecialchars($recurso['titulo']) ?>"></iframe>
                    </div>
                    <?php else: ?>
                    <a href="<?= htmlspecialchars($recurso['url_video']) ?>" target="_blank" rel="noopener"
                       class="flex items-center justify-center h-40 bg-gradient-to-br from-orange-100 to-amber-100 hover:from-orange-200 hover:to-amber-200 transition-colors">
                        <span class="material-symbols-outlined text-[56px] text-orange-400 group-hover:scale-110 transition-transform">play_circle</span>
                    </a>
                    <?php endif; ?>

                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-slate-800 mb-1 truncate"><?= htmlspecialchars($recurso['titulo']) ?></h3>
                        <?php if (!empty($recurso['descripcion'])): ?>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-2"><?= htmlspecialchars($recurso['descripcion']) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400">
                                Por <strong><?= htmlspecialchars($recurso['psicologo_nombre']) ?></strong>
                            </p>
                            <p class="text-xs text-slate-400"><?= date('d M Y', strtotime($recurso['fecha_creacion'])) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- ══════════ NOTAS DE LA PSICÓLOGA ══════════ -->
    <section>
        <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px]">sticky_note_2</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Notas de tu Psicóloga</h2>
                <p class="text-xs text-slate-500">Mensajes y orientaciones personalizadas para tu proceso</p>
            </div>
        </div>

        <?php if (empty($notas)): ?>
            <div class="bg-slate-50 rounded-2xl p-10 text-center border-2 border-dashed border-slate-200">
                <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-3">sticky_note_2</span>
                <p class="text-slate-500 font-medium">Aún no tienes notas de tu psicóloga</p>
                <p class="text-slate-400 text-sm mt-1">Las notas aparecerán aquí a medida que avances en tu proceso</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($notas as $nota): ?>
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 border-2 border-purple-100 rounded-2xl p-5 hover:border-purple-200 hover:shadow-md transition-all">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 font-bold text-sm shrink-0">
                                <?= strtoupper(mb_substr($nota['psicologo_nombre'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-purple-800"><?= htmlspecialchars($nota['psicologo_nombre']) ?></p>
                                <p class="text-xs text-purple-500"><?= date('d M Y, H:i', strtotime($nota['fecha_creacion'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-2"><?= htmlspecialchars($nota['titulo']) ?></h4>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($nota['contenido']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

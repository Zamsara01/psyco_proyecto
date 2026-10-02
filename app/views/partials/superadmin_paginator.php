<?php
/**
 * Paginador reutilizable para el panel de superusuario.
 * Espera: $totalPaginas, $paginaActual, $q (búsqueda actual)
 * El componente lee $urlBase para construir los enlaces.
 */
if ($totalPaginas <= 1) return;
$urlBase = $urlBasePag ?? ($_GET['url'] ?? '');
$buildUrl = fn($p) => URL_BASE . $urlBase . '?page=' . $p . ($q ? '&q=' . urlencode($q) : '');
?>
<nav class="flex items-center justify-center gap-1 mt-6 flex-wrap">
    <!-- Anterior -->
    <?php if ($paginaActual > 1): ?>
    <a href="<?= $buildUrl($paginaActual - 1) ?>" class="pag-btn flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">chevron_left</span>
    </a>
    <?php endif; ?>

    <?php
    $delta = 2;
    $start = max(1, $paginaActual - $delta);
    $end   = min($totalPaginas, $paginaActual + $delta);
    if ($start > 1): ?><a href="<?= $buildUrl(1) ?>" class="pag-btn">1</a><?php if ($start > 2): ?><span class="pag-dots">…</span><?php endif; endif;
    for ($i = $start; $i <= $end; $i++): ?>
        <a href="<?= $buildUrl($i) ?>" class="pag-btn <?= $i === $paginaActual ? 'pag-active' : '' ?>"><?= $i ?></a>
    <?php endfor;
    if ($end < $totalPaginas): if ($end < $totalPaginas - 1): ?><span class="pag-dots">…</span><?php endif; ?><a href="<?= $buildUrl($totalPaginas) ?>" class="pag-btn"><?= $totalPaginas ?></a><?php endif; ?>

    <!-- Siguiente -->
    <?php if ($paginaActual < $totalPaginas): ?>
    <a href="<?= $buildUrl($paginaActual + 1) ?>" class="pag-btn flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    </a>
    <?php endif; ?>
</nav>
<p class="text-center text-xs text-[#a39c8e] mt-2">Página <?= $paginaActual ?> de <?= $totalPaginas ?> · <?= $totalRegistros ?> registros</p>

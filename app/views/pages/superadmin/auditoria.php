<style>
    #main-content { background-image:url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size:cover; background-position:center; background-attachment:fixed; }
    .glass-card { background:rgba(42,41,38,0.88); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,0.07); border-radius:1.5rem; }
    body:not(.dark) #main-content { background-image:url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background:rgba(253,251,247,0.90); border-color:rgba(212,195,163,0.4); }
    .search-box { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:0.75rem; display:flex; align-items:center; gap:0.5rem; padding:0 1rem; }
    body:not(.dark) .search-box { background:rgba(0,0,0,0.04); border-color:rgba(212,195,163,0.6); }
    .search-box input { background:transparent !important; border:none !important; color:inherit; }
    .pag-btn { min-width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:0.5rem; font-size:0.8rem; font-weight:600; color:#a39c8e; border:1px solid rgba(255,255,255,0.08); transition:all 0.15s; }
    .pag-btn:hover { background:rgba(141,163,153,0.15); color:#E4EAE6; }
    .pag-btn.pag-active { background:#3A5C3D; color:#D7E6D5; border-color:transparent; }
    .pag-dots { color:#a39c8e; padding:0 0.25rem; font-size:0.8rem; }
</style>

<div class="pt-8 pb-16 px-4 max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6]" style="color:#3d3730">Auditoría de Seguridad</h1>
            <p class="text-sm text-[#a39c8e] mt-1">Cambios de contraseña registrados, quién los hizo y desde qué IP.</p>
        </div>
        <form method="GET" action="<?= URL_BASE ?>superusuario/auditoria" class="search-box w-full sm:w-72">
            <input type="hidden" name="url" value="superusuario/auditoria" />
            <span class="material-symbols-outlined text-[#a39c8e] text-[18px] shrink-0">search</span>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Email, IP, tipo..." class="py-2.5 text-sm" />
            <?php if ($q): ?><a href="<?= URL_BASE ?>superusuario/auditoria" class="text-[#a39c8e] hover:text-[#E4EAE6] shrink-0"><span class="material-symbols-outlined text-[18px]">close</span></a><?php endif; ?>
        </form>
    </div>

    <div class="glass-card p-6">
        <?php if (empty($auditoria)): ?>
        <div class="text-center py-12 text-[#a39c8e]">
            <span class="material-symbols-outlined text-[48px]"><?= $q?'search_off':'security' ?></span>
            <p class="mt-2"><?= $q?'Sin resultados para "'.$q.'"':'No hay eventos de auditoría todavía.' ?></p>
            <?php if (!$q): ?><p class="text-xs mt-1">Los cambios de contraseña aparecerán aquí automáticamente.</p><?php endif; ?>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#E4EAE6]">
                <thead class="text-xs uppercase text-[#a39c8e] border-b border-white/10">
                    <tr>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Email Afectado</th>
                        <th class="px-4 py-3">Realizado por</th>
                        <th class="px-4 py-3">IP de Origen</th>
                        <th class="px-4 py-3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($auditoria as $a):
                        $tipoClass = match($a['entidad_tipo']) {
                            'psicologo'    => 'bg-blue-500/20 text-blue-400',
                            'paciente'     => 'bg-purple-500/20 text-purple-400',
                            'superusuario' => 'bg-yellow-500/20 text-yellow-400',
                            default        => 'bg-white/10 text-[#a39c8e]'
                        };
                    ?>
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="px-4 py-3"><span class="text-[10px] uppercase font-bold px-2 py-1 rounded <?= $tipoClass ?>"><?= $a['entidad_tipo'] ?></span></td>
                        <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($a['entidad_email']) ?></td>
                        <td class="px-4 py-3 text-[#a39c8e]"><?= htmlspecialchars($a['realizado_por']) ?></td>
                        <td class="px-4 py-3"><code class="bg-white/10 px-2 py-0.5 rounded text-xs"><?= htmlspecialchars($a['ip_address']) ?></code></td>
                        <td class="px-4 py-3 text-[#a39c8e] text-xs"><?= $a['fecha'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php $urlBasePag = 'superusuario/auditoria'; $paginaActual = $page; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>
</div>
<script>
let timer;document.querySelector('input[name=q]').addEventListener('input',function(){clearTimeout(timer);timer=setTimeout(()=>this.form.submit(),400);});
</script>

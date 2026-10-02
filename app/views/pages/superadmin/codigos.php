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
            <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6]" style="color:#3d3730">Historial de Códigos OTP</h1>
            <p class="text-sm text-[#a39c8e] mt-1">Registro de todos los códigos de verificación generados.</p>
        </div>
        <!-- Búsqueda -->
        <form method="GET" action="<?= URL_BASE ?>superusuario/codigos" class="search-box w-full sm:w-72">
            <input type="hidden" name="url" value="superusuario/codigos" />
            <span class="material-symbols-outlined text-[#a39c8e] text-[18px] shrink-0">search</span>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Email, tipo, estado..." class="py-2.5 text-sm" />
            <?php if ($q): ?><a href="<?= URL_BASE ?>superusuario/codigos" class="text-[#a39c8e] hover:text-[#E4EAE6] shrink-0"><span class="material-symbols-outlined text-[18px]">close</span></a><?php endif; ?>
        </form>
    </div>

    <div class="glass-card p-6">
        <?php if (empty($codigos)): ?>
        <div class="text-center py-12 text-[#a39c8e]">
            <span class="material-symbols-outlined text-[48px]"><?= $q?'search_off':'pin' ?></span>
            <p class="mt-2"><?= $q?'Sin resultados para "'.$q.'"':'No hay registros OTP todavía.' ?></p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#E4EAE6]">
                <thead class="text-xs uppercase text-[#a39c8e] border-b border-white/10">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-center">Intentos</th>
                        <th class="px-4 py-3">Expira</th>
                        <th class="px-4 py-3">Creado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($codigos as $c):
                        $cls = match($c['status']) {
                            'active'  => 'bg-orange-500/20 text-orange-400',
                            'used'    => 'bg-green-700/30 text-green-400',
                            'expired' => 'bg-slate-500/20 text-slate-400',
                            'blocked' => 'bg-red-500/20 text-red-400',
                            default   => ''
                        };
                    ?>
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="px-4 py-3 text-[#a39c8e]"><?= $c['id'] ?></td>
                        <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($c['email']) ?></td>
                        <td class="px-4 py-3"><span class="text-[10px] uppercase font-bold px-2 py-1 rounded bg-white/10"><?= $c['type'] ?></span></td>
                        <td class="px-4 py-3"><span class="text-[10px] uppercase font-bold px-2 py-1 rounded <?= $cls ?>"><?= $c['status'] ?></span></td>
                        <td class="px-4 py-3 text-center"><?= $c['attempts'] ?></td>
                        <td class="px-4 py-3 text-[#a39c8e] text-xs"><?= $c['expires_at'] ?></td>
                        <td class="px-4 py-3 text-[#a39c8e] text-xs"><?= $c['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php $urlBasePag = 'superusuario/codigos'; $paginaActual = $page; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>
</div>
<script>
let timer;document.querySelector('input[name=q]').addEventListener('input',function(){clearTimeout(timer);timer=setTimeout(()=>this.form.submit(),400);});
</script>

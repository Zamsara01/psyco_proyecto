<style>
    #main-content { background-image:url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size:cover; background-position:center; background-attachment:fixed; }
    .glass-card { background:rgba(42,41,38,0.88); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,0.07); border-radius:1.5rem; }
    body:not(.dark) #main-content { background-image:url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background:rgba(253,251,247,0.90); border-color:rgba(212,195,163,0.4); }
    .search-box { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:0.75rem; display:flex; align-items:center; gap:0.5rem; padding:0 1rem; }
    body:not(.dark) .search-box { background:rgba(0,0,0,0.04); border-color:rgba(212,195,163,0.6); }
    .search-box input { background:transparent !important; border:none !important; color:inherit; }
    .tab-btn { padding:0.5rem 1.25rem; border-radius:0.75rem; font-size:0.85rem; font-weight:600; transition:all 0.15s; color:#a39c8e; }
    .tab-btn.active { background:#3A5C3D; color:#E4EAE6; }
    .pag-btn { min-width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:0.5rem; font-size:0.8rem; font-weight:600; color:#a39c8e; border:1px solid rgba(255,255,255,0.08); transition:all 0.15s; }
    .pag-btn:hover { background:rgba(141,163,153,0.15); color:#E4EAE6; }
    .pag-btn.pag-active { background:#3A5C3D; color:#D7E6D5; border-color:transparent; }
    .pag-dots { color:#a39c8e; padding:0 0.25rem; font-size:0.8rem; }
</style>

<div class="pt-8 pb-16 px-4 max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6]" style="color:#3d3730">Citas y Recursos</h1>
        <div class="flex gap-3">
            <?php if ($tab==='citas'): ?>
            <button onclick="cancelarTodas()" class="px-4 py-2 rounded-xl text-sm font-semibold border" style="background:rgba(180,40,40,0.15);color:#f87171;border-color:rgba(200,60,60,0.3)">Cancelar Pendientes</button>
            <?php else: ?>
            <button onclick="inhabilitarRecursos()" class="px-4 py-2 rounded-xl text-sm font-semibold border" style="background:rgba(180,40,40,0.15);color:#f87171;border-color:rgba(200,60,60,0.3)">Inhabilitar Todos</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabs + Búsqueda -->
    <div class="glass-card p-4 mb-6 flex flex-col sm:flex-row gap-3 justify-between items-center">
        <div class="flex gap-2">
            <a href="<?= URL_BASE ?>superusuario/citasRecursos?tab=citas<?= $q?'&q='.urlencode($q):'' ?>" class="tab-btn <?= $tab==='citas'?'active':'' ?>">
                <span class="material-symbols-outlined text-[16px] mr-1 align-middle">event</span> Citas <?= $totalCitas?"($totalCitas)":'' ?>
            </a>
            <a href="<?= URL_BASE ?>superusuario/citasRecursos?tab=recursos<?= $q?'&q='.urlencode($q):'' ?>" class="tab-btn <?= $tab==='recursos'?'active':'' ?>">
                <span class="material-symbols-outlined text-[16px] mr-1 align-middle">folder_open</span> Recursos <?= $totalRecursos?"($totalRecursos)":'' ?>
            </a>
        </div>
        <form method="GET" action="<?= URL_BASE ?>superusuario/citasRecursos" class="search-box w-full sm:w-72">
            <input type="hidden" name="url" value="superusuario/citasRecursos" />
            <input type="hidden" name="tab" value="<?= $tab ?>" />
            <span class="material-symbols-outlined text-[#a39c8e] text-[18px] shrink-0">search</span>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Buscar..." class="py-2.5 text-sm" />
            <?php if ($q): ?>
            <a href="<?= URL_BASE ?>superusuario/citasRecursos?tab=<?= $tab ?>" class="text-[#a39c8e] hover:text-[#E4EAE6] shrink-0"><span class="material-symbols-outlined text-[18px]">close</span></a>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($tab==='citas'): ?>
    <div class="glass-card p-6">
        <?php if (empty($citas)): ?>
        <div class="text-center py-10 text-[#a39c8e]"><span class="material-symbols-outlined text-[48px]">search_off</span><p class="mt-2">Sin resultados.</p></div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#E4EAE6]">
                <thead class="text-xs uppercase text-[#a39c8e] border-b border-white/10">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Psicólogo</th>
                        <th class="px-4 py-3">Paciente</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $c): ?>
                    <tr class="border-b border-white/5 hover:bg-white/5">
                        <td class="px-4 py-3 font-semibold"><?= $c['fecha'] ?></td>
                        <td class="px-4 py-3 text-[#a39c8e]"><?= substr($c['hora'],0,5) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($c['psico']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($c['pac']) ?></td>
                        <td class="px-4 py-3">
                            <span class="text-[10px] uppercase font-bold px-2 py-1 rounded <?= match($c['estado']){'pendiente'=>'bg-orange-500/20 text-orange-400','completada'=>'bg-green-700/30 text-green-400',default=>'bg-red-500/20 text-red-400'} ?>"><?= $c['estado'] ?></span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <?php if ($c['estado']==='pendiente'): ?>
                            <button onclick="toggleCita(<?= $c['id_cita'] ?>,'cancelada')" class="text-red-400 hover:opacity-75 text-xs font-semibold">Cancelar</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php $totalRegistros=$totalCitas; $totalPaginas=$totalPagCitas; $paginaActual=$pageCitas; $urlBasePag='superusuario/citasRecursos'; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <div class="glass-card p-6">
        <?php if (empty($recursos)): ?>
        <div class="text-center py-10 text-[#a39c8e]"><span class="material-symbols-outlined text-[48px]">search_off</span><p class="mt-2">Sin resultados.</p></div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($recursos as $r): ?>
            <div class="p-4 rounded-xl border border-white/5 bg-white/5 flex justify-between items-start">
                <div>
                    <p class="font-bold text-[#E4EAE6]"><?= htmlspecialchars($r['titulo']) ?></p>
                    <p class="text-xs text-[#a39c8e]">Por: <?= htmlspecialchars($r['psico']) ?> · <?= $r['tipo'] ?></p>
                    <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded mt-2 inline-block <?= ($r['estado']??'activo')==='activo' ? 'bg-[#3A5C3D]/30 text-[#8DA399]' : 'bg-red-500/20 text-red-400' ?>"><?= $r['estado']??'activo' ?></span>
                </div>
                <button onclick="toggleRecurso(<?= $r['id_recurso'] ?>,'<?= ($r['estado']??'activo')==='activo'?'inactivo':'activo' ?>')" class="material-symbols-outlined text-[20px] <?= ($r['estado']??'activo')==='activo'?'text-red-400':'text-[#8DA399]' ?> hover:opacity-75 shrink-0"><?= ($r['estado']??'activo')==='activo'?'block':'check_circle' ?></button>
            </div>
            <?php endforeach; ?>
        </div>
        <?php $totalRegistros=$totalRecursos; $totalPaginas=$totalPagRecursos; $paginaActual=$pageRecursos; $urlBasePag='superusuario/citasRecursos'; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
async function toggleCita(id,e){if(!confirm('¿Cancelar esta cita?'))return;const d=new FormData();d.append('id',id);d.append('estado',e);const r=await fetch('<?= URL_BASE ?>superusuario/toggleCita',{method:'POST',body:d});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
async function cancelarTodas(){if(!confirm('¿Cancelar TODAS las citas pendientes?'))return;const r=await fetch('<?= URL_BASE ?>superusuario/cancelarTodasCitas',{method:'POST'});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
async function toggleRecurso(id,e){if(!confirm('¿Cambiar estado del recurso?'))return;const d=new FormData();d.append('id',id);d.append('estado',e);const r=await fetch('<?= URL_BASE ?>superusuario/toggleRecurso',{method:'POST',body:d});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
async function inhabilitarRecursos(){if(!confirm('¿Inhabilitar TODOS los recursos?'))return;const r=await fetch('<?= URL_BASE ?>superusuario/inhabilitarTodosRecursos',{method:'POST'});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
let timer;document.querySelector('input[name=q]').addEventListener('input',function(){clearTimeout(timer);timer=setTimeout(()=>this.form.submit(),400);});
</script>

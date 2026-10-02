<?php
$paginatorStyles = true; // señal para incluir estilos del paginador
?>
<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size:cover; background-position:center; background-attachment:fixed; }
    .glass-card { background:rgba(42,41,38,0.88); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,0.07); border-radius:1.5rem; }
    body:not(.dark) #main-content { background-image:url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background:rgba(253,251,247,0.90); border-color:rgba(212,195,163,0.4); }
    input, select { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:#E4EAE6; border-radius:0.75rem; padding:0.65rem 1rem; width:100%; outline:none; }
    body:not(.dark) input, body:not(.dark) select { background:rgba(0,0,0,0.04); border-color:rgba(212,195,163,0.6); color:#3d3730; }
    .search-box { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:0.75rem; display:flex; align-items:center; gap:0.5rem; padding:0 1rem; }
    body:not(.dark) .search-box { background:rgba(0,0,0,0.04); border-color:rgba(212,195,163,0.6); }
    .search-box input { background:transparent !important; border:none !important; }
    .tab-btn { padding:0.5rem 1.25rem; border-radius:0.75rem; font-size:0.85rem; font-weight:600; transition:all 0.15s; color:#a39c8e; }
    .tab-btn.active { background:#3A5C3D; color:#E4EAE6; }
    /* Paginador */
    .pag-btn { min-width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:0.5rem; font-size:0.8rem; font-weight:600; color:#a39c8e; transition:all 0.15s; border:1px solid rgba(255,255,255,0.08); }
    .pag-btn:hover { background:rgba(141,163,153,0.15); color:#E4EAE6; }
    .pag-btn.pag-active { background:#3A5C3D; color:#D7E6D5; border-color:transparent; }
    .pag-dots { color:#a39c8e; padding:0 0.25rem; font-size:0.8rem; }
</style>

<?php $urlActual = $_GET['url'] ?? ''; ?>

<div class="pt-8 pb-16 px-4 max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="font-handwritten text-4xl font-bold" style="color:#3d3730; color: var(--text-title, #E4EAE6)">Gestión de Usuarios</h1>
        <div class="flex gap-3">
            <button onclick="document.getElementById('modalCrearPsico').classList.remove('hidden')" class="px-4 py-2 rounded-xl text-sm font-semibold bg-[#3A5C3D] text-[#E4EAE6]">+ Crear Psicólogo</button>
            <button onclick="inhabilitarTodos()" class="px-4 py-2 rounded-xl text-sm font-semibold border" style="background:rgba(180,40,40,0.15);color:#f87171;border-color:rgba(200,60,60,0.3)">Inhabilitar TODOS los Pacientes</button>
        </div>
    </div>

    <!-- Tabs + Búsqueda -->
    <div class="glass-card p-4 mb-6 flex flex-col sm:flex-row gap-3 justify-between items-center">
        <!-- Tabs -->
        <div class="flex gap-2">
            <a href="<?= URL_BASE ?>superusuario/usuarios?tab=psicologos<?= $q ? '&q='.urlencode($q) : '' ?>" class="tab-btn <?= $tab==='psicologos'?'active':'' ?>">
                <span class="material-symbols-outlined text-[16px] mr-1 align-middle">psychology</span> Psicólogos <?= $totalPsico ? "($totalPsico)" : '' ?>
            </a>
            <a href="<?= URL_BASE ?>superusuario/usuarios?tab=pacientes<?= $q ? '&q='.urlencode($q) : '' ?>" class="tab-btn <?= $tab==='pacientes'?'active':'' ?>">
                <span class="material-symbols-outlined text-[16px] mr-1 align-middle">person</span> Pacientes <?= $totalPac ? "($totalPac)" : '' ?>
            </a>
        </div>
        <!-- Búsqueda -->
        <form method="GET" action="<?= URL_BASE ?>superusuario/usuarios" class="search-box w-full sm:w-72">
            <input type="hidden" name="url" value="superusuario/usuarios" />
            <input type="hidden" name="tab" value="<?= $tab ?>" />
            <span class="material-symbols-outlined text-[#a39c8e] text-[18px] shrink-0">search</span>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Buscar por nombre o correo..." class="py-2.5 text-sm" />
            <?php if ($q): ?>
            <a href="<?= URL_BASE ?>superusuario/usuarios?tab=<?= $tab ?>" class="text-[#a39c8e] hover:text-[#E4EAE6] shrink-0">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Contenido tab Psicólogos -->
    <?php if ($tab === 'psicologos'): ?>
    <div class="glass-card p-6">
        <?php if (empty($psicologos)): ?>
        <div class="text-center py-10 text-[#a39c8e]"><span class="material-symbols-outlined text-[48px]">search_off</span><p class="mt-2">No se encontraron resultados.</p></div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($psicologos as $p): ?>
            <div class="p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/8 transition">
                <div class="flex justify-between items-start gap-2">
                    <div class="min-w-0">
                        <p class="font-bold text-[#E4EAE6] truncate" style="color:#2d2a25"><?= htmlspecialchars($p['nombre']) ?></p>
                        <p class="text-xs text-[#a39c8e] truncate"><?= htmlspecialchars($p['correo_electronico']) ?></p>
                        <p class="text-xs text-[#a39c8e] mt-0.5"><?= htmlspecialchars($p['especialidad'] ?? '—') ?></p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded mt-2 inline-block <?= $p['estado']==='activo' ? 'bg-[#3A5C3D]/30 text-[#8DA399]' : 'bg-red-500/20 text-red-400' ?>"><?= $p['estado'] ?></span>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0">
                        <button onclick="editarUsuario('psicologo',<?= $p['id_psicologo'] ?>,'<?= htmlspecialchars($p['nombre'],ENT_QUOTES) ?>','<?= htmlspecialchars($p['correo_electronico'],ENT_QUOTES) ?>')" title="Editar" class="material-symbols-outlined text-[20px] text-[#8DA399] hover:opacity-75">edit</button>
                        <button onclick="toggleEstado('psicologo',<?= $p['id_psicologo'] ?>,'<?= $p['estado']==='activo'?'inactivo':'activo' ?>')" title="<?= $p['estado']==='activo'?'Inhabilitar':'Habilitar' ?>" class="material-symbols-outlined text-[20px] <?= $p['estado']==='activo'?'text-red-400':'text-[#8DA399]' ?> hover:opacity-75"><?= $p['estado']==='activo'?'block':'check_circle' ?></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php $totalRegistros=$totalPsico; $totalPaginas=$totalPagPsico; $paginaActual=$pagePsico; $urlBasePag='superusuario/usuarios'; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>

    <!-- Contenido tab Pacientes -->
    <?php else: ?>
    <div class="glass-card p-6">
        <?php if (empty($pacientes)): ?>
        <div class="text-center py-10 text-[#a39c8e]"><span class="material-symbols-outlined text-[48px]">search_off</span><p class="mt-2">No se encontraron resultados.</p></div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($pacientes as $u): ?>
            <div class="p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/8 transition">
                <div class="flex justify-between items-start gap-2">
                    <div class="min-w-0">
                        <p class="font-bold text-[#E4EAE6] truncate" style="color:#2d2a25"><?= htmlspecialchars($u['nombre']) ?></p>
                        <p class="text-xs text-[#a39c8e] truncate"><?= htmlspecialchars($u['correo_electronico']) ?></p>
                        <p class="text-xs text-[#a39c8e]">Grado: <?= $u['grado'] ?? '—' ?></p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded mt-2 inline-block <?= $u['estado']==='activo' ? 'bg-[#3A5C3D]/30 text-[#8DA399]' : 'bg-red-500/20 text-red-400' ?>"><?= $u['estado'] ?></span>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0">
                        <button onclick="editarUsuario('paciente',<?= $u['id_usuario'] ?>,'<?= htmlspecialchars($u['nombre'],ENT_QUOTES) ?>','<?= htmlspecialchars($u['correo_electronico'],ENT_QUOTES) ?>')" title="Editar" class="material-symbols-outlined text-[20px] text-[#8DA399] hover:opacity-75">edit</button>
                        <button onclick="toggleEstado('paciente',<?= $u['id_usuario'] ?>,'<?= $u['estado']==='activo'?'inactivo':'activo' ?>')" title="<?= $u['estado']==='activo'?'Inhabilitar':'Habilitar' ?>" class="material-symbols-outlined text-[20px] <?= $u['estado']==='activo'?'text-red-400':'text-[#8DA399]' ?> hover:opacity-75"><?= $u['estado']==='activo'?'block':'check_circle' ?></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php $totalRegistros=$totalPac; $totalPaginas=$totalPagPac; $paginaActual=$pagePac; $urlBasePag='superusuario/usuarios'; ?>
        <?php include __DIR__ . '/../../partials/superadmin_paginator.php'; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modals -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60" onclick="document.getElementById('modalEdit').classList.add('hidden')"></div>
    <div class="glass-card relative p-6 w-full max-w-md z-10">
        <h3 class="font-bold text-lg mb-4 text-[#E4EAE6]">Editar Usuario</h3>
        <form id="formEdit">
            <input type="hidden" id="edit_id" name="id" />
            <input type="hidden" id="edit_tipo" name="tipo" />
            <div class="space-y-3">
                <input type="text" id="edit_nombre" name="nombre" placeholder="Nombre completo" required />
                <input type="email" id="edit_correo" name="correo" placeholder="Correo" required />
                <input type="password" name="password" placeholder="Nueva contraseña (vacío = no cambiar)" minlength="6" />
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-[#a39c8e]">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-[#3A5C3D] text-[#E4EAE6] rounded-xl font-semibold">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div id="modalCrearPsico" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60" onclick="document.getElementById('modalCrearPsico').classList.add('hidden')"></div>
    <div class="glass-card relative p-6 w-full max-w-md z-10">
        <h3 class="font-bold text-lg mb-4 text-[#E4EAE6]">Registrar Psicólogo</h3>
        <form id="formCrear">
            <div class="space-y-3">
                <input type="text" name="nombre" placeholder="Nombre completo" required />
                <input type="email" name="correo" placeholder="Correo electrónico" required />
                <select name="id_especialidad" required>
                    <option value="">— Especialidad —</option>
                    <?php foreach ($especialidades as $e): ?>
                    <option value="<?= $e['id_especialidad'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="password" name="password" placeholder="Contraseña" required minlength="6" />
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modalCrearPsico').classList.add('hidden')" class="text-[#a39c8e]">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-[#3A5C3D] text-[#E4EAE6] rounded-xl font-semibold">Crear</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarUsuario(tipo,id,nombre,correo){document.getElementById('edit_tipo').value=tipo;document.getElementById('edit_id').value=id;document.getElementById('edit_nombre').value=nombre;document.getElementById('edit_correo').value=correo;document.getElementById('modalEdit').classList.remove('hidden');}
document.getElementById('formEdit').addEventListener('submit',async e=>{e.preventDefault();const d=new FormData(e.target);const r=await fetch('<?= URL_BASE ?>superusuario/editarUser',{method:'POST',body:d});const j=await r.json();if(j.ok)location.reload();else alert(j.error);});
document.getElementById('formCrear').addEventListener('submit',async e=>{e.preventDefault();const d=new FormData(e.target);const r=await fetch('<?= URL_BASE ?>superusuario/crearPsicologo',{method:'POST',body:d});const j=await r.json();if(j.ok)location.reload();else alert(j.error);});
async function toggleEstado(tipo,id,estado){if(!confirm('¿Cambiar estado a '+estado+'?'))return;const d=new FormData();d.append('tipo',tipo);d.append('id',id);d.append('estado',estado);const r=await fetch('<?= URL_BASE ?>superusuario/toggleEstadoUser',{method:'POST',body:d});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
async function inhabilitarTodos(){if(!confirm('¿Inhabilitar TODOS los pacientes? Esto les impedirá iniciar sesión.'))return;const r=await fetch('<?= URL_BASE ?>superusuario/inhabilitarTodosPacientes',{method:'POST'});const j=await r.json();if(j.ok)location.reload();else alert(j.error);}
// Búsqueda en tiempo real (debounce 400ms)
let timer;document.querySelector('input[name=q]').addEventListener('input',function(){clearTimeout(timer);timer=setTimeout(()=>this.form.submit(),400);});
</script>

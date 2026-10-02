<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; }
    .glass-card { background: rgba(42,41,38,0.88); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.07); border-radius: 1.5rem; }
    body:not(.dark) #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background: rgba(253,251,247,0.90); border-color: rgba(212,195,163,0.4); }
    input, select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #E4EAE6; border-radius: 0.75rem; padding: 0.65rem 1rem; width: 100%; outline: none; transition: border-color 0.2s; }
    input:focus, select:focus { border-color: #8DA399; }
    body:not(.dark) input, body:not(.dark) select { background: rgba(0,0,0,0.04); border-color: rgba(212,195,163,0.6); color: #3d3730; }
    body:not(.dark) input:focus, body:not(.dark) select:focus { border-color: #8DA399; }
    
    /* Scrollbar minimalista */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(141,163,153,0.3); border-radius: 10px; }
</style>

<div class="pt-8 pb-16 px-4 md:px-8 max-w-6xl mx-auto relative z-10 w-full">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-handwritten text-4xl font-bold mb-1 text-[#E4EAE6]" style="color:#3d3730">Panel de Control</h1>
            <p class="text-sm text-[#a39c8e]">Gestión de psicólogos y administración del sistema.</p>
        </div>
        
        <button onclick="document.getElementById('dangerZoneModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all" style="background:rgba(180,40,40,0.15);color:#f87171;border:1px solid rgba(200,60,60,0.3);">
            <span class="material-symbols-outlined text-[18px]">warning</span>
            Zona de Peligro
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulario Crear Psicólogo -->
        <div class="lg:col-span-1">
            <div class="glass-card p-6 sticky top-24">
                <h2 class="font-semibold mb-6 flex items-center gap-2 text-[#E4EAE6]" style="color:#3d3730">
                    <span class="material-symbols-outlined text-[20px]" style="color:#8DA399">person_add</span>
                    Registrar Psicólogo
                </h2>
                
                <form id="formCrear" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 text-[#a39c8e]">Nombre completo</label>
                        <input type="text" name="nombre" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 text-[#a39c8e]">Correo electrónico</label>
                        <input type="email" name="correo" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 text-[#a39c8e]">Especialidad</label>
                        <select name="id_especialidad" required>
                            <option value="">— Seleccionar —</option>
                            <?php foreach ($especialidades as $e): ?>
                                <option value="<?= $e['id_especialidad'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 text-[#a39c8e]">Contraseña</label>
                        <input type="password" name="password" required minlength="6" />
                    </div>
                    
                    <button type="submit" id="btnCrear" class="w-full mt-4 flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-semibold text-sm transition-all hover:opacity-90" style="background:#3A5C3D;color:#E4EAE6;">
                        Crear Psicólogo
                    </button>
                </form>
            </div>
        </div>

        <!-- Lista de Psicólogos -->
        <div class="lg:col-span-2">
            <div class="glass-card p-6 overflow-hidden flex flex-col h-full">
                <h2 class="font-semibold mb-6 flex items-center gap-2 text-[#E4EAE6]" style="color:#3d3730">
                    <span class="material-symbols-outlined text-[20px]" style="color:#8DA399">group</span>
                    Psicólogos Registrados
                </h2>
                
                <div class="overflow-y-auto custom-scrollbar pr-2 space-y-3" style="max-height: 600px;">
                    <?php if (empty($psicologos)): ?>
                        <p class="text-sm text-[#a39c8e]">No hay psicólogos registrados.</p>
                    <?php endif; ?>
                    
                    <?php foreach ($psicologos as $p): ?>
                    <div class="p-4 rounded-2xl flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-base text-[#E4EAE6]" style="color:#2d2a25"><?= htmlspecialchars($p['nombre']) ?></p>
                                <span class="text-[10px] px-2 py-0.5 rounded-full uppercase font-bold" 
                                      style="<?= $p['estado']==='activo' ? 'background:rgba(58,92,61,0.2);color:#8DA399;' : 'background:rgba(180,40,40,0.15);color:#f87171;' ?>">
                                    <?= $p['estado'] ?>
                                </span>
                            </div>
                            <p class="text-xs text-[#a39c8e] mt-1"><?= htmlspecialchars($p['correo_electronico']) ?> · <?= htmlspecialchars($p['especialidad']) ?></p>
                        </div>
                        
                        <div class="flex gap-2 w-full sm:w-auto">
                            <!-- Toggle Estado -->
                            <button onclick="toggleEstado(<?= $p['id_psicologo'] ?>, '<?= $p['estado'] === 'activo' ? 'inactivo' : 'activo' ?>')"
                                    class="flex-1 sm:flex-none px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border"
                                    style="<?= $p['estado']==='activo' ? 'background:rgba(180,40,40,0.1);color:#f87171;border-color:rgba(180,40,40,0.2);' : 'background:rgba(58,92,61,0.1);color:#8DA399;border-color:rgba(58,92,61,0.2);' ?>">
                                <?= $p['estado'] === 'activo' ? 'Inhabilitar' : 'Habilitar' ?>
                            </button>
                            
                            <!-- Cambiar Contraseña -->
                            <button onclick="abrirModalPassword(<?= $p['id_psicologo'] ?>, '<?= htmlspecialchars($p['nombre'], ENT_QUOTES) ?>')"
                                    class="flex-1 sm:flex-none px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
                                    style="background:rgba(255,255,255,0.1);color:#E4EAE6;border:1px solid rgba(255,255,255,0.15);">
                                Contraseña
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div id="passwordModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="cerrarModalPassword()"></div>
    <div class="glass-card relative p-6 w-full max-w-md border-t border-slate-500/30">
        <h3 class="font-bold text-lg text-[#E4EAE6] mb-4">Cambiar Contraseña</h3>
        <p class="text-sm text-[#a39c8e] mb-4" id="passModalName"></p>
        
        <form id="formPassword" onsubmit="submitPassword(event)">
            <input type="hidden" id="pass_id_psicologo" />
            <input type="password" id="nueva_password" placeholder="Nueva contraseña (mín 6)" required minlength="6" class="mb-4" />
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="cerrarModalPassword()" class="px-4 py-2 rounded-xl text-sm font-semibold" style="color:#a39c8e;">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold" style="background:#3A5C3D;color:#E4EAE6;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Danger Zone -->
<div id="dangerZoneModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('dangerZoneModal').classList.add('hidden')"></div>
    <div class="glass-card relative p-6 w-full max-w-md" style="border-color: rgba(200,60,60,0.4);">
        <div class="flex items-center gap-3 mb-4 text-[#f87171]">
            <span class="material-symbols-outlined text-[32px]">warning</span>
            <h3 class="font-bold text-xl">Eliminar Pacientes</h3>
        </div>
        <p class="text-sm text-[#E4EAE6] mb-4 font-semibold">Esta acción es irreversible.</p>
        <p class="text-xs text-[#a39c8e] mb-6">Todos los usuarios (pacientes), sus notas, y sus historiales vinculados serán eliminados de la base de datos. Escribe "ELIMINAR" para confirmar.</p>
        
        <input type="text" id="dangerConfirm" placeholder="ELIMINAR" class="mb-4" style="border-color:rgba(200,60,60,0.4) !important;" />
        
        <div class="flex gap-3 justify-end">
            <button onclick="document.getElementById('dangerZoneModal').classList.add('hidden')" class="px-4 py-2 rounded-xl text-sm font-semibold text-[#a39c8e]">Cancelar</button>
            <button onclick="vaciarPacientes()" id="btnDanger" class="px-4 py-2 rounded-xl text-sm font-semibold" style="background:#b91c1c;color:#fff;">Eliminar Todos</button>
        </div>
    </div>
</div>

<script>
// Crear Psicólogo
document.getElementById('formCrear').addEventListener('submit', async e => {
    e.preventDefault();
    const btn = document.getElementById('btnCrear');
    btn.disabled = true;
    btn.textContent = 'Creando...';
    
    const data = new FormData(e.target);
    const res = await fetch('<?= URL_BASE ?>superusuario/crearPsicologo', { method: 'POST', body: data });
    const json = await res.json();
    
    if (json.ok) location.reload();
    else {
        alert(json.error);
        btn.disabled = false;
        btn.textContent = 'Crear Psicólogo';
    }
});

// Toggle Estado
async function toggleEstado(id, estado) {
    if(!confirm('¿Seguro que deseas cambiar el estado a ' + estado + '?')) return;
    const data = new FormData();
    data.append('id_psicologo', id);
    data.append('estado', estado);
    
    const res = await fetch('<?= URL_BASE ?>superusuario/toggleEstadoPsicologo', { method: 'POST', body: data });
    const json = await res.json();
    if(json.ok) location.reload();
    else alert(json.error);
}

// Modal Contraseña
function abrirModalPassword(id, nombre) {
    document.getElementById('pass_id_psicologo').value = id;
    document.getElementById('passModalName').textContent = 'Psicólogo: ' + nombre;
    document.getElementById('nueva_password').value = '';
    document.getElementById('passwordModal').classList.remove('hidden');
}
function cerrarModalPassword() {
    document.getElementById('passwordModal').classList.add('hidden');
}

async function submitPassword(e) {
    e.preventDefault();
    const id = document.getElementById('pass_id_psicologo').value;
    const pass = document.getElementById('nueva_password').value;
    
    const data = new FormData();
    data.append('id_psicologo', id);
    data.append('nueva_password', pass);
    
    const res = await fetch('<?= URL_BASE ?>superusuario/cambiarPassword', { method: 'POST', body: data });
    const json = await res.json();
    
    if (json.ok) {
        alert('Contraseña actualizada correctamente');
        cerrarModalPassword();
    } else alert(json.error);
}

// Vaciar Pacientes
async function vaciarPacientes() {
    const val = document.getElementById('dangerConfirm').value;
    if(val !== 'ELIMINAR') {
        alert('Escribe ELIMINAR para confirmar');
        return;
    }
    
    const btn = document.getElementById('btnDanger');
    btn.disabled = true;
    btn.textContent = 'Borrando...';
    
    try {
        const res = await fetch('<?= URL_BASE ?>superusuario/eliminarTodosPacientes', { method: 'POST' });
        const json = await res.json();
        
        if (json.ok) {
            alert(json.mensaje);
            document.getElementById('dangerZoneModal').classList.add('hidden');
            document.getElementById('dangerConfirm').value = '';
        } else alert(json.error);
    } catch(e) {
        alert('Error de red');
    }
    btn.disabled = false;
    btn.textContent = 'Eliminar Todos';
}
</script>

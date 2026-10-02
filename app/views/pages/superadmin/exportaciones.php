<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; }
    .glass-card { background: rgba(42,41,38,0.88); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.07); border-radius: 1.5rem; }
    body:not(.dark) #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background: rgba(253,251,247,0.90); border-color: rgba(212,195,163,0.4); }
    select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #E4EAE6; border-radius: 0.75rem; padding: 0.65rem 1rem; width: 100%; }
    body:not(.dark) select { background: rgba(0,0,0,0.04); border-color: rgba(212,195,163,0.6); color: #3d3730; }
    .campo-check { display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: background 0.15s; }
    .campo-check:hover { background: rgba(255,255,255,0.06); }
    input[type="checkbox"] { accent-color: #8DA399; width: 1rem; height: 1rem; }
</style>

<div class="pt-8 pb-16 px-4 max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6]" style="color:#3d3730">Exportaciones</h1>
        <p class="text-sm text-[#a39c8e] mt-1">Descarga archivos CSV con la información que necesites. Elige los campos a incluir.</p>
    </div>

    <form id="formExportar" method="POST" action="<?= URL_BASE ?>superusuario/procesarExportacion">
        <div class="glass-card p-8 mb-6">
            <!-- Tipo de entidad -->
            <div class="mb-6">
                <label class="block text-xs font-semibold mb-2 text-[#a39c8e] uppercase tracking-wide">¿Qué quieres exportar?</label>
                <select name="tipo" id="tipoExport" required onchange="cambiarCampos()">
                    <option value="">— Seleccionar —</option>
                    <option value="pacientes">Pacientes</option>
                    <option value="psicologos">Psicólogos</option>
                </select>
            </div>

            <!-- Campos pacientes (oculto por defecto) -->
            <div id="camposPacientes" class="hidden">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-sm font-semibold text-[#E4EAE6]">Campos a incluir en el CSV</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="selectAll('pacientes')" class="text-xs text-[#8DA399] hover:underline">Seleccionar todo</button>
                        <button type="button" onclick="clearAll('pacientes')" class="text-xs text-[#a39c8e] hover:underline">Limpiar</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-1" id="gridPacientes">
                    <?php foreach ($camposPacientes as $col): ?>
                    <label class="campo-check">
                        <input type="checkbox" name="campos[]" value="<?= $col ?>" checked />
                        <span class="text-sm text-[#E4EAE6]" style="color:#3d3730"><?= $col ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Campos psicologos (oculto por defecto) -->
            <div id="camposPsicologos" class="hidden">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-sm font-semibold text-[#E4EAE6]">Campos a incluir en el CSV</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="selectAll('psicologos')" class="text-xs text-[#8DA399] hover:underline">Seleccionar todo</button>
                        <button type="button" onclick="clearAll('psicologos')" class="text-xs text-[#a39c8e] hover:underline">Limpiar</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-1" id="gridPsicologos">
                    <?php foreach ($camposPsicologos as $col): ?>
                    <label class="campo-check">
                        <input type="checkbox" name="campos[]" value="<?= $col ?>" checked />
                        <span class="text-sm text-[#E4EAE6]" style="color:#3d3730"><?= $col ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="sinTipo" class="py-8 text-center text-[#a39c8e]">
                <span class="material-symbols-outlined text-[40px]">table_view</span>
                <p class="mt-2 text-sm">Selecciona qué tipo de datos exportar para ver los campos disponibles.</p>
            </div>
        </div>

        <button type="submit" id="btnExportar" class="w-full py-3 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 disabled:opacity-50" style="background:#3A5C3D;color:#E4EAE6;" disabled>
            <span class="material-symbols-outlined text-[18px]">download</span>
            Descargar CSV
        </button>
    </form>
</div>

<script>
function cambiarCampos() {
    const tipo = document.getElementById('tipoExport').value;
    document.getElementById('camposPacientes').classList.add('hidden');
    document.getElementById('camposPsicologos').classList.add('hidden');
    document.getElementById('sinTipo').classList.add('hidden');
    document.getElementById('btnExportar').disabled = !tipo;

    if (tipo === 'pacientes') {
        document.getElementById('camposPacientes').classList.remove('hidden');
        // Deshabilitar checkbox de contrasena por seguridad
        document.querySelectorAll('#gridPacientes input').forEach(cb => {
            if (cb.value === 'contrasena') { cb.checked = false; cb.disabled = true; }
        });
    } else if (tipo === 'psicologos') {
        document.getElementById('camposPsicologos').classList.remove('hidden');
        document.querySelectorAll('#gridPsicologos input').forEach(cb => {
            if (cb.value === 'contrasena') { cb.checked = false; cb.disabled = true; }
        });
    } else {
        document.getElementById('sinTipo').classList.remove('hidden');
    }
}

function selectAll(tipo) {
    document.querySelectorAll('#grid' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + ' input').forEach(cb => {
        if (!cb.disabled) cb.checked = true;
    });
}

function clearAll(tipo) {
    document.querySelectorAll('#grid' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + ' input').forEach(cb => {
        if (!cb.disabled) cb.checked = false;
    });
}

document.getElementById('formExportar').addEventListener('submit', function(e) {
    const tipo = document.getElementById('tipoExport').value;
    if (!tipo) { e.preventDefault(); alert('Selecciona qué exportar'); return; }
    
    const ids = '#grid' + tipo.charAt(0).toUpperCase() + tipo.slice(1);
    const checked = document.querySelectorAll(ids + ' input:checked').length;
    if (!checked) { e.preventDefault(); alert('Selecciona al menos un campo'); }
    
    // Desactivar campos ocultos para no enviar datos incorrectos
    const otro = tipo === 'pacientes' ? 'Psicologos' : 'Pacientes';
    document.querySelectorAll('#grid' + otro + ' input').forEach(cb => cb.disabled = true);
});
</script>

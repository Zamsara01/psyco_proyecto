<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; }
    .glass-card { background: rgba(42,41,38,0.88); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.07); border-radius: 1.5rem; }
    body:not(.dark) #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background: rgba(253,251,247,0.90); border-color: rgba(212,195,163,0.4); }
    .drop-zone { border: 2px dashed rgba(141,163,153,0.4); border-radius: 1rem; padding: 2.5rem; text-align: center; transition: border-color 0.2s; cursor: pointer; }
    .drop-zone:hover, .drop-zone.drag-over { border-color: #8DA399; background: rgba(141,163,153,0.05); }
    select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #E4EAE6; border-radius: 0.75rem; padding: 0.65rem 1rem; width: 100%; }
    body:not(.dark) select { background: rgba(0,0,0,0.04); border-color: rgba(212,195,163,0.6); color: #3d3730; }
</style>

<div class="pt-8 pb-16 px-4 max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6]" style="color:#3d3730">Importaciones</h1>
        <p class="text-sm text-[#a39c8e] mt-1">Carga masiva de usuarios o psicólogos desde archivos CSV o TXT.</p>
    </div>

    <div class="glass-card p-8 mb-6">
        <h2 class="font-bold text-lg mb-6 text-[#E4EAE6]" style="color:#3d3730">Cargar archivo</h2>
        
        <form id="formImportar" class="space-y-6">
            <!-- Tipo de entidad -->
            <div>
                <label class="block text-xs font-semibold mb-2 text-[#a39c8e] uppercase tracking-wide">¿Qué quieres importar?</label>
                <select name="tipo" id="tipoImport" required onchange="actualizarFormato()">
                    <option value="">— Seleccionar —</option>
                    <option value="pacientes">Pacientes (tabla usuarios)</option>
                    <option value="psicologos">Psicólogos (tabla psicologos)</option>
                </select>
            </div>
            
            <!-- Instrucciones de formato -->
            <div id="instrucciones" class="hidden p-4 rounded-xl" style="background: rgba(141,163,153,0.08); border: 1px solid rgba(141,163,153,0.2)">
                <p class="text-xs font-bold text-[#8DA399] mb-2 uppercase tracking-wide">Formato requerido del archivo CSV/TXT</p>
                <p id="textoFormato" class="text-xs text-[#a39c8e] font-mono"></p>
                <p class="text-[11px] text-[#a39c8e] mt-2">Una fila por registro. El separador debe ser <code class="bg-white/10 px-1 rounded">,</code> (coma). Sin encabezados.</p>
            </div>
            
            <!-- Drop zone -->
            <div>
                <label class="block text-xs font-semibold mb-2 text-[#a39c8e] uppercase tracking-wide">Archivo (.csv o .txt)</label>
                <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                    <span class="material-symbols-outlined text-[40px] text-[#8DA399] mb-3 block">upload_file</span>
                    <p class="text-[#E4EAE6] font-semibold">Arrastra tu archivo aquí</p>
                    <p class="text-xs text-[#a39c8e] mt-1">o haz clic para seleccionarlo</p>
                    <p id="nombreArchivo" class="text-xs text-[#8DA399] mt-3 hidden"></p>
                </div>
                <input type="file" id="fileInput" name="archivo" accept=".csv,.txt" class="hidden" />
            </div>
            
            <button type="submit" id="btnImportar" class="w-full py-3 rounded-xl font-semibold text-sm" style="background:#3A5C3D;color:#E4EAE6;">
                Importar registros
            </button>
        </form>
        
        <!-- Resultado -->
        <div id="resultado" class="hidden mt-4 p-4 rounded-xl" style="background:rgba(58,92,61,0.15); border:1px solid rgba(58,92,61,0.3)">
            <p id="textoResultado" class="text-[#8DA399] font-semibold"></p>
        </div>
    </div>

    <!-- Guía visual -->
    <div class="glass-card p-6">
        <h3 class="font-bold text-base mb-4 text-[#E4EAE6]" style="color:#3d3730">Ejemplos de archivo</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-bold text-[#8DA399] uppercase mb-2">Pacientes (usuarios)</p>
                <pre class="text-xs text-[#a39c8e] bg-black/20 p-3 rounded-lg overflow-auto">Juan García,juan@mail.com,clave123
Ana López,ana@mail.com,pass456</pre>
                <p class="text-[10px] text-[#a39c8e] mt-1">Columnas: nombre, correo, contraseña</p>
            </div>
            <div>
                <p class="text-xs font-bold text-[#8DA399] uppercase mb-2">Psicólogos</p>
                <pre class="text-xs text-[#a39c8e] bg-black/20 p-3 rounded-lg overflow-auto">Dra. Pérez,perez@psyco.com,clave123
Dr. Ruiz,ruiz@psyco.com,pass456</pre>
                <p class="text-[10px] text-[#a39c8e] mt-1">Columnas: nombre, correo, contraseña. (Especialidad: Psicología clínica por defecto)</p>
            </div>
        </div>
    </div>
</div>

<script>
function actualizarFormato() {
    const tipo = document.getElementById('tipoImport').value;
    const instrDiv = document.getElementById('instrucciones');
    const texto = document.getElementById('textoFormato');
    if (!tipo) { instrDiv.classList.add('hidden'); return; }
    instrDiv.classList.remove('hidden');
    texto.textContent = tipo === 'pacientes'
        ? 'nombre, correo_electronico, contrasena'
        : 'nombre, correo_electronico, contrasena  (especialidad = Psicología clínica por defecto)';
}

// Drag and drop
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        mostrarNombreArchivo(e.dataTransfer.files[0].name);
    }
});
fileInput.addEventListener('change', () => {
    if (fileInput.files.length) mostrarNombreArchivo(fileInput.files[0].name);
});
function mostrarNombreArchivo(nombre) {
    const el = document.getElementById('nombreArchivo');
    el.textContent = '✓ ' + nombre;
    el.classList.remove('hidden');
}

// Submit
document.getElementById('formImportar').addEventListener('submit', async e => {
    e.preventDefault();
    const btn = document.getElementById('btnImportar');
    if (!fileInput.files.length) { alert('Selecciona un archivo'); return; }
    
    btn.disabled = true;
    btn.textContent = 'Procesando...';
    
    const data = new FormData(e.target);
    const res = await fetch('<?= URL_BASE ?>superusuario/procesarImportacion', { method:'POST', body:data });
    const json = await res.json();
    
    const res_div = document.getElementById('resultado');
    const res_txt = document.getElementById('textoResultado');
    res_div.classList.remove('hidden');
    
    if (json.ok) {
        res_txt.textContent = '✓ ' + json.mensaje;
        res_div.style.background = 'rgba(58,92,61,0.15)';
        res_div.style.borderColor = 'rgba(58,92,61,0.3)';
    } else {
        res_txt.textContent = '✗ Error: ' + json.error;
        res_div.style.background = 'rgba(180,40,40,0.15)';
        res_div.style.borderColor = 'rgba(180,40,40,0.3)';
        res_txt.style.color = '#f87171';
    }
    
    btn.disabled = false;
    btn.textContent = 'Importar registros';
});
</script>

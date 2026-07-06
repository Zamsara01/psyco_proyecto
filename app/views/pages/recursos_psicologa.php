<?php
/**
 * Vista: Gestión de Recursos — Psicóloga
 * Variables: $recursos[]
 */
function ytEmbed(string $url): string {
    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $m)) {
        return "https://www.youtube.com/embed/{$m[1]}";
    }
    return $url;
}
$tipoIcono = ['video' => 'play_circle', 'mensaje' => 'chat_bubble', 'imagen' => 'image'];
$tipoColor = ['video' => 'bg-red-100 text-red-600', 'mensaje' => 'bg-purple-100 text-purple-600', 'imagen' => 'bg-emerald-100 text-emerald-600'];
$tipoLabel = ['video' => 'Video', 'mensaje' => 'Mensaje', 'imagen' => 'Imagen'];
?>

<div class="p-6 md:p-8 max-w-6xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Gestión de Recursos</h1>
            <p class="text-slate-500 text-sm mt-1">Publica videos, mensajes e imágenes para tus pacientes</p>
        </div>
        <span class="text-xs text-slate-400 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-full font-medium">
            <?= count($recursos) ?> recurso(s) publicados
        </span>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        <!-- ══ PANEL PUBLICAR (izquierda) ══ -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sticky top-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-orange-100 rounded-2xl">
                        <span class="material-symbols-outlined text-orange-600">add_circle</span>
                    </div>
                    <h2 class="font-bold text-slate-800 text-lg">Publicar Recurso</h2>
                </div>

                <!-- Tipo selector -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipo de contenido</label>
                    <div class="grid grid-cols-3 gap-2" id="tipoSelector">
                        <button type="button" onclick="seleccionarTipo('video')" id="btn-tipo-video"
                            class="tipo-btn active-tipo flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-red-300 bg-red-50 text-red-700">
                            <span class="material-symbols-outlined text-[22px]">play_circle</span>
                            Video
                        </button>
                        <button type="button" onclick="seleccionarTipo('mensaje')" id="btn-tipo-mensaje"
                            class="tipo-btn flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-purple-200 hover:bg-purple-50 hover:text-purple-600">
                            <span class="material-symbols-outlined text-[22px]">chat_bubble</span>
                            Mensaje
                        </button>
                        <button type="button" onclick="seleccionarTipo('imagen')" id="btn-tipo-imagen"
                            class="tipo-btn flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600">
                            <span class="material-symbols-outlined text-[22px]">image</span>
                            Imagen
                        </button>
                    </div>
                    <input type="hidden" id="recursoTipo" value="video">
                </div>

                <!-- Título -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Título *</label>
                    <input type="text" id="recursoTitulo" placeholder="Ej: Técnica de respiración 4-7-8"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors">
                </div>

                <!-- Campo dinámico según tipo -->
                <div id="campoVideo" class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">URL del Video *</label>
                    <input type="url" id="recursoUrl" placeholder="https://youtube.com/watch?v=..."
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors">
                    <p class="text-xs text-slate-400 mt-1">YouTube, Vimeo y otros reproductores</p>
                </div>

                <div id="campoImagen" class="mb-4 hidden">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Imagen *</label>
                    <label for="recursoImagen"
                        class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-dashed border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30 cursor-pointer transition-all group">
                        <span class="material-symbols-outlined text-[36px] text-slate-300 group-hover:text-emerald-400 transition-colors">cloud_upload</span>
                        <span class="text-xs font-medium text-slate-500 group-hover:text-emerald-600">Haz clic para seleccionar imagen</span>
                        <span class="text-[10px] text-slate-400">JPG, PNG, GIF, WebP · máx. 5 MB</span>
                    </label>
                    <input type="file" id="recursoImagen" accept="image/*" class="hidden" onchange="previewImagen(this)">
                    <img id="imagenPreview" src="#" alt="Preview" class="hidden mt-3 w-full rounded-xl object-cover max-h-40 border border-slate-100">
                </div>

                <!-- Descripción / Mensaje -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5" id="labelDescripcion">Descripción</label>
                    <textarea id="recursoDescripcion" rows="3" placeholder="Texto adicional o mensaje para el paciente..."
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none"></textarea>
                </div>

                <!-- Destino -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Destino</label>
                    <div class="flex gap-2">
                        <button type="button" onclick="seleccionarDestino('todos')" id="btn-dest-todos"
                            class="dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all border-indigo-300 bg-indigo-50 text-indigo-700">
                            <span class="material-symbols-outlined text-[16px]">groups</span>
                            Todos mis pacientes
                        </button>
                        <button type="button" onclick="seleccionarDestino('especifico')" id="btn-dest-especifico"
                            class="dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-indigo-200 hover:bg-indigo-50/50">
                            <span class="material-symbols-outlined text-[16px]">person</span>
                            Paciente específico
                        </button>
                    </div>
                    <input type="hidden" id="recursoDestino" value="todos">
                </div>

                <!-- Buscador de paciente (solo si destino = especifico) -->
                <div id="selectorPaciente" class="mb-5 hidden">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Buscar paciente</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-[18px]">search</span>
                        <input type="text" id="buscarPacienteRec" placeholder="Nombre o correo..."
                            oninput="buscarPacienteRecurso(this.value)"
                            class="w-full pl-9 pr-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 transition-colors">
                    </div>
                    <div id="resultadosBusqRec" class="hidden mt-1 bg-white border border-slate-100 rounded-xl shadow-lg max-h-44 overflow-y-auto z-20"></div>
                    <input type="hidden" id="recursoIdUsuario" value="">
                    <div id="pacienteSeleccionadoRec" class="hidden mt-2 flex items-center gap-2 bg-indigo-50 border border-indigo-100 rounded-xl p-2.5">
                        <span class="material-symbols-outlined text-indigo-500 text-[18px]">person_check</span>
                        <span id="nombrePacienteRec" class="text-xs font-semibold text-indigo-700 flex-1 truncate"></span>
                        <button onclick="limpiarPacienteRec()" class="text-slate-400 hover:text-red-500">
                            <span class="material-symbols-outlined text-[16px]">close</span>
                        </button>
                    </div>
                </div>

                <!-- Error / Success -->
                <div id="pubError" class="hidden mb-3 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 flex items-start gap-2">
                    <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">error</span>
                    <span id="pubErrorMsg"></span>
                </div>
                <div id="pubSuccess" class="hidden mb-3 p-3 bg-green-50 border border-green-200 rounded-xl text-xs text-green-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span id="pubSuccessMsg"></span>
                </div>

                <button onclick="publicarRecurso()" id="btnPublicar"
                    class="w-full py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-amber-600 shadow-md shadow-orange-200 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-[20px]">publish</span>
                    Publicar
                </button>
            </div>
        </div>

        <!-- ══ LISTA DE RECURSOS (derecha) ══ -->
        <div class="xl:col-span-3">
            <div id="listaRecursosContainer">
                <?php if (empty($recursos)): ?>
                <div class="bg-slate-50 rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-[56px] text-slate-300 block mb-3">folder_open</span>
                    <p class="text-slate-500 font-semibold">Aún no has publicado recursos</p>
                    <p class="text-slate-400 text-sm mt-1">Usa el panel de la izquierda para crear el primero</p>
                </div>
                <?php else: ?>
                <div class="space-y-4" id="recursosGrid">
                    <?php foreach ($recursos as $r):
                        $tipo  = $r['tipo'] ?? 'video';
                        $ico   = $tipoIcono[$tipo] ?? 'folder';
                        $color = $tipoColor[$tipo] ?? 'bg-slate-100 text-slate-600';
                        $label = $tipoLabel[$tipo] ?? 'Recurso';
                        $destLabel = $r['id_usuario'] ? 'Para: '.htmlspecialchars($r['paciente_nombre'] ?? 'Paciente') : 'Todos los pacientes';
                    ?>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-slate-200 transition-all p-5 flex gap-4 group"
                         id="rec-<?= $r['id_recurso'] ?>">
                        <div class="w-11 h-11 rounded-2xl <?= $color ?> flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]"><?= $ico ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 truncate"><?= htmlspecialchars($r['titulo']) ?></p>
                                    <p class="text-xs text-slate-400 mt-0.5"><?= $label ?> · <?= date('d M Y', strtotime($r['fecha_creacion'])) ?></p>
                                    <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full <?= $r['id_usuario'] ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' ?>">
                                        <span class="material-symbols-outlined text-[12px]"><?= $r['id_usuario'] ? 'person' : 'groups' ?></span>
                                        <?= htmlspecialchars($destLabel) ?>
                                    </span>
                                </div>
                                <button onclick="eliminarRecurso(<?= $r['id_recurso'] ?>)"
                                    class="p-1.5 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100 shrink-0" title="Eliminar">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                            <?php if ($r['descripcion']): ?>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2"><?= htmlspecialchars($r['descripcion']) ?></p>
                            <?php endif; ?>
                            <!-- Preview según tipo -->
                            <?php if ($tipo === 'video' && $r['url_video']): ?>
                            <a href="<?= htmlspecialchars($r['url_video']) ?>" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 mt-2 text-xs text-red-500 hover:text-red-700 font-medium">
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                Ver video
                            </a>
                            <?php elseif ($tipo === 'imagen' && $r['imagen_ruta']): ?>
                            <img src="<?= URL_BASE . htmlspecialchars($r['imagen_ruta']) ?>" alt="<?= htmlspecialchars($r['titulo']) ?>"
                                 class="mt-3 rounded-xl max-h-32 object-cover border border-slate-100 cursor-pointer"
                                 onclick="verImagenFull('<?= URL_BASE . htmlspecialchars($r['imagen_ruta']) ?>', '<?= htmlspecialchars(addslashes($r['titulo'])) ?>')">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox imagen -->
<div id="lightbox" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/80 backdrop-blur-sm" onclick="cerrarLightbox()">
    <div class="relative max-w-4xl max-h-[90vh] mx-4" onclick="event.stopPropagation()">
        <button onclick="cerrarLightbox()" class="absolute -top-10 right-0 text-white/70 hover:text-white">
            <span class="material-symbols-outlined text-[28px]">close</span>
        </button>
        <img id="lightboxImg" src="#" alt="" class="max-w-full max-h-[85vh] rounded-2xl object-contain shadow-2xl">
        <p id="lightboxCaption" class="text-white/70 text-sm text-center mt-3"></p>
    </div>
</div>

<script>
const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');

// ── Tipo selector ──────────────────────────────────────────────────
const tipoStyles = {
    video:   'border-red-300 bg-red-50 text-red-700',
    mensaje: 'border-purple-300 bg-purple-50 text-purple-700',
    imagen:  'border-emerald-300 bg-emerald-50 text-emerald-700',
};
const tipoInactivo = 'border-slate-200 text-slate-500';

function seleccionarTipo(tipo) {
    document.getElementById('recursoTipo').value = tipo;
    ['video','mensaje','imagen'].forEach(t => {
        const btn = document.getElementById('btn-tipo-' + t);
        btn.className = 'tipo-btn flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all '
            + (t === tipo ? tipoStyles[t] : tipoInactivo + ' hover:border-slate-300');
    });
    // Campos dinámicos
    document.getElementById('campoVideo').classList.toggle('hidden', tipo !== 'video');
    document.getElementById('campoImagen').classList.toggle('hidden', tipo !== 'imagen');
    document.getElementById('labelDescripcion').textContent =
        tipo === 'mensaje' ? 'Mensaje *' : 'Descripción';
}

// ── Destino selector ───────────────────────────────────────────────
function seleccionarDestino(dest) {
    document.getElementById('recursoDestino').value = dest;
    const esTodos = dest === 'todos';
    document.getElementById('btn-dest-todos').className = 'dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all '
        + (esTodos ? 'border-indigo-300 bg-indigo-50 text-indigo-700' : 'border-slate-200 text-slate-500 hover:border-indigo-200 hover:bg-indigo-50/50');
    document.getElementById('btn-dest-especifico').className = 'dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all '
        + (!esTodos ? 'border-indigo-300 bg-indigo-50 text-indigo-700' : 'border-slate-200 text-slate-500 hover:border-indigo-200 hover:bg-indigo-50/50');
    document.getElementById('selectorPaciente').classList.toggle('hidden', esTodos);
}

// ── Búsqueda de paciente ───────────────────────────────────────────
let timBusq = null;
function buscarPacienteRecurso(q) {
    clearTimeout(timBusq);
    if (q.trim().length < 2) { document.getElementById('resultadosBusqRec').classList.add('hidden'); return; }
    timBusq = setTimeout(async () => {
        const res = await fetch(BASE + 'panel_psicologas/buscarTodosLosPacientes?q=' + encodeURIComponent(q));
        const data = await res.json();
        const cont = document.getElementById('resultadosBusqRec');
        if (!data.ok || !data.pacientes.length) {
            cont.innerHTML = '<p class="p-3 text-xs text-slate-400 text-center">Sin resultados</p>';
            cont.classList.remove('hidden');
            return;
        }
        cont.innerHTML = data.pacientes.map(p => `
            <div onclick="elegirPacienteRec(${p.id_usuario}, '${escRec(p.nombre)}')"
                 class="flex items-center gap-3 px-3 py-2.5 hover:bg-orange-50 cursor-pointer transition-colors">
                <div class="w-7 h-7 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold shrink-0">
                    ${escRec(p.nombre.charAt(0).toUpperCase())}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">${escRec(p.nombre)}</p>
                    <p class="text-xs text-slate-400 truncate">${escRec(p.correo_electronico)}</p>
                </div>
            </div>`).join('');
        cont.classList.remove('hidden');
    }, 300);
}

function elegirPacienteRec(id, nombre) {
    document.getElementById('recursoIdUsuario').value = id;
    document.getElementById('nombrePacienteRec').textContent = nombre;
    document.getElementById('pacienteSeleccionadoRec').classList.remove('hidden');
    document.getElementById('resultadosBusqRec').classList.add('hidden');
    document.getElementById('buscarPacienteRec').value = '';
}
function limpiarPacienteRec() {
    document.getElementById('recursoIdUsuario').value = '';
    document.getElementById('pacienteSeleccionadoRec').classList.add('hidden');
}

// ── Preview imagen ────────────────────────────────────────────────
function previewImagen(input) {
    const prev = document.getElementById('imagenPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { prev.src = e.target.result; prev.classList.remove('hidden'); };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Publicar recurso ──────────────────────────────────────────────
async function publicarRecurso() {
    const errCont = document.getElementById('pubError');
    const sucCont = document.getElementById('pubSuccess');
    errCont.classList.add('hidden');
    sucCont.classList.add('hidden');

    const tipo    = document.getElementById('recursoTipo').value;
    const titulo  = document.getElementById('recursoTitulo').value.trim();
    const desc    = document.getElementById('recursoDescripcion').value.trim();
    const destino = document.getElementById('recursoDestino').value;
    const idUsu   = document.getElementById('recursoIdUsuario').value;

    if (!titulo) { mostrarErrPub('El título es obligatorio.'); return; }
    if (tipo === 'mensaje' && !desc) { mostrarErrPub('El mensaje no puede estar vacío.'); return; }
    if (destino === 'especifico' && !idUsu) { mostrarErrPub('Selecciona un paciente específico.'); return; }

    const fd = new FormData();
    fd.append('tipo', tipo);
    fd.append('titulo', titulo);
    fd.append('descripcion', desc);
    fd.append('destino', destino);
    if (idUsu) fd.append('id_usuario', idUsu);

    if (tipo === 'video') {
        const url = document.getElementById('recursoUrl').value.trim();
        if (!url) { mostrarErrPub('La URL del video es obligatoria.'); return; }
        fd.append('url_video', url);
    } else if (tipo === 'imagen') {
        const file = document.getElementById('recursoImagen').files[0];
        if (!file) { mostrarErrPub('Selecciona una imagen.'); return; }
        fd.append('imagen', file);
    }

    const btn = document.getElementById('btnPublicar');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Publicando...';

    try {
        const res  = await fetch(BASE + 'panel_psicologas/publicarRecurso', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.ok) {
            document.getElementById('pubSuccessMsg').textContent = data.mensaje;
            sucCont.classList.remove('hidden');
            resetFormPublicar();
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarErrPub(data.error);
        }
    } catch(e) {
        mostrarErrPub('Error de conexión.');
    }
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">publish</span> Publicar';
}

function mostrarErrPub(msg) {
    document.getElementById('pubErrorMsg').textContent = msg;
    document.getElementById('pubError').classList.remove('hidden');
}

function resetFormPublicar() {
    ['recursoTitulo','recursoUrl','recursoDescripcion'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('recursoImagen').value = '';
    document.getElementById('imagenPreview').classList.add('hidden');
    limpiarPacienteRec();
    seleccionarTipo('video');
    seleccionarDestino('todos');
}

// ── Eliminar recurso ──────────────────────────────────────────────
async function eliminarRecurso(idRecurso) {
    if (!confirm('¿Eliminar este recurso permanentemente?')) return;
    try {
        const res  = await fetch(BASE + 'panel_psicologas/eliminarRecurso', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_recurso: idRecurso })
        });
        const data = await res.json();
        if (data.ok) {
            const el = document.getElementById('rec-' + idRecurso);
            if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.3s'; setTimeout(() => el.remove(), 300); }
        } else {
            alert(data.error);
        }
    } catch(e) { alert('Error de conexión.'); }
}

// ── Lightbox ──────────────────────────────────────────────────────
function verImagenFull(src, caption) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
}
function cerrarLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
}

// ── Escape helper ─────────────────────────────────────────────────
function escRec(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Cerrar dropdown con click fuera
document.addEventListener('click', e => {
    if (!e.target.closest('#selectorPaciente')) {
        document.getElementById('resultadosBusqRec').classList.add('hidden');
    }
});
</script>

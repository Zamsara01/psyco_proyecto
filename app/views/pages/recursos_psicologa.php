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
$tipoColor = ['video' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400', 'mensaje' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400', 'imagen' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400'];
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sticky top-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-orange-100 dark:bg-orange-900/30 rounded-2xl">
                        <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">add_circle</span>
                    </div>
                    <h2 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Publicar Recurso</h2>
                </div>

                <!-- Tipo selector -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipo de contenido</label>
                    <div class="grid grid-cols-3 gap-2" id="tipoSelector">
                        <button type="button" onclick="seleccionarTipo('video')" id="btn-tipo-video"
                            class="tipo-btn active-tipo flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-red-300 bg-red-50 text-red-700 dark:border-red-700 dark:bg-red-900/30 dark:text-red-400">
                            <span class="material-symbols-outlined text-[22px]">play_circle</span>
                            Video
                        </button>
                        <button type="button" onclick="seleccionarTipo('mensaje')" id="btn-tipo-mensaje"
                            class="tipo-btn flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-purple-200 hover:bg-purple-50 hover:text-purple-600 dark:border-slate-700 dark:text-slate-400 dark:hover:border-purple-700 dark:hover:bg-purple-900/30 dark:hover:text-purple-400">
                            <span class="material-symbols-outlined text-[22px]">chat_bubble</span>
                            Mensaje
                        </button>
                        <button type="button" onclick="seleccionarTipo('imagen')" id="btn-tipo-imagen"
                            class="tipo-btn flex flex-col items-center gap-1 p-3 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600 dark:border-slate-700 dark:text-slate-400 dark:hover:border-emerald-700 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400">
                            <span class="material-symbols-outlined text-[22px]">image</span>
                            Imagen
                        </button>
                    </div>
                    <input type="hidden" id="recursoTipo" value="video">
                </div>

                <!-- Título -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Título *</label>
                    <input type="text" id="recursoTitulo" placeholder="Ej: Técnica de respiración 4-7-8"
                        class="w-full border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-500">
                </div>

                <div id="campoVideo" class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">URL del Video *</label>
                    <input type="url" id="recursoUrl" placeholder="https://youtube.com/watch?v=..."
                        class="w-full border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-500">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">YouTube (con previsualización) y otros reproductores</p>

                    <!-- Previsualización oEmbed -->
                    <div id="youtubePreviewContainer" class="hidden mt-3 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 transition-all">
                        <!-- Contenido dinámico inyectado por JS -->
                    </div>
                </div>

                <div id="campoImagen" class="mb-4 hidden">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Imagen *</label>
                    <label for="recursoImagen"
                        class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-600 hover:bg-emerald-50/30 dark:hover:bg-emerald-900/20 cursor-pointer transition-all group">
                        <span class="material-symbols-outlined text-[36px] text-slate-300 dark:text-slate-600 group-hover:text-emerald-400 dark:group-hover:text-emerald-500 transition-colors">cloud_upload</span>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">Haz clic para seleccionar imagen</span>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500">JPG, PNG, GIF, WebP · máx. 5 MB</span>
                    </label>
                    <input type="file" id="recursoImagen" accept="image/*" class="hidden" onchange="previewImagen(this)">
                    <img id="imagenPreview" src="#" alt="Preview" class="hidden mt-3 w-full rounded-xl object-cover max-h-40 border border-slate-100 dark:border-slate-700">
                </div>

                <!-- Descripción / Mensaje -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5" id="labelDescripcion">Descripción</label>
                    <textarea id="recursoDescripcion" rows="3" placeholder="Texto adicional o mensaje para el paciente..."
                        class="w-full border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none placeholder:text-slate-400 dark:placeholder:text-slate-500"></textarea>
                </div>

                <!-- Destino -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Destino</label>
                    <div class="flex gap-2">
                        <button type="button" onclick="seleccionarDestino('todos')" id="btn-dest-todos"
                            class="dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all border-indigo-300 bg-indigo-50 text-indigo-700 dark:border-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                            <span class="material-symbols-outlined text-[16px]">groups</span>
                            Todos mis pacientes
                        </button>
                        <button type="button" onclick="seleccionarDestino('especifico')" id="btn-dest-especifico"
                            class="dest-btn flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl border-2 text-xs font-bold transition-all border-slate-200 text-slate-500 hover:border-indigo-200 hover:bg-indigo-50/50 dark:border-slate-700 dark:text-slate-400 dark:hover:border-indigo-700 dark:hover:bg-indigo-900/30">
                            <span class="material-symbols-outlined text-[16px]">person</span>
                            Paciente específico
                        </button>
                    </div>
                    <input type="hidden" id="recursoDestino" value="todos">
                </div>

                <!-- Selector de múltiples pacientes -->
                <div id="selectorPaciente" class="mb-5 hidden">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Seleccionar Pacientes</label>
                    
                    <!-- Controles de búsqueda y filtrado -->
                    <div class="space-y-2 mb-3">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-600 text-[18px]">search</span>
                            <input type="text" id="buscarPacienteRec" placeholder="Buscar por nombre o correo..."
                                oninput="filtrarYMostrarPacientes()"
                                class="w-full pl-9 pr-4 py-2 border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-xl text-xs focus:outline-none focus:border-orange-400 transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-500">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Filtro de Trastorno -->
                            <select id="filtroTrastorno" onchange="filtrarYMostrarPacientes()"
                                class="border-2 border-slate-200 dark:border-slate-700 rounded-xl px-2 py-1.5 text-xs focus:outline-none focus:border-orange-400 transition-colors bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 font-medium">
                                <option value="">Todos los trastornos</option>
                                <option value="Ansiedad">Ansiedad</option>
                                <option value="Depresión">Depresión</option>
                                <option value="Estrés">Estrés</option>
                                <option value="Autoestima">Autoestima</option>
                                <option value="Duelo">Duelo</option>
                                <option value="Académico / Concentración">Académico / Concentración</option>
                                <option value="Adaptación / Conducta">Adaptación / Conducta</option>
                                <option value="Otros">Otros</option>
                                <option value="Sin especificar">Sin especificar</option>
                            </select>
                            
                            <!-- Ordenación -->
                            <select id="ordenarPacientes" onchange="filtrarYMostrarPacientes()"
                                class="border-2 border-slate-200 dark:border-slate-700 rounded-xl px-2 py-1.5 text-xs focus:outline-none focus:border-orange-400 transition-colors bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 font-medium">
                                <option value="AZ">Nombre (A-Z)</option>
                                <option value="ZA">Nombre (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Lista de Pacientes -->
                    <div id="pacientesListContainer" class="max-h-56 overflow-y-auto border-2 border-slate-100 dark:border-slate-700 rounded-xl p-2 space-y-1 bg-slate-50/50 dark:bg-slate-800/50">
                        <!-- Se genera dinámicamente con JS -->
                    </div>
                    
                    <!-- Resumen de selección -->
                    <div class="flex items-center justify-between mt-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                        <span id="pacientesSeleccionadosCount">0 pacientes seleccionados</span>
                        <button type="button" onclick="limpiarSeleccionPacientes()" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 hover:underline">
                            Limpiar selección
                        </button>
                    </div>
                </div>

                <!-- Error / Success -->
                <div id="pubError" class="hidden mb-3 p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl text-xs text-red-600 dark:text-red-400 flex items-start gap-2">
                    <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">error</span>
                    <span id="pubErrorMsg"></span>
                </div>
                <div id="pubSuccess" class="hidden mb-3 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl text-xs text-green-700 dark:text-green-400 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span id="pubSuccessMsg"></span>
                </div>

                <button onclick="publicarRecurso()" id="btnPublicar"
                    class="w-full py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-amber-600 shadow-md shadow-orange-200 dark:shadow-orange-900/30 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-[20px]">publish</span>
                    Publicar
                </button>
            </div>
        </div>

        <!-- ══ LISTA DE RECURSOS (derecha) ══ -->
        <div class="xl:col-span-3">
            <div id="listaRecursosContainer">
                <?php if (empty($recursos)): ?>
                <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-12 text-center border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <span class="material-symbols-outlined text-[56px] text-slate-300 dark:text-slate-600 block mb-3">folder_open</span>
                    <p class="text-slate-500 dark:text-slate-400 font-semibold">Aún no has publicado recursos</p>
                    <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Usa el panel de la izquierda para crear el primero</p>
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
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md hover:border-slate-200 dark:hover:border-slate-600 transition-all p-5 flex gap-4 group"
                             id="rec-<?= $r['id_recurso'] ?>">
                        <div class="w-11 h-11 rounded-2xl <?= $color ?> flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]"><?= $ico ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 dark:text-slate-100 truncate"><?= htmlspecialchars($r['titulo']) ?></p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?= $label ?> · <?= date('d M Y', strtotime($r['fecha_creacion'])) ?></p>
                                    <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full <?= $r['id_usuario'] ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' ?>">
                                        <span class="material-symbols-outlined text-[12px]"><?= $r['id_usuario'] ? 'person' : 'groups' ?></span>
                                        <?= htmlspecialchars($destLabel) ?>
                                    </span>
                                </div>
                                <button onclick="eliminarRecurso(<?= $r['id_recurso'] ?>)"
                                    class="p-1.5 rounded-lg text-slate-300 dark:text-slate-600 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all opacity-0 group-hover:opacity-100 shrink-0" title="Eliminar">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                            <?php if ($r['descripcion']): ?>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2"><?= htmlspecialchars($r['descripcion']) ?></p>
                            <?php endif; ?>
                            <!-- Preview según tipo -->
                            <?php if ($tipo === 'video' && $r['url_video']): ?>
                            <a href="<?= htmlspecialchars($r['url_video']) ?>" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 mt-2 text-xs text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                Ver video
                            </a>
                            <?php elseif ($tipo === 'imagen' && $r['imagen_ruta']): ?>
                            <img src="<?= URL_BASE . htmlspecialchars($r['imagen_ruta']) ?>" alt="<?= htmlspecialchars($r['titulo']) ?>"
                                 class="mt-3 rounded-xl max-h-32 object-cover border border-slate-100 dark:border-slate-700 cursor-pointer"
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
const ALL_PATIENTS = <?= json_encode($pacientes ?? []) ?>;
const selectedPatientIds = new Set();

const DISORDER_BADGES = {
    'Ansiedad': 'bg-red-50 text-red-600 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
    'Depresión': 'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
    'Estrés': 'bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
    'Autoestima': 'bg-pink-50 text-pink-600 border border-pink-200 dark:bg-pink-900/30 dark:text-pink-400 dark:border-pink-800',
    'Duelo': 'bg-purple-50 text-purple-600 border border-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
    'Académico / Concentración': 'bg-indigo-50 text-indigo-600 border border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
    'Adaptación / Conducta': 'bg-teal-50 text-teal-600 border border-teal-200 dark:bg-teal-900/30 dark:text-teal-400 dark:border-teal-800',
    'Otros': 'bg-gray-50 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700',
    'Sin especificar': 'bg-slate-50 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700'
};

document.addEventListener('DOMContentLoaded', () => {
    filtrarYMostrarPacientes();
});

function filtrarYMostrarPacientes() {
    const q = document.getElementById('buscarPacienteRec').value.toLowerCase().trim();
    const trastornoFiltro = document.getElementById('filtroTrastorno').value;
    const orden = document.getElementById('ordenarPacientes').value;
    
    // Filtrar
    let filtered = ALL_PATIENTS.filter(p => {
        const matchesQuery = p.nombre.toLowerCase().includes(q) || p.correo_electronico.toLowerCase().includes(q);
        const matchesTrastorno = trastornoFiltro === "" || p.trastorno === trastornoFiltro;
        return matchesQuery && matchesTrastorno;
    });
    
    // Ordenar
    filtered.sort((a, b) => {
        const comp = a.nombre.localeCompare(b.nombre, 'es', { sensitivity: 'base' });
        return orden === 'AZ' ? comp : -comp;
    });
    
    // Renderizar
    const container = document.getElementById('pacientesListContainer');
    if (filtered.length === 0) {
        container.innerHTML = '<p class="text-xs text-slate-400 text-center py-4">No se encontraron pacientes</p>';
        return;
    }
    
    container.innerHTML = filtered.map(p => {
        const isChecked = selectedPatientIds.has(p.id_usuario) ? 'checked' : '';
        const badgeClass = DISORDER_BADGES[p.trastorno] || 'bg-slate-50 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700';
        
        return `
            <label class="flex items-center gap-3 px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg cursor-pointer transition-colors select-none">
                <input type="checkbox" value="${p.id_usuario}" ${isChecked} 
                    onchange="togglePatientSelection(this)"
                    class="paciente-checkbox w-4 h-4 text-orange-500 focus:ring-orange-400 border-slate-300 dark:border-slate-600 rounded transition-all">
                <div class="w-7 h-7 rounded-full bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400 flex items-center justify-center text-xs font-bold shrink-0 font-sans">
                    ${escRec(p.nombre.charAt(0).toUpperCase())}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-100 truncate">${escRec(p.nombre)}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">Grado ${escRec(p.grado)} • ${escRec(p.correo_electronico)}</p>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-medium shrink-0 ${badgeClass}">
                    ${escRec(p.trastorno)}
                </span>
            </label>
        `;
    }).join('');
}

function togglePatientSelection(checkbox) {
    const id = parseInt(checkbox.value, 10);
    if (checkbox.checked) {
        selectedPatientIds.add(id);
    } else {
        selectedPatientIds.delete(id);
    }
    actualizarResumenSeleccion();
}

function actualizarResumenSeleccion() {
    const count = selectedPatientIds.size;
    document.getElementById('pacientesSeleccionadosCount').textContent = `${count} paciente(s) seleccionado(s)`;
}

function limpiarSeleccionPacientes() {
    selectedPatientIds.clear();
    document.querySelectorAll('.paciente-checkbox').forEach(cb => cb.checked = false);
    actualizarResumenSeleccion();
}

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

    if (!titulo) { mostrarErrPub('El título es obligatorio.'); return; }
    if (tipo === 'mensaje' && !desc) { mostrarErrPub('El mensaje no puede estar vacío.'); return; }
    
    if (destino === 'especifico' && selectedPatientIds.size === 0) {
        mostrarErrPub('Selecciona al menos un paciente.');
        return;
    }

    const fd = new FormData();
    fd.append('tipo', tipo);
    fd.append('titulo', titulo);
    fd.append('descripcion', desc);
    fd.append('destino', destino);
    
    if (destino === 'especifico') {
        selectedPatientIds.forEach(id => {
            fd.append('id_usuarios[]', id);
        });
    }

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
    const previewContainer = document.getElementById('youtubePreviewContainer');
    if (previewContainer) {
        previewContainer.classList.add('hidden');
        previewContainer.innerHTML = '';
    }
    limpiarSeleccionPacientes();
    document.getElementById('buscarPacienteRec').value = '';
    document.getElementById('filtroTrastorno').value = '';
    document.getElementById('ordenarPacientes').value = 'AZ';
    filtrarYMostrarPacientes();
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

// ── oEmbed Preview ────────────────────────────────────────────────
let oembedTimeout = null;
const urlInput = document.getElementById('recursoUrl');
const previewContainer = document.getElementById('youtubePreviewContainer');
const tituloInput = document.getElementById('recursoTitulo');

if (urlInput) {
    urlInput.addEventListener('input', function(e) {
        const url = e.target.value.trim();
        clearTimeout(oembedTimeout);
        
        if (!url) {
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
            return;
        }

        // Comprobar si parece de youtube
        if (!url.match(/youtube\.com|youtu\.be/i)) {
            previewContainer.classList.add('hidden');
            return;
        }

        // Mostrar estado de carga
        previewContainer.classList.remove('hidden');
        previewContainer.innerHTML = `
            <div class="p-4 flex items-center gap-3 text-slate-500">
                <span class="material-symbols-outlined animate-spin">progress_activity</span>
                <span class="text-sm font-medium">Buscando información del video...</span>
            </div>
        `;

        oembedTimeout = setTimeout(async () => {
            try {
                const res = await fetch(BASE + 'api/oembed/youtube?link=' + encodeURIComponent(url));
                const json = await res.json();

                if (json.ok) {
                    const dto = json.data;
                    // Autocompletar título si está vacío
                    if (!tituloInput.value.trim()) {
                        tituloInput.value = dto.title;
                    }

                    // Mostrar previsualización con miniatura
                    previewContainer.innerHTML = `
                        <div class="relative bg-slate-900 aspect-video flex items-center justify-center">
                            <img src="${dto.thumbnail_url}" alt="${escRec(dto.title)}" class="absolute inset-0 w-full h-full object-cover opacity-60">
                            <span class="material-symbols-outlined text-white text-[48px] relative z-10 drop-shadow-md">play_circle</span>
                        </div>
                        <div class="p-3 bg-white dark:bg-slate-800">
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-1">${escRec(dto.title)}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${escRec(dto.author_name || dto.provider_name)}</p>
                        </div>
                    `;
                } else {
                    // Mostrar error
                    previewContainer.innerHTML = `
                        <div class="p-3 bg-red-50 text-red-600 flex items-start gap-2 border-t border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800">
                            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
                            <p class="text-xs font-medium">${escRec(json.error)}</p>
                        </div>
                    `;
                }
            } catch (err) {
                previewContainer.innerHTML = `
                    <div class="p-3 bg-red-50 text-red-600 flex items-start gap-2 border-t border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800">
                        <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
                        <p class="text-xs font-medium">Error de conexión al cargar la vista previa.</p>
                    </div>
                `;
            }
        }, 800); // 800ms debounce
    });
}
</script>

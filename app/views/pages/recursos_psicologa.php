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
$tipoColor = ['video' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400', 'mensaje' => 'bg-[#8DA399]/20 text-[#4a6e66]', 'imagen' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400'];
$tipoLabel = ['video' => 'Video', 'mensaje' => 'Mensaje', 'imagen' => 'Imagen'];
?>

<style>
    #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
    }
    #main-content::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(244, 247, 246, 0.55);
        pointer-events: none;
        z-index: 0;
    }
    .dark #main-content::before { background: rgba(15, 23, 42, 0.65); }
    
    .glass-card {
        background: rgba(255,255,255,0.88) !important;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.6) !important;
        border-radius: 1rem !important;
    }
    .dark .glass-card {
        background: rgba(30,41,59,0.88) !important;
        border-color: rgba(255,255,255,0.1) !important;
    }
    
    .primary-blue { color: #6B8CAE; }
    .bg-primary-blue { background-color: #6B8CAE; }
    .border-primary-blue { border-color: #6B8CAE; }
    .hover-bg-primary-blue:hover { background-color: #5a7e9f; }
    
    .sage-green { color: #8DA399; }
    .bg-sage-green { background-color: #8DA399; }
    .border-sage-green { border-color: #8DA399; }
    
    .avatar-orange {
        background: linear-gradient(135deg, #E8824A, #D96B30) !important;
        box-shadow: 0 2px 8px rgba(232,130,74,0.35) !important;
        color: white !important;
    }
</style>

<style>
@import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap');

/* MODO OSCURO ESPECÍFICO PARA ESTA VISTA (WINTON/COZY) */
.dark #main-content {
    background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg') !important;
    background-size: cover !important;
    background-position: center !important;
    background-color: transparent !important;
}
.dark #main-content::before {
    display: block !important;
    content: '';
    position: fixed;
    inset: 0;
    background: rgba(30, 25, 20, 0.45); /* Tint oscuro sepia muy sutil para dejar ver el fondo real */
    pointer-events: none;
    z-index: 0;
}

/* Tipografía de notas/mensajes */
.font-handwritten {
    font-family: 'Caveat', cursive;
    font-size: 1.4rem;
    line-height: 1.3;
}

/* Efecto de carta apilada sutil */
.card-inner { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card-tilted:nth-child(even) .card-inner { transform: rotate(0.8deg); }
.card-tilted:nth-child(odd) .card-inner { transform: rotate(-0.8deg); }
.card-tilted:hover .card-inner { transform: rotate(0deg) scale(1.015); z-index: 10; box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important; }

/* Custom Scrollbar for dropdowns */
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #d4c3a3; border-radius: 10px; }
</style>

<div class="relative z-10 p-6 md:p-10 max-w-7xl mx-auto w-full">
    <!-- Header General -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] drop-shadow-md mb-1">Gestión de Recursos</h1>
            <p class="text-slate-500 dark:text-[#c4bcae] text-sm">Publica videos, mensajes e imágenes para tus pacientes</p>
        </div>
        <div class="bg-white/80 dark:bg-white/10 px-4 py-2 rounded-full border border-[#b0d0c4] dark:border-[#d4c3a3] shadow-md flex items-center gap-2">
            <span class="text-[#3d6b5a] dark:text-[#3a2e1d] font-bold text-sm">Has compartido <?= count($recursos) ?> momentos de bienestar.</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 relative">
        
        <!-- =================== LEFT PANEL (FORM) =================== -->
        <div class="lg:col-span-5">
            <div class="bg-white/80 dark:bg-white dark:!bg-[#2a2926]/95 backdrop-blur-md rounded-[2.5rem] p-7 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-slate-200 dark:!border-white/10">
                
                <!-- Title inside form -->
                <div class="flex items-center gap-4 mb-7">
                    <div class="w-10 h-10 rounded-full border border-[#f5ebd7]/30 flex items-center justify-center text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7]">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] leading-tight">Crear un Nuevo Recurso<br>de Bienestar</h2>
                </div>

                <!-- SELECTOR DE TIPO -->
                <input type="hidden" id="recursoTipo" value="video">
                <label class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-2.5">Tipo de contenido</label>
                <div class="grid grid-cols-3 gap-3 mb-6" id="tipoSelector">
                    <button type="button" onclick="seleccionarTipo('video')" id="btn-tipo-video"
                        class="tipo-btn active-tipo flex flex-col items-center justify-center gap-1.5 p-3 rounded-2xl border border-[#b0d0c4] dark:border-[#d4c3a3] bg-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d] transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[24px]">video_camera_front</span>
                        <span class="text-xs font-bold">Video</span>
                    </button>
                    <button type="button" onclick="seleccionarTipo('mensaje')" id="btn-tipo-mensaje"
                        class="tipo-btn flex flex-col items-center justify-center gap-1.5 p-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#3a3732] text-slate-500 dark:text-[#c4bcae] transition-all">
                        <span class="material-symbols-outlined text-[24px]">edit_note</span>
                        <span class="text-xs font-bold">Nota</span>
                    </button>
                    <button type="button" onclick="seleccionarTipo('imagen')" id="btn-tipo-imagen"
                        class="tipo-btn flex flex-col items-center justify-center gap-1.5 p-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#424d45] text-slate-500 dark:text-[#c4bcae] transition-all">
                        <span class="material-symbols-outlined text-[24px]">image</span>
                        <span class="text-xs font-bold">Imagen</span>
                    </button>
                </div>

                <!-- TÍTULO -->
                <div class="mb-5">
                    <label class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-1.5">Título *</label>
                    <input type="text" id="recursoTitulo" placeholder="Nombre de la técnica o consejo"
                        class="w-full bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border border-slate-200 dark:!border-white/10 rounded-2xl px-5 py-3.5 text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] text-sm focus:outline-none focus:border-[#8DA399] dark:focus:border-[#d4c3a3] transition-colors placeholder-[#666]">
                </div>

                <!-- CONTENIDO DINÁMICO (VIDEO/IMAGEN) -->
                <div id="campoVideo" class="mb-5">
                    <label class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-1.5">URL del video *</label>
                    <input type="text" id="recursoUrl" placeholder="https://youtube.com/watch?v=..."
                        class="w-full bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border border-slate-200 dark:!border-white/10 rounded-2xl px-5 py-3.5 text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] text-sm focus:outline-none focus:border-[#8DA399] dark:focus:border-[#d4c3a3] transition-colors placeholder-[#666]">
                    <p class="text-slate-500 dark:text-[#a39c8e] text-[10px] mt-2 ml-1">Comparte un enlace de ayuda, como una meditación guiada.</p>
                    
                    <div id="youtubePreviewContainer" class="hidden mt-3 rounded-xl overflow-hidden border border-slate-200 dark:!border-white/10 shadow-inner"></div>
                </div>

                <div id="campoImagen" class="mb-5 hidden">
                    <label class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-1.5">Subir Imagen *</label>
                    <div class="relative group cursor-pointer bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border border-slate-200 dark:!border-white/10 border-dashed rounded-2xl px-5 py-6 text-center hover:border-[#d4c3a3] transition-colors">
                        <input type="file" id="recursoImagen" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImagen(this)">
                        <span class="material-symbols-outlined text-slate-500 dark:text-[#a39c8e] text-3xl mb-1 group-hover:text-[#d4c3a3] transition-colors">cloud_upload</span>
                        <p class="text-slate-500 dark:text-[#c4bcae] text-xs">Haz clic o arrastra tu imagen aquí</p>
                    </div>
                    <img id="imagenPreview" class="hidden mt-3 w-full h-32 object-cover rounded-xl border border-slate-200 dark:!border-white/10 shadow-inner" src="" alt="Vista previa">
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="mb-5">
                    <label id="labelDescripcion" class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-1.5">Descripción</label>
                    <textarea id="recursoDescripcion" rows="3" placeholder="Describe el impacto o la guía para tu paciente."
                        class="w-full bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border border-slate-200 dark:!border-white/10 rounded-2xl px-5 py-3.5 text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] text-sm focus:outline-none focus:border-[#8DA399] dark:focus:border-[#d4c3a3] transition-colors resize-none placeholder-[#666]"></textarea>
                </div>

                <!-- DESTINO -->
                <div class="mb-8 relative" id="selectorPaciente">
                    <input type="hidden" id="recursoDestino" value="todos">
                    <label class="block text-[11px] font-bold text-slate-500 dark:text-[#a39c8e] uppercase tracking-widest mb-2">Destino</label>
                    
                    <div class="flex gap-2">
                        <button type="button" onclick="seleccionarDestino('todos')" id="btn-dest-todos"
                            class="flex-1 flex items-center justify-center gap-2 bg-[#d4c3a3] border border-[#b0d0c4] dark:border-[#d4c3a3] rounded-2xl py-2.5 px-3 transition-colors shadow-sm text-[#3d6b5a] dark:text-[#3a2e1d]">
                            <span class="material-symbols-outlined text-[20px]">groups</span>
                            <div class="flex -space-x-2 opacity-80">
                                <?php $limit = min(3, count($pacientes ?? [])); for($i=0; $i<$limit; $i++): ?>
                                    <div class="w-5 h-5 rounded-full bg-white dark:!bg-[#2a2926] border border-[#b0d0c4] dark:border-[#d4c3a3] flex items-center justify-center text-[8px] text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] font-bold">
                                        <?= strtoupper(substr($pacientes[$i]['nombre'], 0, 1)) ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </button>

                        <button type="button" onclick="seleccionarDestino('especifico')" id="btn-dest-especifico"
                            class="flex-1 flex items-center justify-center gap-2 bg-[#23221f] border border-slate-200 dark:!border-white/10 rounded-2xl py-2.5 px-3 text-slate-500 dark:text-[#c4bcae] text-xs font-bold hover:bg-[#33322d] transition-colors">
                            <span class="material-symbols-outlined text-[18px]">person_search</span>
                            Paciente específico
                        </button>
                    </div>

                    <!-- Buscador Desplegable para Pacientes Específicos -->
                    <div id="resultadosBusqRec" class="hidden absolute top-full z-50 w-full mt-2 class="bg-white dark:bg-white dark:!bg-[#2a2926] border border-slate-200 dark:!border-white/10 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.6)] max-h-64 flex flex-col overflow-hidden left-0 right-0 mt-2 bg-white dark:!bg-[#2a2926] border border-[#b0d0c4] dark:border-[#d4c3a3]/30 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.6)] z-50 max-h-64 flex flex-col overflow-hidden">
                        
                        <div class="p-3 border-b border-slate-200 dark:!border-white/10 bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18]">
                            <div class="flex items-center gap-2 bg-white dark:!bg-[#2a2926] rounded-xl px-3 py-2 border border-slate-200 dark:!border-white/10">
                                <span class="material-symbols-outlined text-slate-500 dark:text-[#a39c8e] text-[18px]">search</span>
                                <input type="text" id="buscarPacienteRec" placeholder="Buscar paciente..." oninput="filtrarYMostrarPacientes()"
                                    class="bg-transparent border-none outline-none text-sm w-full text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] placeholder-[#666]">
                            </div>
                            <div class="flex gap-2 mt-2">
                                <select id="filtroTrastorno" onchange="filtrarYMostrarPacientes()" class="text-xs bg-white dark:!bg-[#2a2926] border border-slate-200 dark:!border-white/10 text-slate-500 dark:text-[#c4bcae] rounded-lg px-2 py-1 outline-none flex-1">
                                    <option value="">Cualquier trastorno</option>
                                    <option value="Ansiedad">Ansiedad</option>
                                    <option value="Depresión">Depresión</option>
                                    <option value="Estrés">Estrés</option>
                                    <option value="TDAH">TDAH</option>
                                    <option value="TCA">TCA</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <select id="ordenarPacientes" onchange="filtrarYMostrarPacientes()" class="text-xs bg-white dark:!bg-[#2a2926] border border-slate-200 dark:!border-white/10 text-slate-500 dark:text-[#c4bcae] rounded-lg px-2 py-1 outline-none">
                                    <option value="AZ">A-Z</option>
                                    <option value="ZA">Z-A</option>
                                </select>
                            </div>
                        </div>

                        <div id="pacientesListContainer" class="overflow-y-auto custom-scrollbar p-2 space-y-1">
                            <!-- JS inyecta lista de pacientes aquí -->
                        </div>

                        <div class="p-3 border-t border-white/5 bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] flex justify-between items-center">
                            <span id="txt-seleccion-rec" class="text-xs font-bold text-[#d4c3a3]">0 seleccionados</span>
                            <button type="button" onclick="document.getElementById('resultadosBusqRec').classList.add('hidden')"
                                class="px-3 py-1 bg-white dark:bg-[#3a3732] text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] rounded-lg text-xs font-bold hover:bg-[#4a4742]">Listo</button>
                        </div>
                    </div>
                </div>

                <!-- ALERTS -->
                <div id="pubError" class="hidden mb-4 p-3 bg-red-900/40 border border-red-500/30 rounded-xl text-red-200 text-sm flex gap-2 items-center">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    <span id="pubErrorMsg">Error general</span>
                </div>
                <div id="pubSuccess" class="hidden mb-4 p-3 bg-green-900/40 border border-[#3A5C3D] rounded-xl text-[#D7E6D5] text-sm flex gap-2 items-center">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span id="pubSuccessMsg">¡Recurso publicado!</span>
                </div>

                <!-- SUBMIT -->
                <button onclick="publicarRecurso()" id="btnPublicar" 
                    class="w-full bg-[#6B8CAE] hover:bg-[#5a7e9f] dark:bg-[#4a1a1a] dark:hover:bg-[#632222] dark:border-[#632222] text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] font-bold text-sm py-4 rounded-2xl flex items-center justify-center gap-2 transition-all shadow-lg active:scale-[0.98]">
                    <span class="material-symbols-outlined">psychiatry</span>
                    Compartir Bienestar
                </button>
            </div>
        </div>

        <!-- =================== RIGHT PANEL (FEED) =================== -->
        <div class="lg:col-span-7">
            <h2 class="text-2xl text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] mb-8 drop-shadow-md" style="font-family: 'Caveat', cursive; font-size:2rem;">Tus Contribuciones al Bienestar</h2>
            
            <?php if (empty($recursos)): ?>
                <div class="text-center py-20 text-slate-500 dark:text-[#a39c8e]">
                    <span class="material-symbols-outlined text-[64px] mb-4 opacity-50">auto_awesome</span>
                    <p class="text-lg">No has compartido recursos aún.</p>
                </div>
            <?php else: ?>
                <div class="space-y-10 pl-2 md:pl-6 pb-20">
                    <?php foreach ($recursos as $index => $rec): 
                        $esVideo = ($rec['tipo'] === 'video');
                        $esMsg   = ($rec['tipo'] === 'mensaje');
                        $esImg   = ($rec['tipo'] === 'imagen');

                        // Offset aleatorio para que se vea orgánico (zigzag)
                        $marginLeft = ($index % 2 == 0) ? 'ml-0' : 'ml-8 md:ml-12';
                    ?>
                        <div class="card-tilted <?= $marginLeft ?>" id="rec-<?= $rec['id'] ?>">
                            <div class="card-inner relative bg-white/90 dark:bg-[#2e2d2b] p-5 md:p-6 rounded-2xl flex flex-col md:flex-row gap-5 shadow-[0_10px_30px_rgba(0,0,0,0.6)] border border-slate-200 dark:!border-white/10 group transition-transform hover:-translate-y-1">
                                
                                <!-- Botón eliminar (oculto por defecto, visible en hover) -->
                                <button onclick="eliminarRecurso(<?= $rec['id'] ?>)" 
                                    class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-red-900/90 text-red-200 shadow-md border border-red-500/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20 hover:scale-110">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </button>

                                <?php if ($esVideo): ?>
                                    <!-- THUMBNAIL VIDEO -->
                                    <div class="w-full md:w-40 h-24 rounded-xl overflow-hidden relative shrink-0 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18]">
                                        <?php
                                            $vidUrl = $rec['url_video'] ?? '';
                                            $thumb = '';
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $vidUrl, $m)) {
                                                $thumb = "https://img.youtube.com/vi/{$m[1]}/mqdefault.jpg";
                                            }
                                        ?>
                                        <?php if($thumb): ?>
                                            <img src="<?= $thumb ?>" class="w-full h-full object-cover opacity-80" alt="Video">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="material-symbols-outlined text-slate-500 dark:text-[#a39c8e] text-3xl">smart_display</span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] text-4xl drop-shadow-lg">play_circle</span>
                                        </div>
                                    </div>
                                <?php elseif ($esImg && !empty($rec['url_imagen'])): ?>
                                    <!-- THUMBNAIL IMAGEN -->
                                    <div class="w-full md:w-40 h-24 rounded-xl overflow-hidden relative shrink-0 border border-slate-200 dark:border-white/10 cursor-pointer bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18]" onclick="verImagenFull('<?= URL_BASE . 'public/' . htmlspecialchars($rec['url_imagen']) ?>', '<?= htmlspecialchars($rec['titulo']) ?>')">
                                        <img src="<?= URL_BASE . 'public/' . htmlspecialchars($rec['url_imagen']) ?>" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition-opacity" alt="Imagen">
                                        <div class="absolute bottom-1 right-1 bg-black/60 rounded p-1">
                                            <span class="material-symbols-outlined text-white text-[14px]">zoom_in</span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- CONTENIDO DE LA TARJETA -->
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start gap-2">
                                            <h3 class="text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] font-bold text-lg leading-tight break-words"><?= htmlspecialchars($rec['titulo']) ?></h3>
                                            
                                            <!-- Destinatario Avatar -->
                                            <?php if ($rec['id_paciente']): ?>
                                                <?php 
                                                    // Buscar inicial del paciente
                                                    $inicial = '?';
                                                    foreach(($pacientes ?? []) as $pa) {
                                                        if($pa['id'] == $rec['id_paciente']) {
                                                            $inicial = strtoupper(substr($pa['nombre'], 0, 1));
                                                            break;
                                                        }
                                                    }
                                                ?>
                                                <div class="w-7 h-7 rounded-full bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border-2 border-[#2e2d2b] flex items-center justify-center text-[10px] text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] font-bold shrink-0 shadow-sm" title="Paciente específico">
                                                    <?= $inicial ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-7 h-7 rounded-full bg-slate-50 dark:bg-slate-50 dark:!bg-[#1b1a18] border-2 border-[#2e2d2b] flex items-center justify-center text-[14px] text-slate-500 dark:text-[#a39c8e] shrink-0 shadow-sm" title="Para todos">
                                                    <span class="material-symbols-outlined text-[14px]">public</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex items-center gap-1.5 text-slate-500 dark:text-[#a39c8e] text-xs mt-1">
                                            <?php if ($esVideo): ?> <span class="material-symbols-outlined text-[14px]">movie</span> Video 
                                            <?php elseif ($esMsg): ?> <span class="material-symbols-outlined text-[14px]">notes</span> Mensaje 
                                            <?php else: ?> <span class="material-symbols-outlined text-[14px]">image</span> Imagen <?php endif; ?>
                                            <span>&bull;</span>
                                            <span><?= date('d M Y', strtotime($rec['fecha_creacion'])) ?></span>
                                        </div>

                                        <?php if ($esMsg): ?>
                                            <!-- Texto manuscrito para notas -->
                                            <p class="mt-4 font-handwritten text-[#d4c3a3] whitespace-pre-wrap">"<?= htmlspecialchars($rec['descripcion']) ?>"</p>
                                        <?php else: ?>
                                            <p class="text-slate-500 dark:text-[#c4bcae] text-sm mt-2 line-clamp-2"><?= htmlspecialchars($rec['descripcion']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($esVideo && !empty($rec['url_video'])): ?>
                                        <div class="mt-4 flex items-center gap-1.5 text-[#d4c3a3] text-sm font-bold">
                                            <span class="material-symbols-outlined text-[18px]">open_in_new</span> 
                                            <a href="<?= htmlspecialchars($rec['url_video']) ?>" target="_blank" class="hover:underline">Ver video original</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para ver imagen en grande -->
<div id="lightbox" class="hidden fixed inset-0 z-50 bg-black/90 backdrop-blur-sm items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="cerrarLightbox()" class="absolute -top-12 right-0 text-white hover:text-[#d4c3a3] transition-colors">
            <span class="material-symbols-outlined text-4xl">close</span>
        </button>
        <img id="lightboxImg" src="" alt="Zoom" class="w-full max-h-[85vh] object-contain rounded-xl shadow-2xl border border-slate-200 dark:border-white/10">
        <p id="lightboxCaption" class="text-center text-slate-800 dark:text-slate-800 dark:text-[#f5ebd7] mt-4 font-handwritten text-2xl"></p>
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
    'Académico / Concentración': 'bg-[#6B8CAE]/10 text-indigo-600 border border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
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
        container.innerHTML = '<p class="text-xs text-slate-500 dark:text-[#c4bcae] text-center py-4">No se encontraron pacientes</p>';
        return;
    }
    
    container.innerHTML = filtered.map(p => {
        const isChecked = selectedPatientIds.has(p.id_paciente) ? 'checked' : '';
        const badgeClass = DISORDER_BADGES[p.trastorno] || 'bg-slate-50 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700';
        
        return `
            <label class="flex items-center gap-3 px-3 py-2 hover:bg-slate-100 dark:hover:!bg-[#3a3732] rounded-lg cursor-pointer transition-colors select-none">
                <input type="checkbox" value="${p.id_paciente}" ${isChecked} 
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
    video:   'border-[#d4c3a3] bg-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d]',
    mensaje: 'border-[#d4c3a3] bg-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d]',
    imagen:  'border-[#d4c3a3] bg-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d]',
};
const tipoInactivo = 'border-slate-200 dark:border-white/10 bg-white dark:bg-[#3a3732] text-slate-500 dark:text-[#c4bcae]';

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
    document.getElementById('btn-dest-todos').className = 'dest-btn flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-2xl border transition-colors shadow-sm '
        + (esTodos ? 'bg-[#d4c3a3] border-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d]' : 'bg-[#23221f] border-white/5 text-slate-500 dark:text-[#c4bcae] hover:bg-[#33322d]');
    document.getElementById('btn-dest-especifico').className = 'dest-btn flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-2xl border transition-colors text-xs font-bold '
        + (!esTodos ? 'bg-[#d4c3a3] border-[#d4c3a3] text-[#3d6b5a] dark:text-[#3a2e1d]' : 'bg-[#23221f] border-white/5 text-slate-500 dark:text-[#c4bcae] hover:bg-[#33322d]');
    document.getElementById('resultadosBusqRec').classList.toggle('hidden', esTodos);
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
            fd.append('id_pacientes[]', id);
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
                            <p class="text-xs text-slate-500 dark:!text-[#8DA399] mt-1">${escRec(dto.author_name || dto.provider_name)}</p>
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

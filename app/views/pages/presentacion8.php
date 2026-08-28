<!-- PSYCO — Presentación 8 (Modelo Relacional) -->
<script>
    // Ocultar sidebar y ajustar el layout al entrar a esta página
    (function() {
        const sidebar = document.getElementById('app-sidebar');
        const mainContent = document.getElementById('main-content');
        if (sidebar) {
            sidebar.style.display = 'none';
        }
        if (mainContent) {
            mainContent.style.marginLeft = '0';
            mainContent.classList.remove('lg:ml-64');
        }
        // Restaurar al salir de la página
        window.addEventListener('pagehide', () => {
            if (sidebar) sidebar.style.display = '';
            if (mainContent) {
                mainContent.style.marginLeft = '';
                mainContent.classList.add('lg:ml-64');
            }
        });
    })();
</script>
<style>
    @keyframes nebula-flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .bg-nebula {
        background: linear-gradient(270deg, #10b981, #2563eb, #34d399, #3b82f6);
        background-size: 300% 300%;
        animation: nebula-flow 8s ease infinite;
    }
    .text-nebula {
        background: linear-gradient(270deg, #10b981, #2563eb, #34d399, #3b82f6);
        background-size: 300% 300%;
        animation: nebula-flow 8s ease infinite;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
    }
    /* Estilos para arrastrar */
    .draggable-card {
        transition: box-shadow 0.2s ease;
        will-change: transform; /* optimiza el rendimiento al arrastrar */
    }
    .draggable-card.dragging {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        opacity: 0.95;
    }
</style>
<section class="min-h-screen py-8 px-4 bg-nebula flex flex-col items-center justify-start w-full relative overflow-x-hidden overflow-y-hidden">

    <!-- Overlay SVG para dibujar las relaciones -->
    <svg id="svg-lines" class="absolute top-0 left-0 w-full h-full pointer-events-none z-0"></svg>

    <div class="w-full max-w-7xl flex flex-col items-center mb-6 mt-4 z-10 relative pointer-events-none">
        <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-wide drop-shadow-lg mb-2" style="font-family: 'Canva Sans', sans-serif;">
            MODELO RELACIONAL
        </h2>
        <p class="text-sm text-white/90 font-medium bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-md">Arrastra las tablas para organizarlas libremente</p>
    </div>

    <!-- Contenedor Grid para posiciones iniciales -->
    <div id="grid-container" class="w-full min-w-[1200px] max-w-[1400px] grid grid-cols-4 gap-4 items-start z-10 relative px-6 mx-auto pb-32">

        <!-- COLUMNA 1 -->
        <div class="flex flex-col gap-5 pt-32">
            <!-- Tabla: otp_codes -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #334155;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        otp_codes
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="otp-id" class="px-2.5 py-1 flex justify-between bg-yellow-50/50"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">email</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">code_hash</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(64)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">type</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">attempts</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">tinyint(3)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">status</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">expires_at</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">created_at</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                </ul>
            </div>
        </div>

        <!-- COLUMNA 2 -->
        <div class="flex flex-col gap-5 pt-8">
            <!-- Tabla: recursos_acompanamiento -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #f97316;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        recursos_acompanamiento
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="recursos-id_recurso" class="px-2.5 py-1 flex justify-between bg-yellow-50/50"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_recurso</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="recursos-id_psicologo" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_psicologo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="recursos-id_usuario" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_usuario</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">titulo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(255)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">tipo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">url_video</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(512)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">imagen_ruta</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(512)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">descripcion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_creacion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                </ul>
            </div>

            <!-- Tabla: notas_paciente -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #c026d3;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        notas_paciente
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="notas-id_nota" class="px-2.5 py-1 flex justify-between bg-yellow-50/50"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_nota</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="notas-id_psicologo" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_psicologo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="notas-id_usuario" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_usuario</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">titulo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(255)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">contenido</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_creacion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                </ul>
            </div>

            <!-- Tabla: especialidades -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #4f46e5;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        especialidades
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="especialidades-id_especialidad" class="px-2.5 py-1 flex justify-between bg-yellow-50/50 relative"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_especialidad</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">nombre</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">descripcion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                </ul>
            </div>
        </div>

        <!-- COLUMNA 3 -->
        <div class="flex flex-col gap-5">
            <!-- Tabla: usuarios -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #2563eb;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        usuarios
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="usuarios-id_usuario" class="px-2.5 py-1 flex justify-between bg-yellow-50/50 relative">
                        <span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_usuario</span>
                        <span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span>
                    </li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">grado</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">nombre</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">correo_electronico</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">contrasena</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(255)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">acepta_politica</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">estado</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">email_verified_at</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_registro</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">acudiente_nombre</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">acudiente_cedula</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">acudiente_relacion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">acudiente_correo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">observaciones_psicologicas</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">google_id</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">avatar_url</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(512)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">verificado</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">tinyint(1)</span></li>
                </ul>
            </div>

            <!-- Tabla: psicologos -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #059669;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        psicologos
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="psicologos-id_psicologo" class="px-2.5 py-1 flex justify-between bg-yellow-50/50 relative"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_psicologo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="psicologos-id_especialidad" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_especialidad</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">nombre</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">telefono</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(20)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">foto_perfil</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(255)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">estado</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_registro</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">correo_electronico</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(100)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">contrasena</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(255)</span></li>
                </ul>
            </div>

            <!-- Tabla: disponibilidad_psicologos -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #0d9488;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        disponibilidad_psicologos
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="disponibilidad-id" class="px-2.5 py-1 flex justify-between bg-yellow-50/50"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_disponibilidad</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="disponibilidad-id_psicologo" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_psicologo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">dia_semana</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">hora_inicio</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">time</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">hora_fin</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">time</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">jornada</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">varchar(20)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">activo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">tinyint(1)</span></li>
                </ul>
            </div>
        </div>

        <!-- COLUMNA 4 -->
        <div class="flex flex-col gap-5 pt-20">
            <!-- Tabla: recordatorios -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #f43f5e;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        recordatorios
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="recordatorios-id" class="px-2.5 py-1 flex justify-between bg-yellow-50/50"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_recordatorio</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="recordatorios-id_cita" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_cita</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">mensaje</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_programada</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_envio</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">canal</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">estado_envio</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                </ul>
            </div>
            
            <!-- Tabla: citas -->
            <div class="draggable-card bg-white rounded-lg shadow-lg border border-slate-300/50 overflow-hidden relative">
                <div class="cursor-move px-3 py-1.5 border-b border-slate-200 select-none" style="background-color: #9333ea;">
                    <h3 class="font-bold text-white text-sm flex items-center gap-1.5 pointer-events-none" style="font-family: 'Canva Sans', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">drag_indicator</span>
                        citas
                    </h3>
                </div>
                <ul class="text-xs divide-y divide-slate-100">
                    <li id="citas-id_cita" class="px-2.5 py-1 flex justify-between bg-yellow-50/50 relative"><span class="font-bold text-slate-800 flex items-center gap-1"><span class="text-yellow-500 material-symbols-outlined text-[14px]">key</span>id_cita</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="citas-id_usuario" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_usuario</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li id="citas-id_psicologo" class="px-2.5 py-1 flex justify-between bg-blue-50/50 relative"><span class="font-medium text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>id_psicologo</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">date</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">hora</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">time</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">duracion_minutos</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">int(11)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">hora_inicio_real</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">timestamp</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">estado</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">enum</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">asistio</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">tinyint(1)</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">motivo_consulta</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">notas_sesion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">text</span></li>
                    <li class="px-2.5 py-1 flex justify-between hover:bg-slate-50"><span class="text-slate-700">fecha_creacion</span><span class="text-slate-400 font-mono text-[9px] mt-0.5">datetime</span></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Navegación fijada en las esquinas inferiores -->
    

<div class="fixed bottom-6 right-8 z-[9999] flex items-center gap-4">
    <a id="btn-v8" href="<?= URL_BASE ?>pages/presentacion7" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
    </a>
    <a id="btn-s8" href="<?= URL_BASE ?>pages/presentacion9" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
    </a>
</div>
</section>

<!-- Script para dibujar las relaciones y arrastrar -->
<script>
    const connections = [
        // Desde Usuarios (PK) - Amarillo de alto contraste
        { from: 'usuarios-id_usuario', to: 'citas-id_usuario', color: '#fbbf24' }, 
        { from: 'usuarios-id_usuario', to: 'notas-id_usuario', color: '#fbbf24' },
        { from: 'usuarios-id_usuario', to: 'recursos-id_usuario', color: '#fbbf24' },
        
        // Desde Psicologos (PK) - Naranja brillante
        { from: 'psicologos-id_psicologo', to: 'citas-id_psicologo', color: '#fb923c' }, 
        { from: 'psicologos-id_psicologo', to: 'notas-id_psicologo', color: '#fb923c' },
        { from: 'psicologos-id_psicologo', to: 'recursos-id_psicologo', color: '#fb923c' },
        { from: 'psicologos-id_psicologo', to: 'disponibilidad-id_psicologo', color: '#fb923c' },
        
        // Desde Especialidades (PK) - Rosa fuerte
        { from: 'especialidades-id_especialidad', to: 'psicologos-id_especialidad', color: '#f472b6' }, 
        
        // Desde Citas (PK) - Blanco
        { from: 'citas-id_cita', to: 'recordatorios-id_cita', color: '#ffffff' } 
    ];

    function drawLines() {
        const svg = document.getElementById('svg-lines');
        if (!svg) return;
        svg.innerHTML = ''; 
        const svgRect = svg.getBoundingClientRect();

        connections.forEach(conn => {
            const fromEl = document.getElementById(conn.from);
            const toEl = document.getElementById(conn.to);
            if (!fromEl || !toEl) return;

            const fromRect = fromEl.getBoundingClientRect();
            const toRect = toEl.getBoundingClientRect();

            let startX = fromRect.right - svgRect.left;
            let startY = fromRect.top + (fromRect.height / 2) - svgRect.top;
            let endX = toRect.left - svgRect.left;
            let endY = toRect.top + (toRect.height / 2) - svgRect.top;

            if (toRect.left < fromRect.left) {
                startX = fromRect.left - svgRect.left;
                endX = toRect.right - svgRect.left;
            }

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            const curveOffset = Math.max(Math.abs(endX - startX) * 0.4, 20);
            
            const ctrl1X = startX + (toRect.left < fromRect.left ? -curveOffset : curveOffset);
            const ctrl2X = endX + (toRect.left < fromRect.left ? curveOffset : -curveOffset);
            
            const d = `M ${startX} ${startY} C ${ctrl1X} ${startY}, ${ctrl2X} ${endY}, ${endX} ${endY}`;
            
            path.setAttribute('d', d);
            path.setAttribute('stroke', conn.color);
            path.setAttribute('stroke-width', '4'); // Línea más gruesa
            path.setAttribute('fill', 'none');
            path.setAttribute('class', 'opacity-100 drop-shadow-md'); // 100% opacidad y sombra para resaltar sobre el fondo
            svg.appendChild(path);
            
            const circle1 = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle1.setAttribute('cx', startX);
            circle1.setAttribute('cy', startY);
            circle1.setAttribute('r', '4');
            circle1.setAttribute('fill', conn.color);
            svg.appendChild(circle1);
            
            const circle2 = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle2.setAttribute('cx', endX);
            circle2.setAttribute('cy', endY);
            circle2.setAttribute('r', '4');
            circle2.setAttribute('fill', conn.color);
            svg.appendChild(circle2);
        });
    }

    // --- Lógica Drag and Drop ---
    let isDragging = false;
    let currentCard = null;
    let startX, startY;

    document.querySelectorAll('.draggable-card').forEach(card => {
        const header = card.querySelector('.cursor-move');
        
        // Inicializar transformaciones a 0
        card.dataset.x = 0;
        card.dataset.y = 0;

        header.addEventListener('mousedown', (e) => {
            isDragging = true;
            currentCard = card;
            
            // Traer al frente
            document.querySelectorAll('.draggable-card').forEach(c => c.style.zIndex = '1');
            currentCard.style.zIndex = '100';
            currentCard.classList.add('dragging');
            
            startX = e.clientX - parseFloat(currentCard.dataset.x);
            startY = e.clientY - parseFloat(currentCard.dataset.y);
            
            document.body.style.userSelect = 'none'; // Evitar selección de texto
        });
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging || !currentCard) return;
        
        const currentX = e.clientX - startX;
        const currentY = e.clientY - startY;
        
        currentCard.dataset.x = currentX;
        currentCard.dataset.y = currentY;
        currentCard.style.transform = `translate(${currentX}px, ${currentY}px)`;
        
        drawLines(); // REDIBUJAR LÍNEAS EN TIEMPO REAL
    });

    document.addEventListener('mouseup', () => {
        if (isDragging && currentCard) {
            currentCard.classList.remove('dragging');
        }
        isDragging = false;
        currentCard = null;
        document.body.style.userSelect = '';
    });

    window.addEventListener('load', () => setTimeout(drawLines, 100));
    window.addEventListener('resize', drawLines);
    
    // Fallback observer por si hay cambios en la caja
    const observer = new ResizeObserver(drawLines);
    observer.observe(document.getElementById('grid-container'));

    // Fix para que los botones sean realmente fijos (evita problemas con transformaciones CSS de los ancestros)
    document.addEventListener("DOMContentLoaded", () => {
        const btnVolver = document.getElementById('btn-volver-nav');
        const btnSiguiente = document.getElementById('btn-siguiente-nav');
        if (btnVolver) document.body.appendChild(btnVolver);
        if (btnSiguiente) document.body.appendChild(btnSiguiente);
    });
</script>
<!-- TRANSICIONES DE DIAPOSITIVAS -->

<style>
body { overflow-x: hidden; perspective: 1200px; }
section { transform-style: preserve-3d; }

/* 1. Slide Horizontal */
.fx-1-out-next { animation: fx1ON 0.6s ease forwards; }
.fx-1-in-next { animation: fx1IN 0.6s ease forwards; }
.fx-1-out-prev { animation: fx1OP 0.6s ease forwards; }
.fx-1-in-prev { animation: fx1IP 0.6s ease forwards; }
@keyframes fx1ON { to { transform: translateX(-100vw); opacity: 0; } }
@keyframes fx1IN { from { transform: translateX(100vw); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes fx1OP { to { transform: translateX(100vw); opacity: 0; } }
@keyframes fx1IP { from { transform: translateX(-100vw); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

/* 2. Slide Vertical */
.fx-2-out-next { animation: fx2ON 0.6s ease forwards; }
.fx-2-in-next { animation: fx2IN 0.6s ease forwards; }
.fx-2-out-prev { animation: fx2OP 0.6s ease forwards; }
.fx-2-in-prev { animation: fx2IP 0.6s ease forwards; }
@keyframes fx2ON { to { transform: translateY(-100vh); opacity: 0; } }
@keyframes fx2IN { from { transform: translateY(100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fx2OP { to { transform: translateY(100vh); opacity: 0; } }
@keyframes fx2IP { from { transform: translateY(-100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* 3. Scale Down & Slide */
.fx-3-out-next { animation: fx3ON 0.6s ease forwards; }
.fx-3-in-next { animation: fx3IN 0.6s ease forwards; }
.fx-3-out-prev { animation: fx3OP 0.6s ease forwards; }
.fx-3-in-prev { animation: fx3IP 0.6s ease forwards; }
@keyframes fx3ON { to { transform: scale(0.8) translateX(-100vw); opacity: 0; } }
@keyframes fx3IN { from { transform: scale(0.8) translateX(100vw); opacity: 0; } to { transform: scale(1) translateX(0); opacity: 1; } }
@keyframes fx3OP { to { transform: scale(0.8) translateX(100vw); opacity: 0; } }
@keyframes fx3IP { from { transform: scale(0.8) translateX(-100vw); opacity: 0; } to { transform: scale(1) translateX(0); opacity: 1; } }

/* 4. 3D Flip Y */
.fx-4-out-next { animation: fx4ON 0.6s ease forwards; }
.fx-4-in-next { animation: fx4IN 0.6s ease forwards; }
.fx-4-out-prev { animation: fx4OP 0.6s ease forwards; }
.fx-4-in-prev { animation: fx4IP 0.6s ease forwards; }
@keyframes fx4ON { to { transform: rotateY(-90deg); opacity: 0; } }
@keyframes fx4IN { from { transform: rotateY(90deg); opacity: 0; } to { transform: rotateY(0); opacity: 1; } }
@keyframes fx4OP { to { transform: rotateY(90deg); opacity: 0; } }
@keyframes fx4IP { from { transform: rotateY(-90deg); opacity: 0; } to { transform: rotateY(0); opacity: 1; } }

/* 5. 3D Flip X */
.fx-5-out-next { animation: fx5ON 0.6s ease forwards; }
.fx-5-in-next { animation: fx5IN 0.6s ease forwards; }
.fx-5-out-prev { animation: fx5OP 0.6s ease forwards; }
.fx-5-in-prev { animation: fx5IP 0.6s ease forwards; }
@keyframes fx5ON { to { transform: rotateX(90deg); opacity: 0; } }
@keyframes fx5IN { from { transform: rotateX(-90deg); opacity: 0; } to { transform: rotateX(0); opacity: 1; } }
@keyframes fx5OP { to { transform: rotateX(-90deg); opacity: 0; } }
@keyframes fx5IP { from { transform: rotateX(90deg); opacity: 0; } to { transform: rotateX(0); opacity: 1; } }

/* 6. Push (Z depth) */
.fx-6-out-next { animation: fx6ON 0.6s ease forwards; }
.fx-6-in-next { animation: fx6IN 0.6s ease forwards; }
.fx-6-out-prev { animation: fx6OP 0.6s ease forwards; }
.fx-6-in-prev { animation: fx6IP 0.6s ease forwards; }
@keyframes fx6ON { to { transform: translateZ(-800px); opacity: 0; } }
@keyframes fx6IN { from { transform: translateZ(800px); opacity: 0; } to { transform: translateZ(0); opacity: 1; } }
@keyframes fx6OP { to { transform: translateZ(800px); opacity: 0; } }
@keyframes fx6IP { from { transform: translateZ(-800px); opacity: 0; } to { transform: translateZ(0); opacity: 1; } }

/* 7. Newspaper Spin */
.fx-7-out-next { animation: fx7ON 0.7s ease forwards; }
.fx-7-in-next { animation: fx7IN 0.7s ease forwards; }
.fx-7-out-prev { animation: fx7OP 0.7s ease forwards; }
.fx-7-in-prev { animation: fx7IP 0.7s ease forwards; }
@keyframes fx7ON { to { transform: scale(0) rotate(720deg); opacity: 0; } }
@keyframes fx7IN { from { transform: scale(0) rotate(-720deg); opacity: 0; } to { transform: scale(1) rotate(0); opacity: 1; } }
@keyframes fx7OP { to { transform: scale(0) rotate(-720deg); opacity: 0; } }
@keyframes fx7IP { from { transform: scale(0) rotate(720deg); opacity: 0; } to { transform: scale(1) rotate(0); opacity: 1; } }

/* 8. Fall / Drop */
.fx-8-out-next { animation: fx8ON 0.6s ease forwards; }
.fx-8-in-next { animation: fx8IN 0.6s ease forwards; }
.fx-8-out-prev { animation: fx8OP 0.6s ease forwards; }
.fx-8-in-prev { animation: fx8IP 0.6s ease forwards; }
@keyframes fx8ON { to { transform: translateZ(-300px) rotateX(20deg); opacity: 0; } }
@keyframes fx8IN { from { transform: translateY(-100vh); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fx8OP { to { transform: translateY(-100vh); opacity: 0; } }
@keyframes fx8IP { from { transform: translateZ(-300px) rotateX(20deg); opacity: 0; } to { transform: translateZ(0) rotateX(0); opacity: 1; } }

/* 9. Blur & Fade */
.fx-9-out-next { animation: fx9ON 0.6s ease forwards; }
.fx-9-in-next { animation: fx9IN 0.6s ease forwards; }
.fx-9-out-prev { animation: fx9OP 0.6s ease forwards; }
.fx-9-in-prev { animation: fx9IP 0.6s ease forwards; }
@keyframes fx9ON { to { filter: blur(30px); opacity: 0; transform: scale(1.1); } }
@keyframes fx9IN { from { filter: blur(30px); opacity: 0; transform: scale(0.9); } to { filter: blur(0); opacity: 1; transform: scale(1); } }
@keyframes fx9OP { to { filter: blur(30px); opacity: 0; transform: scale(0.9); } }
@keyframes fx9IP { from { filter: blur(30px); opacity: 0; transform: scale(1.1); } to { filter: blur(0); opacity: 1; transform: scale(1); } }

/* 10. Swing Hinge */
.fx-10-out-next { animation: fx10ON 0.7s ease forwards; transform-origin: top left; }
.fx-10-in-next { animation: fx10IN 0.7s ease forwards; transform-origin: top right; }
.fx-10-out-prev { animation: fx10OP 0.7s ease forwards; transform-origin: top right; }
.fx-10-in-prev { animation: fx10IP 0.7s ease forwards; transform-origin: top left; }
@keyframes fx10ON { to { transform: rotate(90deg); opacity: 0; } }
@keyframes fx10IN { from { transform: rotate(-90deg); opacity: 0; } to { transform: rotate(0); opacity: 1; } }
@keyframes fx10OP { to { transform: rotate(-90deg); opacity: 0; } }
@keyframes fx10IP { from { transform: rotate(90deg); opacity: 0; } to { transform: rotate(0); opacity: 1; } }

/* 11. Super Zoom */
.fx-11-out-next { animation: fx11ON 0.6s ease forwards; }
.fx-11-in-next { animation: fx11IN 0.6s ease forwards; }
.fx-11-out-prev { animation: fx11OP 0.6s ease forwards; }
.fx-11-in-prev { animation: fx11IP 0.6s ease forwards; }
@keyframes fx11ON { to { transform: scale(3); opacity: 0; } }
@keyframes fx11IN { from { transform: scale(0.1); opacity: 0; } to { transform: scale(1); opacity: 1; } }
@keyframes fx11OP { to { transform: scale(0.1); opacity: 0; } }
@keyframes fx11IP { from { transform: scale(3); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const CURRENT_PAGE = 8;
    const urlParams = new URLSearchParams(window.location.search);
    const fx = urlParams.get('fx');
    const dir = urlParams.get('dir');
    const section = document.querySelector('section');
    
    if (section) {
        if (fx && dir) {
            section.classList.add(`fx-${fx}-in-${dir}`);
            section.addEventListener('animationend', () => {
                section.className = section.className.replace(/fx-\d+-in-(next|prev)/g, '').trim();
            }, {once: true});
        } else {
            section.style.opacity = '0';
            section.style.animation = 'pFadeIn 0.8s ease forwards';
        }
    }

    const btnS = document.querySelector('[id^="btn-s"]');
    const btnV = document.querySelector('[id^="btn-v"]');

    if (btnS) {
        btnS.addEventListener('click', (e) => {
            e.preventDefault();
            const fxId = CURRENT_PAGE; // Effect from N to N+1 is N
            const href = btnS.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=next`;
            
            if(section) section.classList.add(`fx-${fxId}-out-next`);
            setTimeout(() => { window.location.href = finalHref; }, 550); // increased timeout to allow animations to finish
        });
    }

    if (btnV) {
        btnV.addEventListener('click', (e) => {
            e.preventDefault();
            const fxId = CURRENT_PAGE - 1; // Effect from N to N-1 is N-1
            const href = btnV.getAttribute('href');
            const finalHref = href + (href.includes('?') ? '&' : '?') + `fx=${fxId}&dir=prev`;
            
            if(section) section.classList.add(`fx-${fxId}-out-prev`);
            setTimeout(() => { window.location.href = finalHref; }, 550);
        });
    }
});

if(!document.getElementById('pfade-style')) {
    const style = document.createElement('style');
    style.id = 'pfade-style';
    style.innerHTML = `@keyframes pFadeIn { to { opacity: 1; } }`;
    document.head.appendChild(style);
}
</script>

<!-- FIN TRANSICIONES -->
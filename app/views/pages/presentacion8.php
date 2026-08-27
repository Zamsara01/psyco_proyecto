<!-- PSYCO — Presentación 8 (Modelo Relacional) -->
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

    <!-- Navegación pegada abajo a la izquierda/derecha usando absolute/fixed -->
    <div class="fixed bottom-0 left-0 w-full px-6 py-6 flex justify-between items-center z-50 pointer-events-none">
        <a href="<?= URL_BASE ?>pages/presentacion7" class="pointer-events-auto inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold text-sm">Volver</span>
        </a>
        <a href="<?= URL_BASE ?>pages/presentacion9" class="pointer-events-auto inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg">
            <span class="font-bold text-sm">Siguiente</span>
            <span class="material-symbols-outlined">arrow_forward</span>
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
</script>

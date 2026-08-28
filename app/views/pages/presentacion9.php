<!-- PSYCO — Presentación 9 (MER) -->
<script>
(function() {
    const sidebar = document.getElementById('app-sidebar');
    const mainContent = document.getElementById('main-content');
    if (sidebar) sidebar.style.display = 'none';
    if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.classList.remove('lg:ml-64'); }
    window.addEventListener('pagehide', () => {
        if (sidebar) sidebar.style.display = '';
        if (mainContent) { mainContent.style.marginLeft = ''; mainContent.classList.add('lg:ml-64'); }
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
    #mer-canvas {
        position: relative;
        width: 2200px;
        min-height: 1100px;
    }
    .mer-entity {
        position: absolute;
        cursor: grab;
        user-select: none;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .mer-entity:active { cursor: grabbing; z-index: 100; }
    .mer-entity .entity-header {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Canva Sans', sans-serif;
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        border: 2px solid rgba(255,255,255,0.4);
        position: relative;
        z-index: 10;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .mer-entity:active .entity-header {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(0,0,0,0.4);
    }
    .mer-entity ul { 
        position: absolute;
        top: 50%; left: 50%;
        width: 0; height: 0;
        list-style: none; padding: 0; margin: 0;
        z-index: 1;
    }
    .mer-attribute {
        position: absolute;
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid #cbd5e1;
        border-radius: 30px;
        padding: 6px 12px;
        font-size: 11px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 6px;
        transform: translate(-50%, -50%);
        font-family: 'Canva Sans', sans-serif;
        font-weight: 700;
        color: #334155;
        z-index: 5;
        backdrop-filter: blur(4px);
    }
    .mer-attribute.pk { background: #fefce8; border-color: #fde047; color: #854d0e; }
    .mer-attribute.fk { background: #eff6ff; border-color: #93c5fd; color: #1e40af; }
    .mer-attribute span.type { font-family: monospace; font-size: 10px; color: #94a3b8; font-weight: 500; }
    .mer-line {
        position: absolute;
        top: 0; left: 0;
        height: 2px;
        background-color: rgba(255,255,255,0.5);
        transform-origin: 0 50%;
        z-index: 0;
    }

    /* Rombos de relación */
    .mer-relation {
        position: absolute;
        z-index: 10;
        cursor: grab;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mer-relation:active { cursor: grabbing; z-index: 100; }
    .diamond {
        width: 80px;
        height: 80px;
        transform: rotate(45deg);
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }
    .diamond-label {
        transform: rotate(-45deg);
        font-size: 9px;
        font-weight: 800;
        color: white;
        text-align: center;
        line-height: 1.2;
        font-family: 'Canva Sans', sans-serif;
        pointer-events: none;
        max-width: 60px;
    }
    .card-label {
        position: absolute;
        background: rgba(0,0,0,0.55);
        color: #fbbf24;
        font-size: 9px;
        font-weight: 800;
        padding: 1px 5px;
        border-radius: 4px;
        pointer-events: none;
        font-family: monospace;
    }
    /* Etiqueta de cardinalidad flotante encima de cada entidad */
    .cardinality-tag {
        position: absolute;
        top: -26px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 10px;
        font-weight: 900;
        padding: 3px 12px;
        background: rgba(0,0,0,0.60);
        color: #fbbf24;
        border-radius: 20px;
        white-space: nowrap;
        letter-spacing: 1.5px;
        font-family: 'Courier New', monospace;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        pointer-events: none;
    }
</style>

<section class="min-h-screen py-6 px-4 bg-nebula flex flex-col items-center w-full relative overflow-auto">
    <svg id="mer-svg" class="absolute top-0 left-0 pointer-events-none z-0" style="width:100%;height:100%;overflow:visible;"></svg>

    <div class="flex flex-col items-center mb-4 mt-2 z-10 relative w-full pointer-events-none">
        <h2 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg mb-1" style="font-family:'Canva Sans',sans-serif;">MODELO ENTIDAD-RELACIÓN (MER)</h2>
        <p class="text-xs text-white/90 font-medium bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-md">Arrastra entidades y relaciones · ⬛ Entidades · ◆ Relaciones</p>
    </div>

    <div id="mer-canvas" class="z-10 relative mx-auto">

        <!-- ═══════════════ ENTIDADES ═══════════════ -->

        <!-- ESPECIALIDADES -->
        <div class="mer-entity" id="ent-especialidades" style="left:190px;top:530px;">
            <div class="cardinality-tag">1 : N  →  psicólogos</div>
            <div class="entity-header" style="background:#4f46e5;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> especialidades
            </div>
            <ul>
                <li class="pk" id="f-esp-pk"><span>🔑 id_especialidad</span><span class="type">int(11)</span></li>
                <li><span>nombre</span><span class="type">varchar(100)</span></li>
                <li><span>descripcion</span><span class="type">text</span></li>
            </ul>
        </div>

        <!-- PSICOLOGOS -->
        <div class="mer-entity" id="ent-psicologos" style="left:530px;top:450px;">
            <div class="cardinality-tag">N : 1  (esp)  ·  1 : N  (citas)</div>
            <div class="entity-header" style="background:#059669;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> psicologos
            </div>
            <ul>
                <li class="pk" id="f-psi-pk"><span>🔑 id_psicologo</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-psi-fk-esp"><span>🔗 id_especialidad</span><span class="type">int(11)</span></li>
                <li><span>nombre</span><span class="type">varchar(100)</span></li>
                <li><span>telefono</span><span class="type">varchar(20)</span></li>
                <li><span>correo_electronico</span><span class="type">varchar(100)</span></li>
                <li><span>contrasena</span><span class="type">varchar(255)</span></li>
                <li><span>estado</span><span class="type">enum</span></li>
                <li><span>fecha_registro</span><span class="type">datetime</span></li>
            </ul>
        </div>

        <!-- USUARIOS -->
        <div class="mer-entity" id="ent-usuarios" style="left:1030px;top:210px;">
            <div class="cardinality-tag">1 : N  →  citas / notas / recursos</div>
            <div class="entity-header" style="background:#2563eb;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> usuarios
            </div>
            <ul>
                <li class="pk" id="f-usr-pk"><span>🔑 id_usuario</span><span class="type">int(11)</span></li>
                <li><span>nombre</span><span class="type">varchar(100)</span></li>
                <li><span>correo_electronico</span><span class="type">varchar(100)</span></li>
                <li><span>grado</span><span class="type">enum</span></li>
                <li><span>estado</span><span class="type">enum</span></li>
                <li><span>acudiente_nombre</span><span class="type">text</span></li>
                <li><span>verificado</span><span class="type">tinyint(1)</span></li>
                <li><span>fecha_registro</span><span class="type">datetime</span></li>
            </ul>
        </div>

        <!-- CITAS -->
        <div class="mer-entity" id="ent-citas" style="left:830px;top:570px;">
            <div class="cardinality-tag">N : 1  (usr/psi)  ·  1 : N  (record.)</div>
            <div class="entity-header" style="background:#9333ea;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> citas
            </div>
            <ul>
                <li class="pk" id="f-cit-pk"><span>🔑 id_cita</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-cit-fk-usr"><span>🔗 id_usuario</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-cit-fk-psi"><span>🔗 id_psicologo</span><span class="type">int(11)</span></li>
                <li><span>fecha</span><span class="type">date</span></li>
                <li><span>hora</span><span class="type">time</span></li>
                <li><span>estado</span><span class="type">enum</span></li>
                <li><span>duracion_minutos</span><span class="type">int(11)</span></li>
                <li><span>asistio</span><span class="type">tinyint(1)</span></li>
            </ul>
        </div>

        <!-- DISPONIBILIDAD -->
        <div class="mer-entity" id="ent-disponibilidad" style="left:350px;top:830px;">
            <div class="cardinality-tag">N : 1  →  psicólogo</div>
            <div class="entity-header" style="background:#0d9488;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> disponibilidad_psicologos
            </div>
            <ul>
                <li class="pk"><span>🔑 id_disponibilidad</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-dis-fk-psi"><span>🔗 id_psicologo</span><span class="type">int(11)</span></li>
                <li><span>dia_semana</span><span class="type">enum</span></li>
                <li><span>hora_inicio</span><span class="type">time</span></li>
                <li><span>hora_fin</span><span class="type">time</span></li>
                <li><span>jornada</span><span class="type">varchar(20)</span></li>
                <li><span>activo</span><span class="type">tinyint(1)</span></li>
            </ul>
        </div>

        <!-- NOTAS -->
        <div class="mer-entity" id="ent-notas" style="left:790px;top:870px;">
            <div class="cardinality-tag">N : 1  →  psicólogo / usuario</div>
            <div class="entity-header" style="background:#c026d3;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> notas_paciente
            </div>
            <ul>
                <li class="pk"><span>🔑 id_nota</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-not-fk-psi"><span>🔗 id_psicologo</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-not-fk-usr"><span>🔗 id_usuario</span><span class="type">int(11)</span></li>
                <li><span>titulo</span><span class="type">varchar(255)</span></li>
                <li><span>contenido</span><span class="type">text</span></li>
                <li><span>fecha_creacion</span><span class="type">datetime</span></li>
            </ul>
        </div>

        <!-- RECURSOS -->
        <div class="mer-entity" id="ent-recursos" style="left:1250px;top:670px;">
            <div class="cardinality-tag">N : 1  →  psicólogo / usuario</div>
            <div class="entity-header" style="background:#f97316;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> recursos_acompanamiento
            </div>
            <ul>
                <li class="pk"><span>🔑 id_recurso</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-rec-fk-psi"><span>🔗 id_psicologo</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-rec-fk-usr"><span>🔗 id_usuario</span><span class="type">int(11)</span></li>
                <li><span>titulo</span><span class="type">varchar(255)</span></li>
                <li><span>tipo</span><span class="type">enum</span></li>
                <li><span>descripcion</span><span class="type">text</span></li>
                <li><span>fecha_creacion</span><span class="type">datetime</span></li>
            </ul>
        </div>

        <!-- RECORDATORIOS -->
        <div class="mer-entity" id="ent-recordatorios" style="left:1050px;top:830px;">
            <div class="cardinality-tag">N : 1  →  cita</div>
            <div class="entity-header" style="background:#f43f5e;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> recordatorios
            </div>
            <ul>
                <li class="pk"><span>🔑 id_recordatorio</span><span class="type">int(11)</span></li>
                <li class="fk" id="f-red-fk-cit"><span>🔗 id_cita</span><span class="type">int(11)</span></li>
                <li><span>mensaje</span><span class="type">text</span></li>
                <li><span>fecha_programada</span><span class="type">datetime</span></li>
                <li><span>canal</span><span class="type">enum</span></li>
                <li><span>estado_envio</span><span class="type">enum</span></li>
            </ul>
        </div>

        <!-- OTP_CODES -->
        <div class="mer-entity" id="ent-otp" style="left:1550px;top:230px;">
            <div class="cardinality-tag">autónoma  (sin FK)</div>
            <div class="entity-header" style="background:#334155;">
                <span class="material-symbols-outlined" style="font-size:14px;">table_chart</span> otp_codes
            </div>
            <ul>
                <li class="pk"><span>🔑 id</span><span class="type">int(11)</span></li>
                <li><span>email</span><span class="type">varchar(100)</span></li>
                <li><span>code_hash</span><span class="type">varchar(64)</span></li>
                <li><span>type</span><span class="type">enum</span></li>
                <li><span>attempts</span><span class="type">tinyint(3)</span></li>
                <li><span>status</span><span class="type">enum</span></li>
                <li><span>expires_at</span><span class="type">datetime</span></li>
            </ul>
            <div style="font-size:9px;color:#94a3b8;padding:4px 10px;font-style:italic;">⚠ Relación ambigua via email</div>
        </div>

        <!-- ═══════════════ ROMBOS ═══════════════ -->

        <!-- clasifica: especialidades → psicologos -->
        <div class="mer-relation" id="rel-clasifica" style="left:370px;top:505px;width:80px;height:80px;">
            <div class="diamond" style="background:#4f46e5;">
                <span class="diamond-label">clasifica</span>
            </div>
        </div>

        <!-- atiende: psicologo → citas -->
        <div class="mer-relation" id="rel-atiende" style="left:685px;top:525px;width:80px;height:80px;">
            <div class="diamond" style="background:#059669;">
                <span class="diamond-label">atiende</span>
            </div>
        </div>

        <!-- solicita: usuario → citas -->
        <div class="mer-relation" id="rel-solicita" style="left:940px;top:410px;width:80px;height:80px;">
            <div class="diamond" style="background:#2563eb;">
                <span class="diamond-label">solicita</span>
            </div>
        </div>

        <!-- genera: citas → recordatorios -->
        <div class="mer-relation" id="rel-genera" style="left:950px;top:720px;width:80px;height:80px;">
            <div class="diamond" style="background:#9333ea;">
                <span class="diamond-label">genera</span>
            </div>
        </div>

        <!-- define: psicologo → disponibilidad -->
        <div class="mer-relation" id="rel-define" style="left:450px;top:690px;width:80px;height:80px;">
            <div class="diamond" style="background:#0d9488;">
                <span class="diamond-label">define</span>
            </div>
        </div>

        <!-- escribe: psicologo → notas -->
        <div class="mer-relation" id="rel-escribe" style="left:650px;top:730px;width:80px;height:80px;">
            <div class="diamond" style="background:#c026d3;">
                <span class="diamond-label">escribe</span>
            </div>
        </div>

        <!-- tiene_nota: usuario → notas -->
        <div class="mer-relation" id="rel-tiene-nota" style="left:950px;top:900px;width:80px;height:80px;">
            <div class="diamond" style="background:#1d4ed8;">
                <span class="diamond-label">tiene nota</span>
            </div>
        </div>

        <!-- crea_recurso: psicologo → recursos -->
        <div class="mer-relation" id="rel-crea" style="left:910px;top:600px;width:80px;height:80px;">
            <div class="diamond" style="background:#f97316;">
                <span class="diamond-label">crea recurso</span>
            </div>
        </div>

        <!-- accede: usuario → recursos -->
        <div class="mer-relation" id="rel-accede" style="left:1210px;top:450px;width:80px;height:80px;">
            <div class="diamond" style="background:#ea580c;">
                <span class="diamond-label">accede</span>
            </div>
        </div>

    </div><!-- /mer-canvas -->

    <!-- Leyenda -->
    <div class="fixed bottom-20 left-1/2 -translate-x-1/2 z-50 flex gap-4 bg-black/40 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 pointer-events-none">
        <span class="flex items-center gap-1.5 text-white text-xs"><span class="inline-block w-4 h-4 bg-white rounded-sm border border-white/50"></span>Entidad</span>
        <span class="flex items-center gap-1.5 text-white text-xs"><span class="inline-block w-4 h-4 rotate-45 bg-emerald-400 border border-white/50"></span>Relación</span>
        <span class="flex items-center gap-1.5 text-white text-xs"><span class="inline-block w-3 h-3 rounded-full bg-yellow-400"></span>PK &nbsp;<span class="inline-block w-3 h-3 rounded-full bg-blue-400"></span>FK</span>
        <span class="text-white/60 text-xs">1:N = uno a muchos</span>
    </div>

    <!-- Botones navegacion -->
    

<div class="fixed bottom-6 right-8 z-[9999] flex items-center gap-4">
    <a id="btn-v9" href="<?= URL_BASE ?>pages/presentacion8" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
    </a>
    <a id="btn-s9" href="<?= URL_BASE ?>pages/presentacion10" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
    </a>
</div>
</section>

<script>
// ── Conexiones SVG ──────────────────────────────────────────────────
const merConnections = [
    // clasifica: especialidades.id_especialidad → rel → psicologos.id_especialidad(FK)
    { from:'f-esp-pk',      to:'rel-clasifica',  color:'#a5b4fc', card1:'1',  card2:null },
    { from:'rel-clasifica', to:'f-psi-fk-esp',   color:'#a5b4fc', card1:null, card2:'N'  },

    // atiende: psicologos.id_psicologo → rel → citas.id_psicologo(FK)
    { from:'f-psi-pk',     to:'rel-atiende',    color:'#6ee7b7', card1:'1',  card2:null },
    { from:'rel-atiende',  to:'f-cit-fk-psi',   color:'#6ee7b7', card1:null, card2:'N'  },

    // solicita: usuarios.id_usuario → rel → citas.id_usuario(FK)
    { from:'f-usr-pk',     to:'rel-solicita',   color:'#93c5fd', card1:'1',  card2:null },
    { from:'rel-solicita', to:'f-cit-fk-usr',   color:'#93c5fd', card1:null, card2:'N'  },

    // genera: citas.id_cita → rel → recordatorios.id_cita(FK)
    { from:'f-cit-pk',    to:'rel-genera',      color:'#d8b4fe', card1:'1',  card2:null },
    { from:'rel-genera',  to:'f-red-fk-cit',    color:'#d8b4fe', card1:null, card2:'N'  },

    // define: psicologos.id_psicologo → rel → disponibilidad.id_psicologo(FK)
    { from:'f-psi-pk',   to:'rel-define',       color:'#5eead4', card1:'1',  card2:null },
    { from:'rel-define', to:'f-dis-fk-psi',     color:'#5eead4', card1:null, card2:'N'  },

    // escribe: psicologos.id_psicologo → rel → notas.id_psicologo(FK)
    { from:'f-psi-pk',    to:'rel-escribe',     color:'#f0abfc', card1:'1',  card2:null },
    { from:'rel-escribe', to:'f-not-fk-psi',    color:'#f0abfc', card1:null, card2:'N'  },

    // tiene_nota: usuarios.id_usuario → rel → notas.id_usuario(FK)
    { from:'f-usr-pk',       to:'rel-tiene-nota', color:'#bfdbfe', card1:'1',  card2:null },
    { from:'rel-tiene-nota', to:'f-not-fk-usr',   color:'#bfdbfe', card1:null, card2:'N'  },

    // crea_recurso: psicologos.id_psicologo → rel → recursos.id_psicologo(FK)
    { from:'f-psi-pk',  to:'rel-crea',          color:'#fdba74', card1:'1',  card2:null },
    { from:'rel-crea',  to:'f-rec-fk-psi',      color:'#fdba74', card1:null, card2:'N'  },

    // accede: usuarios.id_usuario → rel → recursos.id_usuario(FK)
    { from:'f-usr-pk',   to:'rel-accede',        color:'#fcd34d', card1:'1',  card2:null },
    { from:'rel-accede', to:'f-rec-fk-usr',      color:'#fcd34d', card1:null, card2:'N'  },
];

function getCenter(el) {
    const canvasRect = document.getElementById('mer-canvas').getBoundingClientRect();
    const r = el.getBoundingClientRect();
    return {
        x: r.left - canvasRect.left + r.width / 2,
        y: r.top  - canvasRect.top  + r.height / 2,
    };
}

function drawMerLines() {
    const svg = document.getElementById('mer-svg');
    if (!svg) return;
    svg.innerHTML = '';
    const canvasRect = document.getElementById('mer-canvas').getBoundingClientRect();
    const sectionRect = svg.parentElement.getBoundingClientRect();

    // Offset del canvas respecto al section
    const offX = canvasRect.left - sectionRect.left;
    const offY = canvasRect.top  - sectionRect.top;

    merConnections.forEach(conn => {
        const fromEl = document.getElementById(conn.from);
        const toEl   = document.getElementById(conn.to);
        if (!fromEl || !toEl) return;

        const fc = getCenter(fromEl);
        const tc = getCenter(toEl);

        const x1 = fc.x + offX, y1 = fc.y + offY;
        const x2 = tc.x + offX, y2 = tc.y + offY;

        const midX = (x1+x2)/2, midY = (y1+y2)/2;
        const dx = x2-x1, dy = y2-y1;
        const cx = midX - dy*0.2, cy = midY + dx*0.2;

        const path = document.createElementNS('http://www.w3.org/2000/svg','path');
        path.setAttribute('d', `M${x1},${y1} Q${cx},${cy} ${x2},${y2}`);
        path.setAttribute('stroke', conn.color);
        path.setAttribute('stroke-width', '3');
        path.setAttribute('fill', 'none');
        path.setAttribute('opacity', '0.9');
        svg.appendChild(path);

        // Cardinalidad
        if (conn.card1) {
            const t = document.createElementNS('http://www.w3.org/2000/svg','text');
            t.setAttribute('x', x1 + (x2-x1)*0.12);
            t.setAttribute('y', y1 + (y2-y1)*0.12 - 6);
            t.setAttribute('fill', '#fbbf24');
            t.setAttribute('font-size', '11');
            t.setAttribute('font-weight', '800');
            t.setAttribute('font-family', 'monospace');
            t.textContent = conn.card1;
            svg.appendChild(t);
        }
        if (conn.card2) {
            const t = document.createElementNS('http://www.w3.org/2000/svg','text');
            t.setAttribute('x', x2 - (x2-x1)*0.12);
            t.setAttribute('y', y2 - (y2-y1)*0.12 - 6);
            t.setAttribute('fill', '#fbbf24');
            t.setAttribute('font-size', '11');
            t.setAttribute('font-weight', '800');
            t.setAttribute('font-family', 'monospace');
            t.textContent = conn.card2;
            svg.appendChild(t);
        }
    });
}

// ── Drag and Drop ──────────────────────────────────────────────────
let dragging = null, startX, startY;
const initX = {}, initY = {};

document.querySelectorAll('.mer-entity, .mer-relation').forEach(el => {
    initX[el.id] = parseFloat(el.style.left) || 0;
    initY[el.id] = parseFloat(el.style.top)  || 0;

    el.addEventListener('mousedown', e => {
        dragging = el;
        startX = e.clientX;
        startY = e.clientY;
        document.querySelectorAll('.mer-entity,.mer-relation').forEach(x => x.style.zIndex = 10);
        el.style.zIndex = 100;
    });
});

document.addEventListener('mousemove', e => {
    if (!dragging) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    const nx = (initX[dragging.id] || 0) + dx;
    const ny = (initY[dragging.id] || 0) + dy;
    dragging.style.left = nx + 'px';
    dragging.style.top  = ny + 'px';
    drawMerLines();
});

document.addEventListener('mouseup', e => {
    if (!dragging) return;
    initX[dragging.id] = parseFloat(dragging.style.left);
    initY[dragging.id] = parseFloat(dragging.style.top);
    dragging = null;
});

// Convertir atributos a burbujas flotantes
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.mer-entity').forEach(entity => {
        const ul = entity.querySelector('ul');
        if (!ul) return;
        const lis = ul.querySelectorAll('li');
        const count = lis.length;
        const radius = Math.max(110, 50 + count * 12); 
        
        let currentAngle = -Math.PI / 2; // Inicia desde arriba
        const angleStep = (2 * Math.PI) / count;
        
        lis.forEach(li => {
            li.classList.add('mer-attribute');
            
            const x = Math.cos(currentAngle) * radius;
            const y = Math.sin(currentAngle) * radius;
            
            li.style.left = `${x}px`;
            li.style.top = `${y}px`;
            
            const line = document.createElement('div');
            line.className = 'mer-line';
            const length = Math.sqrt(x*x + y*y);
            line.style.width = `${length}px`;
            line.style.transform = `rotate(${currentAngle}rad)`;
            
            ul.appendChild(line);
            
            currentAngle += angleStep;
        });
    });
});

// Fix botones — sacarlos del section para que no queden bajo la capa drag
document.addEventListener('DOMContentLoaded', () => {
    ['btn-v9','btn-s9'].forEach(id => {
        const b = document.getElementById(id);
        if (b) {
            // Sacar el botón del contenedor y pegarlo directo en body
            // para que no quede bloqueado por el z-index del canvas
            const wrapper = b.closest('div.fixed');
            if (wrapper && !document.getElementById('nav-wrapper-9')) {
                wrapper.id = 'nav-wrapper-9';
                document.body.appendChild(wrapper);
            }
        }
    });
    setTimeout(drawMerLines, 150);
});

window.addEventListener('resize', drawMerLines);
new ResizeObserver(drawMerLines).observe(document.getElementById('mer-canvas'));
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
    const CURRENT_PAGE = 9;
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
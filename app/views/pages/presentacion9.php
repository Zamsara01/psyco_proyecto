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
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        border: 2px solid rgba(255,255,255,0.3);
        min-width: 160px;
        cursor: grab;
        user-select: none;
        z-index: 10;
    }
    .mer-entity:active { cursor: grabbing; z-index: 100; box-shadow: 0 16px 48px rgba(0,0,0,0.35); }
    .mer-entity .entity-header {
        padding: 6px 10px;
        border-radius: 6px 6px 0 0;
        font-weight: 800;
        font-size: 12px;
        color: white;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Canva Sans', sans-serif;
    }
    .mer-entity ul { list-style: none; padding: 0; margin: 0; font-size: 10px; }
    .mer-entity ul li { padding: 3px 10px; display: flex; justify-content: space-between; gap: 8px; border-top: 1px solid #f1f5f9; color: #475569; }
    .mer-entity ul li.pk { background: #fefce8; font-weight: 700; color: #1e293b; }
    .mer-entity ul li.fk { background: #eff6ff; color: #1d4ed8; font-weight: 600; }
    .mer-entity ul li span.type { font-family: monospace; font-size: 8px; color: #94a3b8; }

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
        <div class="mer-entity" id="ent-especialidades" style="left:40px;top:380px;">
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
        <div class="mer-entity" id="ent-psicologos" style="left:380px;top:300px;">
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
        <div class="mer-entity" id="ent-usuarios" style="left:880px;top:60px;">
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
        <div class="mer-entity" id="ent-citas" style="left:680px;top:420px;">
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
        <div class="mer-entity" id="ent-disponibilidad" style="left:200px;top:680px;">
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
        <div class="mer-entity" id="ent-notas" style="left:640px;top:720px;">
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
        <div class="mer-entity" id="ent-recursos" style="left:1100px;top:520px;">
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
        <div class="mer-entity" id="ent-recordatorios" style="left:900px;top:680px;">
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
        <div class="mer-entity" id="ent-otp" style="left:1400px;top:80px;">
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
        <div class="mer-relation" id="rel-clasifica" style="left:220px;top:355px;width:80px;height:80px;">
            <div class="diamond" style="background:#4f46e5;">
                <span class="diamond-label">clasifica</span>
            </div>
        </div>

        <!-- atiende: psicologo → citas -->
        <div class="mer-relation" id="rel-atiende" style="left:535px;top:375px;width:80px;height:80px;">
            <div class="diamond" style="background:#059669;">
                <span class="diamond-label">atiende</span>
            </div>
        </div>

        <!-- solicita: usuario → citas -->
        <div class="mer-relation" id="rel-solicita" style="left:790px;top:260px;width:80px;height:80px;">
            <div class="diamond" style="background:#2563eb;">
                <span class="diamond-label">solicita</span>
            </div>
        </div>

        <!-- genera: citas → recordatorios -->
        <div class="mer-relation" id="rel-genera" style="left:800px;top:570px;width:80px;height:80px;">
            <div class="diamond" style="background:#9333ea;">
                <span class="diamond-label">genera</span>
            </div>
        </div>

        <!-- define: psicologo → disponibilidad -->
        <div class="mer-relation" id="rel-define" style="left:300px;top:540px;width:80px;height:80px;">
            <div class="diamond" style="background:#0d9488;">
                <span class="diamond-label">define</span>
            </div>
        </div>

        <!-- escribe: psicologo → notas -->
        <div class="mer-relation" id="rel-escribe" style="left:500px;top:580px;width:80px;height:80px;">
            <div class="diamond" style="background:#c026d3;">
                <span class="diamond-label">escribe</span>
            </div>
        </div>

        <!-- tiene_nota: usuario → notas -->
        <div class="mer-relation" id="rel-tiene-nota" style="left:800px;top:750px;width:80px;height:80px;">
            <div class="diamond" style="background:#1d4ed8;">
                <span class="diamond-label">tiene nota</span>
            </div>
        </div>

        <!-- crea_recurso: psicologo → recursos -->
        <div class="mer-relation" id="rel-crea" style="left:760px;top:450px;width:80px;height:80px;">
            <div class="diamond" style="background:#f97316;">
                <span class="diamond-label">crea recurso</span>
            </div>
        </div>

        <!-- accede: usuario → recursos -->
        <div class="mer-relation" id="rel-accede" style="left:1060px;top:300px;width:80px;height:80px;">
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
    <a id="btn-volver-nav9" href="<?= URL_BASE ?>pages/presentacion8" class="fixed bottom-6 left-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
        <span class="font-bold text-sm">Volver</span>
    </a>
    <a id="btn-siguiente-nav9" href="<?= URL_BASE ?>pages/presentacion10" class="fixed bottom-6 right-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="font-bold text-sm">Siguiente</span>
        <span class="material-symbols-outlined">arrow_forward</span>
    </a>
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
        e.preventDefault();
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

// Fix botones
document.addEventListener('DOMContentLoaded', () => {
    ['btn-volver-nav9','btn-siguiente-nav9'].forEach(id => {
        const b = document.getElementById(id);
        if (b) document.body.appendChild(b);
    });
    setTimeout(drawMerLines, 150);
});

window.addEventListener('resize', drawMerLines);
new ResizeObserver(drawMerLines).observe(document.getElementById('mer-canvas'));
</script>

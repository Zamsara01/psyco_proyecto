<?php
// Ocultar sidebar en esta página
$hideSidebar = true;
?>
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
/* Fondo nebula reutilizable */
.bg-nebula { background: radial-gradient(ellipse at 20% 30%, #1e1b4b 0%, #0f172a 40%, #1e1b4b 70%, #0f172a 100%); min-height:100vh; }

/* Sistema Boundary */
#uc-boundary {
  position: absolute;
  border: 2.5px solid rgba(139,92,246,0.7);
  border-radius: 18px;
  background: rgba(139,92,246,0.06);
  pointer-events: none;
  z-index: 1;
}
#uc-boundary-label {
  position: absolute;
  top: -18px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 13px;
  font-weight: 800;
  color: #a78bfa;
  letter-spacing: 2px;
  text-transform: uppercase;
  white-space: nowrap;
  pointer-events: none;
}

/* Actor */
.uc-actor {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: grab;
  user-select: none;
  z-index: 20;
  width: 80px;
}
.uc-actor:active { cursor: grabbing; }
.uc-actor-emoji {
  font-size: 38px;
  line-height: 1;
  filter: drop-shadow(0 0 8px rgba(255,255,255,0.3));
}
.uc-actor-name {
  margin-top: 6px;
  font-size: 11px;
  font-weight: 700;
  color: #e2e8f0;
  text-align: center;
  background: rgba(0,0,0,0.5);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 10px;
  padding: 2px 8px;
  white-space: nowrap;
}

/* Caso de uso */
.uc-case {
  position: absolute;
  cursor: grab;
  user-select: none;
  z-index: 20;
}
.uc-case:active { cursor: grabbing; }
.uc-oval {
  background: linear-gradient(135deg, #1e293b, #334155);
  border: 2px solid #64748b;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 10px 18px;
  font-size: 11px;
  font-weight: 600;
  color: #e2e8f0;
  transition: border-color 0.2s, box-shadow 0.2s;
  width: 160px;
  height: 60px;
  line-height: 1.3;
  box-shadow: 0 2px 12px rgba(0,0,0,0.4);
}
.uc-oval:hover { border-color: #a78bfa; box-shadow: 0 0 18px rgba(139,92,246,0.4); }
.uc-oval.auth { border-color: #3b82f6; }
.uc-oval.patient { border-color: #8b5cf6; }
.uc-oval.psy { border-color: #10b981; }
.uc-oval.shared { border-color: #f59e0b; }
</style>

<section class="min-h-screen py-6 px-4 bg-nebula flex flex-col items-center w-full relative overflow-auto">
<svg id="uc-svg" class="absolute top-0 left-0 pointer-events-none z-0" style="width:100%;height:100%;overflow:visible;"></svg>

<div class="flex flex-col items-center mb-4 mt-2 z-10 w-full pointer-events-none">
    <h2 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg mb-1" style="font-family:'Canva Sans',sans-serif;">DIAGRAMA DE CASOS DE USO</h2>
    <p class="text-xs text-white/90 font-medium bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-md">Basado en código real · Arrastra actores y casos de uso</p>
</div>

<div id="uc-canvas" class="z-10 relative" style="width:1600px; height:1000px; flex-shrink:0;">
  <div id="uc-boundary"><span id="uc-boundary-label">🖥 Psyco</span></div>
</div>



<div class="fixed bottom-6 right-8 z-[9999] flex items-center gap-4">
    <a id="btn-v11" href="<?= URL_BASE ?>pages/presentacion10" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
    </a>
    <a id="btn-s11" href="<?= URL_BASE ?>pages/presentacion12" class="inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
        <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
    </a>
</div>
</section>

<script>
// ─── ACTORES ────────────────────────────────────────────────────────────────
const ACTORS = [
  { id:'Usuario',    x:60,  y:380, emoji:'👤', label:'Usuario\n(General)' },
  { id:'Estudiante', x:60,  y:180, emoji:'👦', label:'Estudiante\n(Paciente)' },
  { id:'Psicologa',  x:60,  y:620, emoji:'🧑‍🔬', label:'Psicóloga' },
];

// ─── CASOS DE USO ─────────────────────────────────────────────────────────
// position: inside=true means inside boundary, false=outside
const USES = [
  // Compartidos (auth)
  { id:'uc-login',    x:260, y:340, label:'Iniciar Sesión',      cat:'auth' },
  { id:'uc-register', x:260, y:450, label:'Registrar Cuenta',    cat:'auth' },
  { id:'uc-logout',   x:260, y:550, label:'Cerrar Sesión',       cat:'auth' },

  // Solo Estudiante
  { id:'uc-calendario', x:550, y:20, label:'Consultar Calendario\nde Disponibilidad', cat:'patient' },
  { id:'uc-miscitas',  x:550, y:120, label:'Consultar\nMis Citas',  cat:'patient' },
  { id:'uc-solicitar', x:550, y:220, label:'Solicitar Cita',         cat:'patient' },
  { id:'uc-cancelar',  x:550, y:320, label:'Cancelar Cita',          cat:'patient' },
  { id:'uc-editar',    x:550, y:420, label:'Editar Cita',            cat:'patient' },
  { id:'uc-recursos',  x:550, y:520, label:'Consultar\nRecursos',    cat:'patient' },

  // Solo Psicóloga
  { id:'uc-agenda',    x:870, y:120, label:'Agendar Cita\n(Manual)', cat:'psy' },
  { id:'uc-cancel-p',  x:870, y:220, label:'Cancelar Cita\n(Psicóloga)', cat:'psy' },
  { id:'uc-notas',     x:870, y:340, label:'Gestionar Notas\nClínicas',   cat:'psy' },
  { id:'uc-creanota',  x:870, y:450, label:'Crear Nota',               cat:'psy' },
  { id:'uc-pacientes', x:870, y:560, label:'Gestionar\nPacientes',      cat:'psy' },
  { id:'uc-crearpaciente', x:1090, y:560, label:'Crear Paciente',      cat:'psy' },
  { id:'uc-dispon',    x:870, y:660, label:'Gestionar\nDisponibilidad',  cat:'psy' },
  { id:'uc-pub-rec',   x:870, y:760, label:'Publicar / Eliminar\nRecurso', cat:'psy' },

  // Extendidos / Incluidos
  { id:'uc-otp',       x:460, y:620, label:'Verificar OTP', cat:'auth' },
  { id:'uc-google',    x:260, y:240, label:'Login con Google', cat:'auth' },
];

// ─── RELACIONES ─────────────────────────────────────────────────────────────
// type: 'assoc' | 'gen' | 'include' | 'extend'
const RELS = [
  // Generalización: Estudiante y Psicóloga heredan de Usuario (▷ apunta a Usuario)
  { from:'Estudiante', to:'Usuario',   type:'gen' },
  { from:'Psicologa',  to:'Usuario',   type:'gen' },

  // Usuario asociado a login, register, logout
  { from:'Usuario', to:'uc-login',    type:'assoc' },
  { from:'Usuario', to:'uc-register', type:'assoc' },
  { from:'Usuario', to:'uc-logout',   type:'assoc' },

  // Estudiante → sus casos de uso
  { from:'Estudiante', to:'uc-calendario', type:'assoc' },
  { from:'Estudiante', to:'uc-miscitas',  type:'assoc' },
  { from:'Estudiante', to:'uc-solicitar', type:'assoc' },
  { from:'Estudiante', to:'uc-recursos',  type:'assoc' },

  // Psicóloga → sus casos de uso
  { from:'Psicologa', to:'uc-agenda',    type:'assoc' },
  { from:'Psicologa', to:'uc-cancel-p',  type:'assoc' },
  { from:'Psicologa', to:'uc-notas',     type:'assoc' },
  { from:'Psicologa', to:'uc-pacientes', type:'assoc' },
  { from:'Psicologa', to:'uc-dispon',    type:'assoc' },
  { from:'Psicologa', to:'uc-pub-rec',   type:'assoc' },

  // <<include>>: Registrar → siempre verifica OTP
  { from:'uc-register', to:'uc-otp',     type:'include' },

  // <<extend>>: Login ← Login con Google (opcional)
  { from:'uc-google', to:'uc-login',     type:'extend' },

  // <<extend>>: Ver mis citas ← cancelar / editar (condicional al tener citas)
  { from:'uc-cancelar', to:'uc-miscitas', type:'extend' },
  { from:'uc-editar',   to:'uc-miscitas', type:'extend' },

  // <<extend>>: Notas ← Crear Nota
  { from:'uc-creanota', to:'uc-notas',   type:'extend' },

  // <<extend>>: Gestionar Pacientes ← Crear Paciente
  { from:'uc-crearpaciente', to:'uc-pacientes', type:'extend' },
];

// ─── CONSTRUCCIÓN DEL DOM ────────────────────────────────────────────────
const canvas = document.getElementById('uc-canvas');
const positions = {}; // almacena centro x,y de cada elemento

function el(tag, cls, extra={}) {
  const e = document.createElement(tag);
  if(cls) e.className = cls;
  Object.entries(extra).forEach(([k,v]) => e.setAttribute(k,v));
  return e;
}

// Actores
ACTORS.forEach(a => {
  const div = el('div','uc-actor');
  div.id = 'ac-'+a.id;
  div.style.left = a.x+'px';
  div.style.top  = a.y+'px';

  const emoji = el('div','uc-actor-emoji');
  emoji.textContent = a.emoji;
  div.appendChild(emoji);

  const name = el('div','uc-actor-name');
  name.textContent = a.label.replace('\n',' ');
  div.appendChild(name);

  canvas.appendChild(div);
  positions[a.id] = { x: a.x+40, y: a.y+40 };
});

// Casos de uso
USES.forEach(u => {
  const div = el('div','uc-case');
  div.id = u.id;
  div.style.left = u.x+'px';
  div.style.top  = u.y+'px';

  const oval = el('div', 'uc-oval '+u.cat);
  oval.textContent = u.label;
  div.appendChild(oval);

  canvas.appendChild(div);
  positions[u.id] = { x: u.x+80, y: u.y+30 };
});

// Límite del sistema (bounding box alrededor de todos los USES)
const boundary = document.getElementById('uc-boundary');
boundary.style.left   = '220px';
boundary.style.top    = '10px';
boundary.style.width  = '1060px';
boundary.style.height = '850px';

// ─── DRAG & DROP ────────────────────────────────────────────────────────────
let drag = null, sx, sy;
const ix = {}, iy = {};
function makeDraggable(el) {
  ix[el.id] = parseFloat(el.style.left)||0;
  iy[el.id] = parseFloat(el.style.top)||0;
  el.addEventListener('mousedown', e => {
    drag = el; sx = e.clientX; sy = e.clientY;
    document.querySelectorAll('.uc-actor,.uc-case').forEach(x=>x.style.zIndex=20);
    el.style.zIndex = 100;
  });
}
document.querySelectorAll('.uc-actor,.uc-case').forEach(makeDraggable);
document.addEventListener('mousemove', e => {
  if(!drag) return;
  const nx = (ix[drag.id]||0)+(e.clientX-sx);
  const ny = (iy[drag.id]||0)+(e.clientY-sy);
  drag.style.left = nx+'px';
  drag.style.top  = ny+'px';
  drawLines();
});
document.addEventListener('mouseup', e => {
  if(!drag) return;
  ix[drag.id] = parseFloat(drag.style.left);
  iy[drag.id] = parseFloat(drag.style.top);
  drag = null;
});

// ─── GEOMETRÍA ───────────────────────────────────────────────────────────────
function getCenter(id) {
  // Actores
  const actor = document.getElementById('ac-'+id);
  if(actor) {
    const cr = canvas.getBoundingClientRect();
    const r  = actor.getBoundingClientRect();
    return { x: r.left-cr.left+r.width/2, y: r.top-cr.top+r.height/2 };
  }
  // Casos de uso
  const uc = document.getElementById(id);
  if(uc) {
    const cr = canvas.getBoundingClientRect();
    const r  = uc.getBoundingClientRect();
    return { x: r.left-cr.left+r.width/2, y: r.top-cr.top+r.height/2 };
  }
  return { x:0, y:0 };
}

function getEllipseEdge(center, w, h, targetX, targetY) {
  const dx = targetX - center.x;
  const dy = targetY - center.y;
  const angle = Math.atan2(dy, dx);
  const rx = w/2, ry = h/2;
  const ex = rx * Math.cos(angle);
  const ey = ry * Math.sin(angle);
  return { x: center.x + ex, y: center.y + ey };
}

// ─── DIBUJO SVG ──────────────────────────────────────────────────────────────
function drawLines() {
  const svg = document.getElementById('uc-svg');
  svg.innerHTML = '';
  const cr = canvas.getBoundingClientRect();
  const sr = svg.parentElement.getBoundingClientRect();
  const ox = cr.left-sr.left, oy = cr.top-sr.top;

  const defs = document.createElementNS('http://www.w3.org/2000/svg','defs');
  // Triangle marker (generalización)
  defs.innerHTML = `
    <marker id="tri-gen" markerWidth="14" markerHeight="14" refX="14" refY="7" orient="auto">
      <polygon points="0,0 14,7 0,14" fill="#0f172a" stroke="#cbd5e1" stroke-width="1.5"/>
    </marker>
    <marker id="arr-open" markerWidth="10" markerHeight="10" refX="10" refY="5" orient="auto">
      <polyline points="0,0 10,5 0,10" fill="none" stroke="#94a3b8" stroke-width="2"/>
    </marker>
  `;
  svg.appendChild(defs);

  RELS.forEach(rel => {
    const f = getCenter(rel.from);
    const t = getCenter(rel.to);
    const x1 = f.x+ox, y1 = f.y+oy;
    const x2 = t.x+ox, y2 = t.y+oy;

    const path = document.createElementNS('http://www.w3.org/2000/svg','path');
    path.setAttribute('fill','none');
    path.setAttribute('stroke-width','2');

    const midX = (x1+x2)/2, midY = (y1+y2)/2;

    if(rel.type === 'assoc') {
      // Línea continua, sin flecha
      path.setAttribute('d', `M${x1},${y1} L${x2},${y2}`);
      path.setAttribute('stroke','#94a3b8');
      svg.appendChild(path);
    }
    else if(rel.type === 'gen') {
      // Línea continua + triángulo vacío hacia el padre
      path.setAttribute('d', `M${x1},${y1} L${x2},${y2}`);
      path.setAttribute('stroke','#cbd5e1');
      path.setAttribute('marker-end','url(#tri-gen)');
      svg.appendChild(path);
    }
    else if(rel.type === 'include') {
      // Línea discontinua + flecha abierta + etiqueta <<include>>
      path.setAttribute('d', `M${x1},${y1} L${x2},${y2}`);
      path.setAttribute('stroke','#60a5fa');
      path.setAttribute('stroke-dasharray','7,5');
      path.setAttribute('marker-end','url(#arr-open)');
      svg.appendChild(path);

      const label = document.createElementNS('http://www.w3.org/2000/svg','text');
      label.setAttribute('x', midX);
      label.setAttribute('y', midY - 6);
      label.setAttribute('fill','#60a5fa');
      label.setAttribute('font-size','10');
      label.setAttribute('text-anchor','middle');
      label.setAttribute('font-style','italic');
      label.textContent = '«include»';
      svg.appendChild(label);
    }
    else if(rel.type === 'extend') {
      // Línea discontinua + flecha abierta + etiqueta <<extend>>
      path.setAttribute('d', `M${x1},${y1} L${x2},${y2}`);
      path.setAttribute('stroke','#f59e0b');
      path.setAttribute('stroke-dasharray','7,5');
      path.setAttribute('marker-end','url(#arr-open)');
      svg.appendChild(path);

      const label = document.createElementNS('http://www.w3.org/2000/svg','text');
      label.setAttribute('x', midX);
      label.setAttribute('y', midY - 6);
      label.setAttribute('fill','#f59e0b');
      label.setAttribute('font-size','10');
      label.setAttribute('text-anchor','middle');
      label.setAttribute('font-style','italic');
      label.textContent = '«extend»';
      svg.appendChild(label);
    }
  });
}

// ─── LEYENDA ─────────────────────────────────────────────────────────────────
const leg = document.createElement('div');
leg.style.cssText = 'position:fixed;bottom:70px;left:50%;transform:translateX(-50%);z-index:50;display:flex;gap:14px;background:rgba(0,0,0,.75);backdrop-filter:blur(10px);padding:8px 20px;border-radius:24px;border:1px solid rgba(255,255,255,.2);pointer-events:none;flex-wrap:wrap;justify-content:center;max-width:90vw;';
leg.innerHTML = `
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:24px;height:2px;background:#94a3b8;"></span> Asociación</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:24px;height:2px;background:#cbd5e1;position:relative;"><span style="position:absolute;right:-4px;top:-4px;width:0;height:0;border-left:8px solid #cbd5e1;border-top:5px solid transparent;border-bottom:5px solid transparent;"></span></span> Generalización</span>
  <span style="color:#60a5fa;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:24px;height:2px;border-top:2px dashed #60a5fa;position:relative;"><span style="position:absolute;right:-2px;top:-5px;font-size:14px;line-height:1;">›</span></span> <i>«include»</i></span>
  <span style="color:#f59e0b;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:24px;height:2px;border-top:2px dashed #f59e0b;position:relative;"><span style="position:absolute;right:-2px;top:-5px;font-size:14px;line-height:1;">›</span></span> <i>«extend»</i></span>
  <span style="color:#94a3b8;font-size:11px;border-left:1px solid #475569;padding-left:14px;">Actores: 👦 Estudiante · 🧑‍🔬 Psicóloga · 👤 Usuario</span>
`;
document.body.appendChild(leg);

// ─── INIT ─────────────────────────────────────────────────────────────────────
// Ocultar sidebar si existe
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  if(sidebar) sidebar.style.display = 'none';
  // Mover botones al body para que no queden bloqueados por el canvas SVG
  const navWrapper = document.querySelector('div.fixed.bottom-6.right-8');
  if(navWrapper && !document.getElementById('nav-wrapper-11')) {
    navWrapper.id = 'nav-wrapper-11';
    document.body.appendChild(navWrapper);
  }
  setTimeout(drawLines, 200);
});
window.addEventListener('resize', drawLines);
new ResizeObserver(drawLines).observe(canvas);
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
    const CURRENT_PAGE = 11;
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
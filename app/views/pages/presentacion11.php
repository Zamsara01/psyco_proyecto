<?php
// Ocultar sidebar en esta página
$hideSidebar = true;
?>
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
  <div id="uc-boundary"><span id="uc-boundary-label">🖥 PsycoApp System</span></div>
</div>

<a id="btn-v11" href="<?= URL_BASE ?>pages/presentacion10" class="fixed bottom-6 left-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
    <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
</a>
<a id="btn-s11" href="<?= URL_BASE ?>pages/presentacion12" class="fixed bottom-6 right-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
    <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
</a>
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
boundary.style.top    = '80px';
boundary.style.width  = '780px';
boundary.style.height = '750px';

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
    e.preventDefault();
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
  setTimeout(drawLines, 200);
});
window.addEventListener('resize', drawLines);
new ResizeObserver(drawLines).observe(canvas);
</script>

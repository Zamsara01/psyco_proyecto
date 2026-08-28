<!-- PSYCO — Presentación 10 (Diagrama de Clases) -->
<script>
(function(){
    const s=document.getElementById('app-sidebar'),m=document.getElementById('main-content');
    if(s)s.style.display='none';
    if(m){m.style.marginLeft='0';m.classList.remove('lg:ml-64');}
    window.addEventListener('pagehide',()=>{if(s)s.style.display='';if(m){m.style.marginLeft='';m.classList.add('lg:ml-64');}});
})();
</script>
<style>
@keyframes nebula-flow{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
.bg-nebula{background:linear-gradient(270deg,#10b981,#2563eb,#34d399,#3b82f6);background-size:300% 300%;animation:nebula-flow 8s ease infinite;}
#cls-canvas{position:relative;width:2400px;min-height:1200px;}
.cls-box{position:absolute;background:#fff;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,.2);border:2px solid rgba(255,255,255,.3);min-width:180px;cursor:grab;user-select:none;z-index:10;font-size:10px;}
.cls-box:active{cursor:grabbing;z-index:100;}
.cls-head{padding:5px 10px;font-weight:800;font-size:11px;color:#fff;font-family:'Canva Sans',sans-serif;display:flex;align-items:center;gap:4px;border-radius:6px 6px 0 0;}
.cls-stereo{font-size:8px;opacity:.8;font-style:italic;}
.cls-section{border-top:1px solid #e2e8f0;}
.cls-section li{padding:2px 10px;color:#334155;border-bottom:1px solid #f8fafc;white-space:nowrap;}
.cls-section li.pub{color:#166534;}
.cls-section li.prv{color:#991b1b;}
.cls-section li.prt{color:#1e40af;}
.cls-section li.abs{color:#6b21a8;font-style:italic;}
.cls-section ul{list-style:none;margin:0;padding:0;}
.cls-badge{position:absolute;top:-22px;left:50%;transform:translateX(-50%);font-size:9px;font-weight:800;padding:2px 10px;background:rgba(0,0,0,.6);color:#fbbf24;border-radius:20px;white-space:nowrap;font-family:monospace;border:1px solid rgba(255,255,255,.2);pointer-events:none;}
</style>
<section class="min-h-screen py-6 px-4 bg-nebula flex flex-col items-center w-full relative overflow-auto">
<svg id="cls-svg" class="absolute top-0 left-0 pointer-events-none z-0" style="width:100%;height:100%;overflow:visible;"></svg>
<div class="flex flex-col items-center mb-4 mt-2 z-10 w-full pointer-events-none">
    <h2 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg mb-1" style="font-family:'Canva Sans',sans-serif;">DIAGRAMA DE CLASES</h2>
    <p class="text-xs text-white/90 font-medium bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-md">Clases reales del código fuente · Arrastra para organizar</p>
</div>
<div id="cls-canvas" class="z-10 relative mx-auto pb-20">
</div>
<a id="btn-v10" href="<?= URL_BASE ?>pages/presentacion9" class="fixed bottom-6 left-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
    <span class="material-symbols-outlined">arrow_back</span><span class="font-bold text-sm">Volver</span>
</a>
<a id="btn-s10" href="<?= URL_BASE ?>pages/presentacion11" class="fixed bottom-6 right-6 z-[9999] inline-flex items-center gap-2 text-white/80 hover:text-white bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-2xl backdrop-blur-sm border border-white/10 shadow-lg transition-colors">
    <span class="font-bold text-sm">Siguiente</span><span class="material-symbols-outlined">arrow_forward</span>
</a>
</section>
<script>
const CLASSES = [
  {id:'Model',x:900,y:20,color:'#475569',stereo:'«abstract»',badge:'Clase Base',
   attrs:['# db : PDO'],
   methods:['abs + __construct() : void']},
  {id:'Controller',x:1200,y:20,color:'#475569',stereo:'«abstract»',badge:'Clase Base',
   attrs:['# layout : string'],
   methods:['# render(view,data) : void','# redirect(path) : void']},
  {id:'UserModel',x:40,y:200,color:'#2563eb',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ getAll() : array','+ findById(id) : ?array',
    '+ findByCredentials(email,pass) : ?array','+ create(...) : void',
    '+ buscarTodos(query) : array','+ emailExists(email) : bool',
    '+ findByGoogle(data) : ?array','+ getActivePatientsWithDisorder() : array']},
  {id:'CitaModel',x:260,y:200,color:'#9333ea',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ misCitas(id) : array','+ crear(...) : int',
    '+ cancelar(id) : bool','+ editar(...) : bool',
    '+ horasDisponibles(...) : array','+ getById(id) : ?array',
    '+ getCitasPsicologo(id) : array','+ iniciarCita(id) : bool',
    '+ finalizarCita(id,min) : bool']},
  {id:'PsicologoModel',x:490,y:200,color:'#059669',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ findByCredentials(email,pass) : ?array',
    '+ findById(id) : ?array','+ getAllActivos() : array',
    '+ getDisponibilidad(id) : array',
    '+ addDisponibilidad(...) : bool',
    '+ deleteDisponibilidad(...) : bool']},
  {id:'OtpModel',x:700,y:200,color:'#334155',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ crear(email,hash,type) : void',
    '+ findValid(email,type) : ?array',
    '+ invalidar(id) : void','+ incrementAttempts(id) : void']},
  {id:'NotaPacienteModel',x:900,y:200,color:'#c026d3',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ getByPsicologo(id) : array',
    '+ getByPaciente(id) : array',
    '+ crear(...) : bool']},
  {id:'RecordatorioModel',x:1100,y:200,color:'#f43f5e',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ crearRecordatorio(...) : bool',
    '+ marcarEnviado(id) : bool','+ marcarFallido(id) : bool',
    '+ getByCita(id) : array','+ getPendientes(n) : array']},
  {id:'RecursoModel',x:1300,y:200,color:'#f97316',stereo:'«Model»',badge:'extends Model',
   attrs:[], methods:[
    '+ getRecursosByUsuario(id) : array',
    '+ getRecursosByPsicologo(id) : array',
    '+ createRecurso(...) : bool','+ deleteRecurso(...) : bool']},
  {id:'ControllerUsers',x:40,y:560,color:'#1d4ed8',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- userModel : UserModel'],
   methods:['+ login() : void','+ authenticate() : void',
    '+ register() : void','+ store() : void',
    '+ verifyOtp() : void','+ resendOtp() : void',
    '+ logout() : void']},
  {id:'ControllerAuth',x:240,y:560,color:'#4338ca',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- oauthService : GoogleOAuthService','- userModel : UserModel'],
   methods:['+ google() : void','+ googleCallback() : void','+ error() : void']},
  {id:'ControllerCitas',x:440,y:560,color:'#7c3aed',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:[
    '+ misCitas() : void','+ misRecursos() : void',
    '+ cancelar() : void','+ cancelarPsicologa() : void',
    '+ editar() : void','+ horasDisponiblesEdicion() : void']},
  {id:'ControllerPanel',x:640,y:560,color:'#065f46',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- UPLOADS_DIR : string'],
   methods:['+ index() : void','+ notasPacientes() : void',
    '+ buscarPaciente() : void','+ crearNota() : void',
    '+ recursos() : void','+ publicarRecurso() : void',
    '+ obtenerRecursos() : void','+ eliminarRecurso() : void',
    '+ agendarCita() : void','+ crearPaciente() : void',
    '+ obtenerDisponibilidad() : void','+ agregarDisponibilidad() : void',
    '- requirePsicologo() : void']},
  {id:'ControllerChat',x:870,y:560,color:'#0e7490',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:[
    '+ index() : void','+ psicologosDisponibles() : void',
    '+ horasDisponibles() : void',
    '+ guardarCita() : void','+ terminarCita() : void',
    '- diaSemanaEspanol(fecha) : string']},
  {id:'ControllerPages',x:1060,y:560,color:'#64748b',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:['+ index() : void','+ presentacion1..12() : void','+ about() : void','+ services() : void']},
  {id:'OEmbedIface',x:1300,y:560,color:'#0891b2',stereo:'«interface»',badge:'Interface',
   attrs:[], methods:['+ supports(url) : bool','+ fetch(url) : OEmbedDTO']},
  {id:'YouTubeService',x:1300,y:820,color:'#0369a1',stereo:'«Service»',badge:'implements Interface',
   attrs:['- logger : Logger','- cache : FileCache'],
   methods:['+ supports(url) : bool','+ fetch(url) : OEmbedDTO','- createDtoFromArray(data) : OEmbedDTO']},
  {id:'OEmbedDTO',x:1560,y:560,color:'#0f766e',stereo:'«DTO»',badge:'implements JsonSerializable',
   attrs:['+ title : string','+ html : string','+ width : int','+ height : int',
    '+ provider_name : string','+ author_name : ?string','+ thumbnail_url : ?string'],
   methods:['+ toArray() : array','+ jsonSerialize() : mixed']},
];

const RELATIONS = [
  // Herencia (solid + empty triangle)
  {from:'UserModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'CitaModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'PsicologoModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'OtpModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'NotaPacienteModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'RecordatorioModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'RecursoModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'ControllerUsers',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerAuth',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerCitas',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerPanel',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerChat',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerPages',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  
  // Implementación (dashed + empty triangle)
  {from:'YouTubeService',to:'OEmbedIface',type:'implement',color:'#67e8f9',m1:'',m2:''},
  
  // Asociación (solid line)
  {from:'ControllerUsers',to:'UserModel',type:'assoc',color:'#fbbf24',m1:'1',m2:'1'},
  {from:'ControllerAuth',to:'UserModel',type:'assoc',color:'#fbbf24',m1:'1',m2:'1'},
  
  // Agregación (rombo vacío en el origen)
  {from:'PsicologoModel',to:'CitaModel',type:'agreg',color:'#f472b6',m1:'1',m2:'0..*'},
  
  // Composición (rombo lleno en el origen)
  {from:'CitaModel',to:'RecordatorioModel',type:'comp',color:'#e879f9',m1:'1',m2:'0..*'},
  
  // Dependencia (dashed + arrow)
  {from:'ControllerPanel',to:'CitaModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerPanel',to:'NotaPacienteModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerPanel',to:'RecursoModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerPanel',to:'PsicologoModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerChat',to:'CitaModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerChat',to:'PsicologoModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerCitas',to:'CitaModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'ControllerCitas',to:'RecursoModel',type:'depend',color:'#fb923c',m1:'',m2:''},
  {from:'YouTubeService',to:'OEmbedDTO',type:'depend',color:'#6ee7b7',m1:'',m2:''},
];

const canvas = document.getElementById('cls-canvas');
const positions = {};

function buildBox(cls) {
  const div = document.createElement('div');
  div.className = 'cls-box';
  div.id = 'cls-'+cls.id;
  div.style.left = cls.x+'px';
  div.style.top  = cls.y+'px';
  positions[cls.id] = {x:cls.x, y:cls.y};

  const badge = document.createElement('div');
  badge.className = 'cls-badge';
  badge.textContent = cls.badge;
  div.appendChild(badge);

  const head = document.createElement('div');
  head.className = 'cls-head';
  head.style.background = cls.color;
  head.innerHTML = `<span class="material-symbols-outlined" style="font-size:13px;">class</span><div><div class="cls-stereo">${cls.stereo}</div><div>${cls.id}</div></div>`;
  div.appendChild(head);

  if (cls.attrs.length) {
    const sec = document.createElement('div');
    sec.className = 'cls-section';
    const ul = document.createElement('ul');
    cls.attrs.forEach(a => {
      const li = document.createElement('li');
      li.className = a.startsWith('-') ? 'prv' : a.startsWith('#') ? 'prt' : 'pub';
      li.textContent = a;
      ul.appendChild(li);
    });
    sec.appendChild(ul);
    div.appendChild(sec);
  }

  if (cls.methods.length) {
    const sec = document.createElement('div');
    sec.className = 'cls-section';
    const ul = document.createElement('ul');
    cls.methods.forEach(m => {
      const li = document.createElement('li');
      li.className = m.startsWith('-') ? 'prv' : m.startsWith('#') ? 'prt' : m.startsWith('abs') ? 'abs' : 'pub';
      li.textContent = m.replace(/^abs /,'');
      ul.appendChild(li);
    });
    sec.appendChild(ul);
    div.appendChild(sec);
  }

  canvas.appendChild(div);
}

CLASSES.forEach(buildBox);

let drag=null,sx,sy;
const ix={},iy={};
document.querySelectorAll('.cls-box').forEach(el=>{
  ix[el.id]=parseFloat(el.style.left)||0;
  iy[el.id]=parseFloat(el.style.top)||0;
  el.addEventListener('mousedown',e=>{drag=el;sx=e.clientX;sy=e.clientY;e.preventDefault();
    document.querySelectorAll('.cls-box').forEach(x=>x.style.zIndex=10);el.style.zIndex=100;});
});
document.addEventListener('mousemove',e=>{
  if(!drag)return;
  const nx=(ix[drag.id]||0)+(e.clientX-sx);
  const ny=(iy[drag.id]||0)+(e.clientY-sy);
  drag.style.left=nx+'px';drag.style.top=ny+'px';
  drawLines();
});
document.addEventListener('mouseup',e=>{
  if(!drag)return;
  ix[drag.id]=parseFloat(drag.style.left);
  iy[drag.id]=parseFloat(drag.style.top);
  drag=null;
});

function getBoxIntersection(r, cr, ox, oy, tx, ty) {
  const cx = r.left - cr.left + r.width/2 + ox;
  const cy = r.top - cr.top + r.height/2 + oy;
  const w = r.width/2 + 2; // Padding para que no toque el borde interno
  const h = r.height/2 + 2;
  
  const dx = tx - cx;
  const dy = ty - cy;
  if(dx===0 && dy===0) return {x:cx,y:cy};
  
  let x = dx > 0 ? w : -w;
  let y = dy * (x / dx);
  if(Math.abs(y) <= h) return {x: cx+x, y: cy+y};
  
  y = dy > 0 ? h : -h;
  x = dx * (y / dy);
  return {x: cx+x, y: cy+y};
}

function drawLines() {
  const svg = document.getElementById('cls-svg');
  svg.innerHTML = '';
  const cr = canvas.getBoundingClientRect();
  const sr = svg.parentElement.getBoundingClientRect();
  const ox = cr.left-sr.left, oy = cr.top-sr.top;

  const defs = document.createElementNS('http://www.w3.org/2000/svg','defs');
  const generatedMarkers = new Set();
  
  RELATIONS.forEach((rel) => {
    const c = rel.color.replace('#','');
    if(!generatedMarkers.has(c)) {
      generatedMarkers.add(c);
      defs.innerHTML += `
        <marker id="mark-inherit-${c}" markerWidth="14" markerHeight="14" refX="14" refY="7" orient="auto">
          <polygon points="0,0 14,7 0,14" fill="#0f172a" stroke="${rel.color}" stroke-width="1.5" />
        </marker>
        <marker id="mark-depend-${c}" markerWidth="12" markerHeight="12" refX="12" refY="6" orient="auto">
          <polyline points="0,0 12,6 0,12" fill="none" stroke="${rel.color}" stroke-width="2" />
        </marker>
        <marker id="mark-agreg-${c}" markerWidth="16" markerHeight="12" refX="0" refY="6" orient="auto">
          <polygon points="0,6 8,0 16,6 8,12" fill="#0f172a" stroke="${rel.color}" stroke-width="1.5" />
        </marker>
        <marker id="mark-comp-${c}" markerWidth="16" markerHeight="12" refX="0" refY="6" orient="auto">
          <polygon points="0,6 8,0 16,6 8,12" fill="${rel.color}" stroke="${rel.color}" stroke-width="1.5" />
        </marker>
      `;
    }
  });
  svg.appendChild(defs);

  RELATIONS.forEach(rel=>{
    const elF = document.getElementById('cls-'+rel.from);
    const elT = document.getElementById('cls-'+rel.to);
    if(!elF || !elT) return;

    const rF = elF.getBoundingClientRect();
    const rT = elT.getBoundingClientRect();
    const cF = { x: rF.left - cr.left + rF.width/2 + ox, y: rF.top - cr.top + rF.height/2 + oy };
    const cT = { x: rT.left - cr.left + rT.width/2 + ox, y: rT.top - cr.top + rT.height/2 + oy };

    // Calcular intersección exacta con los bordes de la caja
    const pF = getBoxIntersection(rF, cr, ox, oy, cT.x, cT.y);
    const pT = getBoxIntersection(rT, cr, ox, oy, cF.x, cF.y);

    const path = document.createElementNS('http://www.w3.org/2000/svg','path');
    
    // Line style
    if (rel.type==='implement' || rel.type==='depend') {
      path.setAttribute('stroke-dasharray', '8,6');
    }
    
    path.setAttribute('d', `M${pF.x},${pF.y} L${pT.x},${pT.y}`);
    path.setAttribute('stroke', rel.color);
    path.setAttribute('stroke-width', '2.5');
    path.setAttribute('fill', 'none');
    path.setAttribute('opacity', '0.85');
    
    const c = rel.color.replace('#','');
    if (rel.type === 'inherit' || rel.type === 'implement') {
      path.setAttribute('marker-end', `url(#mark-inherit-${c})`);
    } else if (rel.type === 'depend') {
      path.setAttribute('marker-end', `url(#mark-depend-${c})`);
    } else if (rel.type === 'agreg') {
      path.setAttribute('marker-start', `url(#mark-agreg-${c})`);
    } else if (rel.type === 'comp') {
      path.setAttribute('marker-start', `url(#mark-comp-${c})`);
    }
    
    svg.appendChild(path);

    // Multiplicidades (posicionadas a lo largo de la línea)
    const dx = pT.x - pF.x, dy = pT.y - pF.y;
    const len = Math.hypot(dx, dy);
    if(len > 0) {
      const nx = dx / len, ny = dy / len;
      
      if(rel.m1) {
        const text = document.createElementNS('http://www.w3.org/2000/svg','text');
        text.setAttribute('x', pF.x + nx * 20 - ny * 10);
        text.setAttribute('y', pF.y + ny * 20 + nx * 10);
        text.setAttribute('fill', '#fbbf24');
        text.setAttribute('font-size', '12');
        text.setAttribute('font-weight', 'bold');
        text.textContent = rel.m1;
        svg.appendChild(text);
      }
      if(rel.m2) {
        const text = document.createElementNS('http://www.w3.org/2000/svg','text');
        text.setAttribute('x', pT.x - nx * 25 - ny * 10);
        text.setAttribute('y', pT.y - ny * 25 + nx * 10);
        text.setAttribute('fill', '#fbbf24');
        text.setAttribute('font-size', '12');
        text.setAttribute('font-weight', 'bold');
        text.textContent = rel.m2;
        svg.appendChild(text);
      }
    }
  });
}

// Legend
const leg = document.createElement('div');
leg.style.cssText='position:fixed;bottom:70px;left:50%;transform:translateX(-50%);z-index:50;display:flex;gap:12px;background:rgba(0,0,0,.75);backdrop-filter:blur(10px);padding:8px 20px;border-radius:24px;border:1px solid rgba(255,255,255,.2);pointer-events:none;flex-wrap:wrap;justify-content:center;max-width:90vw;';
leg.innerHTML=`
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:#cbd5e1;position:relative;"><span style="position:absolute;right:-4px;top:-4px;width:0;height:0;border-left:8px solid #cbd5e1;border-top:5px solid transparent;border-bottom:5px solid transparent;"></span></span> Herencia</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:transparent;border-top:2px dashed #67e8f9;position:relative;"><span style="position:absolute;right:-4px;top:-5px;width:0;height:0;border-left:8px solid #67e8f9;border-top:5px solid transparent;border-bottom:5px solid transparent;"></span></span> Implementa</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:#f472b6;position:relative;"><span style="position:absolute;left:0;top:-4px;width:10px;height:10px;border:2px solid #f472b6;transform:rotate(45deg);"></span></span> Agregación</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:#e879f9;position:relative;"><span style="position:absolute;left:0;top:-4px;width:10px;height:10px;background:#e879f9;transform:rotate(45deg);"></span></span> Composición</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:#fbbf24;"></span> Asociación</span>
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:transparent;border-top:2px dashed #fb923c;position:relative;"><span style="position:absolute;right:-2px;top:-5px;font-size:14px;color:#fb923c;line-height:1;">></span></span> Dependencia</span>
  <span style="color:#94a3b8;font-size:11px;border-left:1px solid #475569;padding-left:12px;">+ pub &nbsp; - priv &nbsp; # prot</span>`;
document.body.appendChild(leg);

document.addEventListener('DOMContentLoaded',()=>{
  ['btn-v10','btn-s10'].forEach(id=>{const b=document.getElementById(id);if(b)document.body.appendChild(b);});
  setTimeout(drawLines,200);
});
window.addEventListener('resize',drawLines);
new ResizeObserver(drawLines).observe(canvas);
</script>

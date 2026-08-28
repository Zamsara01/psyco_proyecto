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
.dimmed { opacity: 0.15 !important; pointer-events: none; }
.cls-box, path, polygon, polyline, line, text { transition: opacity 0.3s; }
/* Tooltip animado simple */
.info-icon { position:absolute; top:-10px; right:-10px; width:22px; height:22px; background:#3b82f6; border-radius:50%; color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:bold; cursor:help; border:2px solid #fff; z-index:20; }
.info-tooltip { position:absolute; bottom:30px; right:-10px; background:#1e293b; color:#fff; padding:6px 10px; border-radius:6px; font-size:10px; width:200px; opacity:0; pointer-events:none; transition:opacity 0.2s; box-shadow:0 4px 12px rgba(0,0,0,0.3); font-weight:normal; }
.info-icon:hover .info-tooltip { opacity:1; }
</style>
<section class="min-h-screen py-6 px-4 bg-nebula flex flex-col items-center w-full relative overflow-auto">
<svg id="cls-svg" class="absolute top-0 left-0 pointer-events-none z-0" style="width:100%;height:100%;overflow:visible;"></svg>
<div class="flex flex-col items-center mb-4 mt-2 z-10 w-full pointer-events-none">
    <h2 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg mb-1" style="font-family:'Canva Sans',sans-serif;">DIAGRAMA DE CLASES</h2>
    <p class="text-xs text-white/90 font-medium bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-md">Clases reales del código fuente · Arrastra para organizar</p>
</div>

<!-- Controles UI -->
<div class="flex flex-col gap-3" style="position: fixed; top: 24px; left: 24px; z-index: 1000; pointer-events: auto;">
    <div class="bg-black/50 backdrop-blur-md border border-white/20 p-3 rounded-xl shadow-xl flex flex-col gap-2 w-48">
        <span class="text-white text-xs font-bold mb-1 border-b border-white/10 pb-1">Vista por Secciones</span>
        <button class="filter-btn w-full text-left text-sm text-white/90 hover:text-white bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded transition-colors" data-filter="all">✓ Mostrar Todo</button>
        <button class="filter-btn w-full text-left text-sm text-white/90 hover:text-white bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded transition-colors" data-filter="model">◫ Solo Modelos</button>
        <button class="filter-btn w-full text-left text-sm text-white/90 hover:text-white bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded transition-colors" data-filter="controller">⚙ Solo Controladores</button>
    </div>
    
    <div class="bg-black/50 backdrop-blur-md border border-white/20 p-3 rounded-xl shadow-xl w-48">
        <button id="toggle-deps" class="w-full text-sm text-red-400 font-bold hover:text-red-300 bg-white/5 hover:bg-white/10 px-3 py-2 rounded flex items-center justify-between transition-colors">
            Dependencias 
            <span id="deps-status" class="bg-red-500/30 px-2 py-0.5 rounded text-xs">ON</span>
        </button>
    </div>
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
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ getAll() : array','+ findById(id) : ?array',
    '+ findByCredentials(email,pass) : ?array','+ create(...) : void',
    '+ buscarTodos(query) : array','+ emailExists(email) : bool',
    '+ findByGoogle(data) : ?array','+ getActivePatientsWithDisorder() : array']},
  {id:'CitaModel',x:260,y:200,color:'#9333ea',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ misCitas(id) : array','+ crear(...) : int',
    '+ cancelar(id) : bool','+ editar(...) : bool',
    '+ horasDisponibles(...) : array','+ getById(id) : ?array',
    '+ getCitasPsicologo(id) : array','+ iniciarCita(id) : bool',
    '+ finalizarCita(id,min) : bool']},
  {id:'PsicologoModel',x:490,y:200,color:'#059669',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ findByCredentials(email,pass) : ?array',
    '+ findById(id) : ?array','+ getAllActivos() : array',
    '+ getDisponibilidad(id) : array',
    '+ addDisponibilidad(...) : bool',
    '+ deleteDisponibilidad(...) : bool']},
  {id:'OtpModel',x:700,y:200,color:'#334155',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ crear(email,hash,type) : void',
    '+ findValid(email,type) : ?array',
    '+ invalidar(id) : void','+ incrementAttempts(id) : void']},
  {id:'NotaPacienteModel',x:900,y:200,color:'#c026d3',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ getByPsicologo(id) : array',
    '+ getByPaciente(id) : array',
    '+ crear(...) : bool']},
  {id:'RecordatorioModel',x:1100,y:200,color:'#f43f5e',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ crearRecordatorio(...) : bool',
    '+ marcarEnviado(id) : bool','+ marcarFallido(id) : bool',
    '+ getByCita(id) : array','+ getPendientes(n) : array']},
  {id:'RecursoModel',x:1300,y:200,color:'#f97316',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ getRecursosByUsuario(id) : array',
    '+ getRecursosByPsicologo(id) : array',
    '+ createRecurso(...) : bool','+ deleteRecurso(...) : bool']},
  {id:'ProductModel',x:1500,y:200,color:'#b45309',stereo:'«Model»',badge:'extends Model',
   attrs:['// Propiedades mapeadas','// dinámicamente vía PDO'], methods:[
    '+ getAll() : array','+ findById(id) : ?array',
    '+ create(...) : void','+ update(...) : void',
    '+ delete(id) : void']},
  {id:'ControllerUsers',x:40,y:560,color:'#1d4ed8',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- userModel : UserModel'],
   methods:['+ login() : void','+ authenticate() : void',
    '+ register() : void','+ store() : void',
    '+ verifyOtp() : void','+ resendOtp() : void',
    '+ logout() : void','+ list() : void','+ edit() : void']},
  {id:'ControllerAuth',x:240,y:560,color:'#4338ca',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- oauthService : GoogleOAuthService','- userModel : UserModel'],
   methods:['+ google() : void','+ googleCallback() : void','+ error() : void']},
  {id:'ControllerCitas',x:440,y:560,color:'#7c3aed',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:[
    '+ misCitas() : void','+ misRecursos() : void',
    '+ cancelar() : void','+ cancelarPsicologa() : void',
    '+ editar() : void','+ horasDisponiblesEdicion() : void']},
  {id:'ControllerPanel_psicologas',x:640,y:560,color:'#065f46',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- UPLOADS_DIR : string'],
   methods:['+ index() : void','+ notasPacientes() : void',
    '+ buscarPaciente() : void','+ crearNota() : void',
    '+ recursos() : void','+ publicarRecurso() : void',
    '+ obtenerRecursos() : void','+ eliminarRecurso() : void',
    '+ agendarCita() : void','+ crearPaciente() : void',
    '+ obtenerDisponibilidad() : void','+ agregarDisponibilidad() : void',
    '+ historialPaciente() : void','+ notasPaciente() : void',
    '+ buscarTodosLosPacientes() : void','+ horasDisponiblesAgenda() : void',
    '+ eliminarDisponibilidad() : void',
    '- requirePsicologo() : void']},
  {id:'ControllerChat_bot',x:870,y:560,color:'#0e7490',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:[
    '+ index() : void','+ psicologosDisponibles() : void',
    '+ horasDisponibles() : void',
    '+ guardarCita() : void','+ terminarCita() : void',
    '- diaSemanaEspanol(fecha) : string']},
  {id:'ControllerPages',x:1060,y:560,color:'#64748b',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:['+ index() : void','+ presentacion1..12() : void','+ about() : void','+ services() : void']},
  {id:'ControllerApi',x:1260,y:560,color:'#0c4a6e',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:['+ oembed() : void']},
  {id:'ControllerCalendario',x:1460,y:560,color:'#134e4a',stereo:'«Controller»',badge:'extends Controller',
   attrs:[], methods:['+ index() : void']},
  {id:'ControllerProducts',x:1660,y:560,color:'#78350f',stereo:'«Controller»',badge:'extends Controller',
   attrs:['- productModel : ProductModel'],
   methods:['+ list() : void','+ create() : void',
    '+ store() : void','+ edit() : void',
    '+ update() : void','+ delete() : void']},
  {id:'OEmbedProviderInterface',x:1300,y:900,color:'#0891b2',stereo:'«interface»',badge:'Interface',
   attrs:[], methods:['+ supports(url) : bool','+ fetch(url) : OEmbedDTO']},
  {id:'YouTubeOEmbedService',x:1100,y:1100,color:'#0369a1',stereo:'«Service»',badge:'implements Interface', info:'Servicio para incrustar contenido multimedia de YouTube vía oEmbed aislado del dominio principal',
   attrs:['- logger : Logger','- cache : FileCache'],
   methods:['+ supports(url) : bool','+ fetch(url) : OEmbedDTO','- createDtoFromArray(data) : OEmbedDTO']},
  {id:'OEmbedDTO',x:1500,y:1100,color:'#0f766e',stereo:'«DTO»',badge:'implements JsonSerializable',
   attrs:['+ title : string','+ html : string','+ width : int','+ height : int',
    '+ provider_name : string','+ author_name : ?string','+ thumbnail_url : ?string'],
   methods:['+ toArray() : array','+ jsonSerialize() : mixed']},
  // ── Clases Core / Infraestructura ──────────────────────────────────────
  {id:'Database',x:40,y:1000,color:'#374151',stereo:'«Core»',badge:'Singleton',
   attrs:['- instance : ?PDO','- host : string','- dbname : string','- user : string','- pass : string'],
   methods:['+ getInstance() : PDO','- __construct() : void','- __clone() : void']},
  {id:'Router',x:260,y:1000,color:'#374151',stereo:'«Core»',badge:'Front Controller',
   attrs:['- controller : string','- action : string'],
   methods:['+ dispatch() : void','- notFound() : void']},
  {id:'MailService',x:480,y:1000,color:'#374151',stereo:'«Service»',badge:'Email Sender',
   attrs:['- mail : PHPMailer','- recordatorioModel : ?RecordatorioModel'],
   methods:['+ sendOtpEmail(...) : bool','+ sendRecordatorioEstudiante(...) : bool',
    '+ sendRecordatorioPsicologo(...) : bool',
    '+ sendConfirmacionCitaEstudiante(...) : bool',
    '+ sendConfirmacionCitaPsicologo(...) : bool',
    '+ sendRecordatorio1HoraEstudiante(...) : bool',
    '+ sendRecordatorio1HoraPsicologo(...) : bool',
    '- enviarYRegistrar(...) : bool']},
  {id:'GoogleOAuthService',x:720,y:1000,color:'#374151',stereo:'«Service»',badge:'OAuth2',
   attrs:['- clientId : string','- clientSecret : string','- redirectUri : string'],
   methods:['+ getAuthUrl() : string','+ exchangeCode(code) : string',
    '+ getUserInfo(token) : array','+ validateState(state) : void',
    '- post(url,fields) : array']},
  {id:'EncryptionService',x:960,y:1000,color:'#374151',stereo:'«Service»',badge:'AES-256-GCM',
   attrs:['- CIPHER : string','- VERSION : string'],
   methods:['+ encrypt(plainText) : string','+ decrypt(payload) : string',
    '- getKey() : string']},
  {id:'Logger',x:1200,y:1000,color:'#374151',stereo:'«Core»',badge:'File Logger',
   attrs:[], methods:['+ info(msg) : void','+ error(msg) : void','+ warning(msg) : void']},
  {id:'FileCache',x:1440,y:1000,color:'#374151',stereo:'«Core»',badge:'File Cache',
   attrs:['- cacheDir : string','- defaultTtl : int'],
   methods:['+ get(key) : mixed','+ set(key,value,ttl) : bool',
    '+ delete(key) : bool','- getCacheFilePath(key) : string']},
  {id:'EnvLoader',x:1680,y:1000,color:'#374151',stereo:'«Core»',badge:'Env Loader',
   attrs:[],
   methods:['+ load(path) : void']},
];

const RELATIONS = [
  // Herencia Models → Model (solid + empty triangle)
  {from:'UserModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'CitaModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'PsicologoModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'OtpModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'NotaPacienteModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'RecordatorioModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'RecursoModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  {from:'ProductModel',to:'Model',type:'inherit',color:'#cbd5e1',m1:'',m2:''},
  // Herencia Controllers → Controller
  {from:'ControllerUsers',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerAuth',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerCitas',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerPanel_psicologas',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerChat_bot',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerPages',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerApi',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerCalendario',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  {from:'ControllerProducts',to:'Controller',type:'inherit',color:'#93c5fd',m1:'',m2:''},
  
  // Implementación (dashed + empty triangle)
  {from:'YouTubeOEmbedService',to:'OEmbedProviderInterface',type:'implement',color:'#67e8f9',m1:'',m2:''},
  
  // Agregación (rombo vacío)
  {from:'PsicologoModel',to:'CitaModel',type:'agreg',color:'#f472b6',m1:'1',m2:'0..*'},
  
  // Composición (rombo lleno) MailService agrupa RecordatorioModel
  {from:'MailService',to:'RecordatorioModel',type:'comp',color:'#e879f9',m1:'1',m2:'0..*'},
  
  // Asociación estructural (ControllerProducts posee ProductModel como atributo)
  {from:'ControllerProducts',to:'ProductModel',type:'agreg',color:'#fbbf24',m1:'1',m2:'1'},

  // Dependencia (dashed + open arrow) — usa en un método, no lo retiene
  {from:'ControllerUsers',to:'UserModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerAuth',to:'UserModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerAuth',to:'GoogleOAuthService',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerPanel_psicologas',to:'CitaModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerPanel_psicologas',to:'NotaPacienteModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerPanel_psicologas',to:'RecursoModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerPanel_psicologas',to:'PsicologoModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerChat_bot',to:'CitaModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerChat_bot',to:'PsicologoModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerCitas',to:'CitaModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerCitas',to:'RecursoModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerCalendario',to:'PsicologoModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerCalendario',to:'CitaModel',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'ControllerApi',to:'YouTubeOEmbedService',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'YouTubeOEmbedService',to:'OEmbedDTO',type:'depend',color:'#ef4444',m1:'',m2:''},
  // Core services
  {from:'ControllerUsers',to:'MailService',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'YouTubeOEmbedService',to:'Logger',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'YouTubeOEmbedService',to:'FileCache',type:'depend',color:'#ef4444',m1:'',m2:''},
  {from:'Model',to:'Database',type:'depend',color:'#6b7280',m1:'',m2:''},
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

  if (cls.info) {
    const info = document.createElement('div');
    info.className = 'info-icon';
    info.innerHTML = `i <div class="info-tooltip">${cls.info}</div>`;
    div.appendChild(info);
  }

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

// ESTADO DE FILTROS
let currentFilter = 'all'; // all, model, controller
let showDependencies = true;

function applyFilters() {
  CLASSES.forEach(cls => {
    const el = document.getElementById('cls-'+cls.id);
    if (!el) return;
    
    let visible = true;
    if (currentFilter === 'model' && !cls.id.includes('Model') && cls.id !== 'Model') visible = false;
    if (currentFilter === 'controller' && !cls.id.includes('Controller') && cls.id !== 'Controller') visible = false;
    
    if (visible) el.classList.remove('dimmed');
    else el.classList.add('dimmed');
  });
  
  // Actualizar UI de botones
  document.querySelectorAll('.filter-btn').forEach(b => {
    if(b.dataset.filter === currentFilter) b.innerHTML = b.innerHTML.replace(/^[^\s]+/,'✓');
    else {
      if(b.dataset.filter === 'all') b.innerHTML = b.innerHTML.replace(/^[^\s]+/,'〇');
      if(b.dataset.filter === 'model') b.innerHTML = b.innerHTML.replace(/^[^\s]+/,'◫');
      if(b.dataset.filter === 'controller') b.innerHTML = b.innerHTML.replace(/^[^\s]+/,'⚙');
    }
  });
  
  drawLines();
}

document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    currentFilter = e.target.dataset.filter;
    applyFilters();
  });
});

document.getElementById('toggle-deps').addEventListener('click', () => {
  showDependencies = !showDependencies;
  document.getElementById('deps-status').textContent = showDependencies ? 'ON' : 'OFF';
  document.getElementById('deps-status').className = showDependencies ? 'bg-red-500/30 px-2 py-0.5 rounded text-xs' : 'bg-white/10 px-2 py-0.5 rounded text-xs opacity-50';
  drawLines();
});

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
    // Lógica de filtrado para relaciones
    if (rel.type === 'depend' && !showDependencies) return; // ocultar dependencias
    
    const elF = document.getElementById('cls-'+rel.from);
    const elT = document.getElementById('cls-'+rel.to);
    if(!elF || !elT) return;

    let isDimmed = false;
    if (currentFilter !== 'all') {
      if (elF.classList.contains('dimmed') || elT.classList.contains('dimmed')) {
        isDimmed = true;
      }
    }

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
    
    // Ajuste de opacidad normal (sin transparencia para dependencias)
    let baseOpacity = 0.85;
    if (isDimmed) baseOpacity = 0.05;
    path.setAttribute('opacity', baseOpacity);
    
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

    // Multiplicidades
    if(!isDimmed) {
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
  <span style="color:#fff;font-size:11px;display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:2px;background:transparent;border-top:2px dashed #ef4444;position:relative;"><span style="position:absolute;right:-2px;top:-5px;font-size:14px;color:#ef4444;line-height:1;">></span></span> Dependencia</span>
  <span style="color:#94a3b8;font-size:11px;border-left:1px solid #475569;padding-left:12px;">+ pub &nbsp; - priv &nbsp; # prot</span>`;
document.body.appendChild(leg);

document.addEventListener('DOMContentLoaded',()=>{
  ['btn-v10','btn-s10'].forEach(id=>{const b=document.getElementById(id);if(b)document.body.appendChild(b);});
  setTimeout(drawLines,200);
});
window.addEventListener('resize',drawLines);
new ResizeObserver(drawLines).observe(canvas);
</script>

<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; }
    .glass-card { background: rgba(42,41,38,0.88); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.07); border-radius: 1.5rem; }
    body:not(.dark) #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background: rgba(253,251,247,0.90); border-color: rgba(212,195,163,0.4); }
</style>

<div class="pt-8 pb-16 px-4 md:px-8 max-w-4xl mx-auto relative z-10 w-full">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-handwritten text-4xl font-bold mb-1" style="color:#3d3730">Solicitudes pendientes</h1>
        <p class="text-sm text-[#a39c8e]">Revisa y aprueba (o rechaza) las propuestas de nuevos psicólogos enviadas por tus colegas.</p>
    </div>

    <?php if (empty($pendientes)): ?>
        <div class="glass-card p-12 flex flex-col items-center justify-center gap-4 text-center">
            <span class="material-symbols-outlined text-5xl" style="color:#8DA399">check_circle</span>
            <p class="font-semibold text-lg text-[#E4EAE6]" style="color:#3d3730">Sin solicitudes pendientes</p>
            <p class="text-sm text-[#a39c8e]">Cuando una colega proponga un nuevo psicólogo aparecerá aquí.</p>
        </div>
    <?php else: ?>
        <div class="space-y-4" id="solicitudesList">
            <?php foreach ($pendientes as $s): ?>
            <div class="glass-card p-6 flex flex-col sm:flex-row sm:items-center gap-4" id="sol-<?= $s['id_solicitud'] ?>">
                <!-- Avatar -->
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 text-white font-bold text-lg"
                    style="background:#3A5C3D;">
                    <?= mb_strtoupper(mb_substr($s['nombre'], 0, 1)) ?>
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-[#E4EAE6] text-base leading-tight" style="color:#2d2a25"><?= htmlspecialchars($s['nombre']) ?></p>
                    <p class="text-xs text-[#a39c8e] mt-0.5"><?= htmlspecialchars($s['correo_electronico']) ?></p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background:rgba(141,163,153,0.15);color:#8DA399;">
                            <?= htmlspecialchars($s['especialidad']) ?>
                        </span>
                        <span class="text-xs px-2 py-0.5 rounded-full" style="background:rgba(255,255,255,0.05);color:#a39c8e;">
                            Propuesto por <?= htmlspecialchars($s['propuesto_por_nombre']) ?>
                        </span>
                        <span class="text-xs px-2 py-0.5 rounded-full" style="background:rgba(255,255,255,0.05);color:#a39c8e;">
                            <?= date('d M Y, H:i', strtotime($s['fecha_solicitud'])) ?>
                        </span>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex gap-3 shrink-0">
                    <button onclick="accionSolicitud(<?= $s['id_solicitud'] ?>, 'aprobar', this)"
                        class="flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:opacity-80"
                        style="background:#3A5C3D;color:#E4EAE6;">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                        Aceptar
                    </button>
                    <button onclick="accionSolicitud(<?= $s['id_solicitud'] ?>, 'rechazar', this)"
                        class="flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:opacity-80"
                        style="background:rgba(180,40,40,0.2);color:#f87171;border:1px solid rgba(200,60,60,0.3);">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                        Rechazar
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Toast -->
        <div id="toast" class="fixed bottom-6 right-6 z-50 hidden px-5 py-3 rounded-xl text-sm font-semibold shadow-lg" style="transition:opacity 0.3s;"></div>
    <?php endif; ?>
</div>

<script>
async function accionSolicitud(id, tipo, btn) {
    const accion = tipo === 'aprobar' ? 'aprobarPropuesta' : 'rechazarPropuesta';
    const card   = document.getElementById('sol-' + id);

    // Deshabilitar botones de esa tarjeta
    card.querySelectorAll('button').forEach(b => b.disabled = true);
    btn.textContent = 'Procesando...';

    const data = new FormData();
    data.append('id_solicitud', id);

    try {
        const res  = await fetch('<?= URL_BASE ?>panel_psicologas/' + accion, { method: 'POST', body: data });
        const json = await res.json();

        if (json.ok) {
            card.style.transition = 'opacity 0.4s, transform 0.4s';
            card.style.opacity = '0';
            card.style.transform = 'translateX(30px)';
            setTimeout(() => card.remove(), 400);
            showToast(tipo === 'aprobar' ? '✓ Psicólogo activado correctamente' : '✓ Solicitud rechazada', tipo === 'aprobar');
        } else {
            showToast(json.error || 'Error al procesar', false);
            card.querySelectorAll('button').forEach(b => b.disabled = false);
        }
    } catch(err) {
        showToast('Error de red. Intenta de nuevo.', false);
        card.querySelectorAll('button').forEach(b => b.disabled = false);
    }
}

function showToast(text, ok) {
    const t = document.getElementById('toast');
    t.textContent  = text;
    t.style.background = ok ? '#3A5C3D' : 'rgba(180,40,40,0.9)';
    t.style.color      = ok ? '#E4EAE6' : '#fff';
    t.classList.remove('hidden');
    t.style.opacity = '1';
    setTimeout(() => {
        t.style.opacity = '0';
        setTimeout(() => t.classList.add('hidden'), 300);
    }, 3500);
}
</script>

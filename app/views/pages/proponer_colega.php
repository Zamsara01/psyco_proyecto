<style>
    #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; }
    .glass-card { background: rgba(42,41,38,0.88); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.07); border-radius: 1.5rem; }
    body:not(.dark) #main-content { background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpg'); }
    body:not(.dark) .glass-card { background: rgba(253,251,247,0.90); border-color: rgba(212,195,163,0.4); }
    input, select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #E4EAE6; border-radius: 0.75rem; padding: 0.65rem 1rem; width: 100%; outline: none; transition: border-color 0.2s; }
    input:focus, select:focus { border-color: #8DA399; }
    body:not(.dark) input, body:not(.dark) select { background: rgba(0,0,0,0.04); border-color: rgba(212,195,163,0.6); color: #3d3730; }
    body:not(.dark) input:focus, body:not(.dark) select:focus { border-color: #8DA399; }
</style>

<div class="pt-8 pb-16 px-4 md:px-8 max-w-4xl mx-auto relative z-10 w-full">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-handwritten text-4xl font-bold text-[#E4EAE6] dark:text-[#E4EAE6] mb-1" style="color:#3d3730">Proponer colega</h1>
        <p class="text-sm text-[#a39c8e]">Completa los datos del psicólogo que quieres invitar. Otra psicóloga deberá aprobar la solicitud para que pueda acceder.</p>
    </div>

    <!-- Formulario -->
    <div class="glass-card p-8 mb-8">
        <form id="formPropuesta" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nombre -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-2 text-[#a39c8e]">Nombre completo</label>
                <input type="text" name="nombre" id="inp_nombre" placeholder="Dra. María García" required />
            </div>

            <!-- Correo -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-[#a39c8e]">Correo electrónico</label>
                <input type="email" name="correo" id="inp_correo" placeholder="colega@correo.com" required />
            </div>

            <!-- Especialidad -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-[#a39c8e]">Especialidad</label>
                <select name="id_especialidad" id="inp_especialidad" required>
                    <option value="">— Selecciona —</option>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id_especialidad'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Contraseña temporal -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-[#a39c8e]">Contraseña temporal</label>
                <input type="password" name="password" id="inp_pass" placeholder="Mínimo 6 caracteres" required minlength="6" />
            </div>

            <!-- Confirmar -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-[#a39c8e]">Confirmar contraseña</label>
                <input type="password" id="inp_pass2" placeholder="Repite la contraseña" required />
            </div>

            <!-- Mensaje de error/éxito -->
            <div class="md:col-span-2" id="formMsg" style="display:none;"></div>

            <!-- Botón -->
            <div class="md:col-span-2 flex justify-end">
                <button type="submit" id="btnEnviar"
                    class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm transition-all"
                    style="background:#3A5C3D;color:#E4EAE6;">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Enviar propuesta
                </button>
            </div>
        </form>
    </div>

    <!-- Mis propuestas pendientes -->
    <?php if (!empty($misPropuestas)): ?>
    <div class="glass-card p-6">
        <h2 class="font-semibold text-[#E4EAE6] mb-4 flex items-center gap-2" style="color:#3d3730">
            <span class="material-symbols-outlined text-[20px]" style="color:#8DA399">pending</span>
            Mis propuestas pendientes de aprobación
        </h2>
        <div class="space-y-3">
            <?php foreach ($misPropuestas as $p): ?>
            <div class="flex items-center justify-between px-4 py-3 rounded-xl" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06);">
                <div>
                    <p class="font-semibold text-sm text-[#E4EAE6]" style="color:#3d3730"><?= htmlspecialchars($p['nombre']) ?></p>
                    <p class="text-xs text-[#a39c8e]"><?= htmlspecialchars($p['correo_electronico']) ?> · <?= htmlspecialchars($p['especialidad']) ?></p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full font-semibold" style="background:rgba(141,163,153,0.15);color:#8DA399;">
                    Esperando aprobación
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('formPropuesta').addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = document.getElementById('formMsg');
    const btn = document.getElementById('btnEnviar');

    // Validar contraseñas
    if (document.getElementById('inp_pass').value !== document.getElementById('inp_pass2').value) {
        showMsg('Las contraseñas no coinciden', false);
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Enviando...';

    const data = new FormData(this);

    try {
        const res = await fetch('<?= URL_BASE ?>panel_psicologas/storePropuesta', { method: 'POST', body: data });
        const json = await res.json();

        if (json.ok) {
            showMsg('✓ Propuesta enviada. Otra psicóloga deberá aprobarla.', true);
            this.reset();
            setTimeout(() => location.reload(), 2000);
        } else {
            showMsg(json.error || 'Error al enviar la propuesta', false);
        }
    } catch(err) {
        showMsg('Error de red. Intenta de nuevo.', false);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">person_add</span> Enviar propuesta';
    }
});

function showMsg(text, ok) {
    const el = document.getElementById('formMsg');
    el.style.display = 'block';
    el.className = 'md:col-span-2 px-4 py-3 rounded-xl text-sm font-medium';
    el.style.background = ok ? 'rgba(58,92,61,0.3)' : 'rgba(180,40,40,0.2)';
    el.style.border     = ok ? '1px solid #3A5C3D' : '1px solid rgba(200,60,60,0.4)';
    el.style.color      = ok ? '#8DA399' : '#f87171';
    el.textContent      = text;
}
</script>

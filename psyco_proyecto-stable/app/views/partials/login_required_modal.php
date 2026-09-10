<!-- ═══════════════════════════════════════════════════════════
     MODAL: Se requiere inicio de sesión para usar esta función.
     Uso: openLoginRequiredModal('Nombre de la función')
     ═══════════════════════════════════════════════════════════ -->

<div id="loginRequiredModal" class="fixed inset-0 z-[70] hidden items-center justify-center" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeLoginRequiredModal()"></div>
    <div id="loginRequiredCard" class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 z-10 text-center transform scale-95 transition-all duration-200">

        <!-- Icono -->
        <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-5">
            <span class="material-symbols-outlined text-orange-500 text-[42px]">lock</span>
        </div>

        <h3 class="text-xl font-bold text-slate-800 mb-2">Función bloqueada</h3>
        <p class="text-slate-500 text-sm mb-1">Para acceder a</p>
        <p id="loginRequiredFeatureName" class="text-orange-600 font-bold text-base mb-4">esta función</p>
        <p class="text-slate-500 text-sm mb-7">debes iniciar sesión en tu cuenta PSYCO.</p>

        <div class="flex flex-col gap-3">
            <button onclick="closeLoginRequiredModal(); openLoginModal();"
                class="w-full py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] shadow-md shadow-orange-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">login</span>
                Iniciar sesión
            </button>
            <button onclick="closeLoginRequiredModal(); openRegisterModal();"
                class="w-full py-3 border-2 border-orange-200 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                Registrarse gratis
            </button>
            <button onclick="closeLoginRequiredModal()"
                class="text-sm text-slate-400 hover:text-slate-600 transition-colors py-1">
                Cancelar
            </button>
        </div>
    </div>
</div>

<script>
function openLoginRequiredModal(featureName) {
    const m    = document.getElementById('loginRequiredModal');
    const card = document.getElementById('loginRequiredCard');
    const name = document.getElementById('loginRequiredFeatureName');
    if (name) name.textContent = featureName || 'esta función';
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }, 10);
}

function closeLoginRequiredModal() {
    const m    = document.getElementById('loginRequiredModal');
    const card = document.getElementById('loginRequiredCard');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    setTimeout(() => {
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }, 150);
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLoginRequiredModal();
});
</script>

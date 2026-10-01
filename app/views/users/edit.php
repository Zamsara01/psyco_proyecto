<style>
#main-content {
    background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
}
#main-content::before {
    content: '';
    position: fixed;
    inset: 0;
    background: rgba(244, 247, 246, 0.55);
    pointer-events: none;
    z-index: 0;
}
.dark #main-content::before { background: rgba(15, 23, 42, 0.65); }
.glass-card {
    background: rgba(255,255,255,0.88) !important;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.6);
}
</style>
<div class="relative z-10 p-6 md:p-8 max-w-2xl mx-auto w-full mt-6">
    <div class="glass-card rounded-3xl p-6 md:p-8 shadow-lg">
        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-200">
            <div style="width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;background:#6B8CAE;box-shadow:0 2px 8px rgba(107,140,174,0.3);">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
            </div>
            <h2 class="text-2xl font-bold text-[#3a6a8a] m-0">Editar Usuario</h2>
        </div>
        
        <form method="POST" action="<?= URL_BASE ?>users/update/<?= $user['id'] ?>" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre</label>
                <input type="text" name="txtnombre" 
                       class="w-full px-4 py-2 rounded-xl border-2 border-slate-200 focus:border-[#6B8CAE] focus:outline-none focus:ring-4 focus:ring-[#dce8f0] transition-all bg-white/50"
                       value="<?= htmlspecialchars($user['nombre']) ?>" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Correo</label>
                <input type="email" name="txtEmail" 
                       class="w-full px-4 py-2 rounded-xl border-2 border-slate-200 focus:border-[#6B8CAE] focus:outline-none focus:ring-4 focus:ring-[#dce8f0] transition-all bg-white/50"
                       value="<?= htmlspecialchars($user['correo']) ?>" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Perfil</label>
                <select name="txtperfil" 
                        class="w-full px-4 py-2 rounded-xl border-2 border-slate-200 focus:border-[#6B8CAE] focus:outline-none focus:ring-4 focus:ring-[#dce8f0] transition-all bg-white/50">
                    <option value="usuario" <?= $user['perfil'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                    <option value="administrador" <?= $user['perfil'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <div class="flex gap-3 pt-4 border-t border-slate-100 mt-6">
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 rounded-xl font-bold text-white transition-all shadow-sm active:scale-95 flex items-center justify-center gap-2"
                        style="background:#6B8CAE;">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Guardar
                </button>
                <a href="<?= URL_BASE ?>users/list" 
                   class="flex-1 px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm active:scale-95 flex items-center justify-center gap-2"
                   style="color:#8a4a4a; background:rgba(174,107,107,0.12); border:1px solid rgba(174,107,107,0.3);">
                    <span class="material-symbols-outlined text-[18px]">cancel</span>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

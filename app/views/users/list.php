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
<div class="relative z-10 p-6 md:p-8 max-w-5xl mx-auto w-full mt-6">
    <div class="glass-card rounded-3xl p-6 md:p-8 shadow-lg">
        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-200">
            <div style="width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;background:#6B8CAE;box-shadow:0 2px 8px rgba(107,140,174,0.3);">
                <span class="material-symbols-outlined text-[20px]">group</span>
            </div>
            <h2 class="text-2xl font-bold text-[#3a6a8a] m-0">Usuarios del Sistema</h2>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-slate-200/60">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-[#F4F7F6]/80 text-[#3d6b5a] font-semibold">
                    <tr>
                        <th class="px-4 py-3 border-b border-slate-200/60">ID</th>
                        <th class="px-4 py-3 border-b border-slate-200/60">Perfil</th>
                        <th class="px-4 py-3 border-b border-slate-200/60">Nombre</th>
                        <th class="px-4 py-3 border-b border-slate-200/60">Correo</th>
                        <th class="px-4 py-3 border-b border-slate-200/60">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-slate-700"><?= htmlspecialchars($u['id']) ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-[#dce8f0] text-[#3a6a8a] rounded-lg text-xs font-semibold">
                                <?= htmlspecialchars($u['perfil']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3"><?= htmlspecialchars($u['nombre']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($u['correo']) ?></td>
                        <td class="px-4 py-3">
                            <a href="<?= URL_BASE ?>users/edit/<?= $u['id'] ?>"
                               style="color:#4a6e8a; background:rgba(107,140,174,0.15); border:1px solid rgba(107,140,174,0.3);"
                               class="px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-[#6B8CAE] hover:text-white transition-colors inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ══════════ MODAL: SESIONES ESTE MES ══════════ -->
<div id="modalSesionesMes" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalSesionesMes()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-2xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalSesionesMes()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-2xl">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl">clinical_notes</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 dark:text-slate-100 text-xl">Sesiones de este Mes</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500">Todas las sesiones del mes actual (excepto canceladas)</p>
            </div>
        </div>

        <div id="sesionesMesLoading" class="hidden text-center py-8">
            <div class="w-8 h-8 border-3 border-blue-200 border-t-blue-500 dark:border-blue-800 dark:border-t-blue-500 rounded-full animate-spin mx-auto mb-2"></div>
            <p class="text-sm text-slate-400 dark:text-slate-500">Cargando sesiones...</p>
        </div>

        <div id="sesionesMesError" class="hidden p-3 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="sesionesMesErrorMsg"></span>
        </div>

        <div id="sesionesMesContainer" class="hidden space-y-3 max-h-[60vh] overflow-y-auto pr-1">
            <!-- Se llena vía JS -->
        </div>

        <div id="sesionesMesEmpty" class="hidden text-center py-8 text-slate-400 dark:text-slate-500 border border-dashed border-slate-200 dark:border-slate-700 rounded-xl text-sm">
            No hay sesiones para mostrar.
        </div>
    </div>
</div>
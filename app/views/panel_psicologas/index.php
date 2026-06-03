<!-- Page Content -->
<div class="p-8 flex-1">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                    <span class="material-symbols-outlined">clinical_notes</span>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Sesiones este mes</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">48</h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-full">Hoy</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Citas Pendientes</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">6</h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                    <span class="material-symbols-outlined">neurology</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Nuevos Diagnósticos</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">3</h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                    <span class="material-symbols-outlined">sentiment_satisfied</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Alta Médica</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">12</h3>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-50 dark:border-slate-800 flex justify-between items-center bg-slate-50/30">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Listado de Pacientes</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Filtrar</button>
                <button class="px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Exportar</button>
            </div>
        </div>
        
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Paciente</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Situación Mental</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Info del Paciente</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Notas</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Row 1 -->
                    <tr class="hover:bg-orange-50/30 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-400">1</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs">CG</div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">Carlos Gómez</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                Esquizofrenia
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">15 de Mayo 2026</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-900 dark:text-white">#3007314624</span>
                                <span class="text-xs text-slate-500">carlosgomez@gmail.com</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm italic text-red-500">No asistió.</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-orange-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">more_vert</span>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-orange-50/30 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-400">2</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">VR</div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">Valeria Ríos</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                Autismo
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">18 de Julio 2026</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-900 dark:text-white">#3244377127</span>
                                <span class="text-xs text-slate-500">valeriarios@gmail.com</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            Viene con los padres.
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-orange-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">more_vert</span>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr class="hover:bg-orange-50/30 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-400">3</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs">SD</div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">Simón Duque</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400 font-medium italic">No tiene</td>
                        <td class="px-6 py-4 text-sm text-slate-400 font-medium italic">No definida</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-900 dark:text-white">#42134737421</span>
                                <span class="text-xs text-slate-400 italic">No tiene correo.</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400 italic">--</td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-slate-400 hover:text-orange-600 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">more_vert</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination footer -->
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-sm font-medium text-slate-500">
            <p>Mostrando 1 a 3 de 124 pacientes</p>
            <div class="flex gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-100 text-slate-400 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-orange-600 text-white">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-slate-100">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-slate-100">3</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-slate-100">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Side Cards / Asymmetric Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        <!-- Upcoming Appointments Bento -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-500">event_upcoming</span>
                Citas para Hoy
            </h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-50 hover:border-orange-100 hover:bg-orange-50/20 transition-all">
                    <div class="text-center w-16">
                        <p class="text-xs font-black text-orange-600 uppercase">09:00</p>
                        <p class="text-[10px] text-slate-400">AM</p>
                    </div>
                    <div class="h-10 w-[2px] bg-orange-200"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Carlos Gómez</p>
                        <p class="text-xs text-slate-500">Seguimiento mensual • Consultorio 402</p>
                    </div>
                    <button class="px-3 py-1.5 bg-orange-600 text-white text-xs font-bold rounded-lg active:scale-95">Check-in</button>
                </div>
                
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-50 hover:border-orange-100 hover:bg-orange-50/20 transition-all">
                    <div class="text-center w-16">
                        <p class="text-xs font-black text-orange-600 uppercase">10:30</p>
                        <p class="text-[10px] text-slate-400">AM</p>
                    </div>
                    <div class="h-10 w-[2px] bg-orange-200"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Valeria Ríos</p>
                        <p class="text-xs text-slate-500">Terapia Ocupacional • Consultorio 201</p>
                    </div>
                    <button class="px-3 py-1.5 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg active:scale-95">Re-agendar</button>
                </div>
            </div>
        </div>
        
        <!-- Calendar/Note Side Card -->
        <div class="bg-primary-container p-6 rounded-2xl shadow-lg relative overflow-hidden group">
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-white font-bold">Resumen Diario</h3>
                    <span class="material-symbols-outlined text-white/80">lightbulb</span>
                </div>
                <p class="text-white/90 font-body-sm mb-6 leading-relaxed">
                    Recuerda revisar las notas de Valeria Ríos antes de su sesión. Los padres mencionaron cambios en su rutina de sueño durante la última llamada.
                </p>
                
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-white uppercase">Progreso del Día</span>
                        <span class="text-xs font-bold text-white">75%</span>
                    </div>
                    <div class="w-full bg-white/20 h-2 rounded-full overflow-hidden">
                        <div class="bg-white h-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAB for quick action -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-orange-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50">
    <span class="material-symbols-outlined text-[28px]">chat_bubble</span>
</button>

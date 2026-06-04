<!-- Page Content -->
<div class="p-8 flex-1">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                    <span class="material-symbols-outlined">clinical_notes</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Sesiones este mes</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= htmlspecialchars($stats['sesiones_mes'] ?? 0) ?></h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-full">Hoy</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Pendientes Hoy</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= htmlspecialchars($stats['pendientes_hoy'] ?? 0) ?></h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                    <span class="material-symbols-outlined">neurology</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Nuevos Diagnósticos</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= htmlspecialchars($stats['nuevos_diagnosticos'] ?? 0) ?></h3>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                    <span class="material-symbols-outlined">sentiment_satisfied</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Altas Médicas</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= htmlspecialchars($stats['altas_medicas'] ?? 0) ?></h3>
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
                    <?php if (empty($citasRecientes)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">No hay citas registradas.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($citasRecientes as $index => $cita): ?>
                            <?php 
                                // Generar iniciales
                                $partes = explode(' ', $cita['paciente_nombre']);
                                $iniciales = count($partes) >= 2 
                                    ? strtoupper(substr($partes[0], 0, 1) . substr($partes[1], 0, 1))
                                    : strtoupper(substr($cita['paciente_nombre'], 0, 2));

                                // Formato de fecha
                                $fechaFormateada = date('d M Y', strtotime($cita['fecha']));
                                
                                // Color basado en el estado
                                $estadoColor = match($cita['estado']) {
                                    'pendiente' => 'bg-blue-100 text-blue-700',
                                    'completada' => 'bg-green-100 text-green-700',
                                    'cancelada' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            ?>
                            <tr class="hover:bg-orange-50/30 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-slate-400"><?= $index + 1 ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs"><?= htmlspecialchars($iniciales) ?></div>
                                        <span class="text-sm font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($cita['paciente_nombre']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $estadoColor ?>">
                                        <?= htmlspecialchars($cita['motivo_consulta'] ?? 'No especificado') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400"><?= $fechaFormateada ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-900 dark:text-white">#<?= str_pad($cita['id_usuario'], 6, '0', STR_PAD_LEFT) ?></span>
                                        <span class="text-xs text-slate-500"><?= htmlspecialchars($cita['correo_electronico']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    <?= htmlspecialchars($cita['notas_sesion'] ?? '--') ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-slate-400 hover:text-orange-600 transition-colors" title="<?= ucfirst($cita['estado']) ?>">
                                        <span class="material-symbols-outlined text-[20px]">
                                            <?= $cita['estado'] === 'completada' ? 'check_circle' : ($cita['estado'] === 'cancelada' ? 'cancel' : 'schedule') ?>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                <?php if (empty($citasHoy)): ?>
                    <div class="p-6 text-center text-slate-500 border border-dashed border-slate-200 rounded-xl">
                        Día libre. No tienes citas pendientes para hoy.
                    </div>
                <?php else: ?>
                    <?php foreach ($citasHoy as $citaHoy): ?>
                        <?php
                            $horaFormateada = date('h:i', strtotime($citaHoy['hora']));
                            $amPm = date('A', strtotime($citaHoy['hora']));
                        ?>
                        <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-50 hover:border-orange-100 hover:bg-orange-50/20 transition-all">
                            <div class="text-center w-16">
                                <p class="text-xs font-black text-orange-600 uppercase"><?= $horaFormateada ?></p>
                                <p class="text-[10px] text-slate-400"><?= $amPm ?></p>
                            </div>
                            <div class="h-10 w-[2px] bg-orange-200"></div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($citaHoy['paciente_nombre']) ?></p>
                                <p class="text-xs text-slate-500"><?= htmlspecialchars($citaHoy['motivo_consulta'] ?? 'Sin motivo específico') ?> • Consultorio</p>
                            </div>
                            <button class="px-3 py-1.5 bg-orange-600 text-white text-xs font-bold rounded-lg active:scale-95 hover:bg-orange-700 transition-colors">Check-in</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
                <?php if (!empty($citasHoy)): ?>
                    <p class="text-white/90 font-body-sm mb-6 leading-relaxed">
                        Tienes <?= count($citasHoy) ?> paciente(s) esperando hoy. Tu primer paciente es <strong><?= htmlspecialchars($citasHoy[0]['paciente_nombre']) ?></strong> a las <?= date('h:i A', strtotime($citasHoy[0]['hora'])) ?>.
                    </p>
                <?php else: ?>
                    <p class="text-white/90 font-body-sm mb-6 leading-relaxed">
                        Aprovecha este tiempo para actualizar tus diagnósticos o revisar material de apoyo para tus próximos pacientes.
                    </p>
                <?php endif; ?>
                
                <?php
                    $sesionesMes  = (int) ($stats['sesiones_mes']  ?? 0);
                    $altasMedicas = (int) ($stats['altas_medicas'] ?? 0);
                    $porcentaje   = $sesionesMes > 0 ? min(100, round(($altasMedicas / $sesionesMes) * 100)) : 0;
                ?>
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-white uppercase">Progreso del Mes</span>
                        <span class="text-xs font-bold text-white"><?= $porcentaje ?>%</span>
                    </div>
                    <div class="w-full bg-white/20 h-2 rounded-full overflow-hidden">
                        <div class="bg-white h-full transition-all duration-1000" style="width: <?= $porcentaje ?>%"></div>
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

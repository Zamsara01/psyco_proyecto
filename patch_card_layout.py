with open('app/views/pages/miscitas.php', 'r') as f:
    content = f.read()

old_card_inner = """            <div class="cita-card rounded-2xl px-5 py-4 border border-white/60 dark:border-slate-700/50"
                 data-estado="<?= $estado ?>">
                <div class="flex items-center gap-4 flex-wrap">
                    <!-- Avatar circular con iniciales -->
                    <div class="cita-avatar"><?= $iniciales ?></div>
                    <!-- Info principal -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-0.5">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">
                                <?= htmlspecialchars($cita['psicologo_nombre']) ?>
                            </span>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($estado) ?></span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mb-1.5">
                            <?= htmlspecialchars($cita['especialidad']) ?>
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 dark:text-slate-300">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">calendar_month</span>
                                <?= $fechaF ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">schedule</span>
                                <?= $horaF ?>
                            </span>
                        </div>
                        <?php if (!empty($cita['motivo_consulta'])): ?>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">notes</span>
                            <?= htmlspecialchars($cita['motivo_consulta']) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <!-- Acciones -->
                    <?php if ($estado === 'pendiente' && !$esPasada): ?>
                    <div class="flex items-center gap-2 shrink-0">
                        <button onclick="abrirModalEditar(<?= $cita['id_cita'] ?>, '<?= $cita['fecha'] ?>', '<?= substr($cita['hora'],0,5) ?>', <?= $cita['id_psicologo'] ?>, '<?= htmlspecialchars(addslashes($cita['psicologo_nombre'])) ?>')"
                            class="btn-editar">
                            <span class="material-symbols-outlined text-[15px]">edit</span>
                            Editar
                        </button>
                        <button onclick="cancelarCita(<?= $cita['id_cita'] ?>)" class="btn-cancelar">
                            <span class="material-symbols-outlined text-[15px]">cancel</span>
                            Cancelar
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>"""

new_card_inner = """            <div class="cita-card rounded-2xl p-5 border border-white/60 dark:border-slate-700/50 flex flex-col"
                 data-estado="<?= $estado ?>">

                <!-- Fila superior: Avatar + Nombre + Badge -->
                <div class="flex items-center gap-3 mb-2">
                    <div class="cita-avatar shrink-0"><?= $iniciales ?></div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-tight">
                                <?= htmlspecialchars($cita['psicologo_nombre']) ?>
                            </span>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($estado) ?></span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                            <?= htmlspecialchars($cita['especialidad']) ?>
                        </p>
                    </div>
                </div>

                <!-- Fecha y Hora -->
                <div class="flex items-center gap-4 text-xs text-slate-600 dark:text-slate-300 mb-1.5 pl-1">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">calendar_month</span>
                        <?= $fechaF ?>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">schedule</span>
                        <?= $horaF ?>
                    </span>
                </div>

                <!-- Motivo -->
                <?php if (!empty($cita['motivo_consulta'])): ?>
                <p class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1 pl-1 mb-3">
                    <span class="material-symbols-outlined text-[13px]">notes</span>
                    <?= htmlspecialchars($cita['motivo_consulta']) ?>
                </p>
                <?php else: ?>
                <div class="mb-3"></div>
                <?php endif; ?>

                <!-- Área de botones (parte inferior izquierda) -->
                <?php if ($estado === 'pendiente' && !$esPasada): ?>
                <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center gap-2">
                    <button onclick="abrirModalEditar(<?= $cita['id_cita'] ?>, '<?= $cita['fecha'] ?>', '<?= substr($cita['hora'],0,5) ?>', <?= $cita['id_psicologo'] ?>, '<?= htmlspecialchars(addslashes($cita['psicologo_nombre'])) ?>')"
                        class="btn-editar flex-1 justify-center">
                        <span class="material-symbols-outlined text-[15px]">edit</span>
                        Editar
                    </button>
                    <button onclick="cancelarCita(<?= $cita['id_cita'] ?>)"
                        class="btn-cancelar flex-1 justify-center">
                        <span class="material-symbols-outlined text-[15px]">cancel</span>
                        Cancelar
                    </button>
                </div>
                <?php else: ?>
                <!-- Espacio reservado para mantener altura uniforme -->
                <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/50 h-[44px]"></div>
                <?php endif; ?>

            </div>"""

if old_card_inner in content:
    content = content.replace(old_card_inner, new_card_inner)
    print("Card layout updated successfully.")
else:
    print("ERROR: old card inner not found.")

with open('app/views/pages/miscitas.php', 'w') as f:
    f.write(content)

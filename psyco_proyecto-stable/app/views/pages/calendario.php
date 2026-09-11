<main class="pt-8 px-4 md:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 mb-24 relative z-10 w-full">
    <!-- Left Section: Interactive Calendar -->
    <section class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div class="flex flex-col">
                    <div class="flex items-center gap-1" id="calendar-month-year">
                        <select id="month-select" class="font-headline-md text-on-surface bg-transparent border-transparent focus:border-transparent focus:ring-0 p-0 pr-6 hover:text-orange-600 transition-colors cursor-pointer"></select>
                        <select id="year-select" class="font-headline-md text-on-surface bg-transparent border-transparent focus:border-transparent focus:ring-0 p-0 pr-6 hover:text-orange-600 transition-colors cursor-pointer"></select>
                    </div>
                    <p class="text-body-sm text-on-tertiary-fixed-variant">Selecciona un día para ver disponibilidad</p>
                </div>
                <div class="flex gap-2">
                    <button id="prev-month-btn" class="p-2 rounded-lg border border-slate-200 transition-all hover:bg-slate-50">
                        <span class="material-symbols-outlined text-orange-600">chevron_left</span>
                    </button>
                    <button id="next-month-btn" class="p-2 rounded-lg border border-slate-200 transition-all hover:bg-slate-50">
                        <span class="material-symbols-outlined text-orange-600">chevron_right</span>
                    </button>
                </div>
            </div>

            <!-- Calendar Days Header -->
            <div class="calendar-grid text-center font-label-md text-slate-400 mb-4">
                <div>LUN</div>
                <div>MAR</div>
                <div>MIÉ</div>
                <div>JUE</div>
                <div>VIE</div>
                <div>SÁB</div>
                <div>DOM</div>
            </div>

            <!-- Calendar Days Grid -->
            <div class="calendar-grid gap-2" id="calendar-grid">
            </div>

            <!-- Legend -->
            <div class="mt-8 flex flex-wrap gap-6 border-t border-slate-100 pt-6">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-body-sm text-slate-600">Totalmente libre</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <span class="text-body-sm text-slate-600">Disponibilidad parcial</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <span class="text-body-sm text-slate-600">Completamente ocupado</span>
                </div>
            </div>
        </div>

        <!-- Bento Featured Psychology Insight -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-orange-600 rounded-xl p-6 text-white overflow-hidden relative group">
                <div class="relative z-10">
                    <h3 class="font-headline-sm mb-2">Consejo del día</h3>
                    <p class="text-body-sm opacity-90 leading-relaxed">Priorizar tu salud mental no es un lujo, es una inversión en tu futuro bienestar.</p>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-9xl">psychology</span>
            </div>

            <div class="bg-white rounded-xl p-1 border border-slate-100 shadow-sm flex overflow-hidden">
                <img class="w-1/3 object-cover rounded-l-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQ8XE1OmaOO7d76QcGyu-fpngMNPVAWd19YKle1m611F5eOjm0FbfrElMB_lIakjDtGwvu-A3LZZtgjRHkt0pkXT8Z2--LDOyvIWs51OQvNC8rBAy1RPEVbCbE-qVoMSETUa3PM56OyHoX0B4xY9X5wpKvvZVFt-zyw0zPpoUqJ56Rcmp0yL06kfI0KjzSPvOnTW4otkDpUIJPlZNUQ2pTtokTeBmUNLMku5Y1AWrAfM2PeXSSsgKET6MmlBbPAoZ1NNvVktHwdLrY" />
                <div class="p-4 w-2/3 flex flex-col justify-center">
                    <h4 class="font-bold text-orange-600">Nuevos Recursos</h4>
                    <p class="text-body-sm text-slate-500">Guía de meditación guiada disponible ahora.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Right Section: Day Details Panel -->
    <aside class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 flex flex-col h-full sticky top-24">
            <div class="p-6 border-b border-slate-50">
                <h3 class="font-headline-md text-on-surface" id="selected-date-display">Selecciona un día</h3>
                <p class="text-body-sm text-slate-500" id="psico-count">Haz clic en un día para ver disponibilidad</p>
            </div>

            <!-- Lista dinámica de psicólogos -->
            <div class="p-6 flex-grow flex flex-col gap-6 overflow-y-auto hide-scrollbar max-h-[614px]" id="psicologos-panel">
                <!-- Relleno por JavaScript -->
                <div class="flex flex-col items-center justify-center h-40 text-slate-400 gap-3">
                    <span class="material-symbols-outlined text-5xl text-slate-300">calendar_month</span>
                    <p class="text-sm text-center">Selecciona un día en el calendario para ver la disponibilidad</p>
                </div>
            </div>

            <div class="p-6 bg-slate-50 rounded-b-2xl">
                <?php if (isset($_SESSION['user'])): ?>
                    <p class="text-sm text-slate-500 text-center font-medium">
                        <span class="material-symbols-outlined align-middle text-[18px] mr-1">touch_app</span>
                        <?php if ($_SESSION['user']['rol'] === 'psicologo'): ?>
                            Selecciona un psicólogo y una hora para agendar una cita
                        <?php else: ?>
                            Haz clic en un psicólogo arriba para agendar tu cita
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <button type="button" onclick="openLoginModal()" class="w-full bg-orange-100 text-orange-600 font-bold py-4 rounded-xl shadow-sm hover:bg-orange-200 transition-colors active:scale-95 duration-150">
                        Inicia sesión para agendar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</main>



<!-- Datos inyectados desde la BD (PHP → JS) -->
<script>
    const psicologosData = <?= $psicologosJson ?? '[]' ?>;
    const citasData = <?= $citasJson ?? '{}' ?>;
    const isPaciente  = <?= (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'paciente')  ? 'true' : 'false' ?>;
    const isPsicologo = <?= (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'psicologo') ? 'true' : 'false' ?>;
    const canSchedule = isPaciente || isPsicologo;
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const calendarGrid = document.getElementById('calendar-grid');
        const selectedDateDisplay = document.getElementById('selected-date-display');
        const psicoCount = document.getElementById('psico-count');
        const psicologosPanel = document.getElementById('psicologos-panel');
        const monthSelect = document.getElementById('month-select');
        const yearSelect = document.getElementById('year-select');
        const prevBtn = document.getElementById('prev-month-btn');
        const nextBtn = document.getElementById('next-month-btn');

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();
        let selectedDate = new Date(today);

        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        const colors = ['bg-green-500', 'bg-yellow-500', 'bg-red-500', ''];

        // Populate selects
        monthNames.forEach((name, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = name;
            monthSelect.appendChild(option);
        });

        for (let y = today.getFullYear(); y <= 2100; y++) {
            const option = document.createElement('option');
            option.value = y;
            option.textContent = y;
            yearSelect.appendChild(option);
        }

        monthSelect.addEventListener('change', (e) => {
            currentMonth = parseInt(e.target.value);
            renderCalendar();
        });

        yearSelect.addEventListener('change', (e) => {
            currentYear = parseInt(e.target.value);
            if (currentYear === today.getFullYear() && currentMonth < today.getMonth()) {
                currentMonth = today.getMonth();
            }
            renderCalendar();
        });

        function renderCalendar() {
            monthSelect.value = currentMonth;
            yearSelect.value = currentYear;

            // Disable past months if current year is selected
            Array.from(monthSelect.options).forEach(opt => {
                if (currentYear === today.getFullYear() && parseInt(opt.value) < today.getMonth()) {
                    opt.disabled = true;
                } else {
                    opt.disabled = false;
                }
            });

            if (currentYear === today.getFullYear() && currentMonth === today.getMonth()) {
                prevBtn.disabled = true;
                prevBtn.style.opacity = '0.3';
                prevBtn.style.cursor = 'not-allowed';
            } else {
                prevBtn.disabled = false;
                prevBtn.style.opacity = '1';
                prevBtn.style.cursor = 'pointer';
            }

            if (currentYear >= 2100 && currentMonth >= 11) {
                nextBtn.disabled = true;
                nextBtn.style.opacity = '0.3';
                nextBtn.style.cursor = 'not-allowed';
            } else {
                nextBtn.disabled = false;
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }

            let html = '';
            const firstDay = new Date(currentYear, currentMonth, 1);
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let startDayOffset = firstDay.getDay() - 1;
            if (startDayOffset === -1) startDayOffset = 6;

            const prevMonthDays = new Date(currentYear, currentMonth, 0).getDate();

            for (let i = 0; i < startDayOffset; i++) {
                const dayNum = prevMonthDays - startDayOffset + 1 + i;
                html += `<div class="h-16 flex items-center justify-center text-slate-300">${dayNum}</div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateObj = new Date(currentYear, currentMonth, i);
                const isPast = dateObj < today;

                const isSelected = selectedDate && dateObj.getTime() === selectedDate.getTime();
                const isWeekend = dateObj.getDay() === 0 || dateObj.getDay() === 6;
                const diaNombreBD = diasSemanaMap[dateObj.getDay()];

                // Formatear fecha a YYYY-MM-DD
                const mFormat = String(currentMonth + 1).padStart(2, '0');
                const dFormat = String(i).padStart(2, '0');
                const dateString = `${currentYear}-${mFormat}-${dFormat}`;

                // 1. Verificar si hay al menos un psicólogo disponible este día
                const hayDisponibilidad = psicologosData.some(p => p.disponibilidad.some(d => d.dia === diaNombreBD));

                // 2. Determinar color del punto (solo si hay disponibilidad y no es un día pasado)
                let dotHtml = '';
                if (!isPast && hayDisponibilidad) {
                    const totalCitas = citasData[dateString] || 0;
                    let colorClass = '';

                    if (totalCitas >= 5) {
                        colorClass = 'bg-red-500'; // Completamente ocupado
                    } else if (totalCitas >= 1) {
                        colorClass = 'bg-yellow-500'; // Disponibilidad parcial
                    } else {
                        colorClass = 'bg-green-500'; // Totalmente libre
                    }

                    dotHtml = `<div class="absolute bottom-2 w-1.5 h-1.5 rounded-full ${colorClass}"></div>`;
                }

                let classes = 'h-16 flex flex-col items-center justify-center rounded-xl relative transition-all ';

                if (isPast) {
                    classes += ' text-slate-300 bg-slate-50 opacity-50 cursor-not-allowed';
                } else {
                    classes += ' cursor-pointer day-btn';
                    if (isSelected) {
                        classes += ' border-2 border-orange-500 bg-orange-50 text-orange-600 selected-day';
                    } else if (isWeekend) {
                        classes += ' bg-slate-50 text-slate-500 hover:border hover:border-orange-200';
                    } else {
                        classes += ' border border-slate-100 hover:border-orange-200';
                    }
                }

                html += `
                <div class="${classes}" data-day="${i}" data-month="${currentMonth}" data-year="${currentYear}">
                    <span class="font-bold ${isSelected ? '' : (isPast ? 'text-slate-400' : (isWeekend ? '' : 'text-slate-700'))}">${i}</span>
                    ${dotHtml}
                </div>`;
            }

            const totalCells = startDayOffset + daysInMonth;
            const remainingCells = (7 - (totalCells % 7)) % 7;
            for (let i = 1; i <= remainingCells; i++) {
                html += `<div class="h-16 flex items-center justify-center text-slate-300">${i}</div>`;
            }

            calendarGrid.innerHTML = html;

            const dayButtons = document.querySelectorAll('.day-btn');
            dayButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const d = parseInt(this.dataset.day);
                    const m = parseInt(this.dataset.month);
                    const y = parseInt(this.dataset.year);
                    selectedDate = new Date(y, m, d);

                    renderCalendar();
                    updateDisplay();
                });
            });
        }

        // Mapeo de getDay() (0=Domingo..6=Sábado) → nombre en BD
        const diasSemanaMap = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        function updateDisplay() {
            if (!selectedDate) return;

            // Actualizar título del panel
            const dayName = dayNames[selectedDate.getDay()];
            const d = selectedDate.getDate();
            const m = monthNames[selectedDate.getMonth()].substr(0, 3);
            selectedDateDisplay.textContent = `${dayName}, ${d} ${m}`;

            // Determinar qué día de la semana es (ej. 'Lunes')
            const diaBD = diasSemanaMap[selectedDate.getDay()];

            // Filtrar psicólogos que tienen disponibilidad ese día
            const disponibles = psicologosData.filter(p =>
                p.disponibilidad.some(d => d.dia === diaBD)
            );

            // Actualizar contador
            if (disponibles.length === 0) {
                psicoCount.textContent = 'Sin psicólogos disponibles este día';
            } else {
                psicoCount.textContent = `${disponibles.length} psicólogo${disponibles.length !== 1 ? 's' : ''} disponible${disponibles.length !== 1 ? 's' : ''}`;
            }

            // Generar HTML del panel
            if (disponibles.length === 0) {
                psicologosPanel.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-40 text-slate-400 gap-3">
                        <span class="material-symbols-outlined text-5xl text-slate-300">event_busy</span>
                        <p class="text-sm text-center">No hay psicólogos disponibles para este día.</p>
                    </div>`;
                return;
            }

            let html = '';
            disponibles.forEach(p => {
                // Obtener sólo los turnos del día seleccionado
                const turnos = p.disponibilidad.filter(d => d.dia === diaBD);

                const turnosHtml = turnos.map(t =>
                    `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                            text-sm font-medium bg-orange-50 text-orange-600 border border-orange-100">
                        <span class="material-symbols-outlined text-[15px]">schedule</span>
                        ${t.inicio} – ${t.fin}
                    </span>`
                ).join('');

                // Formatear fecha para el chatbot
                const mFormat = String(selectedDate.getMonth() + 1).padStart(2, '0');
                const dFormat = String(selectedDate.getDate()).padStart(2, '0');
                const dateString = `${selectedDate.getFullYear()}-${mFormat}-${dFormat}`;

                const turnosText = turnos.map(t => `${t.inicio.slice(0,5)} – ${t.fin.slice(0,5)}`).join(' y ');
                const hoverClasses = canSchedule && selectedDate >= today ? 'cursor-pointer hover:bg-orange-50 p-3 -mx-3 rounded-xl transition-colors' : '';
                const clickAttr = canSchedule && selectedDate >= today ? `onclick="abrirModalAgendar('${dateString}', ${p.id}, '${p.nombre.replace(/'/g, "\\'")}', '${p.especialidad.replace(/'/g, "\\'")}', '${p.foto_perfil}', '${turnosText}')"` : '';

                const agendarBadge = (canSchedule && selectedDate >= today)
                    ? `<span class="inline-flex items-center gap-1 text-xs font-semibold text-orange-500 bg-orange-50 border border-orange-200 rounded-full px-2 py-0.5 mt-1">
                        <span class="material-symbols-outlined text-[13px]">event_available</span> Agendar cita
                       </span>`
                    : '';

                html += `
                <div class="flex flex-col gap-3 ${hoverClasses}" ${clickAttr}>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-orange-100 shrink-0">
                            <img class="w-full h-full object-cover rounded-full"
                                 src="${p.foto_perfil}"
                                 alt="${p.nombre}"
                                 onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(p.nombre)}&background=F97316&color=fff'"/>
                        </div>
                        <div class="flex flex-col overflow-hidden">
                            <span class="font-bold text-slate-800 truncate">${p.nombre}</span>
                            <span class="text-sm text-orange-600 truncate">${p.especialidad}</span>
                            ${agendarBadge}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 px-1">${turnosHtml}</div>
                    <div class="h-px bg-slate-50 mt-1"></div>
                </div>`;

            });

            psicologosPanel.innerHTML = html;
        }

        prevBtn.addEventListener('click', () => {
            if (currentYear === today.getFullYear() && currentMonth === today.getMonth()) return;
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        nextBtn.addEventListener('click', () => {
            if (currentYear >= 2100 && currentMonth >= 11) return;
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        renderCalendar();
        updateDisplay();
    });

    // ─── Modal Agendar Cita (Específico del Calendario) ───────────────────
    let agendarData = {
        fecha: '',
        idPsicologo: null,
        hora: null
    };

    function abrirModalAgendar(fecha, idPsicologo, nombre, especialidad, foto, jornada) {
        agendarData = {
            fecha,
            idPsicologo,
            hora: null
        };

        document.getElementById('agendarModalFecha').textContent = cbFormatFechaSoloDia(fecha);
        document.getElementById('agendarModalJornada').textContent = jornada ? `Jornada: ${jornada}` : 'Sin jornada definida';
        document.getElementById('agendarModalNombre').textContent = nombre;
        document.getElementById('agendarModalEspecialidad').textContent = especialidad;
        document.getElementById('agendarModalFoto').src = foto;

        document.getElementById('agendarModalBtn').disabled = true;
        document.getElementById('agendarModalError').classList.add('hidden');
        document.getElementById('agendarModalMotivo').value = '';

        if (isPsicologo) {
            document.getElementById('agendarModalIdUsuario').value = '';
            const buscador = document.getElementById('agendarModalBuscador');
            if (buscador) buscador.value = '';
            const txt = document.getElementById('agendarModalPacienteNombreTxt');
            if (txt) txt.textContent = '';
            const sel = document.getElementById('agendarModalPacienteSeleccionado');
            if (sel) sel.classList.add('hidden');
            const res = document.getElementById('agendarModalResultados');
            if (res) res.classList.add('hidden');
        }

        const grid = document.getElementById('agendarModalHoras');
        grid.innerHTML = '<div class="col-span-3 flex justify-center py-6"><div class="w-6 h-6 border-4 border-orange-200 border-t-orange-500 rounded-full animate-spin"></div></div>';

        const m = document.getElementById('agendarCitaModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';

        cargarHorasDisponibles(fecha, idPsicologo);
    }

    function cerrarModalAgendar() {
        const m = document.getElementById('agendarCitaModal');
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }

    async function cargarHorasDisponibles(fecha, idPsicologo) {
        const grid = document.getElementById('agendarModalHoras');
        try {
            const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
            const url  = BASE + 'chat_bot/horasDisponibles?fecha=' + fecha + '&id_psicologo=' + idPsicologo;
            console.log('[Agendar] Cargando horas:', url);
            const res  = await fetch(url);
            const data = await res.json();
            console.log('[Agendar] Respuesta:', data);

            if (!data.ok || !data.horas || data.horas.length === 0) {
                grid.innerHTML = `<div class="col-span-3 text-center py-6">
                    <span class="material-symbols-outlined text-slate-300 text-4xl block mb-2">schedule</span>
                    <p class="text-slate-500 text-sm">No hay horas disponibles este día.</p>
                </div>`;
                return;
            }

            grid.innerHTML = data.horas.map(h => `
                <button onclick="seleccionarHoraAgendar('${h}', this)"
                    class="hora-agendar-btn py-2.5 text-sm font-bold border-2 border-slate-200 rounded-xl text-slate-600 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
                    ${h}
                </button>
            `).join('');
        } catch (e) {
            console.error('[Agendar] Error:', e);
            grid.innerHTML = `<div class="col-span-3 text-center py-4 text-red-500 text-sm">Error al cargar horarios: ${e.message}</div>`;
        }
    }

    function seleccionarHoraAgendar(hora, btn) {
        document.querySelectorAll('.hora-agendar-btn').forEach(b => {
            b.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
            b.classList.add('border-slate-200', 'text-slate-600');
        });
        btn.classList.add('border-orange-500', 'bg-orange-500', 'text-white');
        btn.classList.remove('border-slate-200', 'text-slate-600');

        agendarData.hora = hora;
        document.getElementById('agendarModalBtn').disabled = false;
    }

    async function confirmarCitaModal() {
        if (!agendarData.hora) return;
        
        let idUsuario = null;
        if (isPsicologo) {
            idUsuario = document.getElementById('agendarModalIdUsuario').value;
            if (!idUsuario) {
                const errEl = document.getElementById('agendarModalError');
                errEl.textContent = "Selecciona un paciente para la cita.";
                errEl.classList.remove('hidden');
                return;
            }
        }

        const motivo = document.getElementById('agendarModalMotivo').value.trim();
        const errEl = document.getElementById('agendarModalError');
        const btn = document.getElementById('agendarModalBtn');

        errEl.classList.add('hidden');
        btn.disabled = true;
        btn.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> Procesando...';

        try {
            const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
            let url = BASE + 'chat_bot/guardarCita';
            let bodyData = {
                id_psicologo: agendarData.idPsicologo,
                fecha: agendarData.fecha,
                hora: agendarData.hora,
                estado: 'pendiente',
                motivo_consulta: motivo,
                fecha_creacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
            };

            if (isPsicologo) {
                url = BASE + 'panel_psicologas/agendarCita';
                bodyData = {
                    id_usuario: parseInt(idUsuario),
                    id_psicologo: agendarData.idPsicologo,
                    fecha: agendarData.fecha,
                    hora: agendarData.hora,
                    motivo_consulta: motivo
                };
            }

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(bodyData)
            });
            const data = await res.json();

            if (data.ok) {
                cerrarModalAgendar();
                if (typeof openSuccessCitaModal === 'function') openSuccessCitaModal();
                else alert('¡Cita agendada con éxito!');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || 'Error al guardar la cita');
            }
        } catch (e) {
            errEl.textContent = e.message;
            errEl.classList.remove('hidden');
            btn.disabled = false;
            btn.innerHTML = 'Confirmar Cita';
        }
    }

    function cbFormatFechaSoloDia(fecha) {
        const [y, m, d] = fecha.split('-');
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return `${parseInt(d)} de ${meses[parseInt(m)-1]}. ${y}`;
    }

    // ─── Lógica Buscador Pacientes (Psicólogos) ───────────────────────────
    let debounceTimerBuscador;
    document.addEventListener('DOMContentLoaded', () => {
        const inputBuscador = document.getElementById('agendarModalBuscador');
        if (!inputBuscador) return;

        inputBuscador.addEventListener('input', () => {
            clearTimeout(debounceTimerBuscador);
            const q = inputBuscador.value.trim();
            const lista = document.getElementById('agendarModalResultados');
            if (q.length < 2) { lista.classList.add('hidden'); return; }

            debounceTimerBuscador = setTimeout(async () => {
                const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
                const res  = await fetch(BASE + 'panel_psicologas/buscarTodosLosPacientes?q=' + encodeURIComponent(q));
                const data = await res.json();
                if (!data.ok || !data.pacientes.length) {
                    lista.innerHTML = '<p class="px-4 py-3 text-sm text-slate-400">Sin resultados.</p>';
                    lista.classList.remove('hidden');
                    return;
                }
                lista.innerHTML = data.pacientes.map(p => `
                    <button type="button" onclick="seleccionarPacienteBuscador(${p.id_usuario}, '${p.nombre.replace(/'/g, "\\'")}', '${p.correo_electronico.replace(/'/g, "\\'")}')"
                        class="w-full text-left px-4 py-2.5 hover:bg-orange-50 transition-colors border-b border-slate-100 last:border-0">
                        <p class="text-sm font-bold text-slate-800">${p.nombre}</p>
                        <p class="text-xs text-slate-400">${p.correo_electronico} · Grado ${p.grado}</p>
                    </button>`).join('');
                lista.classList.remove('hidden');
            }, 350);
        });
    });

    function seleccionarPacienteBuscador(id, nombre, correo) {
        document.getElementById('agendarModalIdUsuario').value = id;
        document.getElementById('agendarModalBuscador').value = nombre + ' — ' + correo;
        document.getElementById('agendarModalPacienteNombreTxt').textContent = nombre;
        document.getElementById('agendarModalPacienteSeleccionado').classList.remove('hidden');
        document.getElementById('agendarModalResultados').classList.add('hidden');
    }

    // ─── Modal Crear Paciente ─────────────────────────────────────────────
    function abrirModalCrearPaciente() {
        resetModalCrearPaciente();
        const m = document.getElementById('modalCrearPaciente');
        if (m) {
            m.classList.remove('hidden');
            m.classList.add('flex');
            document.body.style.overflow = 'hidden';
            cerrarModalAgendar(); // Cerramos el de agendar temporalmente
        }
    }
    
    function cerrarModalCrearPaciente() {
        const m = document.getElementById('modalCrearPaciente');
        if (m) {
            m.classList.add('hidden');
            m.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    function resetModalCrearPaciente() {
        ['cpGrado','cpNombre','cpCorreo','cpContrasena','cpContrasena2',
         'cpAcudNombre','cpAcudCedula','cpAcudRelacion','cpAcudCorreo'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        const errCont = document.getElementById('cpError');
        const succCont = document.getElementById('cpSuccess');
        if (errCont) errCont.classList.add('hidden');
        if (succCont) succCont.classList.add('hidden');
    }

    async function guardarNuevoPaciente() {
        const btn = document.getElementById('btnGuardarPaciente');
        const errEl = document.getElementById('cpErrorMsg');
        const errCont = document.getElementById('cpError');
        const succEl = document.getElementById('cpSuccessMsg');
        const succCont = document.getElementById('cpSuccess');

        errCont.classList.add('hidden');
        succCont.classList.add('hidden');

        const grado      = document.getElementById('cpGrado').value;
        const nombre     = document.getElementById('cpNombre').value.trim();
        const correo     = document.getElementById('cpCorreo').value.trim();
        const contrasena = document.getElementById('cpContrasena').value;
        const contrasena2= document.getElementById('cpContrasena2').value;
        const acudNombre = document.getElementById('cpAcudNombre').value.trim();
        const acudCedula = document.getElementById('cpAcudCedula').value.trim();
        const acudRelacion = document.getElementById('cpAcudRelacion').value;
        const acudCorreo = document.getElementById('cpAcudCorreo').value.trim();

        if (!grado || !nombre || !correo || !contrasena) {
            errEl.textContent = 'Grado, nombre, correo y contraseña son obligatorios.';
            errCont.classList.remove('hidden'); return;
        }
        if (contrasena !== contrasena2) {
            errEl.textContent = 'Las contraseñas no coinciden.';
            errCont.classList.remove('hidden'); return;
        }
        if (acudCedula && !/^\d+$/.test(acudCedula)) {
            errEl.textContent = 'La cédula del acudiente solo puede contener números.';
            errCont.classList.remove('hidden'); return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Registrando...';

        try {
            const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
            const res  = await fetch(BASE + 'panel_psicologas/crearPaciente', {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify({
                    grado, nombre, correo_electronico: correo, contrasena,
                    acudiente_nombre: acudNombre, acudiente_cedula: acudCedula,
                    acudiente_relacion: acudRelacion, acudiente_correo: acudCorreo
                })
            });
            const data = await res.json();
            if (data.ok) {
                succEl.textContent = data.mensaje;
                succCont.classList.remove('hidden');
                
                // Set the newly created user in the booking modal!
                if (isPsicologo) {
                    seleccionarPacienteBuscador(data.id_usuario, nombre, correo);
                }

                setTimeout(() => {
                    cerrarModalCrearPaciente();
                    const m = document.getElementById('agendarCitaModal');
                    if (m) {
                        m.classList.remove('hidden');
                        m.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    }
                }, 1500);
            } else {
                errEl.textContent = data.error;
                errCont.classList.remove('hidden');
            }
        } catch(e) {
            errEl.textContent = 'Error de conexión.';
            errCont.classList.remove('hidden');
        }

        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">person_check</span> Registrar Paciente';
    }
</script>

<!-- ══════════ MODAL AGENDAR CITA (CALENDARIO) ══════════ -->
<div id="agendarCitaModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cerrarModalAgendar()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 z-10 p-7 transform transition-transform">
        <button onclick="cerrarModalAgendar()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">event_available</span>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-lg leading-tight">Agendar Cita</h3>
                <p id="agendarModalFecha" class="text-xs text-orange-500 font-semibold"></p>
                <p id="agendarModalJornada" class="text-xs text-slate-500"></p>
            </div>
        </div>

        <!-- Info Psicólogo -->
        <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-2xl mb-5 border border-slate-100">
            <img id="agendarModalFoto" src="" alt="Foto" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
            <div class="min-w-0 flex-1">
                <p id="agendarModalNombre" class="font-bold text-slate-800 text-sm truncate"></p>
                <p id="agendarModalEspecialidad" class="text-xs text-slate-500 truncate"></p>
            </div>
        </div>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'psicologo'): ?>
        <!-- Buscador de paciente -->
        <div class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Paciente <span class="text-red-400">*</span></label>
                <button type="button" onclick="abrirModalCrearPaciente()" class="text-xs font-bold text-orange-600 hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">person_add</span> Crear Paciente
                </button>
            </div>
            <div class="relative">
                <input type="text" id="agendarModalBuscador" placeholder="Buscar por nombre o correo..." autocomplete="off"
                    class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors pr-10">
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 text-[20px]">search</span>
            </div>
            <div id="agendarModalResultados" class="hidden mt-1 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden max-h-40 overflow-y-auto z-20 relative"></div>
            <input type="hidden" id="agendarModalIdUsuario">
            <p id="agendarModalPacienteSeleccionado" class="hidden mt-2 text-xs font-semibold text-orange-600 flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                <span id="agendarModalPacienteNombreTxt"></span>
            </p>
        </div>
        <?php endif; ?>

        <!-- Selector de horas -->
        <div class="mb-5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Horarios Disponibles</label>
            <div id="agendarModalHoras" class="grid grid-cols-3 gap-2 min-h-[48px]">
                <!-- Llenado por JS -->
            </div>
        </div>

        <!-- Motivo -->
        <div class="mb-5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Motivo de consulta <span class="font-normal text-slate-400">(Opcional)</span></label>
            <textarea id="agendarModalMotivo" rows="2" placeholder="Ej: Ansiedad, estrés..." class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none"></textarea>
        </div>

        <div id="agendarModalError" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 font-medium"></div>

        <button id="agendarModalBtn" onclick="confirmarCitaModal()" disabled
            class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl shadow-md shadow-orange-200 hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            Confirmar Cita
        </button>
    </div>
</div>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'psicologo'): ?>
<!-- ══════════ MODAL: CREAR PACIENTE ══════════ -->
<div id="modalCrearPaciente" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalCrearPaciente()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalCrearPaciente()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 rounded-2xl">
                <span class="material-symbols-outlined text-blue-500 text-2xl">person_add</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-xl">Nuevo Paciente</h3>
                <p class="text-sm text-slate-400">Registrar paciente rápido</p>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Datos básicos -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Datos del Paciente</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Grado <span class="text-red-400">*</span></label>
                    <select id="cpGrado" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white">
                        <option value="">Seleccionar</option>
                        <?php foreach(['6','7','8','9','10','11'] as $g): ?>
                        <option value="<?= $g ?>">Grado <?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre Completo <span class="text-red-400">*</span></label>
                    <input type="text" id="cpNombre" placeholder="Nombre del paciente"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Correo Electrónico <span class="text-red-400">*</span></label>
                <input type="email" id="cpCorreo" placeholder="correo@ejemplo.com"
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena" placeholder="Contraseña inicial"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Confirmar Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena2" placeholder="Repetir contraseña"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>

            <!-- Datos acudiente -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2 mt-2">Datos del Acudiente <span class="font-normal text-slate-300">(opcional)</span></p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre Acudiente</label>
                    <input type="text" id="cpAcudNombre" placeholder="Nombre completo"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cédula</label>
                    <input type="text" id="cpAcudCedula" placeholder="Solo números"
                        inputmode="numeric" pattern="[0-9]*"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Relación</label>
                    <select id="cpAcudRelacion" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white">
                        <option value="">Seleccionar</option>
                        <option value="Padre">Padre</option>
                        <option value="Madre">Madre</option>
                        <option value="Tutor legal">Tutor legal</option>
                        <option value="Hermano/a">Hermano/a</option>
                        <option value="Abuelo/a">Abuelo/a</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Correo Acudiente</label>
                    <input type="email" id="cpAcudCorreo" placeholder="correo@ejemplo.com"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
        </div>

        <div id="cpError" class="hidden mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="cpErrorMsg"></span>
        </div>
        <div id="cpSuccess" class="hidden mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">check_circle</span>
            <span id="cpSuccessMsg"></span>
        </div>

        <button onclick="guardarNuevoPaciente()" id="btnGuardarPaciente"
            class="w-full mt-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all active:scale-[0.98] shadow-md shadow-blue-200 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">person_check</span>
            Registrar Paciente
        </button>
    </div>
</div>
<?php endif; ?>
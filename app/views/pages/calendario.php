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
                <div>LUN</div><div>MAR</div><div>MIÉ</div><div>JUE</div><div>VIE</div><div>SÁB</div><div>DOM</div>
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
                <img class="w-1/3 object-cover rounded-l-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQ8XE1OmaOO7d76QcGyu-fpngMNPVAWd19YKle1m611F5eOjm0FbfrElMB_lIakjDtGwvu-A3LZZtgjRHkt0pkXT8Z2--LDOyvIWs51OQvNC8rBAy1RPEVbCbE-qVoMSETUa3PM56OyHoX0B4xY9X5wpKvvZVFt-zyw0zPpoUqJ56Rcmp0yL06kfI0KjzSPvOnTW4otkDpUIJPlZNUQ2pTtokTeBmUNLMku5Y1AWrAfM2PeXSSsgKET6MmlBbPAoZ1NNvVktHwdLrY"/>
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
                    <?php if ($_SESSION['user']['rol'] === 'paciente'): ?>
                        <button class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:bg-on-primary-fixed-variant transition-colors active:scale-95 duration-150">
                            Confirmar Cita
                        </button>
                    <?php else: ?>
                        <!-- Si es psicólogo, no tiene sentido que agende citas para sí mismo por este medio -->
                        <button class="w-full bg-slate-200 text-slate-500 font-bold py-4 rounded-xl cursor-not-allowed" disabled>
                            Modo Psicóloga (Agendamiento Deshabilitado)
                        </button>
                    <?php endif; ?>
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
        today.setHours(0,0,0,0);
        
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
                        colorClass = 'bg-red-500';      // Completamente ocupado
                    } else if (totalCitas >= 1) {
                        colorClass = 'bg-yellow-500';   // Disponibilidad parcial
                    } else {
                        colorClass = 'bg-green-500';    // Totalmente libre
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
        const diasSemanaMap = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];

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

                html += `
                <div class="flex flex-col gap-3">
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
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">${turnosHtml}</div>
                    <div class="h-px bg-slate-50"></div>
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
</script>

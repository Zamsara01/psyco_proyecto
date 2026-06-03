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
                <h3 class="font-headline-md text-on-surface" id="selected-date-display">Martes, 8 Oct</h3>
                <p class="text-body-sm text-slate-500">2 Psicólogos disponibles</p>
            </div>
            
            <div class="p-6 flex-grow flex flex-col gap-8 overflow-y-auto hide-scrollbar max-h-[614px]">
                <!-- Psicólogo 1 -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-orange-100 p-0.5">
                            <img class="w-full h-full object-cover rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAoCt8e7vWmBlHVCPztD4M6zP6RYQm_TPiSyvOB77MEDxC5EWIV3FxihpDjgKH0OmG3Lsrlry5AJUoazNhPIbmNLHItvrew3cLkU4Yuyv5uOqyfaucb5dTkctyp6mtL-KJaMiXtbe0FMRRG5BmVLDIG9dunS1-q11VparZsVaOZ8vkHLJIXFXqZ6y41RTYRIR8KRAfoGUvSaGGADY6PeXOnGMh7qKFufXr7DPdmEwNWE-Z9BhnDq2R46AdottHjFsU0bezmyBtMBK2"/>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-on-surface">Dra. Elena Vargas</span>
                            <span class="text-body-sm text-orange-600">Terapia Cognitivo-Conductual</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 rounded-xl text-label-md border border-orange-100 bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-all active:scale-95">09:00 AM</button>
                        <button class="px-4 py-2 rounded-xl text-label-md border border-orange-100 bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-all active:scale-95">10:30 AM</button>
                        <button class="px-4 py-2 rounded-xl text-label-md border border-orange-100 bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-all active:scale-95">03:00 PM</button>
                    </div>
                </div>

                <!-- Psicólogo 2 -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center border-2 border-slate-50">
                            <span class="material-symbols-outlined text-slate-400 text-3xl">person</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-on-surface">Dr. Ricardo Mena</span>
                            <span class="text-body-sm text-orange-600">Especialista en Ansiedad</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 rounded-xl text-label-md border border-orange-100 bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-all active:scale-95">11:00 AM</button>
                        <button class="px-4 py-2 rounded-xl text-label-md border border-orange-100 bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-all active:scale-95">04:30 PM</button>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-slate-50 rounded-b-2xl">
                <button class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:bg-on-primary-fixed-variant transition-colors active:scale-95 duration-150">
                    Confirmar Cita
                </button>
            </div>
        </div>
    </aside>
</main>

<!-- BottomNavBar Section -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 pb-safe bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg border-t border-slate-100 dark:border-slate-800 shadow-[0_-4px_20px_rgba(249,115,22,0.08)]">
    <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-2 hover:text-orange-500 dark:hover:text-orange-300 active:scale-90 transition-transform duration-150" href="<?= URL_BASE ?>chat_bot">
        <span class="material-symbols-outlined mb-1">forum</span>
        <span class="font-['Plus_Jakarta_Sans'] text-[10px] uppercase tracking-wider font-bold">Asistente</span>
    </a>
    <a class="flex flex-col items-center justify-center text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 rounded-xl px-4 py-2 active:scale-90 transition-transform duration-150" href="<?= URL_BASE ?>calendario">
        <span class="material-symbols-outlined mb-1">calendar_month</span>
        <span class="font-['Plus_Jakarta_Sans'] text-[10px] uppercase tracking-wider font-bold">Agenda</span>
    </a>
    <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-2 hover:text-orange-500 dark:hover:text-orange-300 active:scale-90 transition-transform duration-150" href="#">
        <span class="material-symbols-outlined mb-1">auto_stories</span>
        <span class="font-['Plus_Jakarta_Sans'] text-[10px] uppercase tracking-wider font-bold">Recursos</span>
    </a>
    <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 px-4 py-2 hover:text-orange-500 dark:hover:text-orange-300 active:scale-90 transition-transform duration-150" href="<?= URL_BASE ?>panel_psicologas">
        <span class="material-symbols-outlined mb-1">person</span>
        <span class="font-['Plus_Jakarta_Sans'] text-[10px] uppercase tracking-wider font-bold">Perfil</span>
    </a>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const calendarGrid = document.getElementById('calendar-grid');
        const selectedDateDisplay = document.getElementById('selected-date-display');
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
                
                const seed = currentYear * 10000 + currentMonth * 100 + i;
                const colorClass = colors[seed % colors.length];
                
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
                
                let dotHtml = (!isPast && colorClass) ? `<div class="absolute bottom-2 w-1.5 h-1.5 rounded-full ${colorClass}"></div>` : '';
                
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
        
        function updateDisplay() {
            if (!selectedDate) return;
            const dayName = dayNames[selectedDate.getDay()];
            const d = selectedDate.getDate();
            const m = monthNames[selectedDate.getMonth()].substr(0, 3);
            selectedDateDisplay.textContent = `${dayName}, ${d} ${m}`;
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

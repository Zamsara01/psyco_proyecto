import sys
import re

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# 1. Add custom styles and inject them right after <main>
style_block = """<style>
    .bg-cream { background-color: #fcf8f2 !important; }
    .border-cream-dark { border-color: #f3efe9 !important; }
    .bg-beige { background-color: #f4ece1 !important; }
    .bg-purple-brand { background-color: #6f4b8b !important; }
    .bg-green-brand { background-color: #87c29b !important; }
    .bg-yellow-brand { background-color: #fcd57e !important; }
    .bg-red-brand { background-color: #f0857a !important; }
    .bg-white-warm { background-color: #fffdf9 !important; }
    .bg-gray-warm { background-color: #f9f5ef !important; }
    .bg-brown-brand { background-color: #8a5a55 !important; }
    .shadow-glow { box-shadow: 0 0 15px rgba(255,165,0,0.4) !important; }
    
    /* Font override for handwriting */
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap');
    .font-handwriting { font-family: 'Caveat', cursive !important; }
</style>
"""

content = content.replace('<main class="pt-8 px-4 md:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 mb-24 relative z-10 w-full">', '<main class="pt-8 px-4 md:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 mb-24 relative z-10 w-full">\n' + style_block)

# 2. Left section replacement
left_str = """
    <!-- Left Section: Calendar + Carousel + Nuevos Recursos stacked -->
    <section class="lg:col-span-12 xl:col-span-8 flex flex-col gap-6">
        <!-- Calendar Card -->
        <div class="bg-cream dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-cream-dark dark:border-slate-700/60 relative">
            <div class="flex items-center justify-between mb-6">
                <div class="flex flex-col">
                    <div class="flex items-center gap-1" id="calendar-month-year">
                        <select id="month-select" class="text-2xl font-bold text-slate-800 dark:text-slate-100 bg-transparent border-transparent focus:border-transparent focus:ring-0 p-0 pr-6 hover:text-orange-900 transition-colors cursor-pointer"></select>
                        <select id="year-select" class="text-2xl font-bold text-slate-800 dark:text-slate-100 bg-transparent border-transparent focus:border-transparent focus:ring-0 p-0 pr-6 hover:text-orange-900 transition-colors cursor-pointer"></select>
                    </div>
                    <p class="text-sm text-slate-700 dark:text-slate-400 mt-1">Selecciona un día para ver disponibilidad</p>
                </div>

                <div class="hidden md:flex flex-col items-end mr-6">
                    <span class="text-2xl font-handwriting text-slate-800 mb-1">Tu Viaje este Mes</span>
                    <svg class="w-32 h-2 text-slate-800" viewBox="0 0 100 10" preserveAspectRatio="none">
                        <path d="M0,5 Q25,10 50,5 T100,5" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </div>

                <div class="flex gap-3">
                    <button id="prev-month-btn" class="w-10 h-10 flex items-center justify-center rounded-xl bg-beige text-slate-600 transition-all hover:opacity-80 hover:scale-105">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                    <button id="next-month-btn" class="w-10 h-10 flex items-center justify-center rounded-xl bg-purple-brand text-white transition-all hover:opacity-80 hover:scale-105">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                </div>
            </div>

            <!-- Calendar Days Header -->
            <div class="calendar-grid text-center text-sm font-semibold text-slate-800 dark:text-slate-400 mb-4">
                <div>LUN</div>
                <div>MAR</div>
                <div>MIÉ</div>
                <div>JUE</div>
                <div>VIE</div>
                <div>SÁB</div>
                <div>DOM</div>
            </div>

            <!-- Calendar Days Grid -->
            <div class="calendar-grid gap-3" id="calendar-grid">
            </div>

            <!-- Legend -->
            <div class="mt-8 flex flex-wrap gap-8 pt-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-brand"></div>
                    <span class="text-sm font-medium text-slate-800 dark:text-slate-400">Día para Mí</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-yellow-brand"></div>
                    <span class="text-sm font-medium text-slate-800 dark:text-slate-400">Tiempo Flexible</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-brand"></div>
                    <span class="text-sm font-medium text-slate-800 dark:text-slate-400">Muy Ocupado</span>
                </div>
            </div>
        </div>

        <!-- Carrusel + Nuevos Recursos side by side (below calendar) -->
        <div class="flex flex-col sm:flex-row gap-6">
            <!-- Espacio de Apoyo (Carrusel de Consejos) -->
            <div class="flex-1 bg-cream dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-cream-dark dark:border-slate-700/60 h-40 flex flex-col justify-center relative overflow-hidden">
                <div class="absolute top-6 right-6 text-slate-700">
                    <span class="material-symbols-outlined">lightbulb</span>
                </div>
                <h4 class="font-bold text-lg text-slate-800 dark:text-slate-200 mb-2">Espacio de Apoyo</h4>
                <div id="tip-carousel" class="relative flex-grow">
                    <div id="tip-content" class="transition-opacity duration-500 ease-in-out h-full">
                        <p id="tip-text" class="text-sm text-slate-700 dark:text-slate-400 leading-relaxed font-medium">Un consejo para hoy (curado por tu Guía): Para aliviar la tensión antes de tu sesión, prueba este ejercicio de respiración consciente de 3 minutos.</p>
                    </div>
                </div>
            </div>

            <!-- Mis Notificaciones (Nuevos Recursos Card) -->
            <a href="<?= URL_BASE ?>citas/misRecursos" class="flex-1 bg-cream dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-cream-dark dark:border-slate-700/60 h-40 hover:border-orange-300 transition-colors group cursor-pointer block relative" id="recursos-carousel-container">
                <div class="absolute top-6 right-6 text-slate-700 relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </div>
                <h4 class="font-bold text-lg text-slate-800 dark:text-slate-200 mb-2">Mis Notificaciones</h4>
                <div id="recursos-carousel" class="relative w-full h-full">
                    <div id="recursos-content" class="transition-opacity duration-500 ease-in-out w-full h-full flex flex-col gap-2 justify-start">
                        <div class="w-full text-left">
                            <h4 class="font-bold text-sm text-slate-700 group-hover:text-orange-700 transition-colors">Nuevos Recursos</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 line-clamp-2">Aún no tienes recursos asignados.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
"""
start_left = content.find('<!-- Left Section: Calendar + Carousel + Nuevos Recursos stacked -->')
end_left = content.find('</section>', start_left) + len('</section>')

content = content[:start_left] + left_str + content[end_left:]

# 3. Right section replacement
right_str = """
    <!-- Right Section: Psychologist Panel only -->
    <aside class="lg:col-span-12 xl:col-span-4 flex flex-col gap-6">
        <div class="bg-cream dark:bg-slate-800 rounded-3xl shadow-sm border border-cream-dark dark:border-slate-700/60 flex flex-col h-full sticky top-24 pb-4">
            <div class="p-6 pb-2">
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100" id="selected-date-display">Nuestro Equipo de Conexión</h3>
                <p class="text-sm text-slate-700 dark:text-slate-400 mt-1" id="psico-count">3 psicólogos disponibles</p>
            </div>

            <!-- Lista dinámica de psicólogos -->
            <div class="px-6 flex-grow flex flex-col gap-4 overflow-y-auto hide-scrollbar max-h-[614px]" id="psicologos-panel">
                <!-- Relleno por JavaScript -->
                <div class="flex flex-col items-center justify-center h-40 text-slate-400 dark:text-slate-500 gap-3">
                    <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-600">calendar_month</span>
                    <p class="text-sm text-center">Selecciona un día en el calendario para ver la disponibilidad</p>
                </div>
            </div>

            <div class="px-6 pt-4 mt-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <p class="text-xs text-slate-600 dark:text-slate-400 text-center font-medium flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined align-middle text-[16px]">touch_app</span>
                        <?php if ($_SESSION['user']['rol'] === 'psicologo'): ?>
                            Selecciona un psicólogo para agendar
                        <?php else: ?>
                            Haz clic en un psicólogo arriba para agendar tu cita
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <button type="button" onclick="openLoginModal()" class="w-full bg-brown-brand text-white font-bold py-3 rounded-xl shadow-sm hover:opacity-90 transition-colors active:scale-95 duration-150">
                        Inicia sesión para agendar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </aside>
"""

start_right = content.find('<!-- Right Section: Psychologist Panel only -->')
end_right = content.find('</aside>', start_right) + len('</aside>')
content = content[:start_right] + right_str + content[end_right:]

# Fix the broken section tag from original code
content = content.replace('</aside>\n\n            <div class="px-6 pt-4 mt-auto">\n    </section>', '</aside>')


# 4. JS: Add recursosData
content = content.replace(
    'const citasData = <?= $citasJson ?? \'{}\' ?>;',
    'const citasData = <?= $citasJson ?? \'{}\' ?>;\n    const recursosData = <?= $recursosJson ?? \'[]\' ?>;'
)

# 5. JS: Replace Calendar rendering
render_cal_js = """
            for (let i = 0; i < startDayOffset; i++) {
                const dayNum = prevMonthDays - startDayOffset + 1 + i;
                html += `<div class="h-16 flex items-center justify-center text-slate-400 bg-beige rounded-2xl mx-auto w-full">${dayNum}</div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateObj = new Date(currentYear, currentMonth, i);
                const maxDate = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
                const isDisabled = dateObj < today || dateObj > maxDate;

                const isSelected = selectedDate && dateObj.getTime() === selectedDate.getTime();
                const isWeekend = dateObj.getDay() === 0 || dateObj.getDay() === 6;
                const diaNombreBD = diasSemanaMap[dateObj.getDay()];

                const mFormat = String(currentMonth + 1).padStart(2, '0');
                const dFormat = String(i).padStart(2, '0');
                const dateString = `${currentYear}-${mFormat}-${dFormat}`;

                const hayDisponibilidad = psicologosData.some(p => p.disponibilidad.some(d => d.dia === diaNombreBD));

                let bgColorClass = 'bg-white-warm';
                let textColorClass = 'text-slate-800';
                let dotHtml = '';

                if (!isDisabled && hayDisponibilidad) {
                    const totalCitas = citasData[dateString] || 0;
                    if (totalCitas >= 5) {
                        bgColorClass = 'bg-red-brand text-white';
                        textColorClass = 'text-white';
                    } else if (totalCitas >= 1) {
                        bgColorClass = 'bg-yellow-brand';
                        textColorClass = 'text-slate-900';
                    } else {
                        bgColorClass = 'bg-green-brand';
                        textColorClass = 'text-slate-900';
                    }
                }

                let classes = 'h-16 flex flex-col items-center justify-center rounded-2xl relative transition-all w-full shadow-sm ';

                if (isDisabled) {
                    classes += ' text-slate-400 bg-gray-warm opacity-60 cursor-not-allowed';
                    textColorClass = 'text-slate-400';
                } else {
                    classes += ' cursor-pointer day-btn hover:scale-105 hover:shadow-md ';
                    if (isSelected) {
                        classes += ' bg-white text-slate-800 selected-day border border-orange-200 shadow-glow z-10 scale-105';
                        textColorClass = 'text-slate-800';
                        dotHtml = '<div class="absolute bottom-2 w-1.5 h-1.5 rounded-full bg-green-500"></div>';
                    } else {
                        classes += ' ' + bgColorClass;
                    }
                }

                html += `
                <div class="${classes}" data-day="${i}" data-month="${currentMonth}" data-year="${currentYear}">
                    <span class="font-bold text-lg ${textColorClass}">${i}</span>
                    ${dotHtml}
                </div>`;
            }

            const totalCells = startDayOffset + daysInMonth;
            const remainingCells = (7 - (totalCells % 7)) % 7;
            for (let i = 1; i <= remainingCells; i++) {
                html += `<div class="h-16 flex items-center justify-center text-slate-400 bg-transparent rounded-2xl mx-auto w-full">${i}</div>`;
            }
"""
pattern_cal = re.compile(r'            for \(let i = 0; i < startDayOffset; i\+\+\) \{.*?for \(let i = 1; i <= remainingCells; i\+\+\) \{.*?\}', re.DOTALL)
content = pattern_cal.sub(lambda m: render_cal_js.strip('\n'), content)

# Remove selected date display overwrite
content = content.replace("selectedDateDisplay.textContent = `${dayName}, ${d} ${m}`;", "")

# 6. JS: Replace Psychologist card rendering
psico_render = """
                const firstName = p.nombre.replace(/Dr\\.\\s*|Dra\\.\\s*/i, '').split(' ')[0];
                const btnActionText = p.nombre.includes('Elena') ? 'Conversar con' : 'Conectar con';
                const turnosText = turnos.map(t => `${t.inicio.slice(0,5)} – ${t.fin.slice(0,5)}`).join(' y ');
                const hoverClasses = canSchedule && selectedDate >= today ? 'cursor-pointer hover:shadow-md transition-shadow' : '';
                const clickAttr = canSchedule && selectedDate >= today ? `onclick="abrirModalAgendar('${dateString}', ${p.id}, '${p.nombre.replace(/'/g, "\\\\'")}', '${p.especialidad.replace(/'/g, "\\\\'")}', '${p.foto_perfil}', '${turnosText}')"` : '';

                html += `
                <div class="bg-white-warm dark:bg-slate-700/50 rounded-2xl p-4 shadow-sm border border-slate-100 dark:border-slate-600 flex flex-col gap-3 ${hoverClasses}" ${clickAttr}>
                    <div class="flex gap-4">
                        <img class="w-16 h-16 rounded-xl object-cover shrink-0 bg-slate-100"
                             src="${p.foto_perfil}"
                             alt="${p.nombre}"
                             onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(p.nombre)}&background=f4ece1&color=6f4b8b'"/>
                        <div class="flex flex-col flex-1 overflow-hidden">
                            <span class="font-bold text-slate-800 dark:text-slate-100 truncate">${p.nombre}</span>
                            <span class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mt-1 leading-relaxed">${p.especialidad}</span>
                        </div>
                    </div>
                    ${(canSchedule && selectedDate >= today) ? `
                    <button class="w-full bg-brown-brand text-white text-xs font-semibold py-2 rounded-lg hover:opacity-90 transition-colors shadow-sm">
                        ${btnActionText} ${firstName}
                    </button>
                    ` : ''}
                </div>`;
"""
pattern_psico = re.compile(r'                const turnosText = turnos.*?</div>`;', re.DOTALL)
content = pattern_psico.sub(lambda m: psico_render.strip('\n'), content)


# 7. Append resources carousel JS logic at the very end before closing script
resources_logic = """
    // ─── Lógica para el carrusel de Recursos ─────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('recursos-carousel-container');
        const content = document.getElementById('recursos-content');
        if (!container || !content || typeof recursosData === 'undefined' || recursosData.length === 0) return;
        
        function getYouTubeThumbnail(url) {
            if (!url) return null;
            const regExp = /^.*((youtu.be\\/)|(v\\/)|(\\/u\\/\\w\\/)|(embed\\/)|(watch\\?))\\??v?=?([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[7].length == 11) ? `https://img.youtube.com/vi/${match[7]}/hqdefault.jpg` : null;
        }

        let recIndex = 0;

        function showRecurso(index) {
            const r = recursosData[index];
            if (!r) return;

            content.style.opacity = '0';
            
            setTimeout(() => {
                let imgHtml = '';
                if (r.tipo === 'video' && r.url_video) {
                    const thumb = getYouTubeThumbnail(r.url_video) || 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=200&auto=format&fit=crop';
                    imgHtml = `<img class="w-1/3 object-cover rounded-lg h-full" src="${thumb}" alt="Video" />`;
                } else if (r.imagen_ruta) {
                    const baseUrl = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
                    imgHtml = `<img class="w-1/3 object-cover rounded-lg h-full" src="${baseUrl + r.imagen_ruta}" alt="Recurso" />`;
                }

                const txtClass = imgHtml ? 'w-2/3 pl-3' : 'w-full text-left';
                const pDesc = r.descripcion ? `<p class="text-xs text-slate-600 dark:text-slate-400 mt-1 line-clamp-2">${r.descripcion}</p>` : '';

                content.innerHTML = `
                    ${imgHtml}
                    <div class="${txtClass} flex flex-col justify-start">
                        <h4 class="font-bold text-sm text-slate-700 group-hover:text-orange-700 transition-colors line-clamp-1">${r.titulo}</h4>
                        ${pDesc}
                    </div>
                `;
                content.style.opacity = '1';
            }, 300);
        }

        if (recursosData.length > 0) {
            showRecurso(0);
            if (recursosData.length > 1) {
                let recInterval = setInterval(() => {
                    recIndex = (recIndex + 1) % recursosData.length;
                    showRecurso(recIndex);
                }, 8000);

                container.addEventListener('mouseenter', () => clearInterval(recInterval));
                container.addEventListener('mouseleave', () => {
                    recInterval = setInterval(() => {
                        recIndex = (recIndex + 1) % recursosData.length;
                        showRecurso(recIndex);
                    }, 8000);
                });
            }
        }
    });
"""

# Find the end of the script before modal
# It's right before `</script>\n\n<!-- ══════════ MODAL AGENDAR CITA`
content = content.replace("    }\n</script>\n\n<!-- ══════════ MODAL AGENDAR CITA", "    }\n" + resources_logic + "\n</script>\n\n<!-- ══════════ MODAL AGENDAR CITA")

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(content)

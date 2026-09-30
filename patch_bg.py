import re

with open('app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# 1. ACTUALIZAR EL JAVASCRIPT
js_old = """                // 1. Verificar si hay al menos un psicólogo disponible este día
                const hayDisponibilidad = psicologosData.some(p => p.disponibilidad.some(d => d.dia === diaNombreBD));

                // 2. Determinar color del punto (solo si hay disponibilidad y no es un día pasado o futuro bloqueado)
                let dotHtml = '';
                if (!isDisabled && hayDisponibilidad) {
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

                if (isDisabled) {
                    classes += ' text-slate-300 dark:text-slate-600 bg-slate-50 dark:bg-slate-800/30 opacity-50 cursor-not-allowed';
                } else {
                    classes += ' cursor-pointer day-btn';
                    if (isSelected) {
                        classes += ' border-2 border-blue-500 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 selected-day';
                    } else if (isWeekend) {
                        classes += ' bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 hover:border hover:border-blue-200 dark:hover:border-blue-500/50';
                    } else {
                        classes += ' border border-slate-100 dark:border-slate-700/60 hover:border-blue-200 dark:hover:border-blue-500/50';
                    }
                }

                html += `
                <div class="${classes}" data-day="${i}" data-month="${currentMonth}" data-year="${currentYear}">
                    <span class="font-bold ${isSelected ? '' : (isDisabled ? 'text-slate-400 dark:text-slate-500' : (isWeekend ? '' : 'text-slate-700 dark:text-slate-200'))}">${i}</span>
                    ${dotHtml}
                </div>`;"""

js_new = """                // 1. Verificar si hay al menos un psicólogo disponible este día
                const hayDisponibilidad = psicologosData.some(p => p.disponibilidad.some(d => d.dia === diaNombreBD));

                // 2. Determinar clase de fondo para disponibilidad
                let bgAvailClass = '';
                if (!isDisabled && hayDisponibilidad) {
                    const totalCitas = citasData[dateString] || 0;
                    if (totalCitas >= 5) {
                        bgAvailClass = 'bg-red-500'; // Completamente ocupado
                    } else if (totalCitas >= 1) {
                        bgAvailClass = 'bg-yellow-500'; // Parcial
                    } else {
                        bgAvailClass = 'bg-green-500'; // Libre
                    }
                }

                let classes = 'h-16 flex flex-col items-center justify-center rounded-xl relative transition-all ';

                if (isDisabled) {
                    classes += ' cursor-not-allowed disabled-day';
                } else {
                    classes += ' cursor-pointer day-btn ' + bgAvailClass;
                    if (isSelected) {
                        classes += ' selected-day';
                    }
                }

                html += `
                <div class="${classes}" data-day="${i}" data-month="${currentMonth}" data-year="${currentYear}">
                    <span class="font-bold">${i}</span>
                </div>`;"""

if js_old in content:
    content = content.replace(js_old, js_new)
    print("JS logic updated to apply background to the full cell.")
else:
    print("JS old text NOT FOUND. Could not apply logic patch.")

# 2. ACTUALIZAR EL CSS 
css_old = """    /* Puntos de disponibilidad */
    .bg-green-500 { background-color: var(--cal-active) !important; border: 1px solid #000 !important; }
    .bg-yellow-500 { background-color: var(--cal-icon) !important; border: 1px solid #000 !important;}
    .bg-red-500 { background-color: var(--cal-btn-main) !important; border: 1px solid #000 !important;}"""

css_new = """    /* FONDOS de disponibilidad en las celdas enteras */
    .day-btn.bg-green-500 { background-color: var(--cal-active) !important; border: 1px solid #334045 !important; }
    .day-btn.bg-yellow-500 { background-color: var(--cal-icon) !important; border: 1px solid #334045 !important; }
    .day-btn.bg-red-500 { background-color: var(--cal-btn-main) !important; border: 1px solid #334045 !important; }
    
    /* Puntos de disponibilidad en la Leyenda (volverlos cuadraditos tipo tarjeta) */
    .mt-8 .bg-green-500 { background-color: var(--cal-active) !important; width: 1.25rem !important; height: 1.25rem !important; border-radius: 0.25rem !important; border: 1px solid #334045 !important;}
    .mt-8 .bg-yellow-500 { background-color: var(--cal-icon) !important; width: 1.25rem !important; height: 1.25rem !important; border-radius: 0.25rem !important; border: 1px solid #334045 !important;}
    .mt-8 .bg-red-500 { background-color: var(--cal-btn-main) !important; width: 1.25rem !important; height: 1.25rem !important; border-radius: 0.25rem !important; border: 1px solid #334045 !important;}
"""

if css_old in content:
    content = content.replace(css_old, css_new)
    print("CSS updated to handle full cell backgrounds.")
else:
    print("CSS old text NOT FOUND. Could not apply style patch.")

with open('app/views/pages/calendario.php', 'w') as f:
    f.write(content)

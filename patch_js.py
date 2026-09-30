import sys
import re

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

replacement = """
            for (let i = 0; i < startDayOffset; i++) {
                const dayNum = prevMonthDays - startDayOffset + 1 + i;
                html += `<div class="h-[4.5rem] flex items-center justify-center text-slate-400 bg-[#f4ece1] rounded-2xl mx-auto w-full">${dayNum}</div>`;
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

                let bgColorClass = 'bg-[#fffdf9]';
                let textColorClass = 'text-slate-800';
                let dotHtml = '';

                if (!isDisabled && hayDisponibilidad) {
                    const totalCitas = citasData[dateString] || 0;
                    if (totalCitas >= 5) {
                        bgColorClass = 'bg-[#f0857a] text-white';
                        textColorClass = 'text-white';
                    } else if (totalCitas >= 1) {
                        bgColorClass = 'bg-[#fcd57e]';
                        textColorClass = 'text-slate-900';
                    } else {
                        bgColorClass = 'bg-[#87c29b]';
                        textColorClass = 'text-slate-900';
                    }
                }

                let classes = 'h-[4.5rem] flex flex-col items-center justify-center rounded-2xl relative transition-all w-full shadow-sm ';

                if (isDisabled) {
                    classes += ' text-slate-400 bg-[#f9f5ef] opacity-60 cursor-not-allowed';
                    textColorClass = 'text-slate-400';
                } else {
                    classes += ' cursor-pointer day-btn hover:scale-105 hover:shadow-md ';
                    if (isSelected) {
                        classes += ' bg-white text-slate-800 selected-day border border-orange-200 ';
                        classes += ' shadow-[0_0_15px_rgba(255,165,0,0.4)] z-10 scale-105';
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
                html += `<div class="h-[4.5rem] flex items-center justify-center text-slate-400 bg-transparent rounded-2xl mx-auto w-full">${i}</div>`;
            }
"""

# Regex substitute the JS render logic
pattern = re.compile(r'            for \(let i = 0; i < startDayOffset; i\+\+\) \{.*?for \(let i = 1; i <= remainingCells; i\+\+\) \{.*?\}', re.DOTALL)
new_content = pattern.sub(replacement.strip('\n'), content)

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(new_content)

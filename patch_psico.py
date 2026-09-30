import sys
import re

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

replacement = """
                const firstName = p.nombre.replace(/Dr\\.\\s*|Dra\\.\\s*/i, '').split(' ')[0];
                const btnActionText = p.nombre.includes('Elena') ? 'Conversar con' : 'Conectar con';
                const turnosText = turnos.map(t => `${t.inicio.slice(0,5)} – ${t.fin.slice(0,5)}`).join(' y ');
                const hoverClasses = canSchedule && selectedDate >= today ? 'cursor-pointer hover:shadow-md transition-shadow' : '';
                const clickAttr = canSchedule && selectedDate >= today ? `onclick="abrirModalAgendar('${dateString}', ${p.id}, '${p.nombre.replace(/'/g, "\\\\'")}', '${p.especialidad.replace(/'/g, "\\\\'")}', '${p.foto_perfil}', '${turnosText}')"` : '';

                html += `
                <div class="bg-[#fffdf9] dark:bg-slate-700/50 rounded-2xl p-4 shadow-sm border border-slate-100 dark:border-slate-600 flex flex-col gap-3 ${hoverClasses}" ${clickAttr}>
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
                    <button class="w-full bg-[#8a5a55] text-white text-xs font-semibold py-2 rounded-lg hover:bg-[#6e4844] transition-colors shadow-sm">
                        ${btnActionText} ${firstName}
                    </button>
                    ` : ''}
                </div>`;
"""

pattern = re.compile(r'                const turnosText = turnos.*?</div>`;', re.DOTALL)
new_content = pattern.sub(lambda m: replacement.strip('\n'), content)

# I also want to stop JS from overwriting "Nuestro Equipo de Conexión"
new_content = new_content.replace("selectedDateDisplay.textContent = `${dayName}, ${d} ${m}`;", "")

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(new_content)

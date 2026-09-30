import sys

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

replacement_js = """
                const txtClass = imgHtml ? 'w-2/3 pl-2' : 'w-full text-left';
                const pDesc = r.descripcion ? `<p class="text-xs text-slate-600 dark:text-slate-400 mt-1 line-clamp-2">${r.descripcion}</p>` : '';

                content.innerHTML = `
                    ${imgHtml}
                    <div class="${txtClass} flex flex-col justify-start">
                        <h4 class="font-bold text-sm text-slate-700 group-hover:text-orange-700 transition-colors line-clamp-1">${r.titulo}</h4>
                        ${pDesc}
                    </div>
                `;
"""

import re
pattern = re.compile(r'                const txtClass = imgHtml.*?</div>\n                `;', re.DOTALL)
new_content = pattern.sub(lambda m: replacement_js.strip('\n'), content)

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(new_content)

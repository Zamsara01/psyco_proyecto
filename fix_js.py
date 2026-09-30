import sys
import re

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# I will use a regex to find the remaining cells loop and replace it cleanly.
pattern = re.compile(r'            const totalCells = startDayOffset \+ daysInMonth;\n            const remainingCells = \(7 - \(totalCells % 7\)\) % 7;\n            for \(let i = 1; i <= remainingCells; i\+\+\) \{.*?(?=\n            calendarGrid\.innerHTML = html;)', re.DOTALL)

clean_loop = """            const totalCells = startDayOffset + daysInMonth;
            const remainingCells = (7 - (totalCells % 7)) % 7;
            for (let i = 1; i <= remainingCells; i++) {
                html += `<div class="h-16 flex items-center justify-center text-slate-400 bg-transparent rounded-2xl mx-auto w-full">${i}</div>`;
            }"""

content = pattern.sub(clean_loop, content)

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(content)

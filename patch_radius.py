import re

with open('app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# 1. Modificar los cuadros de la leyenda en el CSS para que tengan border-radius: 0
content = content.replace('border-radius: 0.25rem !important;', 'border-radius: 0 !important;')

# 2. Añadir regla global para las celdas del calendario (forzando border-radius 0)
css_rule = """
    /* Forzar bordes rectos (sin redondear) en todas las celdas del calendario y leyenda */
    .calendar-grid > div,
    .day-btn {
        border-radius: 0 !important;
    }
</style>"""

content = content.replace('</style>', css_rule)

with open('app/views/pages/calendario.php', 'w') as f:
    f.write(content)
print("Border radius removed successfully!")

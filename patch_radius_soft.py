import re

with open('app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# Reemplazar el border-radius 0 por un redondeo suave (6px)
content = content.replace('border-radius: 0 !important;', 'border-radius: 0.375rem !important;')

with open('app/views/pages/calendario.php', 'w') as f:
    f.write(content)
print("Slight border radius applied successfully!")

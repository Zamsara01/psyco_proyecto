import re

with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# El bloque actual del logo
old_logo_block = r'''<div class="h-20 flex items-center justify-center px-4 border-b border-slate-100 dark:border-slate-700/60 shrink-0 relative">
        <a href="<?= URL_BASE ?>" class="flex items-center justify-center gap-3 min-w-0">
            <img alt="PSYCO Logo" class="h-11 w-auto object-contain shrink-0" src="<?= URL_BASE ?>public/img/psyco.png"/>
            <span class="text-2xl font-bold bg-gradient-to-r from-\[#6B8CAE\] to-\[#8DA399\] bg-clip-text text-transparent hover:opacity-90 transition-opacity truncate">PSYCO</span>
        </a>'''

# Nuevo bloque (logo grande, sin texto al lado, con más padding)
new_logo_block = '''<div class="py-8 px-4 flex items-center justify-center border-b border-slate-100 dark:border-slate-700/60 shrink-0 relative">
        <a href="<?= URL_BASE ?>" class="flex items-center justify-center w-full hover:scale-105 transition-transform duration-300">
            <!-- w-48 = 192px de ancho, ocupando casi todo el sidebar que es de 256px -->
            <img alt="PSYCO Logo" class="w-48 h-auto object-contain drop-shadow-md" src="<?= URL_BASE ?>public/img/psyco.png"/>
        </a>'''

# Si la regex no funciona por diferencias sutiles, hagámoslo más flexible
content = re.sub(
    r'<div class=\"h-20 flex items-center justify-center px-4 border-b border-slate-100.*?</script>\n    </div>\n\n    <!-- ── Navegación' if False else r'<!-- ── Logo ──.*?<a href="<?= URL_BASE ?>".*?</a>',
    '''<!-- ── Logo ─────────────────────────────────────────────── -->
    <div class="py-8 flex items-center justify-center px-4 border-b border-slate-200/50 dark:border-slate-700/60 shrink-0 relative">
        <a href="<?= URL_BASE ?>" class="flex items-center justify-center w-full hover:scale-105 transition-transform duration-300">
            <!-- Logo extra grande -->
            <img alt="PSYCO Logo" class="w-44 h-auto object-contain drop-shadow-sm" src="<?= URL_BASE ?>public/img/psyco.png"/>
        </a>''',
    content,
    flags=re.DOTALL
)

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)


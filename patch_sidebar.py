import re

with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# 1. Modificar Sidebar container para el frosted glass
content = re.sub(
    r'w-64 bg-white/80 dark:bg-slate-900/95 backdrop-blur-md border-r border-white/50',
    r'w-64 bg-white/70 dark:bg-slate-900/80 backdrop-blur-md border-r border-slate-200/50',
    content
)

# 2. Modificar is_active para usar colores de miscitas (slate y azul pizarra)
content = re.sub(
    r'\$isActive  = fn\(string \$path\) => str_starts_with\(\$urlActual, ltrim\(\$path, \'\/\'\)\).*?: \'.*?\';',
    '''$isActive  = fn(string $path) => str_starts_with($urlActual, ltrim($path, '/'))
    ? 'text-[#3a6a8a] bg-[#dce8f0] font-semibold'
    : 'text-slate-600 hover:text-[#4a6e8a] hover:bg-[#F4F7F6]/80 font-medium';''',
    content,
    flags=re.DOTALL
)

# 3. Reemplazar hovers sueltos a lo largo del archivo
content = content.replace('hover:text-blue-600', 'hover:text-[#4a6e8a]')
content = content.replace('hover:bg-blue-50/50', 'hover:bg-[#F4F7F6]')
content = content.replace('text-blue-600', 'text-[#4a6e8a]')
content = content.replace('bg-blue-50/80', 'bg-[#dce8f0]')

# 4. Arreglar 'Un espacio para ti'
content = re.sub(
    r'<div class=\"bg-gradient-to-b from-emerald-50/40.*?</div>\s*</div>\s*</div>',
    '''<div class="bg-gradient-to-b from-[#d8e8e2]/60 to-[#F4F7F6]/60 rounded-2xl p-4 border border-[#b0d0c4]/40 text-center relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-12 h-12 bg-[#8DA399]/30 rounded-full blur-xl opacity-50"></div>
                <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-[#E8824A]/20 rounded-full blur-xl opacity-50"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <span class="material-symbols-outlined text-[#8DA399] text-[32px] mb-2 drop-shadow-sm">spa</span>
                    <p class="text-xs text-[#3d6b5a] font-semibold mb-1">Un espacio para ti</p>
                    <p class="text-[10px] text-[#5a9080] leading-tight">Estamos aquí para escucharte y acompañarte.</p>
                </div>
            </div>
        </div>''',
    content,
    flags=re.DOTALL
)

# 5. Botones inferiores de invitado (Iniciar sesión / Registrarse)
content = re.sub(
    r'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800',
    r'bg-[#6B8CAE] hover:bg-[#5a7e9f]',
    content
)
content = content.replace('shadow-blue-100', 'shadow-slate-200')

content = re.sub(
    r'text-blue-600 dark:text-blue-400 bg-white dark:bg-slate-800 border-2 border-blue-200',
    r'text-[#4a6e8a] bg-white border-2 border-[#b5cfe0]',
    content
)
content = content.replace('hover:bg-blue-50', 'hover:bg-[#F4F7F6]')

# También modificar las clases globales de enlace en la navegación si quedaron 'blue-600'
content = content.replace('text-blue-600', 'text-[#4a6e8a]')
content = content.replace('from-blue-600', 'from-[#6B8CAE]')
content = content.replace('to-green-600', 'to-[#8DA399]')

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)
print('Sidebar updated')

import re

with open('public/css/tailwind-custom.css', 'r') as f:
    css = f.read()

# Remove the previous dark mode block
if '/* ─────────────────────────────────────────────────────────────────\n   MODO OSCURO HUMANIZADO' in css:
    css = css[:css.find('/* ─────────────────────────────────────────────────────────────────\n   MODO OSCURO HUMANIZADO')]

# Add the new strict dark mode block
strict_dark_mode = """/* ─────────────────────────────────────────────────────────────────
   MODO OSCURO HUMANIZADO: "BOSQUE NOCTURNO" (COZY & ORGANIC)
   ───────────────────────────────────────────────────────────────── */

/* 1. Fondo principal y matar la imagen */
.dark body,
.dark html,
.dark #main-content {
    background-color: #1E2624 !important;
    background-image: none !important;
    color: #E4EAE6 !important;
}
.dark #main-content::before {
    display: none !important;
}

/* 2. Tarjetas y contenedores */
.dark .glass-card,
.dark aside,
.dark header,
.dark footer,
.dark .modal-content,
.dark [class*="dark:bg-slate-800"],
.dark [class*="dark:bg-slate-900"],
.dark [class*="bg-white"] {
    background-color: #2C3634 !important;
    border-color: #3A4744 !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: none !important; 
    color: #E4EAE6 !important;
}

/* 3. Textos oscurecidos y títulos */
.dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6 {
    color: #E4EAE6 !important;
}
.dark p, .dark label, .dark span:not(.material-symbols-outlined) {
    color: #8DA399 !important;
}
.dark strong, .dark b {
    color: #E4EAE6 !important;
}

/* 4. Botones de Selección (Video, Mensaje, Imagen, Todos mis pacientes) */
.dark .tipo-btn, 
.dark [class*="border-slate-"],
.dark [class*="dark:border-red-"], 
.dark [class*="dark:border-purple-"],
.dark [class*="dark:border-indigo-"],
.dark [class*="dark:border-blue-"],
.dark [class*="dark:border-emerald-"] {
    background-color: transparent !important;
    border-color: #3A4744 !important;
    color: #8DA399 !important;
}
.dark .tipo-btn .material-symbols-outlined {
    color: #8DA399 !important;
}

/* Botones Activos (El verde relajante interactivo) */
.dark .tipo-btn.active-tipo,
.dark .active-tipo,
.dark [class*="ring-indigo-"],
.dark [class*="ring-blue-"],
.dark [class*="border-indigo-500"] {
    background-color: #4B7065 !important;
    border-color: #4B7065 !important;
    color: #E4EAE6 !important;
}
.dark .tipo-btn.active-tipo .material-symbols-outlined {
    color: #E4EAE6 !important;
}

/* Botones principales de formulario (Publicar, Guardar) */
.dark button[type="submit"], 
.dark .btn-primary,
.dark button.w-full:not(.tipo-btn) {
    background-color: #4B7065 !important;
    border-color: #4B7065 !important;
    color: #E4EAE6 !important;
    box-shadow: none !important;
}
.dark button[type="submit"]:hover, 
.dark .btn-primary:hover,
.dark button.w-full:not(.tipo-btn):hover {
    background-color: #3A5C52 !important;
}

/* 5. Inputs y Textareas */
.dark input, .dark textarea, .dark select {
    background-color: #1E2624 !important;
    border-color: #3A4744 !important;
    color: #E4EAE6 !important;
}
.dark input:focus, .dark textarea:focus, .dark select:focus {
    border-color: #4B7065 !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(75, 112, 101, 0.2) !important;
}

/* 6. Píldoras blancas como "10 recurso(s) publicados" */
.dark .rounded-full.bg-white, 
.dark [class*="bg-white/90"] {
    background-color: transparent !important;
    border: 1px solid #3A4744 !important;
    color: #8DA399 !important;
}

/* 7. ETIQUETAS (Badges) */
/* Cancelado / Error */
.dark [class*="text-red-"], .dark [class*="text-rose-"] { color: #F2D4CE !important; }
.dark [class*="bg-red-"], .dark [class*="bg-rose-"] {
    background-color: transparent !important;
    border: 1px solid #8A4538 !important;
}
/* Confirmado / Éxito */
.dark [class*="text-green-"], .dark [class*="text-emerald-"] { color: #D7E6D5 !important; }
.dark [class*="bg-green-"], .dark [class*="bg-emerald-"] {
    background-color: transparent !important;
    border: 1px solid #3A5C3D !important;
}
/* Pendiente / Info */
.dark [class*="text-blue-"], .dark [class*="text-indigo-"] { color: #D6E1E8 !important; }
.dark [class*="bg-blue-"], .dark [class*="bg-indigo-"] {
    background-color: transparent !important;
    border: 1px solid #375368 !important;
}
/* Parcial / Aviso */
.dark [class*="text-yellow-"], .dark [class*="text-amber-"], .dark [class*="text-orange-"] { color: #F5E5C9 !important; }
.dark [class*="bg-yellow-"], .dark [class*="bg-amber-"], .dark [class*="bg-orange-"] {
    background-color: transparent !important;
    border: 1px solid #7A5922 !important;
}

/* Arreglo para iconos redondos con gradientes que quedaron vivos */
.dark [style*="background:linear-gradient"] {
    background: #2C3634 !important;
    border: 1px solid #3A4744 !important;
    color: #8DA399 !important;
    box-shadow: none !important;
}
.dark [style*="background:#6B8CAE"] {
    background: #4B7065 !important;
    color: #E4EAE6 !important;
    box-shadow: none !important;
}
"""

with open('public/css/tailwind-custom.css', 'w') as f:
    f.write(css + '\n' + strict_dark_mode)


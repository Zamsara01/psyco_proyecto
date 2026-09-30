import re

with open('app/views/pages/calendario.php', 'r') as f:
    content = f.read()

style_block = """<!-- Fondo y Paleta de Colores Exclusiva del Calendario -->
<style>
    /* Variables de Paletas */
    :root {
        /* Paleta 1: Salvia y Pizarra */
        --cal-btn-main: #6B8CAE; /* #7A96AB o #6B8CAE */
        --cal-btn-hover: #7A96AB;
        --cal-sec-el: #8DA399; /* #8DA399 o #A5B8A8 */
        --cal-bg-gen: #F4F7F6;

        /* Paleta 2: Agua y Arcilla */
        --cal-accent: #639296; /* #639296 o #7A9E9F */
        --cal-accent-hover: #7A9E9F;
        --cal-card-bg: #B5C8D6;
        --cal-icon: #D99C78;

        /* Paleta 3: Bosque de Niebla */
        --cal-text-main: #2C4C54; /* #3A5A66 o #2C4C54 */
        --cal-active: #9DB096;
        --cal-prog-bg: #D1E0D9;

        /* Lectura */
        --cal-text: #334045;
    }

    /* Fondo general (#F4F7F6) sobre la imagen */
    #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-attachment: fixed !important;
    }
    #main-content::before {
        content: '';
        position: fixed;
        inset: 0;
        background: var(--cal-bg-gen) !important;
        opacity: 0.85 !important; /* Semi-transparente para ver el fondo */
        pointer-events: none;
        z-index: 0;
    }
    
    /* Textos Generales */
    #main-content * {
        color: var(--cal-text);
    }

    /* Tarjetas principales (Fondos) */
    #main-content section > div.bg-white,
    #main-content aside > div.bg-white,
    #main-content .cal-card-override {
        background-color: var(--cal-card-bg) !important;
        border-color: var(--cal-prog-bg) !important;
    }
    
    /* Textos Principales y Cabeceras */
    #main-content h3, #main-content h4, 
    #month-select, #year-select,
    .calendar-grid > div:not(.day-btn):not(.h-16),
    #selected-date-display {
        color: var(--cal-text-main) !important;
        font-weight: bold !important;
    }

    /* Botones Principales (Mes ant/sig, Botón Login) */
    #prev-month-btn, #next-month-btn,
    aside button {
        background-color: var(--cal-btn-main) !important;
        color: #FFFFFF !important;
        border: none !important;
    }
    #prev-month-btn:hover, #next-month-btn:hover,
    aside button:hover {
        background-color: var(--cal-btn-hover) !important;
    }
    
    /* Iconos */
    .material-symbols-outlined {
        color: var(--cal-icon) !important;
    }
    
    /* Calendario: Días (Celdas) */
    .day-btn {
        background-color: var(--cal-prog-bg) !important;
        border-color: var(--cal-sec-el) !important;
    }
    .day-btn:hover {
        background-color: var(--cal-active) !important;
    }
    
    /* Calendario: Día Seleccionado */
    .selected-day {
        background-color: var(--cal-active) !important;
        color: #FFFFFF !important;
        border-color: var(--cal-btn-main) !important;
    }
    .selected-day span {
        color: #FFFFFF !important;
    }
    
    /* Puntos de disponibilidad */
    .bg-green-500 { background-color: var(--cal-active) !important; }
    .bg-yellow-500 { background-color: var(--cal-icon) !important; }
    .bg-red-500 { background-color: var(--cal-btn-main) !important; }

    /* Etiquetas de disponibilidad y textos secundarios */
    .text-slate-600, .text-slate-500, .text-slate-400 {
        color: var(--cal-sec-el) !important;
    }

    /* Carrusel y Recursos */
    #tip-content > div {
        background: var(--cal-prog-bg) !important;
    }
    #tip-text {
        color: var(--cal-text-main) !important;
    }
    
    /* Acentos y Enlaces (Psicólogos) */
    .text-blue-600, .text-blue-400 {
        color: var(--cal-accent) !important;
    }
    .bg-blue-50, .bg-blue-100 {
        background-color: var(--cal-prog-bg) !important;
    }
    .border-blue-100, .border-blue-200, .border-blue-500 {
        border-color: var(--cal-accent) !important;
    }

</style>
"""

# Quitar el bloque style anterior
content = re.sub(r'<!-- Fondo exclusivo para la página del Calendario -->.*?</style>\n', '', content, flags=re.DOTALL)

# Insertar el nuevo bloque
content = style_block + "\n" + content

with open('app/views/pages/calendario.php', 'w') as f:
    f.write(content)
print("Colors applied successfully!")

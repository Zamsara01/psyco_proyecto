import re

with open('app/views/pages/calendario.php', 'r') as f:
    content = f.read()

# Remover el bloque de estilo anterior
content = re.sub(r'<!-- Fondo y Paleta de Colores Exclusiva del Calendario -->.*?</style>\n', '', content, flags=re.DOTALL)
content = re.sub(r'<!-- Fondo exclusivo para la página del Calendario -->.*?</style>\n', '', content, flags=re.DOTALL)

style_block = """<!-- Fondo y Paleta de Colores Exclusiva del Calendario -->
<style>
    /* Variables de Paletas (Con mayor saturación/tonalidad) */
    :root {
        /* Paleta 1: Salvia y Pizarra */
        --cal-btn-main: #5C81A1; /* Más azul/fuerte que 6B8CAE */
        --cal-btn-hover: #4A6E8C;
        --cal-sec-el: #6F8E80;
        --cal-bg-gen: #F4F7F6;

        /* Paleta 2: Agua y Arcilla */
        --cal-accent: #518589; /* Más saturado */
        --cal-card-bg: #9FB9CE; /* Menos gris, más azul */
        --cal-icon: #D68B61; /* Más vibrante */

        /* Paleta 3: Bosque de Niebla */
        --cal-active: #849E7C; /* Verde más vivo */
        --cal-prog-bg: #C1D4C9;
    }

    /* Fondo general */
    #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-attachment: fixed !important;
    }
    
    /* Overlay para oscurecer/aclarar sutilmente la imagen de fondo */
    #main-content::before {
        content: '';
        position: fixed;
        inset: 0;
        background: var(--cal-bg-gen) !important;
        opacity: 0.5 !important; /* Reducido para que no se vea tan opaco */
        pointer-events: none;
        z-index: 0;
    }
    
    /* 1. TEXTO NEGRO PURO UNIVERSAL (INCLUSO EN FECHAS PASADAS Y MODO OSCURO) */
    #main-content * {
        color: #000000 !important;
    }

    /* 2. ARREGLO MODO OSCURO Y TARJETAS (Sobrescribir bg-slate-800) */
    #main-content section > div,
    #main-content aside > div,
    #main-content .bg-white,
    #main-content .dark\:bg-slate-800,
    #main-content .dark\:bg-slate-700,
    #main-content .dark\:bg-slate-800\\/50 {
        background-color: var(--cal-card-bg) !important;
        border-color: var(--cal-prog-bg) !important;
    }
    
    /* Botones Principales (Mes ant/sig, Botón Login) */
    #prev-month-btn, #next-month-btn,
    aside button {
        background-color: var(--cal-btn-main) !important;
        border: 2px solid #000000 !important;
        box-shadow: 0px 2px 4px rgba(0,0,0,0.2) !important;
    }
    #prev-month-btn:hover, #next-month-btn:hover,
    aside button:hover {
        background-color: var(--cal-btn-hover) !important;
    }
    
    /* Flechas e iconos (Forzados a negro para asegurar que aparezcan) */
    .material-symbols-outlined {
        color: #000000 !important;
        opacity: 1 !important;
    }
    
    /* Calendario: Días (Celdas) */
    .day-btn, .calendar-grid > div {
        background-color: var(--cal-prog-bg) !important;
        border-color: var(--cal-sec-el) !important;
        opacity: 1 !important; /* Quitar opacidad a días pasados */
    }
    .day-btn:hover {
        background-color: var(--cal-active) !important;
    }
    
    /* Calendario: Día Seleccionado */
    .selected-day {
        background-color: var(--cal-active) !important;
        border: 2px solid #000000 !important;
        transform: scale(1.05);
    }
    
    /* Puntos de disponibilidad */
    .bg-green-500 { background-color: var(--cal-active) !important; border: 1px solid #000 !important; }
    .bg-yellow-500 { background-color: var(--cal-icon) !important; border: 1px solid #000 !important;}
    .bg-red-500 { background-color: var(--cal-btn-main) !important; border: 1px solid #000 !important;}

    /* Carrusel de Consejos y Recursos */
    #tip-content > div {
        background: var(--cal-prog-bg) !important;
        border: 1px solid var(--cal-sec-el) !important;
    }
    
    /* Acentos en elementos de psicólogos */
    .bg-blue-50, .dark\:bg-blue-900\\/30 {
        background-color: var(--cal-prog-bg) !important;
        border-color: var(--cal-accent) !important;
    }
    
    /* Quitar clases que opacan los días deshabilitados en JS */
    .cursor-not-allowed {
        opacity: 1 !important;
        cursor: default !important;
    }
</style>
"""

content = style_block + "\n" + content

with open('app/views/pages/calendario.php', 'w') as f:
    f.write(content)
print("Fixes applied!")

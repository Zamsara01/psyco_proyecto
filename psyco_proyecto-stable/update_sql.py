import re

with open('psyco_intento.sql', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
skip = False

for line in lines:
    if line.startswith('-- Estructura de tabla para la tabla `chatbot_interacciones`') or \
       line.startswith('-- Estructura de tabla para la tabla `opciones_chatbot`') or \
       line.startswith('-- Estructura de tabla para la tabla `recordatorios`') or \
       line.startswith('-- Volcado de datos para la tabla `opciones_chatbot`') or \
       line.startswith('-- Indices de la tabla `chatbot_interacciones`') or \
       line.startswith('-- Indices de la tabla `opciones_chatbot`') or \
       line.startswith('-- Indices de la tabla `recordatorios`') or \
       line.startswith('-- AUTO_INCREMENT de la tabla `chatbot_interacciones`') or \
       line.startswith('-- AUTO_INCREMENT de la tabla `opciones_chatbot`') or \
       line.startswith('-- AUTO_INCREMENT de la tabla `recordatorios`') or \
       line.startswith('-- Filtros para la tabla `chatbot_interacciones`') or \
       line.startswith('-- Filtros para la tabla `recordatorios`'):
        skip = True
        # remove previous "-- --------------------------------------------------------" or similar if any
        if len(new_lines) > 0 and new_lines[-1].strip() == '--':
            new_lines.pop()
        if len(new_lines) > 0 and new_lines[-1].strip().startswith('-- -----'):
            new_lines.pop()
            
    if skip:
        # Check if we should stop skipping
        # Usually blocks end with a blank line or start of next block
        # Let's wait for the NEXT '-- --------------------------------------------------------' or '--' followed by a normal text
        if line.startswith(') ENGINE') or line.startswith('ALTER TABLE') or line.startswith('INSERT INTO'):
            pass # still inside
    
    # Actually it's easier to use a state machine

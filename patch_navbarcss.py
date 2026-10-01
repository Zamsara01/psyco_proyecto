with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# Agregar regla para que en navbar-mode el botón se mueva dentro de la navbar
old_css = "body.navbar-mode #app-sidebar {"
new_css = """/* En navbar-mode el botón toggle se reposiciona dentro de la barra */
body.navbar-mode #layoutToggleBtn {
    position: fixed !important;
    top: 18px !important;
    left: auto !important;
    right: 12px !important; /* Lo movemos a la derecha en navbar-mode */
    z-index: 9999 !important;
}

body.navbar-mode #app-sidebar {"""

content = content.replace(old_css, new_css)

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)

print('CSS adjusted for navbar mode button position.')

import re

with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# Fix the Iniciar Sesion button
# We replaced bg-gradient-to-r from-blue-600 to-blue-700... with bg-[#6B8CAE]
# But maybe we left 'bg-gradient-to-r' there? Yes, I only replaced from-blue-600 to-blue-700 in the regex.
# The original was: bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
# And my replacement was: r'bg-[#6B8CAE] hover:bg-[#5a7e9f]' on the `from-` part. So `bg-gradient-to-r` is still there overriding the background color!

# Let's fix this specific button block.
old_login_btn = r'bg-gradient-to-r bg-\[#6B8CAE\] hover:bg-\[#5a7e9f\]'
if re.search(old_login_btn, content):
    content = re.sub(old_login_btn, 'bg-[#6B8CAE] hover:bg-[#5a7e9f]', content)
else:
    # Let's just find the exact button tag and replace its classes.
    pass

# A cleaner way: find the login button by its icon/text and fix its classes.
content = re.sub(
    r'<button onclick=\"openLoginModal\(\)\".*?</button>',
    '''<button onclick="openLoginModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-white bg-[#6B8CAE] hover:bg-[#5a7e9f] rounded-xl transition-all active:scale-[0.98] shadow-sm shadow-slate-200">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciar sesión
                </button>''',
    content,
    flags=re.DOTALL
)

# And also fix 'Registrarse' button text color which seems black in the image instead of the blue-slate.
content = re.sub(
    r'<button onclick=\"openRegisterModal\(\)\".*?</button>',
    '''<button onclick="openRegisterModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-[#4a6e8a] bg-white border-2 border-[#b5cfe0] hover:bg-[#F4F7F6] rounded-xl transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Registrarse
                </button>''',
    content,
    flags=re.DOTALL
)

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)


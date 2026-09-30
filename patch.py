import sys

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'r') as f:
    content = f.read()

with open('/home/dream/.gemini/antigravity/brain/a9313373-d5f9-4a82-bf05-f0ae636f1078/scratch/replace_left.txt', 'r') as f:
    left_str = f.read()
    
with open('/home/dream/.gemini/antigravity/brain/a9313373-d5f9-4a82-bf05-f0ae636f1078/scratch/replace_right.txt', 'r') as f:
    right_str = f.read()

# First we need to clean up the bad sed output which added backslashes
content = content.replace('<!-- Left Section: Calendar + Carousel + Nuevos Recursos stacked -->\\\n', '<!-- Left Section: Calendar + Carousel + Nuevos Recursos stacked -->\n')
import re
content = re.sub(r'\\(\n)', r'\1', content)

# Now find the right boundaries.
# Left section
start_left = content.find('<!-- Left Section: Calendar + Carousel + Nuevos Recursos stacked -->')
end_left = content.find('</section>', start_left) + len('</section>')

# Right section
start_right = content.find('<!-- Right Section: Psychologist Panel only -->')
end_right = content.find('</aside>', start_right) + len('</aside>')

new_content = content[:start_left] + left_str + content[end_left:start_right] + right_str + content[end_right:]

# Also fix the weird extra </section> around line 104 in original code
new_content = new_content.replace('</aside>\n\n            <div class="px-6 pt-4 mt-auto">\n    </section>', '</aside>')

with open('/opt/lampp/htdocs/psyco_proyecto-davidBackend1/app/views/pages/calendario.php', 'w') as f:
    f.write(new_content)

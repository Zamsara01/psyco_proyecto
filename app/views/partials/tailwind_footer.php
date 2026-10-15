<?php
$lineasAyuda = [
    [
        'nombre' => 'Línea 106',
        'tel'    => 'tel:106',
        'desc'   => 'Gratuita, 24 horas'
    ],
    [
        'nombre' => 'Emergencias 123',
        'tel'    => 'tel:123',
        'desc'   => 'Atención inmediata'
    ],
];

$correoContacto = 'contacto@psyco.com';

$userRol = $_SESSION['user']['rol'] ?? null;

$enlacesPlataforma = [];
if (!$userRol) {
    $enlacesPlataforma = [
        ['texto' => 'Iniciar sesión', 'url' => URL_BASE . 'users/login'],
        ['texto' => 'Registrarse', 'url' => URL_BASE . 'users/register'],
    ];
} elseif ($userRol === 'paciente') {
    $enlacesPlataforma = [
        ['texto' => 'Mis Citas', 'url' => URL_BASE . 'citas/misCitas'],
        ['texto' => 'Mis Recursos', 'url' => URL_BASE . 'citas/misRecursos'],
        ['texto' => 'Calendario', 'url' => URL_BASE . 'calendario'],
    ];
} elseif ($userRol === 'psicologo') {
    $enlacesPlataforma = [
        ['texto' => 'Mi Panel', 'url' => URL_BASE . 'panel_psicologas'],
        ['texto' => 'Recursos', 'url' => URL_BASE . 'panel_psicologas/recursos'],
        ['texto' => 'Notas de Pacientes', 'url' => URL_BASE . 'panel_psicologas/notasPacientes'],
        ['texto' => 'Calendario', 'url' => URL_BASE . 'calendario'],
    ];
} elseif ($userRol === 'superusuario' || $userRol === 'administrador') {
    $enlacesPlataforma = [
        ['texto' => 'Usuarios', 'url' => URL_BASE . 'superusuario/usuarios'],
        ['texto' => 'Especialidades', 'url' => URL_BASE . 'superusuario/especialidades'],
        ['texto' => 'Auditoría', 'url' => URL_BASE . 'superusuario/auditoria'],
        ['texto' => 'Reportes', 'url' => URL_BASE . 'superusuario/reportes'],
        ['texto' => 'Exportaciones', 'url' => URL_BASE . 'superusuario/exportaciones'],
    ];
}
?>
<footer class="bg-white/80 dark:bg-[#2a2926] backdrop-blur-sm border-t border-slate-200/60 dark:border-white/5 py-10 px-6 sm:px-10 mt-auto transition-colors">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <img src="<?= URL_BASE ?>public/img/psyco.png" alt="Logo PSYCO" class="h-9 w-auto object-contain">
                <span class="text-lg font-bold text-on-surface dark:text-[#E4EAE6] tracking-tight">PSYCO</span>
            </div>
            <p class="text-body-sm text-on-surface-variant dark:text-[#a39c8e] leading-relaxed">
                Plataforma de acompañamiento psicológico y bienestar emocional institucional.
            </p>
        </div>

        <nav aria-label="Enlaces de la plataforma">
            <p class="text-sm font-bold text-on-surface dark:text-[#E4EAE6] uppercase tracking-wider mb-3">Plataforma</p>
            <ul class="space-y-2">
                <?php foreach ($enlacesPlataforma as $enlace): ?>
                <li>
                    <a href="<?= htmlspecialchars($enlace['url']) ?>" class="text-body-sm text-on-surface-variant dark:text-[#a39c8e] hover:text-primary dark:hover:text-[#E4EAE6] transition-colors rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                        <?= htmlspecialchars($enlace['texto']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <nav aria-label="Líneas de ayuda y emergencias">
            <p class="text-sm font-bold text-on-surface dark:text-[#E4EAE6] uppercase tracking-wider mb-3">Líneas de Ayuda</p>
            <ul class="space-y-2">
                <?php foreach ($lineasAyuda as $linea): ?>
                <li>
                    <a href="<?= htmlspecialchars($linea['tel']) ?>" class="group block rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                        <span class="text-body-sm font-semibold text-primary dark:text-[#E4EAE6] group-hover:underline">
                            <?= htmlspecialchars($linea['nombre']) ?>
                        </span>
                        <span class="block text-xs text-on-surface-variant dark:text-[#a39c8e]">
                            <?= htmlspecialchars($linea['desc']) ?>
                        </span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <nav aria-label="Enlaces legales y de contacto">
            <p class="text-sm font-bold text-on-surface dark:text-[#E4EAE6] uppercase tracking-wider mb-3">Legal y Contacto</p>
            <ul class="space-y-2">
                <li>
                    <a href="<?= URL_BASE ?>pages/terminos" class="text-body-sm text-on-surface-variant dark:text-[#a39c8e] hover:text-primary dark:hover:text-[#E4EAE6] transition-colors rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                        Términos y Condiciones
                    </a>
                </li>
                <li>
                    <a href="mailto:<?= htmlspecialchars($correoContacto) ?>" class="text-body-sm text-on-surface-variant dark:text-[#a39c8e] hover:text-primary dark:hover:text-[#E4EAE6] transition-colors rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                        <?= htmlspecialchars($correoContacto) ?>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto mt-8 pt-6 border-t border-slate-200/60 dark:border-white/5 flex flex-col md:flex-row items-center justify-between gap-3 text-center md:text-left">
        <p class="text-xs text-on-surface-variant dark:text-[#a39c8e]">
            &copy; <?= date('Y') ?> PSYCO — Todos los derechos reservados.
        </p>
        <p class="text-xs text-on-surface-variant dark:text-[#a39c8e]">
            PSYCO es una herramienta de orientación y no reemplaza la atención médica de urgencias.
        </p>
    </div>
</footer>

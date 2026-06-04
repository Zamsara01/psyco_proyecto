<!-- Background Content (Chat Interface Preview) -->
<main class="flex-1 relative flex flex-col p-container-margin z-0">
    <div class="absolute inset-0 bg-pattern"></div>
    <div class="max-w-2xl mx-auto w-full mt-10 space-y-6 opacity-40 select-none">
        <!-- Bot Message -->
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined">smart_toy</span>
            </div>
            <div class="bg-secondary text-white p-4 rounded-2xl rounded-tl-none shadow-sm max-w-[80%]">
                <p class="font-body-md">Bienvenido de nuevo. Estoy aquí para asistirte con tus gestiones de hoy.</p>
            </div>
        </div>
        <!-- User Placeholder -->
        <div class="flex gap-4 justify-end">
            <div class="bg-surface-container-high text-on-surface-variant p-4 rounded-2xl rounded-tr-none shadow-sm max-w-[80%]">
                <p class="font-body-md">Gracias, necesito revisar mi agenda.</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined">person</span>
            </div>
        </div>
        <div class="flex justify-center py-stack-lg">
            <img class="w-full h-48 object-cover rounded-3xl opacity-20 grayscale" src="https://lh3.googleusercontent.com/aida/ADBb0ujT_BkncGJRm488ezTWx0WdWAp79skGXwCDMM-it3AXACsDej_IqV71GKaxPeVbnVFQjMfEVX07sFi4ONE5BGfewQ4cz7dIVx9V2RRBULVFKHALO5X9tFkDeR_EYXGIpZoPqXIEI2a3dxj7V4LOv5T1Crybn2LDuVHPh5LWA-P6M-352xVhra7QjKH24ANfF0TRB1TC45CGFrdGMn43nPMLonIyQ0A8pZEI7PrFIPOzy3rYlK6r8MOwB_1EUEojzwMLjNbYESYO_2U"/>
        </div>
    </div>
</main>

<!-- Bottom Drawer Overlay -->
<div class="fixed inset-0 bg-on-surface/20 z-50 flex flex-col justify-end">
    <div class="bg-white/95 drawer-blur w-full max-w-3xl mx-auto rounded-t-[32px] shadow-[0_-8px_40px_rgba(0,0,0,0.12)] p-6 md:p-10 transform translate-y-0 transition-transform">
        <!-- Handle -->
        <div class="flex justify-center mb-8">
            <div class="w-12 h-1.5 bg-surface-container-highest rounded-full"></div>
        </div>
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="font-headline-md text-on-surface mb-2">Hola, ¿en qué te puedo ayudar hoy?</h1>
            <p class="text-tertiary font-body-sm">Selecciona una de las opciones frecuentes para comenzar.</p>
        </div>
        <!-- Interactive Grid Buttons -->
        <div class="grid grid-cols-2 gap-4 md:gap-6">
            <!-- Agenda Cita -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined !text-3xl">calendar_month</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center">Agenda Cita</span>
            </button>
            <!-- Cancelar Cita -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined !text-3xl">cancel</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center">Cancelar Cita</span>
            </button>
            <!-- Reprogramar -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined !text-3xl">sync</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center">Reprogramar</span>
            </button>
            <!-- Recursos de ayuda -->
            <button class="group flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-[24px] shadow-sm hover:shadow-md hover:border-orange-200 transition-all active:scale-[0.98] duration-150 text-left w-full">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined !text-3xl">auto_stories</span>
                </div>
                <span class="font-headline-sm text-slate-800 text-center text-balance">Recursos de ayuda</span>
            </button>
        </div>
        <!-- Bottom Spacer for SafeArea -->
        <div class="h-8"></div>
    </div>
</div>

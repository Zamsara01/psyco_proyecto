tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "primary": "#0c6e00", // Verde unificado para acciones principales
                "primary-container": "#46b033",
                "on-primary": "#ffffff",
                "on-primary-container": "#043c00",
                "inverse-primary": "#73de5b",
                "primary-fixed": "#8ffb74",
                "primary-fixed-dim": "#73de5b",
                "on-primary-fixed": "#012200",
                "on-primary-fixed-variant": "#075300",
                
                "secondary": "#455e90",
                "secondary-container": "#adc6ff",
                "on-secondary": "#ffffff",
                "on-secondary-container": "#385283",
                "secondary-fixed": "#d8e2ff",
                "secondary-fixed-dim": "#adc6ff",
                "on-secondary-fixed": "#001a41",
                "on-secondary-fixed-variant": "#2c4676",

                "tertiary": "#605e59",
                "tertiary-container": "#9d9a94",
                "on-tertiary": "#ffffff",
                "on-tertiary-container": "#34322e",
                "tertiary-fixed": "#e7e2db",
                "tertiary-fixed-dim": "#cac6bf",
                "on-tertiary-fixed": "#1d1b17",
                "on-tertiary-fixed-variant": "#494742",

                "error": "#ba1a1a",
                "error-container": "#ffdad6",
                "on-error": "#ffffff",
                "on-error-container": "#93000a",

                "surface": "#f8f9fb",
                "surface-dim": "#d9dadc",
                "surface-bright": "#f8f9fb",
                "surface-container-lowest": "#ffffff",
                "surface-container-low": "#f3f4f6",
                "surface-container": "#edeef0",
                "surface-container-high": "#e7e8ea",
                "surface-container-highest": "#e1e2e4",
                "on-surface": "#191c1e",
                "on-surface-variant": "#584237",
                "outline": "#8c7164",
                "outline-variant": "#e0c0b1",
                "inverse-surface": "#2e3132",
                "inverse-on-surface": "#f0f1f3",
                "surface-tint": "#0c6e00",
                "background": "#f8f9fb",
                "on-background": "#191c1e",
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            spacing: {
                "unit": "8px",
                "stack-sm": "8px",
                "stack-md": "16px",
                "gutter": "16px",
                "container-margin": "24px",
                "stack-lg": "32px",
            },
            fontFamily: {
                "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                "body-md": ["Plus Jakarta Sans", "sans-serif"],
                "body-sm": ["Plus Jakarta Sans", "sans-serif"],
                "label-md": ["Plus Jakarta Sans", "sans-serif"],
            },
            fontSize: {
                "headline-lg": ["32px", {"lineHeight": "1.2", "fontWeight": "700"}],
                "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                "body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                "label-md": ["12px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
            }
        }
    }
};

<style>
/* ============================================
   UNIFIED THEME SYSTEM - Use these everywhere!
   ============================================ */
:root {
    /* Primary Colors */
    --primary: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-light: #eaf2ff;

    /* Backgrounds */
    --bg: #ffffff;
    --bg-subtle: #fafafa;
    --bg-muted: #f4f4f5;

    /* Text */
    --text: #18181b;
    --text-subtle: #52525b;
    --text-muted: #a1a1aa;

    /* Borders */
    --border: #e4e4e7;
    --border-hover: #d4d4d8;

    /* Status Colors */
    --success: #22c55e;
    --warning: #eab308;
    --danger: #ef4444;
    --info: #3b82f6;

    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

    /* Radius */
    --radius: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;

    /* Spacing */
    --sidebar-width: 260px;
}

/* ============================================
   DARK THEME - Complete Override
   ============================================ */
body.dark-theme {
    --bg: #09090b;
    --bg-subtle: #18181b;
    --bg-muted: #27272a;

    --text: #fafafa;
    --text-subtle: #a1a1aa;
    --text-muted: #52525b;

    --border: #27272a;
    --border-hover: #3f3f46;

    --primary: #3b82f6;
    --primary-hover: #2563eb;
    --primary-light: rgba(59, 130, 246, 0.1);
}

/* Dark theme image adjustments */
body.dark-theme img {
    opacity: 0.9;
}

body.dark-theme .book-card-image,
body.dark-theme .profile-avatar {
    border: 1px solid var(--border);
}
</style>
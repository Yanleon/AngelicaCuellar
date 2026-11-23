<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Panel de Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
      :root {
        --bg-main: #0f172a;
        --bg-card: #1e293b;
        --bg-card-hover: #243147;
        --bg-input: #182234;
        --border-color: #334155;
        --border-subtle: rgba(255, 255, 255, 0.07);
        --text-primary: #f8fafc;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        --accent-indigo: #6366f1;
        --accent-indigo-hover: #4f46e5;
        --accent-emerald: #10b981;
        --accent-amber: #f59e0b;
        --accent-blue: #3b82f6;
      }

      * { box-sizing: border-box; }
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100vh;
        background-color: var(--bg-main);
        color: var(--text-primary);
        font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
      }

      a { color: inherit; text-decoration: none; }

      .app-layout {
        display: flex;
        width: 100%;
        min-height: 100vh;
      }

      /* Sidebar Navigation */
      .app-sidebar {
        width: 260px;
        flex-shrink: 0;
        background-color: var(--bg-card);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        height: 100vh;
        z-index: 30;
      }

      .sidebar-header {
        padding: 24px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid var(--border-color);
      }

      .brand-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-indigo), #818cf8);
        color: white;
        display: grid;
        place-items: center;
        font-weight: 800;
        font-size: 1.2rem;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
      }

      .brand-title strong { display: block; font-size: 0.98rem; font-weight: 700; color: var(--text-primary); }
      .brand-title span { font-size: 0.78rem; color: var(--text-muted); }

      .sidebar-nav {
        flex: 1;
        padding: 20px 14px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 4px;
      }

      .nav-group-title {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-dim);
        margin: 16px 10px 8px;
      }

      .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 10px;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
      }

      .nav-item:hover {
        color: var(--text-primary);
        background-color: rgba(255, 255, 255, 0.04);
      }

      .nav-item.active {
        color: #ffffff;
        background-color: var(--accent-indigo);
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
      }

      .nav-item svg {
        width: 18px;
        height: 18px;
        opacity: 0.8;
      }

      .nav-item.active svg {
        opacity: 1;
      }

      .sidebar-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border-color);
        background-color: rgba(0, 0, 0, 0.15);
      }

      .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.03);
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .logout-btn:hover {
        background-color: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.2);
      }

      /* Main Content Area */
      .app-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
      }

      .top-bar {
        height: 70px;
        padding: 0 36px;
        border-bottom: 1px solid var(--border-color);
        background-color: var(--bg-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: sticky;
        top: 0;
        z-index: 20;
      }

      .page-header h1 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
      }

      .page-header p {
        margin: 2px 0 0;
        font-size: 0.82rem;
        color: var(--text-muted);
      }

      .top-actions {
        display: flex;
        align-items: center;
        gap: 14px;
      }

      .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
      }

      .btn-secondary {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: var(--border-color);
        color: var(--text-primary);
      }

      .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.09);
        border-color: #475569;
      }

      .btn-primary {
        background-color: var(--accent-indigo);
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
      }

      .btn-primary:hover {
        background-color: var(--accent-indigo-hover);
      }

      .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #475569, #334155);
        color: white;
        display: grid;
        place-items: center;
        font-weight: 700;
        font-size: 0.88rem;
        border: 2px solid var(--border-color);
      }

      /* Dashboard Content Body */
      .dashboard-body {
        padding: 32px 36px;
        display: flex;
        flex-direction: column;
        gap: 28px;
        width: 100%;
      }

      /* Grid System */
      .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        width: 100%;
      }

      .stat-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        transition: transform 0.2s ease, border-color 0.2s ease;
      }

      .stat-card:hover {
        border-color: #475569;
        transform: translateY(-2px);
      }

      .stat-info p {
        margin: 0 0 6px;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-muted);
      }

      .stat-info h2 {
        margin: 0 0 8px;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-primary);
      }

      .stat-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 999px;
      }

      .stat-tag.success { background-color: rgba(16, 185, 129, 0.12); color: var(--accent-emerald); }
      .stat-tag.info { background-color: rgba(99, 102, 241, 0.12); color: var(--accent-indigo); }
      .stat-tag.warning { background-color: rgba(245, 158, 11, 0.12); color: var(--accent-amber); }

      .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background-color: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-subtle);
        color: var(--accent-indigo);
      }

      /* Charts Section */
      .charts-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr;
        gap: 20px;
        width: 100%;
      }

      .card-panel {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 22px;
        display: flex;
        flex-direction: column;
      }

      .card-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .card-panel-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
      }

      .select-sm {
        background-color: var(--bg-input);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        outline: none;
      }

      .chart-container {
        position: relative;
        width: 100%;
        height: 180px;
      }

      .chart-container svg {
        width: 100%;
        height: 100%;
      }

      .chart-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid var(--border-subtle);
        font-size: 0.78rem;
        color: var(--text-dim);
      }

      /* Bar Chart */
      .bars-wrapper {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 180px;
        padding: 0 10px;
      }

      .bar-item {
        width: 12%;
        background: linear-gradient(180deg, var(--accent-indigo), rgba(99, 102, 241, 0.3));
        border-radius: 4px 4px 0 0;
        transition: height 0.3s ease;
      }

      /* Donut Chart */
      .donut-content {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 10px;
      }

      .donut-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(
          var(--accent-indigo) 0deg 162deg,
          var(--accent-emerald) 162deg 270deg,
          var(--accent-amber) 270deg 324deg,
          var(--accent-blue) 324deg 360deg
        );
        position: relative;
        flex-shrink: 0;
      }

      .donut-circle::after {
        content: "";
        position: absolute;
        inset: 24px;
        border-radius: 50%;
        background-color: var(--bg-card);
      }

      .legend-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
      }

      .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.82rem;
      }

      .legend-label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
      }

      .dot-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
      }

      /* Content Modules Grid */
      .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
      }

      .section-heading h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
      }

      .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
        width: 100%;
      }

      .module-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: all 0.2s ease;
      }

      .module-card:hover {
        border-color: var(--accent-indigo);
        background-color: var(--bg-card-hover);
        transform: translateY(-2px);
      }

      .module-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: rgba(99, 102, 241, 0.12);
        color: var(--accent-indigo);
        font-size: 0.82rem;
        font-weight: 800;
      }

      .module-card h4 {
        margin: 0;
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--text-primary);
      }

      .module-card p {
        margin: 0;
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.45;
      }

      /* Bottom Row Grid */
      .bottom-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        width: 100%;
      }

      .messages-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
      }

      .message-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-subtle);
      }

      .sender-info {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .sender-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #334155;
        color: white;
        display: grid;
        place-items: center;
        font-weight: 700;
        font-size: 0.9rem;
      }

      .sender-details strong { display: block; font-size: 0.88rem; color: var(--text-primary); }
      .sender-details p { margin: 2px 0 0; font-size: 0.78rem; color: var(--text-muted); }

      .message-time {
        font-size: 0.76rem;
        color: var(--text-dim);
        padding: 4px 10px;
        border-radius: 999px;
        background-color: rgba(255, 255, 255, 0.05);
      }

      /* Responsive Media Queries */
      @media (max-width: 1280px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-grid { grid-template-columns: 1fr; }
        .bottom-grid { grid-template-columns: 1fr; }
      }

      @media (max-width: 900px) {
        .app-sidebar {
          width: 80px;
        }
        .sidebar-header .brand-title,
        .nav-group-title,
        .nav-item span,
        .sidebar-footer span {
          display: none;
        }
        .sidebar-header { justify-content: center; padding: 18px 0; }
        .nav-item { justify-content: center; padding: 12px 0; }
        .top-bar { padding: 0 20px; }
        .dashboard-body { padding: 20px; }
      }

      @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
        .modules-grid { grid-template-columns: 1fr; }
        .app-sidebar { display: none; }
      }
    </style>
  </head>
  <body>
    @php
      $modules = [
        ['key' => 'general', 'label' => 'General', 'text' => 'SEO, identidad y datos de contacto.'],
        ['key' => 'portada', 'label' => 'Portada', 'text' => 'Título, botones e imagen de encabezado.'],
        ['key' => 'metricas', 'label' => 'Métricas', 'text' => 'Indicadores de rendimiento profesional.'],
        ['key' => 'sobre-mi', 'label' => 'Sobre mí', 'text' => 'Presentación, bio y fortalezas.'],
        ['key' => 'experiencia', 'label' => 'Experiencia', 'text' => 'Servicios y áreas de trabajo.'],
        ['key' => 'marcas', 'label' => 'Marcas', 'text' => 'Logos e historial de clientes.'],
        ['key' => 'herramientas', 'label' => 'Herramientas', 'text' => 'Aplicaciones que dominas y tu nivel.'],
        ['key' => 'proyectos', 'label' => 'Proyectos', 'text' => 'Galería de casos y descripciones.'],
        ['key' => 'contacto', 'label' => 'Contacto', 'text' => 'Frase destacada y textos finales.'],
        ['key' => 'cv', 'label' => 'Hoja de Vida (CV)', 'text' => 'Gestión y selección de PDFs descargables.'],
      ];
    @endphp

    <div class="app-layout">
      <!-- Sidebar Navigation -->
      <aside class="app-sidebar">
        <div class="sidebar-header">
          <div class="brand-icon">A</div>
          <div class="brand-title">
            <strong>Angélica Cuéllar</strong>
            <span>Admin Panel</span>
          </div>
        </div>

        <nav class="sidebar-nav">
          <div class="nav-group-title">Principal</div>
          <a class="nav-item active" href="{{ route('admin.dashboard') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Dashboard</span>
          </a>

          <div class="nav-group-title">Edición de Contenido</div>
          @foreach ($modules as $mod)
            <a class="nav-item" href="{{ route('admin.content.edit', ['section' => $mod['key']]) }}">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10"/><path d="M7 12h10"/><path d="M7 16h6"/></svg>
              <span>{{ $loop->iteration }}. {{ $mod['label'] }}</span>
            </a>
          @endforeach

          <div class="nav-group-title">Interacción</div>
          <a class="nav-item" href="{{ route('admin.messages') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
            <span>Mensajes ({{ $messagesCount }})</span>
          </a>

          <div class="nav-group-title">Seguridad & Cuentas</div>
          <a class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Usuarios & Clave</span>
          </a>
        </nav>

        <div class="sidebar-footer">
          <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button class="logout-btn" type="submit">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              <span>Cerrar Sesión</span>
            </button>
          </form>
        </div>
      </aside>

      <!-- Main Layout Content -->
      <main class="app-main">
        <!-- Top Bar Header -->
        <header class="top-bar">
          <div class="page-header">
            <h1>Dashboard de Control</h1>
            <p>Bienvenida de nuevo, Angélica. Aquí tienes el estado en tiempo real de tu sitio.</p>
          </div>

          <div class="top-actions">
            <a class="btn btn-secondary" href="{{ route('portfolio.show') }}" target="_blank">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              Ver sitio público
            </a>
            <a class="btn btn-primary" href="{{ route('admin.content.edit', ['section' => 'general']) }}">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
              Editar Portafolio
            </a>
            <div class="user-avatar" title="Angélica Cuéllar">AC</div>
          </div>
        </header>

        <!-- Dashboard Body Content -->
        <div class="dashboard-body">
          <!-- Top Stats Row -->
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-info">
                <p>Mensajes Recibidos</p>
                <h2>{{ $messagesCount }}</h2>
                <span class="stat-tag success">↑ {{ $messagesCount }} Formularios</span>
              </div>
              <div class="stat-icon-wrapper">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-info">
                <p>Módulos de Contenido</p>
                <h2>9</h2>
                <span class="stat-tag info">Activos en Laravel</span>
              </div>
              <div class="stat-icon-wrapper">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-info">
                <p>Secciones Públicas</p>
                <h2>7</h2>
                <span class="stat-tag info">Visibles a Clientes</span>
              </div>
              <div class="stat-icon-wrapper">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-info">
                <p>Estado del Sitio</p>
                <h2>En Línea</h2>
                <span class="stat-tag success">● Sistema Operativo</span>
              </div>
              <div class="stat-icon-wrapper" style="color: var(--accent-emerald);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              </div>
            </div>
          </div>

          <!-- Charts Row -->
          <div class="charts-grid">
            <div class="card-panel">
              <div class="card-panel-header">
                <h3>Visitas al Portafolio</h3>
                <select class="select-sm"><option>Año 2026</option></select>
              </div>
              <div class="chart-container">
                <svg viewBox="0 0 400 180" preserveAspectRatio="none">
                  <defs>
                    <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                      <stop offset="0%" stop-color="#6366f1" stop-opacity="0.35"/>
                      <stop offset="100%" stop-color="#6366f1" stop-opacity="0.0"/>
                    </linearGradient>
                  </defs>
                  <path d="M0 140 Q 60 90, 120 110 T 240 70 T 360 40 L 400 30 L 400 180 L 0 180 Z" fill="url(#areaGrad)"/>
                  <path d="M0 140 Q 60 90, 120 110 T 240 70 T 360 40 L 400 30" fill="none" stroke="#6366f1" stroke-width="3"/>
                </svg>
              </div>
              <div class="chart-labels">
                <span>Ene</span><span>Feb</span><span>Mar</span><span>Abr</span><span>May</span><span>Jun</span>
              </div>
            </div>

            <div class="card-panel">
              <div class="card-panel-header">
                <h3>Interacción por Proyecto</h3>
                <select class="select-sm"><option>Mensual</option></select>
              </div>
              <div class="bars-wrapper">
                <div class="bar-item" style="height: 55%;"></div>
                <div class="bar-item" style="height: 40%;"></div>
                <div class="bar-item" style="height: 85%;"></div>
                <div class="bar-item" style="height: 60%;"></div>
                <div class="bar-item" style="height: 75%;"></div>
                <div class="bar-item" style="height: 90%;"></div>
              </div>
              <div class="chart-labels">
                <span>Ene</span><span>Feb</span><span>Mar</span><span>Abr</span><span>May</span><span>Jun</span>
              </div>
            </div>

            <div class="card-panel">
              <div class="card-panel-header">
                <h3>Fuentes de Tráfico</h3>
                <span class="select-sm">Directo & Redes</span>
              </div>
              <div class="donut-content">
                <div class="donut-circle"></div>
                <div class="legend-list">
                  <div class="legend-item">
                    <div class="legend-label"><span class="dot-indicator" style="background-color: var(--accent-indigo);"></span> Directo</div>
                    <strong>45%</strong>
                  </div>
                  <div class="legend-item">
                    <div class="legend-label"><span class="dot-indicator" style="background-color: var(--accent-emerald);"></span> Búsqueda</div>
                    <strong>30%</strong>
                  </div>
                  <div class="legend-item">
                    <div class="legend-label"><span class="dot-indicator" style="background-color: var(--accent-amber);"></span> Social</div>
                    <strong>15%</strong>
                  </div>
                  <div class="legend-item">
                    <div class="legend-label"><span class="dot-indicator" style="background-color: var(--accent-blue);"></span> Referidos</div>
                    <strong>10%</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Modules Section -->
          <div>
            <div class="section-heading">
              <h2>Módulos de Edición del Sitio</h2>
              <span style="font-size: 0.82rem; color: var(--text-muted);">Selecciona un módulo para editar sus textos o imágenes</span>
            </div>

            <div class="modules-grid">
              @foreach ($modules as $mod)
                <a class="module-card" href="{{ route('admin.content.edit', ['section' => $mod['key']]) }}">
                  <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="module-badge">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-dim);"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                  </div>
                  <h4>{{ $mod['label'] }}</h4>
                  <p>{{ $mod['text'] }}</p>
                </a>
              @endforeach
            </div>
          </div>

          <!-- Bottom Grid: Messages & Overview -->
          <div class="bottom-grid">
            <div class="card-panel">
              <div class="card-panel-header">
                <h3>Contactos y Mensajes Recientes</h3>
                <a class="btn btn-secondary" href="{{ route('admin.messages') }}" style="padding: 5px 12px; font-size: 0.78rem;">Ver todos los mensajes →</a>
              </div>

              <div class="messages-list">
                @forelse ($latestMessages as $message)
                  <div class="message-item">
                    <div class="sender-info">
                      <div class="sender-avatar">{{ strtoupper(mb_substr($message->name, 0, 1)) }}</div>
                      <div class="sender-details">
                        <strong>{{ $message->name }}</strong>
                        <p>{{ $message->email }} @if($message->company) • {{ $message->company }} @endif</p>
                      </div>
                    </div>
                    <span class="message-time">{{ $message->created_at?->format('d M, Y') }}</span>
                  </div>
                @empty
                  <div class="message-item">
                    <div class="sender-info">
                      <div class="sender-avatar">0</div>
                      <div class="sender-details">
                        <strong>No hay mensajes registrados aún</strong>
                        <p>Los formularios enviados desde la web aparecerán automáticamente aquí.</p>
                      </div>
                    </div>
                    <span class="message-time">Sin mensajes</span>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>

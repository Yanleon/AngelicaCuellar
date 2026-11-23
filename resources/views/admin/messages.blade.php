<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mensajes Recibidos | Panel de Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
      :root {
        --bg-main: #0f172a;
        --bg-card: #1e293b;
        --bg-card-hover: #243147;
        --border-color: #334155;
        --border-subtle: rgba(255, 255, 255, 0.07);
        --text-primary: #f8fafc;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        --accent-indigo: #6366f1;
        --accent-emerald: #10b981;
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
      button { font: inherit; }

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

      /* Messages Layout */
      .messages-body {
        padding: 32px 36px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
      }

      .message-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: border-color 0.2s ease;
      }

      .message-card:hover {
        border-color: #475569;
      }

      .message-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
      }

      .sender-profile {
        display: flex;
        align-items: center;
        gap: 14px;
      }

      .avatar-large {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-indigo), #818cf8);
        color: white;
        display: grid;
        place-items: center;
        font-weight: 800;
        font-size: 1.1rem;
      }

      .sender-meta strong { display: block; font-size: 1rem; color: var(--text-primary); }
      .sender-meta span { font-size: 0.84rem; color: var(--text-muted); }

      .message-date {
        font-size: 0.78rem;
        color: var(--accent-indigo);
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 999px;
        background-color: rgba(99, 102, 241, 0.12);
      }

      .message-text {
        color: #cbd5e1;
        font-size: 0.94rem;
        line-height: 1.6;
        padding: 14px;
        border-radius: 8px;
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-subtle);
        margin: 0;
      }

      /* Responsive Rules */
      @media (max-width: 900px) {
        .app-sidebar { width: 80px; }
        .sidebar-header .brand-title, .nav-group-title, .nav-item span, .sidebar-footer span { display: none; }
        .sidebar-header { justify-content: center; padding: 18px 0; }
        .nav-item { justify-content: center; padding: 12px 0; }
        .top-bar { padding: 0 20px; }
        .messages-body { padding: 20px; }
      }

      @media (max-width: 640px) {
        .app-sidebar { display: none; }
      }
    </style>
  </head>
  <body>
    @php
      $modules = [
        ['key' => 'general', 'label' => 'General'],
        ['key' => 'portada', 'label' => 'Portada'],
        ['key' => 'metricas', 'label' => 'Métricas'],
        ['key' => 'sobre-mi', 'label' => 'Sobre mí'],
        ['key' => 'experiencia', 'label' => 'Experiencia'],
        ['key' => 'marcas', 'label' => 'Marcas'],
        ['key' => 'herramientas', 'label' => 'Herramientas'],
        ['key' => 'proyectos', 'label' => 'Proyectos'],
        ['key' => 'contacto', 'label' => 'Contacto'],
        ['key' => 'cv', 'label' => 'Hoja de Vida (CV)'],
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
          <a class="nav-item" href="{{ route('admin.dashboard') }}">
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
          <a class="nav-item active" href="{{ route('admin.messages') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
            <span>Mensajes ({{ count($messages) }})</span>
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
            <h1>Bandeja de Mensajes Recibidos</h1>
            <p>Formularios de contacto enviados por potenciales clientes desde la web pública.</p>
          </div>

          <div class="top-actions">
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
              Dashboard
            </a>
            <a class="btn btn-secondary" href="{{ route('portfolio.show') }}" target="_blank">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              Ver sitio público
            </a>
            <div class="user-avatar" title="Angélica Cuéllar">AC</div>
          </div>
        </header>

        <!-- Messages Body -->
        <div class="messages-body">
          @forelse ($messages as $message)
            <div class="message-card">
              <div class="message-head">
                <div class="sender-profile">
                  <div class="avatar-large">{{ strtoupper(mb_substr($message->name, 0, 1)) }}</div>
                  <div class="sender-meta">
                    <strong>{{ $message->name }}</strong>
                    <span>{{ $message->email }} @if($message->company) • Empresa: {{ $message->company }} @endif</span>
                  </div>
                </div>
                <span class="message-date">{{ $message->created_at?->format('d/m/Y H:i') }}</span>
              </div>
              <p class="message-text">{{ $message->message }}</p>
            </div>
          @empty
            <div class="message-card" style="text-align: center; padding: 40px; color: var(--text-muted);">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; color: var(--text-dim);"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
              <h3 style="margin: 0 0 6px; color: var(--text-primary);">No hay mensajes en la bandeja</h3>
              <p style="margin: 0;">Cuando tus visitantes completen el formulario de contacto en el portafolio, sus mensajes aparecerán aquí.</p>
            </div>
          @endforelse
        </div>
      </main>
    </div>
  </body>
</html>

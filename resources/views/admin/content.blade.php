<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Contenido | Panel de Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
      :root {
        --bg-main: #0f172a;
        --bg-card: #1e293b;
        --bg-card-hover: #243147;
        --bg-input: #0b1329;
        --border-color: #334155;
        --border-subtle: rgba(255, 255, 255, 0.08);
        --text-primary: #f8fafc;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        --accent-indigo: #6366f1;
        --accent-indigo-hover: #4f46e5;
        --accent-emerald: #10b981;
        --accent-amber: #f59e0b;
        --accent-red: #ef4444;
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
        padding: 12px 22px;
        border-radius: 10px;
        font-size: 0.95rem;
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
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
      }

      .btn-primary:hover {
        background-color: var(--accent-indigo-hover);
      }

      .btn-danger {
        background-color: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.25);
      }

      .btn-danger:hover {
        background-color: rgba(239, 68, 68, 0.25);
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

      /* Content Body Layout */
      .editor-body {
        padding: 36px 40px;
        display: flex;
        flex-direction: column;
        gap: 28px;
        width: 100%;
      }

      .alert-status {
        padding: 16px 20px;
        border-radius: 12px;
        background-color: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .alert-error {
        padding: 16px 20px;
        border-radius: 12px;
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #fca5a5;
        font-size: 0.95rem;
      }

      .alert-error strong {
        display: block;
        margin-bottom: 6px;
        color: #fecaca;
      }

      .alert-error ul {
        margin: 0;
        padding-left: 20px;
      }

      .field-error {
        color: #fca5a5;
        font-size: 0.85rem;
      }

      .field-hint {
        color: var(--text-muted, #94a3b8);
        font-size: 0.85rem;
      }

      .editor-container {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 36px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      }

      .editor-header {
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-subtle);
      }

      .editor-header h2 {
        margin: 0 0 6px;
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.02em;
      }

      .editor-header p {
        margin: 0;
        font-size: 0.92rem;
        color: var(--text-muted);
      }

      /* Large Comfortable Form Fields Styling */
      .form-grid {
        display: flex;
        flex-direction: column;
        gap: 28px;
        width: 100%;
      }

      .form-row-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        width: 100%;
      }

      .cards-list {
        display: flex;
        flex-direction: column;
        gap: 28px;
        width: 100%;
      }

      .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 28px;
        width: 100%;
      }

      .form-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
      }

      label {
        font-size: 1rem;
        font-weight: 700;
        color: #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: 0.01em;
      }

      label small {
        font-size: 0.84rem;
        font-weight: 500;
        color: var(--text-muted);
      }

      input[type="text"],
      input[type="email"],
      input[type="url"],
      input[type="password"],
      select {
        width: 100%;
        min-height: 56px;
        background-color: var(--bg-input);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 14px 20px;
        color: #ffffff;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 500;
        line-height: 1.5;
        outline: none;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
      }

      input[type="file"] {
        min-height: 56px;
        padding: 14px 18px;
        background-color: var(--bg-input);
        border: 1.5px dashed #475569;
        border-radius: 12px;
        color: #94a3b8;
        cursor: pointer;
        font-size: 0.95rem;
      }

      input[type="file"]:hover {
        border-color: var(--accent-indigo);
        color: #f8fafc;
      }

      textarea {
        width: 100%;
        min-height: 140px;
        background-color: var(--bg-input);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 16px 20px;
        color: #ffffff;
        font-family: inherit;
        font-size: 1.05rem;
        font-weight: 500;
        line-height: 1.6;
        outline: none;
        resize: vertical;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
      }

      input:focus, textarea:focus, select:focus {
        border-color: var(--accent-indigo);
        background-color: #121c38;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
      }

      .img-preview {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 12px;
        border: 1.5px solid var(--border-color);
        margin-top: 10px;
      }

      .card-box {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1.5px solid var(--border-subtle);
        border-radius: 14px;
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
      }

      .card-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-subtle);
      }

      .card-box-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-indigo);
      }

      /* Responsive Rules */
      @media (max-width: 900px) {
        .form-row-2 { grid-template-columns: 1fr; }
        .editor-body { padding: 20px; }
        .top-bar { padding: 0 20px; }
        .app-sidebar { width: 80px; }
        .sidebar-header .brand-title, .nav-group-title, .nav-item span, .sidebar-footer span { display: none; }
        .sidebar-header { justify-content: center; padding: 18px 0; }
        .nav-item { justify-content: center; padding: 12px 0; }
      }

      @media (max-width: 640px) {
        .app-sidebar { display: none; }
      }
    </style>
  </head>
  <body>
    @php
      $strengthsText = implode("\n", $content['about']['strengths']);
      $brandItems = array_map(fn ($brand) => is_array($brand) ? array_replace(['name' => '', 'logo' => null, 'url' => null], $brand) : ['name' => $brand, 'logo' => null, 'url' => null], $content['brands']['items']);
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
            <a class="nav-item {{ $activeSection === $mod['key'] ? 'active' : '' }}" href="{{ route('admin.content.edit', ['section' => $mod['key']]) }}">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10"/><path d="M7 12h10"/><path d="M7 16h6"/></svg>
              <span>{{ $loop->iteration }}. {{ $mod['label'] }}</span>
            </a>
          @endforeach

          <div class="nav-group-title">Interacción</div>
          <a class="nav-item" href="{{ route('admin.messages') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
            <span>Mensajes</span>
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
            <h1>Editar Módulo: {{ $sections[$activeSection] }}</h1>
            <p>Modifica la información visible en el portafolio público.</p>
          </div>

          <div class="top-actions">
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
              Volver al Dashboard
            </a>
            <a class="btn btn-secondary" href="{{ route('portfolio.show') }}" target="_blank">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              Ver sitio público
            </a>
            <div class="user-avatar" title="Angélica Cuéllar">AC</div>
          </div>
        </header>

        <!-- Editor Body -->
        <div class="editor-body">
          @if (session('status'))
            <div class="alert-status">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <span>{{ session('status') }}</span>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert-error" role="alert">
              <strong>No se guardó. Corrige esto y vuelve a guardar:</strong>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="editor-container">
            <form action="{{ route('admin.content.update') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="section" value="{{ $activeSection }}" />

              <!-- 01 GENERAL -->
              @if ($activeSection === 'general')
                <div class="editor-header">
                  <h2>SEO y Datos Personales de Contacto</h2>
                  <p>Información básica del sitio, títulos SEO y enlaces de contacto principales.</p>
                </div>

                <div class="form-grid">
                  <div class="form-group">
                    <label>Título SEO <small>(Aparece en la pestaña del navegador y Google)</small></label>
                    <input type="text" name="seo[title]" value="{{ old('seo.title', $content['seo']['title']) }}" required />
                  </div>

                  <div class="form-group">
                    <label>Descripción SEO <small>(Resumen para buscadores, LinkedIn y WhatsApp)</small></label>
                    <textarea name="seo[description]" rows="3" required>{{ old('seo.description', $content['seo']['description']) }}</textarea>
                  </div>

                  <div class="form-group">
                    <label>Rol / Titular Profesional Completo</label>
                    <input type="text" name="profile[role]" value="{{ old('profile.role', $content['profile']['role']) }}" required />
                  </div>

                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Nombre Completo</label>
                      <input type="text" name="profile[name]" value="{{ old('profile.name', $content['profile']['name']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>Correo Electrónico de Contacto</label>
                      <input type="email" name="profile[email]" value="{{ old('profile.email', $content['profile']['email']) }}" required />
                    </div>
                  </div>

                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Teléfono Visible</label>
                      <input type="text" name="profile[phone]" value="{{ old('profile.phone', $content['profile']['phone']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>WhatsApp <small>(Número limpio sin el símbolo +)</small></label>
                      <input type="text" name="profile[whatsapp]" value="{{ old('profile.whatsapp', $content['profile']['whatsapp']) }}" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Ubicación <small>(Ciudad, País)</small></label>
                    <input type="text" name="profile[location]" value="{{ old('profile.location', $content['profile']['location']) }}" required />
                  </div>

                  <div class="form-group">
                    <label for="profile-linkedin">Enlace Directo a tu Perfil de LinkedIn</label>
                    <input id="profile-linkedin" type="url" name="profile[linkedin]" value="{{ old('profile.linkedin', $content['profile']['linkedin']) }}" required placeholder="https://www.linkedin.com/in/tu-nombre" aria-describedby="profile-linkedin-hint" />
                    <small id="profile-linkedin-hint" class="field-hint">Abre tu perfil en LinkedIn y copia la dirección; debe contener /in/.</small>
                    @error('profile.linkedin')<small class="field-error">{{ $message }}</small>@enderror
                  </div>
                </div>
              @endif

              <!-- 02 PORTADA -->
              @if ($activeSection === 'portada')
                <div class="editor-header">
                  <h2>Sección de Portada (Hero)</h2>
                  <p>Mensaje principal de bienvenida, botones de llamado a la acción e imagen de perfil.</p>
                </div>

                <div class="form-grid">
                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Subtítulo / Etiqueta Superior</label>
                      <input type="text" name="hero[eyebrow]" value="{{ old('hero.eyebrow', $content['hero']['eyebrow']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>Título Principal</label>
                      <input type="text" name="hero[title]" value="{{ old('hero.title', $content['hero']['title']) }}" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Descripción Principal del Encabezado</label>
                    <textarea name="hero[description]" rows="4" required>{{ old('hero.description', $content['hero']['description']) }}</textarea>
                  </div>

                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Texto Botón Principal <small>(Ej: Ver trabajo)</small></label>
                      <input type="text" name="hero[primary_button]" value="{{ old('hero.primary_button', $content['hero']['primary_button']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>Texto Botón Secundario <small>(Ej: Hablemos)</small></label>
                      <input type="text" name="hero[secondary_button]" value="{{ old('hero.secondary_button', $content['hero']['secondary_button']) }}" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Etiqueta de la Tarjeta Visual</label>
                    <input type="text" name="hero[card_label]" value="{{ old('hero.card_label', $content['hero']['card_label']) }}" required />
                  </div>

                  <div class="form-group">
                    <label>Texto Destacado en la Tarjeta Visual</label>
                    <textarea name="hero[card_text]" rows="2" required>{{ old('hero.card_text', $content['hero']['card_text']) }}</textarea>
                  </div>

                  <div class="form-group" id="hero-note-list">
                    <label>Notas Flotantes alrededor de la foto</label>
                    <small class="field-hint">Máximo {{ \App\Http\Controllers\AdminContentController::MAX_HERO_NOTES }} notas de una o dos palabras (por ejemplo: Marca, Comunidad).</small>
                    @error('hero.notes')<small class="field-error">{{ $message }}</small>@enderror
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                      @foreach (old('hero.notes', $content['hero']['notes']) as $note)
                        <div class="card-box" data-hero-note style="display: flex; flex-direction: row; gap: 14px; align-items: center; padding: 16px;">
                          <input type="text" name="hero[notes][]" value="{{ $note }}" maxlength="30" style="flex: 1;" />
                          <button class="btn btn-danger" type="button" data-remove-hero-note style="padding: 12px 18px;">Quitar</button>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-secondary" type="button" data-add-hero-note data-max-notes="{{ \App\Http\Controllers\AdminContentController::MAX_HERO_NOTES }}" style="width: max-content;">+ Agregar otra nota</button>
                  </div>

                  <div class="form-group">
                    <label>Imagen Actual de la Portada</label>
                    <img class="img-preview" src="{{ asset($content['hero']['image']) }}" alt="Imagen de Portada" />
                  </div>
                  <div class="form-group">
                    <label>Cambiar Imagen de Portada</label>
                    <input type="file" name="hero_image" accept="image/*" />
                  </div>
                </div>
              @endif

              <!-- 03 METRICAS -->
              @if ($activeSection === 'metricas')
                <div class="editor-header">
                  <h2>Indicadores y Métricas</h2>
                  <p>Tres indicadores numéricos destacados que respaldan tu experiencia profesional.</p>
                </div>

                <div class="cards-grid">
                  @foreach ($content['metrics'] as $index => $metric)
                    <div class="card-box">
                      <div class="card-box-header">
                        <h3>Métrica {{ $loop->iteration }}</h3>
                      </div>
                      <div class="form-group">
                        <label>Cifra / Valor Numérico <small>(Ej: 4K+, 10+, 360)</small></label>
                        <input type="text" name="metrics[{{ $index }}][value]" value="{{ old("metrics.$index.value", $metric['value']) }}" required />
                      </div>
                      <div class="form-group">
                        <label>Descripción de la Cifra <small>(Ej: Seguidores orgánicos en caso PayU GPO)</small></label>
                        <textarea name="metrics[{{ $index }}][label]" rows="2" required>{{ old("metrics.$index.label", $metric['label']) }}</textarea>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <!-- 04 SOBRE MI -->
              @if ($activeSection === 'sobre-mi')
                <div class="editor-header">
                  <h2>Sección Sobre Mí</h2>
                  <p>Presentación detallada, visión profesional y lista de fortalezas clave.</p>
                </div>

                <div class="form-grid">
                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Subtítulo / Etiqueta Superior</label>
                      <input type="text" name="about[eyebrow]" value="{{ old('about.eyebrow', $content['about']['eyebrow']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>Título Tarjeta de Enfoque</label>
                      <input type="text" name="about[card_title]" value="{{ old('about.card_title', $content['about']['card_title']) }}" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Título Principal de la Sección</label>
                    <input type="text" name="about[title]" value="{{ old('about.title', $content['about']['title']) }}" required />
                  </div>

                  <div class="form-group">
                    <label>Título Bloque de Fortalezas</label>
                    <input type="text" name="about[strengths_title]" value="{{ old('about.strengths_title', $content['about']['strengths_title']) }}" required />
                  </div>

                  <div class="form-group">
                    <label>Descripción Profesional Completa</label>
                    <textarea name="about[description]" rows="6" required>{{ old('about.description', $content['about']['description']) }}</textarea>
                  </div>

                  <div class="form-group">
                    <label>Lista de Fortalezas <small>(Escribe una por cada línea)</small></label>
                    <textarea name="strengths_text" rows="6" required>{{ old('strengths_text', $strengthsText) }}</textarea>
                  </div>
                </div>
              @endif

              <!-- 05 EXPERIENCIA -->
              @if ($activeSection === 'experiencia')
                <div class="editor-header">
                  <h2>Sección de Experiencia y Servicios</h2>
                  <p>Tres áreas de especialización o servicios que ofreces a clientes o marcas.</p>
                </div>

                <div class="form-grid" style="margin-bottom: 28px;">
                  <div class="form-group">
                    <label>Subtítulo / Etiqueta Superior</label>
                    <input type="text" name="experience[eyebrow]" value="{{ old('experience.eyebrow', $content['experience']['eyebrow']) }}" required />
                  </div>
                  <div class="form-group">
                    <label>Título Principal de la Sección</label>
                    <input type="text" name="experience[title]" value="{{ old('experience.title', $content['experience']['title']) }}" required />
                  </div>
                </div>

                <div class="cards-grid">
                  @foreach ($content['experience']['items'] as $index => $item)
                    <div class="card-box">
                      <div class="card-box-header">
                        <h3>Servicio {{ $loop->iteration }}</h3>
                      </div>
                      <div class="form-group">
                        <label>Título del Servicio</label>
                        <input type="text" name="experience[items][{{ $index }}][title]" value="{{ old("experience.items.$index.title", $item['title']) }}" required />
                      </div>
                      <div class="form-group">
                        <label>Descripción del Servicio</label>
                        <textarea name="experience[items][{{ $index }}][description]" rows="3" required>{{ old("experience.items.$index.description", $item['description']) }}</textarea>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <!-- 06 MARCAS -->
              @if ($activeSection === 'marcas')
                <div class="editor-header">
                  <h2>Marcas y Clientes</h2>
                  <p>Logos de empresas o marcas destacadas con las que has colaborado.</p>
                </div>

                <div class="form-grid" style="margin-bottom: 28px;">
                  <div class="form-group">
                    <label>Subtítulo / Etiqueta Superior</label>
                    <input type="text" name="brands[eyebrow]" value="{{ old('brands.eyebrow', $content['brands']['eyebrow']) }}" required />
                  </div>
                  <div class="form-group">
                    <label>Título Principal de la Sección</label>
                    <input type="text" name="brands[title]" value="{{ old('brands.title', $content['brands']['title']) }}" required />
                  </div>
                </div>

                <div class="cards-grid" id="brand-list">
                  @foreach ($brandItems as $index => $brand)
                    <div class="card-box" data-brand-card>
                      <div class="card-box-header">
                        <h3>Marca {{ $loop->iteration }}</h3>
                      </div>
                      @if (! empty($brand['logo']))
                        <div style="width: 100%; text-align: center; padding: 12px; background: rgba(0,0,0,0.2); border-radius: 10px;">
                          <img class="img-preview" src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] }}" style="height: 90px; object-fit: contain; border: 0;" />
                        </div>
                      @endif
                      <input type="hidden" name="brands[items][{{ $index }}][logo]" value="{{ $brand['logo'] ?? '' }}" />
                      <div class="form-group">
                        <label>Nombre de la Marca</label>
                        <input type="text" name="brands[items][{{ $index }}][name]" value="{{ old("brands.items.$index.name", $brand['name']) }}" required />
                      </div>
                      <div class="form-group">
                        <label>Enlace Web de la Marca <small>(Opcional)</small></label>
                        <input type="url" name="brands[items][{{ $index }}][url]" value="{{ old("brands.items.$index.url", $brand['url']) }}" placeholder="https://empresa.com" />
                      </div>
                      <div class="form-group">
                        <label>{{ empty($brand['logo']) ? 'Subir Logo (obligatorio)' : 'Cambiar Logo' }}</label>
                        <input type="file" name="brand_logos[{{ $index }}]" accept="image/*" />
                        @error("brands.items.$index.logo")<small class="field-error">{{ $message }}</small>@enderror
                      </div>
                      <button class="btn btn-danger" type="button" data-remove-brand style="width: max-content; align-self: flex-end;">Quitar Marca</button>
                    </div>
                  @endforeach
                </div>
                <button class="btn btn-secondary" type="button" data-add-brand style="margin-top: 24px; width: max-content;">+ Agregar otra marca</button>
              @endif

              <!-- HERRAMIENTAS -->
              @if ($activeSection === 'herramientas')
                @php
                  $skillItems = old('skills.items', $content['skills']['items']);
                  $skillCategories = collect($content['skills']['items'])->pluck('category')->filter()->unique()->values();
                @endphp
                <div class="editor-header">
                  <h2>Herramientas y nivel de conocimiento</h2>
                  <p>Aplicaciones que usas en tu trabajo. En el portafolio se agrupan por categoría, en el orden en que aparecen aquí.</p>
                </div>

                <div class="form-grid" style="margin-bottom: 28px;">
                  <div class="form-group">
                    <label>Subtítulo / Etiqueta Superior</label>
                    <input type="text" name="skills[eyebrow]" value="{{ old('skills.eyebrow', $content['skills']['eyebrow']) }}" required maxlength="80" />
                  </div>
                  <div class="form-group">
                    <label>Título Principal de la Sección</label>
                    <input type="text" name="skills[title]" value="{{ old('skills.title', $content['skills']['title']) }}" required maxlength="160" />
                  </div>
                </div>

                <datalist id="skill-categories">
                  @foreach ($skillCategories as $category)
                    <option value="{{ $category }}"></option>
                  @endforeach
                </datalist>

                <div class="cards-grid" id="skill-list">
                  @foreach ($skillItems as $index => $skill)
                    <div class="card-box" data-skill-card>
                      <div class="form-group">
                        <label>Herramienta</label>
                        <input type="text" data-skill-name name="skills[items][{{ $index }}][name]" value="{{ $skill['name'] ?? '' }}" required maxlength="60" placeholder="Ej: Canva" />
                        @error("skills.items.$index.name")<small class="field-error">{{ $message }}</small>@enderror
                      </div>
                      <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" data-skill-category name="skills[items][{{ $index }}][category]" value="{{ $skill['category'] ?? '' }}" required maxlength="40" list="skill-categories" placeholder="Ej: Diseño" />
                        @error("skills.items.$index.category")<small class="field-error">{{ $message }}</small>@enderror
                      </div>
                      <div class="form-group">
                        <label>Nivel de conocimiento</label>
                        <select data-skill-level name="skills[items][{{ $index }}][level]" required>
                          @foreach (\App\Models\PortfolioContent::SKILL_LEVELS as $value => $label)
                            <option value="{{ $value }}" @selected((int) ($skill['level'] ?? 0) === $value)>{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Logo pequeño <small>(opcional · PNG, JPG o WebP · máx. 1 MB)</small></label>
                        <input type="hidden" data-skill-logo name="skills[items][{{ $index }}][logo]" value="{{ $skill['logo'] ?? '' }}" />
                        @if (! empty($skill['logo']))
                          <div style="display: flex; align-items: center; gap: 14px;">
                            <img src="{{ asset($skill['logo']) }}" alt="Logo de {{ $skill['name'] ?? '' }}" style="width: 40px; height: 40px; object-fit: contain; background: #fff; border-radius: 8px; padding: 4px;" />
                            <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 500;">
                              <input type="checkbox" data-skill-remove-logo name="skills[items][{{ $index }}][remove_logo]" value="1" /> Quitar logo
                            </label>
                          </div>
                        @endif
                        <input type="file" data-skill-file name="skill_logos[{{ $index }}]" accept="image/png,image/jpeg,image/webp" />
                        @error("skill_logos.$index")<small class="field-error">{{ $message }}</small>@enderror
                      </div>
                      <button class="btn btn-danger" type="button" data-remove-skill style="width: max-content; align-self: flex-end;">Quitar</button>
                    </div>
                  @endforeach
                </div>
                <button class="btn btn-secondary" type="button" data-add-skill style="margin-top: 24px; width: max-content;">+ Agregar herramienta</button>
              @endif

              <!-- 07 PROYECTOS -->
              @if ($activeSection === 'proyectos')
                <div class="editor-header">
                  <h2>Proyectos Destacados</h2>
                  <p>Casos de éxito con imágenes explicativas, categorías y títulos.</p>
                </div>

                <div class="form-grid" style="margin-bottom: 28px;">
                  <div class="form-group">
                    <label>Subtítulo / Etiqueta Superior</label>
                    <input type="text" name="projects[eyebrow]" value="{{ old('projects.eyebrow', $content['projects']['eyebrow']) }}" required />
                  </div>
                  <div class="form-group">
                    <label>Título Principal de la Sección</label>
                    <input type="text" name="projects[title]" value="{{ old('projects.title', $content['projects']['title']) }}" required />
                  </div>
                </div>

                <div class="cards-grid" id="project-list">
                  @foreach ($content['projects']['items'] as $index => $project)
                    <div class="card-box" data-project-card>
                      <div class="card-box-header">
                        <h3>Proyecto {{ $loop->iteration }}</h3>
                      </div>
                      <img class="img-preview" src="{{ asset($project['image']) }}" alt="Proyecto {{ $loop->iteration }}" />
                      <input type="hidden" name="projects[items][{{ $index }}][image]" value="{{ $project['image'] ?? 'assets/2.png' }}" />
                      <div class="form-group">
                        <label>Cambiar Imagen del Proyecto</label>
                        <input type="file" name="project_images[{{ $index }}]" accept="image/*" />
                      </div>
                      <div class="form-row-2">
                        <div class="form-group">
                          <label>Categoría <small>(Ej: Redes sociales)</small></label>
                          <input type="text" name="projects[items][{{ $index }}][category]" value="{{ old("projects.items.$index.category", $project['category']) }}" required />
                        </div>
                        <div class="form-group">
                          <label>Título del Proyecto</label>
                          <input type="text" name="projects[items][{{ $index }}][title]" value="{{ old("projects.items.$index.title", $project['title']) }}" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Descripción Completa del Proyecto</label>
                        <textarea name="projects[items][{{ $index }}][description]" rows="4" required>{{ old("projects.items.$index.description", $project['description']) }}</textarea>
                      </div>
                      <button class="btn btn-danger" type="button" data-remove-project style="width: max-content; align-self: flex-end;">Quitar Proyecto</button>
                    </div>
                  @endforeach
                </div>
                <button class="btn btn-secondary" type="button" data-add-project style="margin-top: 24px; width: max-content;">+ Agregar otro proyecto</button>
              @endif

              <!-- 08 CONTACTO -->
              @if ($activeSection === 'contacto')
                <div class="editor-header">
                  <h2>Sección de Contacto y Frase Final</h2>
                  <p>Cita personal destacada y llamados a la acción para contactar contigo.</p>
                </div>

                <div class="form-grid">
                  <div class="form-group">
                    <label>Frase Personal / Cita Destacada</label>
                    <textarea name="testimonial[quote]" rows="3" required>{{ old('testimonial.quote', $content['testimonial']['quote']) }}</textarea>
                  </div>
                  <div class="form-row-2">
                    <div class="form-group">
                      <label>Etiqueta Sección Contacto</label>
                      <input type="text" name="contact[eyebrow]" value="{{ old('contact.eyebrow', $content['contact']['eyebrow']) }}" required />
                    </div>
                    <div class="form-group">
                      <label>Texto del Botón Enviar</label>
                      <input type="text" name="contact[button]" value="{{ old('contact.button', $content['contact']['button']) }}" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Título Sección Contacto</label>
                    <input type="text" name="contact[title]" value="{{ old('contact.title', $content['contact']['title']) }}" required />
                  </div>
                  <div class="form-group">
                    <label>Descripción Sección Contacto</label>
                    <textarea name="contact[description]" rows="4" required>{{ old('contact.description', $content['contact']['description']) }}</textarea>
                  </div>
                </div>
              @endif

              <!-- 09 HOJA DE VIDA (CV) -->
              @if ($activeSection === 'cv')
                <div class="editor-header">
                  <h2>Gestión de Hojas de Vida (CV en PDF)</h2>
                  <p>Sube archivos PDF de tu CV y elige cuál estará activo para descargar en tu web pública.</p>
                </div>

                <div class="card-box" style="margin-bottom: 32px; padding: 28px;">
                  <h3 style="margin: 0 0 16px; font-size: 1.15rem; color: var(--accent-indigo);">📤 Subir Nuevo Documento PDF</h3>
                  <div class="form-grid">
                    <div class="form-group">
                      <label>Nombre / Título del Documento <small>(Ej: CV 2026 - Estratega Digital)</small></label>
                      <input type="text" name="cv_title" placeholder="Ej: Hoja de Vida - Angélica Cuéllar" />
                    </div>
                    <div class="form-group">
                      <label>Seleccionar Archivo PDF de tu Computadora</label>
                      <input type="file" name="cv_file" accept=".pdf,application/pdf" />
                    </div>
                  </div>
                  <button class="btn btn-primary" type="submit" name="cv_action" value="upload" style="margin-top: 20px; width: max-content;">Subir Archivo PDF</button>
                </div>

                @php
                  $cvItems = $content['cv']['items'] ?? [];
                  $activeCvId = $content['cv']['active_id'] ?? null;
                @endphp

                <h3 style="margin-bottom: 20px; font-size: 1.2rem;">Documentos PDF Almacenados ({{ count($cvItems) }})</h3>

                @if (empty($cvItems))
                  <div class="card-box" style="text-align: center; color: var(--text-muted); padding: 40px;">
                    No has subido ningún archivo PDF. Utiliza el formulario de arriba para cargar tu primer CV.
                  </div>
                @else
                  <div class="cards-list">
                    @foreach ($cvItems as $cv)
                      @php $isActive = ($cv['id'] === $activeCvId); @endphp
                      <div class="card-box" style="border-color: {{ $isActive ? 'var(--accent-indigo)' : 'var(--border-subtle)' }}; background-color: {{ $isActive ? 'rgba(99, 102, 241, 0.08)' : 'rgba(255, 255, 255, 0.02)' }};">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                          <div style="display: flex; align-items: center; gap: 18px;">
                            <div style="width: 52px; height: 52px; border-radius: 14px; background-color: rgba(99, 102, 241, 0.15); color: var(--accent-indigo); display: grid; place-items: center; font-size: 1.5rem; flex-shrink: 0;">📄</div>
                            <div>
                              <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                <strong style="font-size: 1.15rem; color: var(--text-primary);">{{ $cv['title'] }}</strong>
                                @if ($isActive)
                                  <span style="padding: 4px 14px; border-radius: 999px; background-color: var(--accent-emerald); color: white; font-size: 0.78rem; font-weight: 700;">ACTIVO EN LA WEB</span>
                                @endif
                              </div>
                              <span style="font-size: 0.88rem; color: var(--text-muted); margin-top: 4px; display: block;">
                                Archivo: {{ $cv['file_name'] ?? 'cv.pdf' }} ({{ $cv['size'] ?? 'PDF' }}) — Subido: {{ $cv['uploaded_at'] ?? 'Recientemente' }}
                              </span>
                            </div>
                          </div>

                          <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                            <a class="btn btn-secondary" href="{{ asset($cv['file_path']) }}" target="_blank">👁️ Ver PDF</a>
                            @if (!$isActive)
                              <button class="btn btn-primary" type="submit" name="cv_action" value="set_active" onclick="document.querySelector('#selected_cv_id').value='{{ $cv['id'] }}'">⭐ Marcar como Activo</button>
                            @endif
                            <button class="btn btn-danger" type="submit" name="cv_action" value="delete" onclick="if(!confirm('¿Deseas eliminar este archivo PDF?')) return false; document.querySelector('#selected_cv_id').value='{{ $cv['id'] }}'">🗑️ Eliminar</button>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <input type="hidden" name="cv_id" id="selected_cv_id" value="" />
                @endif
              @endif

              @if ($activeSection !== 'cv')
                <div style="margin-top: 36px; padding-top: 28px; border-top: 1px solid var(--border-subtle); display: flex; gap: 16px; flex-wrap: wrap;">
                  <button class="btn btn-primary" type="submit">Guardar Cambios de {{ $sections[$activeSection] }}</button>
                  <a class="btn btn-secondary" href="{{ route('portfolio.show') }}" target="_blank">Ver sitio público</a>
                </div>
              @endif
            </form>
          </div>
        </div>
      </main>
    </div>

    <template id="brand-template">
      <div class="card-box" data-brand-card>
        <div class="card-box-header">
          <h3>Nueva Marca</h3>
        </div>
        <input type="hidden" data-brand-logo name="" value="" />
        <div class="form-group">
          <label>Nombre de la Marca</label>
          <input type="text" data-brand-name name="" value="" required />
        </div>
        <div class="form-group">
          <label>Enlace Web de la Marca <small>(Opcional)</small></label>
          <input type="url" data-brand-url name="" value="" placeholder="https://empresa.com" />
        </div>
        <div class="form-group">
          <label>Subir Logo (obligatorio)</label>
          <input type="file" data-brand-file name="" accept="image/*" required />
        </div>
        <button class="btn btn-danger" type="button" data-remove-brand style="width: max-content; align-self: flex-end;">Quitar Marca</button>
      </div>
    </template>

    <template id="skill-template">
      <div class="card-box" data-skill-card>
        <div class="form-group">
          <label>Herramienta</label>
          <input type="text" data-skill-name name="" value="" required maxlength="60" placeholder="Ej: Canva" />
        </div>
        <div class="form-group">
          <label>Categoría</label>
          <input type="text" data-skill-category name="" value="" required maxlength="40" list="skill-categories" placeholder="Ej: Diseño" />
        </div>
        <div class="form-group">
          <label>Nivel de conocimiento</label>
          <select data-skill-level name="" required>
            @foreach (\App\Models\PortfolioContent::SKILL_LEVELS as $value => $label)
              <option value="{{ $value }}" @selected($value === 2)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Logo pequeño <small>(opcional · PNG, JPG o WebP · máx. 1 MB)</small></label>
          <input type="hidden" data-skill-logo name="" value="" />
          <input type="file" data-skill-file name="" accept="image/png,image/jpeg,image/webp" />
        </div>
        <button class="btn btn-danger" type="button" data-remove-skill style="width: max-content; align-self: flex-end;">Quitar</button>
      </div>
    </template>

    <template id="hero-note-template">
      <div class="card-box" data-hero-note style="display: flex; flex-direction: row; gap: 14px; align-items: center; padding: 16px;">
        <input type="text" name="hero[notes][]" value="" maxlength="30" style="flex: 1;" />
        <button class="btn btn-danger" type="button" data-remove-hero-note style="padding: 12px 18px;">Quitar</button>
      </div>
    </template>

    <template id="project-template">
      <div class="card-box" data-project-card>
        <div class="card-box-header">
          <h3 data-project-title-header>Nuevo Proyecto</h3>
        </div>
        <input type="hidden" data-project-image name="" value="assets/2.png" />
        <div class="form-group">
          <label>Subir Imagen del Proyecto</label>
          <input type="file" data-project-file name="" accept="image/*" />
        </div>
        <div class="form-row-2">
          <div class="form-group">
            <label>Categoría <small>(Ej: Redes sociales)</small></label>
            <input type="text" data-project-category name="" value="" required placeholder="Ej: Social Media & Content" />
          </div>
          <div class="form-group">
            <label>Título del Proyecto</label>
            <input type="text" data-project-title name="" value="" required placeholder="Ej: Estrategia de Contenidos 2026" />
          </div>
        </div>
        <div class="form-group">
          <label>Descripción Completa del Proyecto</label>
          <textarea data-project-description name="" rows="4" required placeholder="Describe el objetivo, las acciones clave y los resultados alcanzados..."></textarea>
        </div>
        <button class="btn btn-danger" type="button" data-remove-project style="width: max-content; align-self: flex-end;">Quitar Proyecto</button>
      </div>
    </template>

    <script>
      const brandList = document.querySelector('[data-add-brand]') ? document.querySelector('#brand-list') : null;
      const brandTemplate = document.querySelector('#brand-template');
      const projectList = document.querySelector('[data-add-project]') ? document.querySelector('#project-list') : null;
      const projectTemplate = document.querySelector('#project-template');
      const heroNoteList = document.querySelector('#hero-note-list');
      const heroNoteTemplate = document.querySelector('#hero-note-template');

      function reindexBrands() {
        if (!brandList) return;
        brandList.querySelectorAll('[data-brand-card]').forEach((card, index) => {
          const logo = card.querySelector('input[type="hidden"]');
          const name = card.querySelector('[data-brand-name]') || card.querySelector('input[name$="[name]"]');
          const url = card.querySelector('[data-brand-url]') || card.querySelector('input[name$="[url]"]');
          const file = card.querySelector('input[type="file"]');
          if (logo) logo.name = `brands[items][${index}][logo]`;
          if (name) name.name = `brands[items][${index}][name]`;
          if (url) url.name = `brands[items][${index}][url]`;
          if (file) file.name = `brand_logos[${index}]`;
        });
      }

      function reindexProjects() {
        if (!projectList) return;
        projectList.querySelectorAll('[data-project-card]').forEach((card, index) => {
          const header = card.querySelector('[data-project-title-header]') || card.querySelector('h3');
          const image = card.querySelector('input[type="hidden"]');
          const file = card.querySelector('input[type="file"]');
          const category = card.querySelector('[data-project-category]') || card.querySelector('input[name$="[category]"]');
          const title = card.querySelector('[data-project-title]') || card.querySelector('input[name$="[title]"]');
          const description = card.querySelector('[data-project-description]') || card.querySelector('textarea[name$="[description]"]');

          if (header) header.textContent = `Proyecto ${index + 1}`;
          if (image) image.name = `projects[items][${index}][image]`;
          if (file) file.name = `project_images[${index}]`;
          if (category) category.name = `projects[items][${index}][category]`;
          if (title) title.name = `projects[items][${index}][title]`;
          if (description) description.name = `projects[items][${index}][description]`;
        });
      }

      const skillList = document.querySelector('#skill-list');
      const skillTemplate = document.querySelector('#skill-template');

      function reindexSkills() {
        if (!skillList) return;
        skillList.querySelectorAll('[data-skill-card]').forEach((card, index) => {
          card.querySelector('[data-skill-name]').name = `skills[items][${index}][name]`;
          card.querySelector('[data-skill-category]').name = `skills[items][${index}][category]`;
          card.querySelector('[data-skill-level]').name = `skills[items][${index}][level]`;
          card.querySelector('[data-skill-logo]').name = `skills[items][${index}][logo]`;
          card.querySelector('[data-skill-file]').name = `skill_logos[${index}]`;
          const removeLogo = card.querySelector('[data-skill-remove-logo]');
          if (removeLogo) removeLogo.name = `skills[items][${index}][remove_logo]`;
        });
      }

      document.addEventListener('click', (event) => {
        if (skillList && event.target.matches('[data-add-skill]')) {
          const clone = skillTemplate.content.firstElementChild.cloneNode(true);
          skillList.appendChild(clone);
          reindexSkills();
          clone.querySelector('[data-skill-name]').focus();
        }

        if (skillList && event.target.matches('[data-remove-skill]')) {
          if (skillList.querySelectorAll('[data-skill-card]').length === 1) return;
          event.target.closest('[data-skill-card]').remove();
          reindexSkills();
        }

        if (event.target.matches('[data-add-brand]')) {
          const clone = brandTemplate.content.firstElementChild.cloneNode(true);
          brandList.appendChild(clone);
          reindexBrands();
        }

        if (event.target.matches('[data-remove-brand]')) {
          const cards = brandList.querySelectorAll('[data-brand-card]');
          if (cards.length === 1) return;
          event.target.closest('[data-brand-card]').remove();
          reindexBrands();
        }

        if (event.target.matches('[data-add-project]')) {
          const clone = projectTemplate.content.firstElementChild.cloneNode(true);
          projectList.appendChild(clone);
          reindexProjects();
        }

        if (event.target.matches('[data-remove-project]')) {
          const cards = projectList.querySelectorAll('[data-project-card]');
          if (cards.length === 1) return;
          event.target.closest('[data-project-card]').remove();
          reindexProjects();
        }

        if (event.target.matches('[data-add-hero-note]')) {
          const max = Number(event.target.dataset.maxNotes) || Infinity;
          if (heroNoteList.querySelectorAll('[data-hero-note]').length < max) {
            heroNoteList.querySelector('div').appendChild(heroNoteTemplate.content.firstElementChild.cloneNode(true));
          }
          syncHeroNoteButton();
        }

        if (event.target.matches('[data-remove-hero-note]')) {
          event.target.closest('[data-hero-note]').remove();
          syncHeroNoteButton();
        }
      });

      function syncHeroNoteButton() {
        const button = document.querySelector('[data-add-hero-note]');
        if (!button || !heroNoteList) return;
        const full = heroNoteList.querySelectorAll('[data-hero-note]').length >= Number(button.dataset.maxNotes);
        button.disabled = full;
        button.textContent = full ? 'Límite de notas alcanzado' : '+ Agregar otra nota';
      }

      syncHeroNoteButton();
    </script>
  </body>
</html>

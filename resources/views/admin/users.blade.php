<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuarios y Seguridad | Panel de Administración</title>
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
        --accent-rose: #f43f5e;
      }

      * { box-sizing: border-box; }
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100vh;
        background-color: var(--bg-main);
        color: var(--text-primary);
        font-family: "Inter", system-ui, -apple-system, sans-serif;
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

      .sidebar-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border-color);
      }

      .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 8px;
        background-color: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.2);
        color: #f43f5e;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .logout-btn:hover {
        background-color: rgba(244, 63, 94, 0.2);
      }

      /* Main Content Area */
      .app-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        width: 100%;
      }

      .top-bar {
        height: 70px;
        padding: 0 32px;
        background-color: var(--bg-card);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 20;
      }

      .page-title {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .page-title h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
      }

      .user-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 14px;
        border-radius: 999px;
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
      }

      .user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: var(--accent-indigo);
        color: white;
        display: grid;
        place-items: center;
        font-weight: 700;
        font-size: 0.8rem;
      }

      .main-content {
        padding: 32px;
        width: 100%;
      }

      /* Alerts & Status Messages */
      .status-alert {
        padding: 16px 20px;
        border-radius: 12px;
        background-color: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--accent-emerald);
        font-weight: 600;
        margin-bottom: 24px;
      }

      .error-alert {
        padding: 16px 20px;
        border-radius: 12px;
        background-color: rgba(244, 63, 94, 0.12);
        border: 1px solid rgba(244, 63, 94, 0.3);
        color: var(--accent-rose);
        font-weight: 600;
        margin-bottom: 24px;
      }

      /* Section Cards */
      .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 28px;
        margin-bottom: 32px;
      }

      .section-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 28px;
      }

      .card-header {
        margin-bottom: 24px;
      }

      .card-header h2 {
        margin: 0 0 6px;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
      }

      .card-header p {
        margin: 0;
        font-size: 0.88rem;
        color: var(--text-muted);
      }

      /* Forms Sizing Overhaul (56px Inputs) */
      .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
      }

      .form-group label {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
      }

      .form-group input {
        width: 100%;
        min-height: 56px;
        padding: 14px 20px;
        border-radius: 12px;
        border: 1.5px solid var(--border-color);
        background-color: var(--bg-input);
        color: #ffffff;
        font-size: 1.05rem;
        font-family: inherit;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
      }

      .form-group input:focus {
        outline: none;
        border-color: var(--accent-indigo);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
      }

      .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 56px;
        padding: 0 28px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
      }

      .btn-primary {
        background-color: var(--accent-indigo);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
      }

      .btn-primary:hover {
        background-color: var(--accent-indigo-hover);
        transform: translateY(-1px);
      }

      .btn-danger-sm {
        min-height: 38px;
        padding: 0 14px;
        font-size: 0.82rem;
        border-radius: 8px;
        background-color: rgba(244, 63, 94, 0.15);
        color: #f43f5e;
        border: 1px solid rgba(244, 63, 94, 0.3);
        cursor: pointer;
      }

      .btn-danger-sm:hover {
        background-color: rgba(244, 63, 94, 0.3);
      }

      .btn-secondary-sm {
        min-height: 38px;
        padding: 0 14px;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 8px;
        background-color: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .btn-secondary-sm:hover {
        background-color: rgba(99, 102, 241, 0.3);
        color: #ffffff;
      }

      /* Users Table */
      .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid var(--border-color);
      }

      table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
      }

      th {
        padding: 16px 20px;
        background-color: rgba(0, 0, 0, 0.2);
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color);
      }

      td {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-subtle);
        font-size: 0.95rem;
        color: var(--text-primary);
      }

      tr:last-child td {
        border-bottom: none;
      }

      .tag-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        background-color: rgba(16, 185, 129, 0.15);
        color: var(--accent-emerald);
      }

      @media (max-width: 1024px) {
        .grid-2 { grid-template-columns: 1fr; }
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
          <a class="nav-item" href="{{ route('admin.messages') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10Z"/><path d="m22 7-10 7L2 7"/></svg>
            <span>Mensajes ({{ $messagesCount }})</span>
          </a>

          <div class="nav-group-title">Seguridad & Cuentas</div>
          <a class="nav-item active" href="{{ route('admin.users.index') }}">
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

      <!-- Main Content -->
      <main class="app-main">
        <header class="top-bar">
          <div class="page-title">
            <h1>👥 Gestión de Usuarios y Seguridad de Acceso</h1>
          </div>
          @php
            $user = $currentUser ?? Auth::user();
            $userEmail = optional($user)->email ?? 'admin@example.com';
            $userName = optional($user)->name ?? 'Administrador';
          @endphp
          <div class="user-badge">
            <div class="user-avatar">{{ mb_substr($userName, 0, 1) }}</div>
            <span style="font-size: 0.9rem; font-weight: 600;">{{ $userName }}</span>
          </div>
        </header>

        <div class="main-content">
          @if (session('status'))
            <div class="status-alert">
              ✓ {{ session('status') }}
            </div>
          @endif

          @if (session('error'))
            <div class="error-alert">
              ⚠️ {{ session('error') }}
            </div>
          @endif

          <div class="grid-2">
            <!-- 01 CAMBIAR MI CONTRASEÑA -->
            <div class="section-card">
              <div class="card-header">
                <h2>🔐 Cambiar mi Contraseña</h2>
                <p>Actualiza la clave de acceso de tu usuario activo ({{ $userEmail }}).</p>
              </div>

              <form action="{{ route('admin.users.update_password') }}" method="post">
                @csrf
                <div class="form-group">
                  <label>Contraseña Actual</label>
                  <input type="password" name="current_password" required placeholder="••••••••" />
                  @error('current_password') <small style="color: #f43f5e; font-weight: 600;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                  <label>Nueva Contraseña</label>
                  <input type="password" name="password" required placeholder="Mínimo 6 caracteres" />
                  @error('password') <small style="color: #f43f5e; font-weight: 600;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                  <label>Confirmar Nueva Contraseña</label>
                  <input type="password" name="password_confirmation" required placeholder="Repite la nueva contraseña" />
                </div>

                <button class="btn btn-primary" type="submit" style="width: 100%;">
                  Actualizar mi Contraseña
                </button>
              </form>
            </div>

            <!-- 02 CREAR NUEVO USUARIO ADMINISTRADOR -->
            <div class="section-card">
              <div class="card-header">
                <h2>➕ Agregar Nuevo Usuario Administrador</h2>
                <p>Crea un nuevo usuario con acceso total al panel de administración.</p>
              </div>

              <form action="{{ route('admin.users.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label>Nombre Completo</label>
                  <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: Angélica Cuéllar" />
                  @error('name') <small style="color: #f43f5e; font-weight: 600;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                  <label>Correo Electrónico (Email de Acceso)</label>
                  <input type="email" name="email" value="{{ old('email') }}" required placeholder="ejemplo@dominio.com" />
                  @error('email') <small style="color: #f43f5e; font-weight: 600;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" name="password" required placeholder="Mínimo 6 caracteres" />
                  @error('password') <small style="color: #f43f5e; font-weight: 600;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                  <label>Confirmar Contraseña</label>
                  <input type="password" name="password_confirmation" required placeholder="Repite la contraseña" />
                </div>

                <button class="btn btn-primary" type="submit" style="width: 100%;">
                  Crear Usuario Administrador
                </button>
              </form>
            </div>
          </div>

          <!-- LISTADO DE USUARIOS REGISTRADOS -->
          <div class="section-card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <h2>📋 Lista de Usuarios Registrados ({{ count($users) }})</h2>
                <p>Usuarios con permisos para ingresar al panel de administración.</p>
              </div>
            </div>

            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Estado / Sesión</th>
                    <th>Fecha de Registro</th>
                    <th style="text-align: right;">Acción</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $u)
                    <tr>
                      <td style="font-weight: 700;">
                        {{ $u->name }}
                        @if ($u->id === Auth::id())
                          <span style="font-size: 0.75rem; background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 2px 8px; border-radius: 999px; margin-left: 6px;">Tú</span>
                        @endif
                      </td>
                      <td>{{ $u->email }}</td>
                      <td>
                        @if ($u->id === Auth::id())
                          <span class="tag-active">● Sesión Activa</span>
                        @else
                          <span style="color: var(--text-muted); font-size: 0.85rem;">Registrado</span>
                        @endif
                      </td>
                      <td style="color: var(--text-muted); font-size: 0.88rem;">
                        {{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : 'N/A' }}
                      </td>
                      <td style="text-align: right; display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                        <button class="btn btn-secondary-sm" type="button" onclick="openEditUserModal('{{ $u->id }}', '{{ e($u->name) }}', '{{ e($u->email) }}')">
                          ✏️ Editar
                        </button>

                        @if ($u->id !== Auth::id())
                          <form action="{{ route('admin.users.destroy', $u) }}" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario administrador?');" style="display: inline-block;">
                            @csrf
                            <button class="btn btn-danger-sm" type="submit">Eliminar</button>
                          </form>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal de Edición de Usuario -->
    <div id="edit-user-modal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
      <div class="section-card" style="width: min(540px, 100%); position: relative; border: 1px solid var(--accent-indigo); box-shadow: 0 25px 70px rgba(0,0,0,0.6);">
        <button type="button" onclick="closeEditUserModal()" style="position: absolute; top: 18px; right: 18px; background: transparent; border: none; color: var(--text-muted); font-size: 1.3rem; cursor: pointer;">✕</button>
        <div class="card-header">
          <h2>✏️ Editar Usuario Administrador</h2>
          <p>Modifica el nombre, correo o contraseña de este usuario.</p>
        </div>
        <form id="edit-user-form" action="" method="post">
          @csrf
          <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" id="edit-user-name" name="name" required />
          </div>
          <div class="form-group">
            <label>Correo Electrónico (Email)</label>
            <input type="email" id="edit-user-email" name="email" required />
          </div>
          <div class="form-group">
            <label>Nueva Contraseña <small>(Opcional: déjala vacía si no deseas cambiarla)</small></label>
            <input type="password" name="password" placeholder="Mínimo 6 caracteres" />
          </div>
          <div class="form-group">
            <label>Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" placeholder="Repite la contraseña" />
          </div>
          <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button class="btn btn-primary" type="submit" style="flex: 1;">Guardar Cambios</button>
            <button class="btn-danger-sm" type="button" onclick="closeEditUserModal()" style="min-height: 56px; padding: 0 20px;">Cancelar</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      function openEditUserModal(id, name, email) {
        const modal = document.getElementById('edit-user-modal');
        const form = document.getElementById('edit-user-form');
        const inputName = document.getElementById('edit-user-name');
        const inputEmail = document.getElementById('edit-user-email');

        form.action = `{{ url('/admin/usuarios') }}/${id}`;
        inputName.value = name;
        inputEmail.value = email;

        modal.style.display = 'flex';
      }

      function closeEditUserModal() {
        const modal = document.getElementById('edit-user-modal');
        modal.style.display = 'none';
      }
    </script>
  </body>
</html>

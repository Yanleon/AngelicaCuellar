<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Acceso Admin | Panel de Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
      :root {
        --bg-main: #0f172a;
        --bg-card: #1e293b;
        --bg-input: #182234;
        --border-color: #334155;
        --text-primary: #f8fafc;
        --text-muted: #94a3b8;
        --accent-indigo: #6366f1;
        --accent-indigo-hover: #4f46e5;
      }

      * { box-sizing: border-box; }
      body {
        margin: 0;
        padding: 0;
        width: 100vw;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-main);
        color: var(--text-primary);
        font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        -webkit-font-smoothing: antialiased;
      }

      a { color: var(--accent-indigo); text-decoration: none; font-weight: 600; }
      a:hover { text-decoration: underline; }

      .login-card {
        width: min(440px, calc(100% - 32px));
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 36px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
      }

      .login-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
      }

      .brand-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent-indigo), #818cf8);
        color: white;
        display: grid;
        place-items: center;
        font-weight: 800;
        font-size: 1.3rem;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
      }

      .brand-title strong { display: block; font-size: 1.05rem; font-weight: 700; color: var(--text-primary); }
      .brand-title span { font-size: 0.8rem; color: var(--text-muted); }

      .login-header h1 {
        margin: 0 0 6px;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
      }

      .login-header p {
        margin: 0 0 24px;
        font-size: 0.86rem;
        color: var(--text-muted);
        line-height: 1.5;
      }

      form {
        display: flex;
        flex-direction: column;
        gap: 16px;
      }

      .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
      }

      label {
        font-size: 0.84rem;
        font-weight: 600;
        color: #cbd5e1;
      }

      input {
        width: 100%;
        background-color: var(--bg-input);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 14px;
        color: var(--text-primary);
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s ease;
      }

      input:focus {
        border-color: var(--accent-indigo);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
      }

      .submit-btn {
        margin-top: 8px;
        padding: 12px;
        border: 0;
        border-radius: 8px;
        background-color: var(--accent-indigo);
        color: white;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
      }

      .submit-btn:hover {
        background-color: var(--accent-indigo-hover);
      }

      .login-footer {
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        text-align: center;
        font-size: 0.85rem;
        color: var(--text-muted);
      }

      small { color: #f87171; font-size: 0.78rem; font-weight: 600; }
    </style>
  </head>
  <body>
    <div class="login-card">
      <div class="login-brand">
        <div class="brand-icon">A</div>
        <div class="brand-title">
          <strong>Angélica Cuéllar</strong>
          <span>Admin Panel</span>
        </div>
      </div>

      <div class="login-header">
        <h1>Iniciar Sesión</h1>
        <p>Ingresa tus credenciales para administrar el contenido del portafolio y revisar mensajes.</p>
      </div>

      <form action="{{ route('admin.authenticate') }}" method="post">
        @csrf
        <div class="form-group">
          <label>Correo Electrónico</label>
          <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus placeholder="admin@example.com" />
          @error('email')<small>{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
          <label>Contraseña</label>
          <input type="password" name="password" autocomplete="current-password" required placeholder="••••••••" />
          @error('password')<small>{{ $message }}</small>@enderror
        </div>

        <button class="submit-btn" type="submit">Acceder al Panel</button>
      </form>

      <div class="login-footer">
        <a href="{{ route('portfolio.show') }}">← Volver al sitio público</a>
      </div>
    </div>
  </body>
</html>

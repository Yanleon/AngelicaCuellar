<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $content['seo']['description'] }}" />
    <title>{{ $content['seo']['title'] }}</title>
    <meta name="color-scheme" content="dark light" />
    <script>
      // Aplica el modo antes de pintar para evitar un destello: elección guardada o, si no hay, la del sistema.
      (function () {
        var theme = null;
        try { theme = localStorage.getItem('theme'); } catch (e) {}
        if (theme !== 'light' && theme !== 'dark') {
          theme = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
        }
        document.documentElement.setAttribute('data-theme', theme);
        // Las animaciones de aparición solo se activan con JS: sin JS, todo queda visible.
        document.documentElement.classList.add('js');
      })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}?v={{ time() }}" />
    <style>
      .project-card {
        cursor: pointer !important;
        transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease !important;
      }
      .project-card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 24px 70px rgba(0, 0, 0, 0.5) !important;
        border-color: var(--accent-fill) !important;
      }
      .project-card:hover .project-card__image {
        transform: scale(1.06);
        transition: transform 0.4s ease;
      }
      .project-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(10, 8, 12, 0.88);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
      }
      .project-modal-backdrop.active {
        display: flex !important;
      }
      .project-modal-box {
        position: relative;
        width: min(850px, 100%);
        max-height: 90vh;
        overflow-y: auto;
        background: var(--surface);
        border: 1px solid var(--surface-border);
        border-radius: 28px;
        box-shadow: 0 35px 100px rgba(0, 0, 0, 0.5);
        color: var(--ink);
        animation: modalPop 0.3s ease forwards;
      }
      @keyframes modalPop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
      }
      .project-modal-close-btn {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 10;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(0, 0, 0, 0.6);
        color: #ffffff;
        font-size: 1.4rem;
        font-weight: 700;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: all 0.2s ease;
      }
      .project-modal-close-btn:hover {
        background: #ef4444;
        border-color: #ef4444;
        transform: scale(1.1);
      }
      .project-modal-img-container {
        width: 100%;
        max-height: 460px;
        overflow: hidden;
        background: #000;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .project-modal-img-container img {
        width: 100%;
        height: 100%;
        max-height: 460px;
        object-fit: cover;
        object-position: top center;
      }
      .project-modal-body-container {
        padding: 36px;
      }
      .project-modal-badge {
        display: inline-block;
        font-size: 0.88rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 8px;
        letter-spacing: 0.05em;
      }
      .project-modal-heading {
        margin: 0 0 16px;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--ink);
        line-height: 1.25;
      }
      .project-modal-line {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #e0a1f5, #f4a261);
        border-radius: 999px;
        margin-bottom: 20px;
      }
      .project-modal-text {
        margin: 0;
        font-size: 1.08rem;
        color: var(--ink-body);
        line-height: 1.75;
        white-space: pre-line;
      }
    </style>
  </head>
  <body>
    <header class="site-header" data-header>
      <a class="brand" href="#inicio" aria-label="Ir al inicio">
        <span class="brand__mark">{{ mb_substr($content['profile']['name'], 0, 1) }}</span>
        <span>{{ $content['profile']['name'] }}</span>
      </a>

      <nav class="nav" id="site-nav" data-nav aria-label="Navegación principal">
        <a href="#sobre-mi">Sobre mi</a>
        <a href="#experiencia">Experiencia</a>
        <a href="#marcas">Marcas</a>
        <a href="#herramientas">Herramientas</a>
        <a href="#proyectos">Proyectos</a>
        <a href="#contacto">Contacto</a>
      </nav>

      <button class="theme-toggle" type="button" data-theme-toggle aria-label="Cambiar a modo día">
        <svg class="theme-toggle__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="4.5" />
          <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
        </svg>
        <svg class="theme-toggle__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
        </svg>
      </button>

      <button class="menu-toggle" type="button" data-menu-toggle aria-label="Abrir menú" aria-expanded="false" aria-controls="site-nav">
        <span></span>
        <span></span>
      </button>
    </header>

    <main>
      <!-- HERO / PORTADA -->
      <section class="hero" id="inicio">
        <div class="hero__content">
          <span class="eyebrow reveal">✨ {{ $content['hero']['eyebrow'] }}</span>
          
          <div class="sector-pills reveal">
            <span class="sector-pill sector-pill--gold">Fintech & Pasarelas de Pago</span>
            <span class="sector-pill">Moda & Retail</span>
            <span class="sector-pill sector-pill--gold">Belleza & Maquillaje</span>
            <span class="sector-pill">Estrategia de Crecimiento</span>
          </div>

          <h1 class="reveal">{{ $content['hero']['title'] }}</h1>
          <p class="hero__lead reveal">{{ $content['hero']['description'] }}</p>
          
          <div class="hero__actions reveal">
            <a class="button button--primary" href="#proyectos">{{ $content['hero']['primary_button'] }}</a>
            <a class="button button--secondary" href="#contacto">{{ $content['hero']['secondary_button'] }}</a>
          </div>

          <!-- METRICAS DESTACADAS -->
          <dl class="metrics reveal">
            @foreach ($content['metrics'] as $metric)
              <div>
                <dt>{{ $metric['value'] }}</dt>
                <dd>{{ $metric['label'] }}</dd>
              </div>
            @endforeach
          </dl>
        </div>

        <div class="hero__visual reveal">
          <div class="portrait-card">
            <img class="portrait-card__photo" src="{{ asset($content['hero']['image']) }}" alt="{{ $content['profile']['name'] }}" />
            <div class="portrait-card__body">
              <p>{{ $content['hero']['card_label'] }}</p>
              <strong>{{ $content['hero']['card_text'] }}</strong>
            </div>
          </div>
          @foreach (array_slice($content['hero']['notes'], 0, \App\Http\Controllers\AdminContentController::MAX_HERO_NOTES) as $index => $note)
            <div class="floating-note floating-note--{{ $index + 1 }}" style="--i: {{ $index }}">{{ $note }}</div>
          @endforeach
        </div>
      </section>

      <!-- SOBRE MI -->
      <section class="section about" id="sobre-mi">
        <div class="section__heading reveal">
          <span class="eyebrow">💡 {{ $content['about']['eyebrow'] }}</span>
          <h2>{{ $content['about']['title'] }}</h2>
        </div>
        <div class="about__grid">
          <article class="card card--large reveal">
            <h3>{{ $content['about']['card_title'] }}</h3>
            <p>{{ $content['about']['description'] }}</p>
          </article>
          <article class="card reveal">
            <h3>{{ $content['about']['strengths_title'] }}</h3>
            <ul class="check-list">
              @foreach ($content['about']['strengths'] as $strength)
                <li>{{ $strength }}</li>
              @endforeach
            </ul>
          </article>
        </div>
      </section>

      <!-- EXPERIENCIA & SECTORES -->
      <section class="section services" id="experiencia">
        <div class="section__heading reveal">
          <span class="eyebrow">🚀 {{ $content['experience']['eyebrow'] }}</span>
          <h2>{{ $content['experience']['title'] }}</h2>
        </div>
        <div class="services__grid">
          @foreach ($content['experience']['items'] as $item)
            <article class="service-card reveal">
              <span>0{{ $loop->iteration }}</span>
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['description'] }}</p>
            </article>
          @endforeach
        </div>
      </section>

      <!-- MARCAS TRABAJADAS -->
      <section class="section brands" id="marcas">
        <div class="section__heading reveal">
          <span class="eyebrow">🤝 {{ $content['brands']['eyebrow'] }}</span>
          <h2>{{ $content['brands']['title'] }}</h2>
        </div>
        <div class="logo-strip">
          @foreach ($content['brands']['items'] as $brand)
            @php
              $brandName = is_array($brand) ? ($brand['name'] ?? '') : $brand;
              $brandLogo = is_array($brand) ? ($brand['logo'] ?? null) : null;
              $brandUrl = is_array($brand) ? ($brand['url'] ?? null) : null;
            @endphp
            <span class="reveal">
              @if ($brandUrl)
                <a href="{{ $brandUrl }}" target="_blank" rel="noopener noreferrer">
              @endif
              @if ($brandLogo)
                <img src="{{ asset($brandLogo) }}" alt="{{ $brandName }}" />
              @else
                {{ $brandName }}
              @endif
              @if ($brandUrl)
                </a>
              @endif
            </span>
          @endforeach
        </div>
      </section>

      <!-- HERRAMIENTAS Y NIVEL DE CONOCIMIENTO -->
      @php
        $skillGroups = collect($content['skills']['items'] ?? [])->groupBy('category');
        $skillLevels = \App\Models\PortfolioContent::SKILL_LEVELS;
        $maxLevel = count($skillLevels);
      @endphp
      @if ($skillGroups->isNotEmpty())
        <section class="section skills" id="herramientas">
          <div class="section__heading reveal">
            <span class="eyebrow">🛠️ {{ $content['skills']['eyebrow'] }}</span>
            <h2>{{ $content['skills']['title'] }}</h2>
          </div>
          <div class="skills__grid">
            @foreach ($skillGroups as $category => $tools)
              <div class="skills__group reveal">
                <h3>{{ $category }}</h3>
                <ul class="skills__list">
                  @foreach ($tools as $tool)
                    @php $level = max(1, min($maxLevel, (int) ($tool['level'] ?? 1))); @endphp
                    <li class="skill" style="--row: {{ $loop->index }}">
                      <span class="skill__logo" aria-hidden="true">
                        @if (! empty($tool['logo']))
                          <img src="{{ asset($tool['logo']) }}" alt="" loading="lazy" />
                        @else
                          {{ mb_strtoupper(mb_substr($tool['name'], 0, 1)) }}
                        @endif
                      </span>
                      <span class="skill__text">
                        <span class="skill__name">{{ $tool['name'] }}</span>
                        <span class="skill__label">{{ $skillLevels[$level] }}</span>
                      </span>
                      <span class="skill__meter" aria-hidden="true">
                        @for ($step = 1; $step <= $maxLevel; $step++)
                          <i @class(['is-on' => $step <= $level]) style="--s: {{ $step }}"></i>
                        @endfor
                      </span>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </div>
        </section>
      @endif

      <!-- PROYECTOS DESTACADOS -->
      <section class="section projects" id="proyectos">
        <div class="section__heading reveal">
          <span class="eyebrow">🏆 {{ $content['projects']['eyebrow'] }}</span>
          <h2>{{ $content['projects']['title'] }}</h2>
        </div>
        <div class="projects__grid">
          @foreach ($content['projects']['items'] as $project)
            <article class="project-card reveal"
                     data-project-card
                     data-image="{{ ! empty($project['image']) ? asset($project['image']) : '' }}"
                     data-category="{{ $project['category'] }}"
                     data-title="{{ $project['title'] }}"
                     data-description="{{ $project['description'] }}">
              @if (! empty($project['image']))
                <img class="project-card__image" src="{{ asset($project['image']) }}" alt="" loading="lazy" />
              @endif
              <div class="project-card__content">
                <p>{{ $project['category'] }}</p>
                <h3>{{ $project['title'] }}</h3>
                <span>{{ $project['description'] }}</span>
                <button class="project-card__more" type="button" data-project-open aria-haspopup="dialog">
                  Ver más información <span class="visually-hidden">sobre {{ $project['title'] }}</span> <span aria-hidden="true">🔍</span>
                </button>
              </div>
            </article>
          @endforeach
        </div>
      </section>

      <!-- TESTIMONIAL / FRASE -->
      <section class="section testimonial">
        <blockquote class="reveal">“{{ $content['testimonial']['quote'] }}”</blockquote>
        <p class="reveal">— {{ $content['profile']['role'] }}</p>
      </section>

      <!-- CONTACTO & CV -->
      <section class="section contact" id="contacto">
        <div class="contact__panel reveal">
          <span class="eyebrow">📩 {{ $content['contact']['eyebrow'] }}</span>
          <h2>{{ $content['contact']['title'] }}</h2>
          <p>{{ $content['contact']['description'] }}</p>

          @if (session('status'))
            <div class="form-status form-status--ok" id="contact-status" role="status" tabindex="-1" data-focus-on-load>{{ session('status') }}</div>
          @elseif ($errors->any())
            <div class="form-status form-status--error" id="contact-status" role="alert" tabindex="-1" data-focus-on-load>
              Revisa {{ $errors->count() === 1 ? 'el campo marcado' : 'los '.$errors->count().' campos marcados' }}; tu mensaje sigue guardado aquí abajo.
            </div>
          @endif

          <form class="contact-form" action="{{ route('contact.store') }}" method="post" data-contact-form novalidate>
            @csrf
            <label>
              Nombre
              <input type="text" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name"
                     placeholder="Tu nombre completo"
                     @error('name') aria-invalid="true" aria-describedby="error-name" @enderror />
              @error('name')<small class="form-error" id="error-name">{{ $message }}</small>@enderror
            </label>
            <label>
              Correo
              <input type="email" name="email" value="{{ old('email') }}" required maxlength="160" autocomplete="email" inputmode="email"
                     placeholder="ejemplo@correo.com"
                     @error('email') aria-invalid="true" aria-describedby="error-email" @enderror />
              @error('email')<small class="form-error" id="error-email">{{ $message }}</small>@enderror
            </label>
            <label class="contact-form__full">
              <span>Marca o empresa <span class="contact-form__optional">(opcional)</span></span>
              <input type="text" name="company" value="{{ old('company') }}" maxlength="160" autocomplete="organization"
                     placeholder="Nombre de tu marca o negocio"
                     @error('company') aria-invalid="true" aria-describedby="error-company" @enderror />
              @error('company')<small class="form-error" id="error-company">{{ $message }}</small>@enderror
            </label>
            <label class="contact-form__full">
              Mensaje
              <textarea name="message" rows="5" required minlength="10" maxlength="1500"
                        placeholder="Cuéntame sobre tu proyecto o marca..."
                        @error('message') aria-invalid="true" aria-describedby="error-message" @enderror>{{ old('message') }}</textarea>
              @error('message')<small class="form-error" id="error-message">{{ $message }}</small>@enderror
            </label>
            <div class="contact-form__trap" aria-hidden="true">
              <label>No llenes este campo <input type="text" name="website" value="" tabindex="-1" autocomplete="off" /></label>
            </div>
            <button class="button button--primary" type="submit" data-submit data-sending-label="Enviando…">{{ $content['contact']['button'] }}</button>
          </form>

          @php
            $activeCvId = $content['cv']['active_id'] ?? null;
            $activeCv = null;
            if (!empty($content['cv']['items'])) {
                foreach ($content['cv']['items'] as $item) {
                    if ($item['id'] === $activeCvId) {
                        $activeCv = $item;
                        break;
                    }
                }
                if (!$activeCv) {
                    $activeCv = $content['cv']['items'][0];
                }
            }
          @endphp

          <div class="contact__links">
            <a href="mailto:{{ $content['profile']['email'] }}">📧 {{ $content['profile']['email'] }}</a>
            <a href="https://wa.me/{{ $content['profile']['whatsapp'] }}" target="_blank" rel="noreferrer">💬 {{ $content['profile']['phone'] }}</a>
            <a href="{{ $content['profile']['linkedin'] }}" target="_blank" rel="noreferrer">💼 LinkedIn</a>
            <span>📍 {{ $content['profile']['location'] }}</span>
            @if ($activeCv)
              <a class="button-cv" href="{{ asset($activeCv['file_path']) }}" download target="_blank" rel="noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Descargar CV en PDF
              </a>
            @endif
          </div>
        </div>
      </section>
    </main>

    <footer class="footer">
      <p>© <span data-year></span> {{ $content['profile']['name'] }}. Todos los derechos reservados.</p>
      <a href="#inicio">Volver arriba ↑</a>
    </footer>

    <!-- Ventana Modal de Ampliación de Proyectos -->
    <div class="project-modal-backdrop" id="project-detail-modal" data-project-modal aria-hidden="true">
      <div class="project-modal-box" role="dialog" aria-modal="true" aria-labelledby="pm-title" aria-describedby="pm-description">
        <button class="project-modal-close-btn" type="button" data-project-close aria-label="Cerrar detalle del proyecto">✕</button>
        <div class="project-modal-img-container" data-project-media hidden>
          <img id="pm-image" alt="" />
        </div>
        <div class="project-modal-body-container">
          <span class="project-modal-badge" id="pm-category"></span>
          <h2 class="project-modal-heading" id="pm-title"></h2>
          <div class="project-modal-line"></div>
          <p class="project-modal-text" id="pm-description"></p>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/script.js') }}?v={{ time() }}"></script>
  </body>
</html>

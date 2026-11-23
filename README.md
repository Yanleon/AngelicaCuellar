# Portafolio Laravel - Angelica Cuellar

Proyecto profesional en Laravel para portafolios personales o comerciales. Incluye landing responsive, contenido editable desde panel privado, formulario de contacto, base de datos MySQL y panel simple para revisar leads.

## Requisitos

- PHP 8.2 o superior.
- Composer 2.
- MySQL o MariaDB.
- Extensiones PHP comunes de Laravel habilitadas.

## Instalacion local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Abrir:

```text
http://127.0.0.1:8000
```

## Backend incluido

- `GET /`: portafolio publico.
- `POST /contacto`: recibe y valida mensajes del formulario.
- `GET /admin`: acceso privado con correo y clave.
- `GET /admin/dashboard`: dashboard principal del backend.
- `GET /admin/contenido`: editor de contenido del sitio.
- `POST /admin/contenido`: guarda textos, enlaces e imagenes del sitio.
- `GET /admin/mensajes`: panel privado para revisar mensajes.

Los mensajes se guardan en la tabla:

```text
contact_messages
```

El contenido editable del sitio se guarda en:

```text
portfolio_contents
```

Desde `/admin/contenido` se puede cambiar:

- SEO: titulo y descripcion.
- Datos personales: nombre, rol, correo, telefono, WhatsApp, ubicacion y LinkedIn.
- Portada: textos, botones, notas flotantes e imagen principal.
- Metricas.
- Sobre mi y fortalezas.
- Experiencia o servicios.
- Marcas trabajadas.
- Herramientas: nombre, categoria, nivel y logo.
- Proyectos, textos e imagenes.
- Frase destacada.
- Seccion de contacto.

## Configuracion importante

En `.env`, cambia:

```env
APP_NAME="Portafolio Angelica Cuellar"
APP_URL=https://tudominio.com
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=angelicacuellar
DB_USERNAME=root
DB_PASSWORD=
ADMIN_EMAIL=tu-correo@tudominio.com
ADMIN_PASSWORD_HASH='hash-de-tu-clave'
```

Para generar el hash de la clave (dejalo entre comillas simples, porque lleva `$`):

```bash
php -r "echo password_hash('TU_CLAVE', PASSWORD_BCRYPT, ['cost' => 12]);"
```

El acceso al panel es:

```text
https://tudominio.com/admin
```

Una vez dentro, el sistema redirige al dashboard. Desde ahi se entra a cada modulo por separado: General, Portada, Metricas, Sobre mi, Experiencia, Marcas, Herramientas, Proyectos, Contacto y Hoja de Vida. Cada modulo tiene su propio formulario y se guarda de manera independiente.

Las imagenes y hojas de vida subidas (`public/uploads`) y la base de datos no se versionan: hay que copiarlas aparte al desplegar.

## Despliegue en Hostinger

Opcion recomendada si Hostinger permite apuntar el dominio a la carpeta `public`:

1. Subir todo el proyecto al hosting.
2. Configurar el dominio para que apunte a `portfolio-laravel/public`.
3. Ejecutar `composer install --no-dev --optimize-autoloader`.
4. Configurar `.env` con `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` real y credenciales MySQL de Hostinger.
5. Ejecutar `php artisan migrate --force`.
6. Ejecutar `php artisan config:cache` y `php artisan route:cache`.

Si el hosting solo permite usar `public_html`, se puede subir el contenido de `public` a `public_html` y dejar el resto del proyecto fuera de `public_html`, ajustando las rutas de `index.php`. Esa configuracion depende del panel exacto de Hostinger.

## Archivos principales

- `app/Http/Controllers/PortfolioController.php`: datos visibles del portafolio.
- `app/Http/Controllers/ContactController.php`: validacion, guardado de mensajes y panel privado.
- `app/Http/Controllers/AdminContentController.php`: editor de contenido del frontend.
- `app/Models/ContactMessage.php`: modelo Eloquent de mensajes.
- `app/Models/PortfolioContent.php`: modelo Eloquent del contenido editable.
- `database/migrations/*_create_contact_messages_table.php`: tabla de leads/contactos.
- `database/migrations/*_create_portfolio_contents_table.php`: tabla del contenido editable.
- `resources/views/portfolio/show.blade.php`: vista principal.
- `resources/views/admin/login.blade.php`: login privado.
- `resources/views/admin/content.blade.php`: formulario para editar el frontend.
- `resources/views/admin/messages.blade.php`: vista privada de mensajes.
- `public/assets`: CSS, JS e imagenes del portafolio.
- `public/uploads`: imagenes subidas desde el panel.
- `config/portfolio.php`: credenciales del administrador.

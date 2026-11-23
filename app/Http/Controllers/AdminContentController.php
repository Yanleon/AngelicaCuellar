<?php

namespace App\Http\Controllers;

use App\Models\PortfolioContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminContentController extends Controller
{
    public const MAX_HERO_NOTES = 4;

    private const LINKEDIN_PROFILE = '#^https://([a-z]{2,3}\.)?linkedin\.com/(in|company)/[^/?\#\s]+/?$#i';

    private array $sections = [
        'general' => 'General',
        'portada' => 'Portada',
        'metricas' => 'Métricas',
        'sobre-mi' => 'Sobre mí',
        'experiencia' => 'Experiencia',
        'marcas' => 'Marcas',
        'herramientas' => 'Herramientas',
        'proyectos' => 'Proyectos',
        'contacto' => 'Contacto',
        'cv' => 'Hoja de Vida',
    ];

    public function edit(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $activeSection = $request->query('section', 'general');

        if (! array_key_exists($activeSection, $this->sections)) {
            $activeSection = 'general';
        }

        return view('admin.content', [
            'content' => PortfolioContent::current(),
            'sections' => $this->sections,
            'activeSection' => $activeSection,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $section = $request->input('section', 'general');

        abort_unless(array_key_exists($section, $this->sections), 404);

        $current = PortfolioContent::current();
        $payload = [];

        if ($section === 'general') {
            $payload = $request->validate([
                'section' => ['required', 'string'],
                'seo.title' => ['required', 'string', 'max:180'],
                'seo.description' => ['required', 'string', 'max:300'],
                'profile.name' => ['required', 'string', 'max:140'],
                'profile.role' => ['required', 'string', 'max:220'],
                'profile.email' => ['required', 'email', 'max:160'],
                'profile.phone' => ['required', 'string', 'max:80'],
                'profile.whatsapp' => ['required', 'string', 'max:40'],
                'profile.location' => ['required', 'string', 'max:120'],
                'profile.linkedin' => ['required', 'url:https', 'max:400', 'regex:'.self::LINKEDIN_PROFILE],
            ], [
                'profile.linkedin.url' => 'El enlace de LinkedIn debe empezar por https://',
                'profile.linkedin.regex' => 'Usa el enlace de tu perfil (linkedin.com/in/tu-nombre), no el de una búsqueda.',
                'profile.email.email' => 'El correo no tiene un formato válido.',
            ]);
        }

        if ($section === 'portada') {
            $payload = $request->validate([
                'section' => ['required', 'string'],
                'hero.eyebrow' => ['required', 'string', 'max:120'],
                'hero.title' => ['required', 'string', 'max:160'],
                'hero.description' => ['required', 'string', 'max:900'],
                'hero.primary_button' => ['required', 'string', 'max:80'],
                'hero.secondary_button' => ['required', 'string', 'max:80'],
                'hero.card_label' => ['required', 'string', 'max:120'],
                'hero.card_text' => ['required', 'string', 'max:220'],
                'hero.notes' => ['nullable', 'array', 'max:'.self::MAX_HERO_NOTES],
                'hero.notes.*' => ['nullable', 'string', 'max:30'],
                'hero_image' => ['nullable', 'image', 'max:4096'],
            ], [
                'hero.notes.max' => 'La portada admite máximo '.self::MAX_HERO_NOTES.' notas flotantes; más de eso tapa la foto.',
                'hero.notes.*.max' => 'Cada nota flotante puede tener máximo :max caracteres.',
                'hero_image.image' => 'La imagen de portada debe ser JPG, PNG o WebP.',
                'hero_image.max' => 'La imagen de portada pesa demasiado (máximo 4 MB).',
            ]);

            $payload['hero']['image'] = $current['hero']['image'];
            $payload['hero']['notes'] = array_values(array_filter(array_map('trim', $payload['hero']['notes'] ?? [])));
            $payload['hero']['note_one'] = $payload['hero']['notes'][0] ?? '';
            $payload['hero']['note_two'] = $payload['hero']['notes'][1] ?? '';

            if ($request->hasFile('hero_image')) {
                $payload['hero']['image'] = $this->upload($request->file('hero_image'));
            }
        }

        if ($section === 'metricas') {
            $payload = $request->validate([
                'section' => ['required', 'string'],
                'metrics' => ['required', 'array', 'size:3'],
                'metrics.*.value' => ['required', 'string', 'max:30'],
                'metrics.*.label' => ['required', 'string', 'max:120'],
            ]);
        }

        if ($section === 'sobre-mi') {
            $data = $request->validate([
                'section' => ['required', 'string'],
                'about.eyebrow' => ['required', 'string', 'max:80'],
                'about.title' => ['required', 'string', 'max:220'],
                'about.card_title' => ['required', 'string', 'max:120'],
                'about.description' => ['required', 'string', 'max:1200'],
                'about.strengths_title' => ['required', 'string', 'max:120'],
                'strengths_text' => ['required', 'string', 'max:1000'],
            ]);

            $payload['about'] = $data['about'];
            $payload['about']['strengths'] = $this->lines($data['strengths_text']);
        }

        if ($section === 'experiencia') {
            $payload = $request->validate([
                'section' => ['required', 'string'],
                'experience.eyebrow' => ['required', 'string', 'max:80'],
                'experience.title' => ['required', 'string', 'max:220'],
                'experience.items' => ['required', 'array', 'size:3'],
                'experience.items.*.title' => ['required', 'string', 'max:140'],
                'experience.items.*.description' => ['required', 'string', 'max:400'],
            ]);
        }

        if ($section === 'marcas') {
            $data = $request->validate([
                'section' => ['required', 'string'],
                'brands.eyebrow' => ['required', 'string', 'max:80'],
                'brands.title' => ['required', 'string', 'max:160'],
                'brands.items' => ['required', 'array', 'min:1', 'max:24'],
                'brands.items.*.name' => ['required', 'string', 'max:120'],
                'brands.items.*.logo' => ['nullable', 'string', 'max:400'],
                'brands.items.*.url' => ['nullable', 'url:http,https', 'max:400'],
                'brand_logos.*' => ['nullable', 'image', 'max:4096'],
            ], [
                'brands.items.*.name.required' => 'Cada marca necesita un nombre.',
                'brands.items.*.url.url' => 'El enlace de ":input" no es válido; debe empezar por https://',
                'brand_logos.*.image' => 'El logo debe ser una imagen (PNG, JPG, WebP o SVG).',
                'brand_logos.*.max' => 'El logo pesa demasiado (máximo 4 MB).',
            ]);

            $payload['brands'] = $data['brands'];

            foreach ($payload['brands']['items'] as $index => $brand) {
                // El formulario envía el logo actual; nunca heredarlo de la marca que ocupaba esta posición.
                $payload['brands']['items'][$index]['logo'] = $brand['logo'] ?? null;
                $payload['brands']['items'][$index]['url'] = $brand['url'] ?? null;
            }

            $missingLogos = [];

            foreach ($payload['brands']['items'] as $index => $brand) {
                if (blank($brand['logo'] ?? null) && ! $request->hasFile("brand_logos.$index")) {
                    $missingLogos["brands.items.$index.logo"] = 'Sube el logo de "'.$brand['name'].'"; sin logo la marca se ve incompleta en el portafolio.';
                }
            }

            if ($missingLogos) {
                throw ValidationException::withMessages($missingLogos);
            }

            foreach ($request->file('brand_logos', []) as $index => $logo) {
                if ($logo) {
                    $payload['brands']['items'][$index]['logo'] = $this->upload($logo);
                }
            }
        }

        if ($section === 'herramientas') {
            $data = $request->validate([
                'section' => ['required', 'string'],
                'skills.eyebrow' => ['required', 'string', 'max:80'],
                'skills.title' => ['required', 'string', 'max:160'],
                'skills.items' => ['required', 'array', 'min:1', 'max:40'],
                'skills.items.*.name' => ['required', 'string', 'max:60'],
                'skills.items.*.category' => ['required', 'string', 'max:40'],
                'skills.items.*.level' => ['required', 'integer', 'between:1,'.count(PortfolioContent::SKILL_LEVELS)],
                'skills.items.*.logo' => ['nullable', 'string', 'max:400'],
                'skills.items.*.remove_logo' => ['nullable', 'boolean'],
                'skill_logos' => ['nullable', 'array'],
                'skill_logos.*' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:1024'],
            ], [
                'skill_logos.*.mimes' => 'El logo debe ser PNG, JPG o WebP.',
                'skill_logos.*.max' => 'El logo pesa demasiado (máximo 1 MB); usa una imagen pequeña.',
                'skills.items.min' => 'Agrega al menos una herramienta.',
                'skills.items.*.name.required' => 'Cada herramienta necesita un nombre.',
                'skills.items.*.category.required' => 'Indica la categoría de ":input" (por ejemplo: Diseño, Video).',
                'skills.items.*.level' => 'Elige un nivel de conocimiento válido para cada herramienta.',
            ]);

            $payload['skills'] = $data['skills'];
            $payload['skills']['items'] = [];

            foreach ($data['skills']['items'] as $index => $item) {
                $logo = $this->safeUploadPath($item['logo'] ?? null);

                if (! empty($item['remove_logo'])) {
                    $logo = null;
                }

                if ($request->hasFile("skill_logos.$index")) {
                    $logo = $this->upload($request->file("skill_logos.$index"));
                }

                $payload['skills']['items'][] = [
                    'name' => trim($item['name']),
                    'category' => trim($item['category']),
                    'level' => (int) $item['level'],
                    'logo' => $logo,
                ];
            }
        }

        if ($section === 'proyectos') {
            $data = $request->validate([
                'section' => ['required', 'string'],
                'projects.eyebrow' => ['required', 'string', 'max:80'],
                'projects.title' => ['required', 'string', 'max:160'],
                'projects.items' => ['required', 'array', 'min:1', 'max:50'],
                'projects.items.*.category' => ['required', 'string', 'max:100'],
                'projects.items.*.title' => ['required', 'string', 'max:160'],
                'projects.items.*.description' => ['required', 'string', 'max:600'],
                'projects.items.*.image' => ['nullable', 'string', 'max:400'],
                'projects.items.*.url' => ['nullable', 'string', 'max:500'],
                'project_images.*' => ['nullable', 'image', 'max:4096'],
            ]);

            $payload['projects'] = $data['projects'];

            foreach ($payload['projects']['items'] as $index => $project) {
                $currentProject = $current['projects']['items'][$index] ?? [];
                $payload['projects']['items'][$index]['image'] = is_array($currentProject)
                    ? ($project['image'] ?? $currentProject['image'] ?? 'assets/2.png')
                    : ($project['image'] ?? 'assets/2.png');
            }

            foreach ($request->file('project_images', []) as $index => $image) {
                if ($image) {
                    $payload['projects']['items'][$index]['image'] = $this->upload($image);
                }
            }
        }

        if ($section === 'contacto') {
            $payload = $request->validate([
                'section' => ['required', 'string'],
                'testimonial.quote' => ['required', 'string', 'max:500'],
                'contact.eyebrow' => ['required', 'string', 'max:80'],
                'contact.title' => ['required', 'string', 'max:160'],
                'contact.description' => ['required', 'string', 'max:500'],
                'contact.button' => ['required', 'string', 'max:80'],
            ]);
        }

        if ($section === 'cv') {
            $cvData = $current['cv'] ?? ['active_id' => null, 'items' => []];
            $cvItems = $cvData['items'] ?? [];
            $activeId = $cvData['active_id'] ?? null;
            $action = $request->input('cv_action', 'upload');

            if ($action === 'upload' && $request->hasFile('cv_file')) {
                $request->validate([
                    'cv_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
                    'cv_title' => ['nullable', 'string', 'max:150'],
                ]);

                $file = $request->file('cv_file');
                $originalName = $file->getClientOriginalName();
                $rawSize = $file->getSize();
                $title = trim((string) $request->input('cv_title')) ?: pathinfo($originalName, PATHINFO_FILENAME);

                File::ensureDirectoryExists(public_path('uploads/cvs'));
                $fileName = uniqid('cv_', true) . '.pdf';
                $file->move(public_path('uploads/cvs'), $fileName);
                $filePath = 'uploads/cvs/' . $fileName;

                $sizeInKb = round($rawSize / 1024, 1);
                $formattedSize = $sizeInKb > 1024 ? round($sizeInKb / 1024, 2) . ' MB' : $sizeInKb . ' KB';

                $newItemId = uniqid('cv_item_');
                $newItem = [
                    'id' => $newItemId,
                    'title' => $title,
                    'file_path' => $filePath,
                    'file_name' => $originalName,
                    'size' => $formattedSize,
                    'uploaded_at' => date('d/m/Y H:i'),
                ];

                array_unshift($cvItems, $newItem);

                if (empty($activeId) || count($cvItems) === 1) {
                    $activeId = $newItemId;
                }
            } elseif ($action === 'set_active') {
                $targetId = $request->input('cv_id');
                foreach ($cvItems as $item) {
                    if ($item['id'] === $targetId) {
                        $activeId = $targetId;
                        break;
                    }
                }
            } elseif ($action === 'delete') {
                $targetId = $request->input('cv_id');
                $updatedItems = [];
                foreach ($cvItems as $item) {
                    if ($item['id'] === $targetId) {
                        $fullPath = public_path($item['file_path']);
                        if (File::exists($fullPath)) {
                            File::delete($fullPath);
                        }
                    } else {
                        $updatedItems[] = $item;
                    }
                }
                $cvItems = $updatedItems;
                if ($activeId === $targetId) {
                    $activeId = count($cvItems) > 0 ? $cvItems[0]['id'] : null;
                }
            } elseif ($action === 'update_titles') {
                $titles = $request->input('cv_titles', []);
                foreach ($cvItems as $idx => $item) {
                    if (isset($titles[$item['id']])) {
                        $cvItems[$idx]['title'] = trim((string) $titles[$item['id']]);
                    }
                }
            }

            $payload['cv'] = [
                'active_id' => $activeId,
                'items' => array_values($cvItems),
            ];
        }

        unset($payload['section']);

        if ($section === 'marcas') {
            PortfolioContent::saveMainReplacing($payload, ['brands']);
        } elseif ($section === 'herramientas') {
            PortfolioContent::saveMainReplacing($payload, ['skills']);
        } elseif ($section === 'proyectos') {
            PortfolioContent::saveMainReplacing($payload, ['projects']);
        } elseif ($section === 'cv') {
            PortfolioContent::saveMainReplacing($payload, ['cv']);
        } else {
            PortfolioContent::saveMain($payload);
        }

        return redirect()
            ->route('admin.content.edit', ['section' => $section])
            ->with('status', 'Módulo actualizado correctamente.');
    }

    private function authorizeAdmin(Request $request): ?RedirectResponse
    {
        if (! (bool) $request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    private function lines(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }

    /**
     * Solo acepta rutas de archivos ya subidos al portafolio (evita que el formulario apunte a otros archivos).
     */
    private function safeUploadPath(?string $path): ?string
    {
        if (blank($path) || ! str_starts_with($path, 'uploads/') || str_contains($path, '..')) {
            return null;
        }

        return $path;
    }

    private function upload($file): string
    {
        File::ensureDirectoryExists(public_path('uploads'));

        // Extensión según el contenido real del archivo, nunca la que envía el navegador
        // (Laravel ya bloquea .php, pero no otras como .html, que se servirían como página).
        $extension = match ($file->extension()) {
            'jpeg', 'jpg' => 'jpg',
            'png' => 'png',
            'webp' => 'webp',
            'gif' => 'gif',
            default => abort(422, 'Formato de imagen no permitido.'),
        };

        $name = uniqid('portfolio_', true).'.'.$extension;
        $file->move(public_path('uploads'), $name);

        return 'uploads/'.$name;
    }
}

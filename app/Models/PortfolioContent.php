<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioContent extends Model
{
    public const SKILL_LEVELS = [
        1 => 'Básico',
        2 => 'Intermedio',
        3 => 'Avanzado',
        4 => 'Experto',
    ];

    protected $fillable = ['key', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public static function current(): array
    {
        $content = static::query()->where('key', 'main')->first();

        $data = $content?->data ?? [];
        $merged = array_replace_recursive(static::defaults(), $data);

        if (isset($data['brands']['items']) && is_array($data['brands']['items'])) {
            $merged['brands']['items'] = $data['brands']['items'];
        }

        if (isset($data['projects']['items']) && is_array($data['projects']['items'])) {
            $merged['projects']['items'] = $data['projects']['items'];
        }

        if (isset($data['skills']['items']) && is_array($data['skills']['items'])) {
            $merged['skills']['items'] = $data['skills']['items'];
        }

        if (isset($data['cv']['items']) && is_array($data['cv']['items'])) {
            $merged['cv']['items'] = $data['cv']['items'];
        }

        if (! isset($merged['hero']['notes']) || ! is_array($merged['hero']['notes'])) {
            $merged['hero']['notes'] = array_values(array_filter([
                $merged['hero']['note_one'] ?? null,
                $merged['hero']['note_two'] ?? null,
            ]));
        }

        return $merged;
    }

    public static function saveMain(array $data): void
    {
        static::query()->updateOrCreate(
            ['key' => 'main'],
            ['data' => array_replace_recursive(static::current(), $data)]
        );
    }

    public static function saveMainReplacing(array $data, array $keys): void
    {
        $merged = array_replace_recursive(static::current(), $data);

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $merged[$key] = $data[$key];
            }
        }

        static::query()->updateOrCreate(
            ['key' => 'main'],
            ['data' => $merged]
        );
    }

    public static function defaults(): array
    {
        return [
            'seo' => [
                'title' => 'Angélica Cuéllar | Social Media & Content Strategist',
                'description' => 'Portafolio profesional de Angélica Cuéllar: comunicadora social, social media, content strategist, marca y comunicaciones.',
            ],
            'profile' => [
                'name' => 'Angélica Cuéllar',
                'role' => 'Comunicadora Social | Social Media & Content Strategist | Brand & Communications',
                'email' => 'ange_1805@hotmail.com',
                'phone' => '+57 311 649 1875',
                'whatsapp' => '573116491875',
                'location' => 'Bogotá, Colombia',
                'linkedin' => 'https://www.linkedin.com/search/results/all/?keywords=Ang%C3%A9lica%20Mar%C3%ADa%20Cu%C3%A9llar%20Arias',
            ],
            'hero' => [
                'eyebrow' => 'Social Media & Content Strategist',
                'title' => 'Angélica Cuéllar',
                'description' => 'Comunicadora Social especializada en estrategia de contenidos, redes sociales y comunicaciones digitales. He liderado operaciones de social media, coordinando equipos multidisciplinarios, agencias y proveedores externos para garantizar consistencia de marca y excelencia en la ejecución.',
                'primary_button' => 'Ver trabajo',
                'secondary_button' => 'Hablemos',
                'image' => 'assets/1.png',
                'card_label' => 'Brand & Communications',
                'card_text' => 'Contenido estratégico para fortalecer presencia digital y generar resultados.',
                'note_one' => 'Marca',
                'note_two' => 'Comunidad',
                'notes' => ['Marca', 'Comunidad'],
            ],
            'metrics' => [
                ['value' => '4K+', 'label' => 'Seguidores orgánicos en caso PayU GPO'],
                ['value' => '4', 'label' => 'Marcas destacadas trabajadas'],
                ['value' => '360', 'label' => 'Gestión integral de redes'],
            ],
            'about' => [
                'eyebrow' => 'Sobre mi',
                'title' => 'Estrategia, contenido y ejecución para marcas con presencia digital.',
                'card_title' => 'Mi enfoque',
                'description' => 'He participado en proyectos de posicionamiento y transformación de marca, conectando estrategia, contenido y ejecución para fortalecer la presencia digital y generar resultados. Mi trabajo une planeación, criterio visual, tono de comunicación y seguimiento de métricas para tomar mejores decisiones.',
                'strengths_title' => 'Fortalezas',
                'strengths' => [
                    'Planeación de parrillas de contenido',
                    'Diseño y publicación de piezas visuales',
                    'Análisis de alcance, interacción y crecimiento',
                    'Coherencia visual, tono y enfoque comercial',
                ],
            ],
            'experience' => [
                'eyebrow' => 'Experiencia',
                'title' => 'Trabajo con marcas, redes sociales y contenido digital',
                'items' => [
                    ['title' => 'Gestión integral de redes', 'description' => 'Conceptualización de ideas, planeación de parrillas, publicación, seguimiento y optimización de contenidos.'],
                    ['title' => 'Contenido digital', 'description' => 'Creación de carruseles, reels, historias, publicaciones estáticas, copies y materiales visuales alineados a marca.'],
                    ['title' => 'Marca y comunidad', 'description' => 'Trabajo orientado a fortalecer presencia digital, conectar con audiencias clave y construir comunidades activas.'],
                ],
            ],
            'brands' => [
                'eyebrow' => 'Trabajé con',
                'title' => 'Marcas y sectores',
                'items' => [
                    ['name' => 'Tejidos Richara', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'Linaje Real', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'Ángel Shop', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'PayU GPO', 'logo' => 'assets/2.png', 'url' => null],
                ],
            ],
            'skills' => [
                'eyebrow' => 'Herramientas',
                'title' => 'Herramientas que uso a diario',
                'items' => [
                    ['name' => 'Canva', 'category' => 'Diseño', 'level' => 4],
                    ['name' => 'Adobe Photoshop', 'category' => 'Diseño', 'level' => 3],
                    ['name' => 'Adobe Illustrator', 'category' => 'Diseño', 'level' => 3],
                    ['name' => 'Adobe Lightroom', 'category' => 'Diseño', 'level' => 3],
                    ['name' => 'Adobe Premiere Pro', 'category' => 'Video', 'level' => 3],
                    ['name' => 'CapCut', 'category' => 'Video', 'level' => 4],
                    ['name' => 'Meta Business Suite', 'category' => 'Redes y analítica', 'level' => 4],
                    ['name' => 'LinkedIn', 'category' => 'Redes y analítica', 'level' => 4],
                    ['name' => 'Metricool', 'category' => 'Redes y analítica', 'level' => 3],
                ],
            ],
            'projects' => [
                'eyebrow' => 'Proyectos',
                'title' => 'Proyectos destacados',
                'items' => [
                    ['category' => 'Redes sociales', 'title' => 'Gestión creativa y operativa', 'description' => 'Planeación, diseño, fotografía de producto, publicación, seguimiento y análisis de resultados.', 'image' => 'assets/3.png'],
                    ['category' => 'Marca y comunidad', 'title' => 'PayU GPO, a Rapyd Company', 'description' => 'Lideré LinkedIn durante la transición de marca, superando los 4.000 seguidores de forma orgánica.', 'image' => 'assets/4.png'],
                    ['category' => 'Marketing digital', 'title' => 'Contenido para distintas industrias', 'description' => 'Experiencia en fintech, ecommerce, eventos, moda, industria y posicionamiento de marca.', 'image' => 'assets/2.png'],
                ],
            ],
            'testimonial' => [
                'quote' => 'Conecto estrategia, contenido y ejecución para fortalecer la presencia digital de las marcas y generar resultados medibles.',
            ],
            'contact' => [
                'eyebrow' => 'Contacto',
                'title' => 'Trabajemos juntos',
                'description' => 'Disponible para proyectos de social media, estrategia de contenido, marca, comunicaciones digitales y acompañamiento a emprendedores.',
                'button' => 'Enviar mensaje',
            ],
            'cv' => [
                'active_id' => null,
                'items' => [],
            ],
        ];
    }
}

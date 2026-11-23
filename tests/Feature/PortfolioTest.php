<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\PortfolioContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Angélica Cuéllar')
            ->assertSee('Social Media');
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post('/contacto', [
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'company' => 'Marca Demo',
            'message' => 'Quiero una estrategia para redes sociales.',
        ])->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
        ]);
    }

    public function test_admin_requires_login_and_allows_authenticated_session(): void
    {
        ContactMessage::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'message' => 'Mensaje de prueba',
        ]);

        $this->get('/admin/mensajes')->assertRedirect('/PortafolioAngelica/admin');
        $this->withSession(['admin_authenticated' => true])
            ->get('/PortafolioAngelica/admin/mensajes')
            ->assertOk()
            ->assertSee('Cliente Demo');
    }

    public function test_admin_login_form_allows_valid_credentials(): void
    {
        config([
            'portfolio.admin_email' => 'admin@example.com',
            'portfolio.admin_password_hash' => bcrypt('secret-demo'),
        ]);

        $this->get('/admin')->assertOk()->assertSee('Panel privado');

        $this->post('/PortafolioAngelica/admin', [
            'email' => 'admin@example.com',
            'password' => 'secret-demo',
        ])
            ->assertRedirect('/PortafolioAngelica/admin/dashboard')
            ->assertSessionHas('admin_authenticated', true);
    }

    public function test_admin_dashboard_loads_with_session(): void
    {
        $this->withSession(['admin_authenticated' => true])
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Editar por categorías');
    }

    public function test_admin_can_update_frontend_content(): void
    {
        $payload = [
            'section' => 'portada',
            'hero' => PortfolioContent::defaults()['hero'],
        ];
        $payload['hero']['title'] = 'Nuevo titulo editable';

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=portada')
            ->assertSessionHas('status');

        $this->get('/PortafolioAngelica')
            ->assertOk()
            ->assertSee('Nuevo titulo editable');
    }

    public function test_admin_can_add_brand_with_logo(): void
    {
        $payload = [
            'section' => 'marcas',
            'brands' => [
                'eyebrow' => 'Trabajé con',
                'title' => 'Marcas y sectores',
                'items' => [
                    ['name' => 'Marca Uno', 'logo' => 'assets/2.png', 'url' => 'https://marca-uno.test'],
                    ['name' => 'Marca Nueva', 'logo' => null, 'url' => 'https://marca-nueva.test'],
                ],
            ],
            'brand_logos' => [
                1 => UploadedFile::fake()->image('marca-nueva.png', 120, 80),
            ],
        ];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=marcas');

        $brands = PortfolioContent::current()['brands']['items'];

        $this->assertCount(2, $brands);
        $this->assertSame('Marca Nueva', $brands[1]['name']);
        $this->assertSame('https://marca-nueva.test', $brands[1]['url']);
        $this->assertStringStartsWith('uploads/', $brands[1]['logo']);

        @unlink(public_path($brands[1]['logo']));
    }

    public function test_admin_can_update_hero_floating_notes(): void
    {
        $payload = [
            'section' => 'portada',
            'hero' => PortfolioContent::defaults()['hero'],
        ];
        $payload['hero']['notes'] = ['Marca', 'Estrategia'];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=portada');

        $this->assertSame(['Marca', 'Estrategia'], PortfolioContent::current()['hero']['notes']);
    }

    public function test_admin_rejects_more_than_four_hero_notes(): void
    {
        $payload = [
            'section' => 'portada',
            'hero' => PortfolioContent::defaults()['hero'],
        ];
        $payload['hero']['notes'] = ['Marca', 'Comunidad', 'Contenido', 'Estrategia', 'Quinta'];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasErrors('hero.notes');

        $this->assertSame(['Marca', 'Comunidad'], PortfolioContent::current()['hero']['notes']);
    }

    public function test_public_page_shows_at_most_four_hero_notes(): void
    {
        PortfolioContent::saveMain(['hero' => ['notes' => ['Uno', 'Dos', 'Tres', 'NotaCuatro', 'NotaCinco']]]);

        $this->get('/')
            ->assertOk()
            ->assertSee('NotaCuatro')
            ->assertDontSee('NotaCinco');
    }

    public function test_admin_accepts_four_hero_notes(): void
    {
        $payload = [
            'section' => 'portada',
            'hero' => PortfolioContent::defaults()['hero'],
        ];
        $payload['hero']['notes'] = ['Marca', 'Comunidad', 'Contenido', 'Estrategia'];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasNoErrors();

        $this->assertCount(4, PortfolioContent::current()['hero']['notes']);
    }

    private function generalPayload(string $linkedin): array
    {
        $defaults = PortfolioContent::defaults();
        $payload = ['section' => 'general', 'seo' => $defaults['seo'], 'profile' => $defaults['profile']];
        $payload['profile']['linkedin'] = $linkedin;

        return $payload;
    }

    public function test_admin_rejects_linkedin_search_url(): void
    {
        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $this->generalPayload('https://www.linkedin.com/search/results/all/?keywords=Angelica'))
            ->assertSessionHasErrors('profile.linkedin');
    }

    public function test_admin_accepts_linkedin_profile_url(): void
    {
        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $this->generalPayload('https://www.linkedin.com/in/angelica-cuellar/'))
            ->assertSessionHasNoErrors();

        $this->assertSame('https://www.linkedin.com/in/angelica-cuellar/', PortfolioContent::current()['profile']['linkedin']);
    }

    public function test_admin_rejects_brand_without_logo(): void
    {
        $payload = [
            'section' => 'marcas',
            'brands' => [
                'eyebrow' => 'Trabajé con',
                'title' => 'Marcas y sectores',
                'items' => [
                    ['name' => 'Marca Uno', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'Rapyd', 'logo' => null, 'url' => null],
                    ['name' => 'Marca Tres', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'Marca Cuatro', 'logo' => 'assets/2.png', 'url' => null],
                    ['name' => 'Marca Cinco', 'logo' => null, 'url' => null],
                ],
            ],
        ];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasErrors(['brands.items.1.logo', 'brands.items.4.logo']);
    }

    public function test_contact_form_returns_to_contact_section(): void
    {
        $this->post('/contacto', [
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'message' => 'Quiero una estrategia para redes sociales.',
        ])->assertRedirect('/PortafolioAngelica#contacto');
    }

    public function test_contact_form_errors_keep_the_message_and_return_to_contact_section(): void
    {
        $this->post('/contacto', [
            'name' => '',
            'email' => 'no-es-un-correo',
            'message' => 'Un mensaje largo que no debe perderse.',
        ])->assertRedirect('/PortafolioAngelica#contacto')
            ->assertSessionHasErrors(['name', 'email'])
            ->assertSessionHasInput('message', 'Un mensaje largo que no debe perderse.');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_honeypot_discards_bots(): void
    {
        $this->post('/contacto', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Compra seguidores baratos ahora.',
            'website' => 'https://spam.example',
        ])->assertRedirect('/PortafolioAngelica#contacto')
            ->assertSessionHas('status');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_skills_section_shows_tools_grouped_with_level(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('id="herramientas"', false)
            ->assertSeeInOrder(['Marcas y sectores', 'Herramientas que uso a diario', 'Proyectos destacados'])
            ->assertSee('Canva')
            ->assertSee('Experto');
    }

    public function test_admin_can_save_skills(): void
    {
        $payload = [
            'section' => 'herramientas',
            'skills' => [
                'eyebrow' => 'Herramientas',
                'title' => 'Mi caja de herramientas',
                'items' => [
                    ['name' => 'Canva', 'category' => 'Diseño', 'level' => '4'],
                    ['name' => 'Adobe After Effects', 'category' => 'Video', 'level' => '1'],
                ],
            ],
        ];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=herramientas')
            ->assertSessionHasNoErrors();

        $skills = PortfolioContent::current()['skills']['items'];
        $this->assertCount(2, $skills);
        $this->assertSame(1, $skills[1]['level']);

        $this->get('/PortafolioAngelica')
            ->assertOk()
            ->assertSee('Mi caja de herramientas')
            ->assertSee('Adobe After Effects')
            ->assertSee('Básico')
            ->assertDontSee('Metricool');
    }

    private function skillsPayload(array $items): array
    {
        return [
            'section' => 'herramientas',
            'skills' => ['eyebrow' => 'Herramientas', 'title' => 'Herramientas', 'items' => $items],
        ];
    }

    public function test_admin_can_upload_and_remove_a_skill_logo(): void
    {
        $payload = $this->skillsPayload([
            ['name' => 'Canva', 'category' => 'Diseño', 'level' => '4', 'logo' => ''],
            ['name' => 'CapCut', 'category' => 'Video', 'level' => '3', 'logo' => ''],
        ]);
        $payload['skill_logos'] = [0 => UploadedFile::fake()->image('canva.png', 64, 64)];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasNoErrors();

        $skills = PortfolioContent::current()['skills']['items'];
        $logo = $skills[0]['logo'];
        $this->assertMatchesRegularExpression('#^uploads/portfolio_[\w.]+\.png$#', $logo);
        $this->assertFileExists(public_path($logo));
        $this->assertNull($skills[1]['logo']);

        $this->get('/PortafolioAngelica')->assertSee($logo, false);

        // Se conserva al guardar sin subir otro, y se quita con la casilla
        $keep = $this->skillsPayload([['name' => 'Canva', 'category' => 'Diseño', 'level' => '4', 'logo' => $logo]]);
        $this->flushSession();
        $this->withSession(['admin_authenticated' => true])
            ->post('/PortafolioAngelica/admin/contenido', $keep)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=herramientas');
        $this->assertSame($logo, PortfolioContent::current()['skills']['items'][0]['logo']);

        $remove = $this->skillsPayload([['name' => 'Canva', 'category' => 'Diseño', 'level' => '4', 'logo' => $logo, 'remove_logo' => '1']]);
        $this->withSession(['admin_authenticated' => true])
            ->post('/PortafolioAngelica/admin/contenido', $remove)
            ->assertRedirect('/PortafolioAngelica/admin/contenido?section=herramientas');
        $this->assertNull(PortfolioContent::current()['skills']['items'][0]['logo']);

        @unlink(public_path($logo));
    }

    public function test_admin_rejects_non_image_skill_logo(): void
    {
        $payload = $this->skillsPayload([['name' => 'Canva', 'category' => 'Diseño', 'level' => '4']]);
        $payload['skill_logos'] = [0 => UploadedFile::fake()->create('logo.php', 2, 'application/x-php')];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasErrors('skill_logos.0');
    }

    public function test_skill_logo_path_cannot_point_outside_uploads(): void
    {
        $payload = $this->skillsPayload([['name' => 'Canva', 'category' => 'Diseño', 'level' => '4', 'logo' => '../.env']]);

        $this->withSession(['admin_authenticated' => true])->post('/admin/contenido', $payload);

        $this->assertNull(PortfolioContent::current()['skills']['items'][0]['logo']);
    }

    public function test_uploaded_image_is_saved_with_the_detected_extension(): void
    {
        $payload = $this->skillsPayload([['name' => 'Canva', 'category' => 'Diseño', 'level' => '4']]);
        // Imagen PNG real con nombre .html: debe guardarse como .png, nunca como .html
        $image = UploadedFile::fake()->image('logo.png', 32, 32);
        $payload['skill_logos'] = [0 => new \Illuminate\Http\UploadedFile($image->getPathname(), 'logo.html', 'image/png', null, true)];

        $this->withSession(['admin_authenticated' => true])->post('/admin/contenido', $payload);

        $logo = PortfolioContent::current()['skills']['items'][0]['logo'];
        $this->assertStringEndsWith('.png', $logo);
        @unlink(public_path($logo));
    }

    public function test_admin_rejects_invalid_skill_level(): void
    {
        $payload = [
            'section' => 'herramientas',
            'skills' => [
                'eyebrow' => 'Herramientas',
                'title' => 'Herramientas',
                'items' => [['name' => 'Canva', 'category' => 'Diseño', 'level' => '9']],
            ],
        ];

        $this->withSession(['admin_authenticated' => true])
            ->post('/admin/contenido', $payload)
            ->assertSessionHasErrors('skills.items.0.level');
    }

    public function test_admin_skills_editor_loads(): void
    {
        $this->withSession(['admin_authenticated' => true])
            ->get('/admin/contenido?section=herramientas')
            ->assertOk()
            ->assertSee('Nivel de conocimiento')
            ->assertSee('Adobe Photoshop');
    }

    public function test_project_cards_open_with_a_keyboard_reachable_button(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-project-open', false)
            ->assertSee('role="dialog"', false)
            ->assertDontSee('onclick=', false);
    }
}

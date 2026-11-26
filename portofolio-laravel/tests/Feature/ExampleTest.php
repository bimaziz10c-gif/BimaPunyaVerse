<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Database\Seeders\PortofolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(PortofolioSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('CV & Portofolio')
            ->assertSee('css/style.css')
            ->assertSee('img/profil.jpeg')
            ->assertSeeInOrder(['HTML/CSS', 'PHP', 'JavaScript', 'MySQL'])
            ->assertSee('Pemateri TRM Goes To School')
            ->assertSee('SMA Negeri 10 Surabaya')
            ->assertSee('Hotel Darmo');
    }

    public function test_projects_can_be_filtered_by_keyword(): void
    {
        $this->get('/?q=Poster')
            ->assertOk()
            ->assertSee('Poster TRM Goes To School')
            ->assertDontSee('Logo Identitas Brand');
    }

    public function test_contact_message_is_validated_and_saved(): void
    {
        $this->post('/kontak', [
            'nama' => 'Bima Aziz',
            'email' => 'bima@example.com',
            'pesan' => 'Halo, saya ingin berdiskusi.',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('pesan_kontak', [
            'nama' => 'Bima Aziz',
            'email' => 'bima@example.com',
            'pesan' => 'Halo, saya ingin berdiskusi.',
        ]);
    }

    public function test_invalid_contact_message_returns_validation_errors(): void
    {
        $this->from('/')
            ->post('/kontak', [
                'nama' => 'AB',
                'email' => 'bukan-email',
                'pesan' => 'pendek',
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors(['nama', 'email', 'pesan']);
    }

    public function test_admin_pages_require_authentication(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_log_in_and_manage_skills(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'a-strong-password',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'a-strong-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame('a-strong-password', $user->fresh()->password);
        $this->get('/admin')->assertOk()->assertSee('Dashboard Admin');
        $this->get('/admin/pesan')->assertOk()->assertSee('Daftar Pesan Masuk');
        $this->get('/admin/skills/create')->assertOk()->assertSee('Tambah Keahlian');

        $this->post('/admin/skills', [
            'nama_skill' => 'Laravel',
            'tingkat' => 80,
        ])->assertRedirect(route('admin.dashboard'));

        $skill = Skill::query()->where('nama', 'Laravel')->firstOrFail();
        $this->assertDatabaseHas('skills', [
            'nama' => 'Laravel',
            'level' => 80,
        ]);
        $this->get('/admin/skills/'.$skill->id.'/edit')
            ->assertOk()
            ->assertSee('Edit Keahlian');
        $this->put('/admin/skills/'.$skill->id, [
            'nama_skill' => 'Laravel Framework',
            'tingkat' => 90,
        ])->assertRedirect(route('admin.dashboard'));

        $this->delete('/admin/skills/'.$skill->id)
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseMissing('skills', ['nama' => 'Laravel Framework']);

        $this->post('/admin/logout')
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PesanKontak;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'skills' => Skill::query()->orderByDesc('level')->get(),
        ]);
    }

    public function messages(): View
    {
        return view('admin.messages', [
            'messages' => PesanKontak::query()->orderByDesc('id')->get(),
        ]);
    }

    public function createSkill(): View
    {
        return view('admin.skill-form', ['skill' => new Skill]);
    }

    public function storeSkill(Request $request): RedirectResponse
    {
        $validated = $this->validatedSkill($request);
        Skill::query()->create([
            'nama' => $validated['nama_skill'],
            'level' => $validated['tingkat'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function editSkill(Skill $skill): View
    {
        return view('admin.skill-form', ['skill' => $skill]);
    }

    public function updateSkill(Request $request, Skill $skill): RedirectResponse
    {
        $validated = $this->validatedSkill($request);
        $skill->update([
            'nama' => $validated['nama_skill'],
            'level' => $validated['tingkat'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function destroySkill(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.dashboard');
    }

    private function validatedSkill(Request $request): array
    {
        return $request->validate([
            'nama_skill' => ['required', 'string', 'max:150'],
            'tingkat' => ['required', 'integer', 'between:0,100'],
        ], [
            'nama_skill.required' => 'Nama skill wajib diisi.',
            'tingkat.required' => 'Tingkat wajib diisi.',
            'tingkat.between' => 'Tingkat harus berada di antara 0 dan 100.',
        ]);
    }
}

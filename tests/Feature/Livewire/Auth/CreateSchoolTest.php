<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\CreateSchool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateSchoolTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(CreateSchool::class)
            ->assertStatus(200);
    }
}

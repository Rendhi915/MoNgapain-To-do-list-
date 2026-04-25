<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Kerja',
            'color' => '#2196F3',
        ]);

        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Kerja',
            'color' => '#2196F3',
        ]);
    }

    public function test_user_cannot_use_duplicate_category_name_for_themselves(): void
    {
        $user = User::factory()->create();

        Category::create([
            'user_id' => $user->id,
            'name' => 'Belajar',
            'color' => '#00A86B',
        ]);

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Belajar',
            'color' => '#673AB7',
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_user_can_update_and_delete_own_category(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Pribadi',
            'color' => '#FF9800',
        ]);

        $updateResponse = $this->actingAs($user)->put(route('categories.update', $category), [
            'name' => 'Rumah',
            'color' => '#F44336',
        ]);

        $updateResponse->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Rumah',
            'color' => '#F44336',
        ]);

        $deleteResponse = $this->actingAs($user)->delete(route('categories.destroy', $category));

        $deleteResponse->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_should_return_categories_index()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/categories');
        $response->assertViewIs('categories.index');
        $response->assertViewHas('categories');
    }

    public function test_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/categories');

        $response->assertRedirect('/');
    }


    public function test_create_should_return_view()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/categories/create');

        $response->assertViewIs('categories.create');
    }

    public function test_create_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/categories/create');

        $response->assertRedirect('/');
    }

    public function test_store_should_create_category()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->make();
        $response = $this->actingAs($adminUser)->post('/categories/create', $category->toArray());

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', $category->toArray());
    }

    public function test_store_shouldnt_create_category_if_already_exists()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $response = $this->actingAs($adminUser)->post('/categories/create', $category->toArray());

        $response->assertSessionHasErrors('name');
    }

    public function test_store_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $category = Category::factory()->make();
        $response = $this->actingAs($user)->post('/categories/create', $category->toArray());

        $response->assertRedirect('/');
    }

    public function test_edit_should_return_view()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $response = $this->actingAs($adminUser)->get('/categories/' . $category->id . '/edit');

        $response->assertViewIs('categories.update');
        $response->assertViewHas('category', $category);
    }

    public function test_edit_should_redirect_back_if_not_exists()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $uuid = Str::uuid();
        $response = $this->actingAs($adminUser)->get("/categories/$uuid/edit");

        $response->assertRedirect('/categories');
        $response->assertSessionHas('flash_notification');
    }

    public function test_edit_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $category = Category::first();
        $response = $this->actingAs($user)->get('/categories/' . $category->id . '/edit');

        $response->assertRedirect('/');
    }

    public function test_update_should_update_category()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $category->name = 'New name';
        $response = $this->actingAs($adminUser)->put('/categories/' . $category->id, $category->toArray());

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', $category->toArray());
    }

    public function test_update_should_redirect_back_if_not_exists()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $uuid = Str::uuid();
        $response = $this->actingAs($adminUser)->put("/categories/$uuid", ['name' => 'New name']);

        $response->assertRedirect('/categories');
        $response->assertSessionHas('flash_notification');
    }

    public function test_update_should_show_errors_if_category_already_exists()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $category2 = Category::factory()->create();
        $category->name = $category2->name;
        $response = $this->actingAs($adminUser)->put('/categories/' . $category->id, $category->toArray());

        $response->assertSessionHasErrors('name');
    }

    public function test_update_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $category = Category::first();
        $category->name = 'New name';
        $response = $this->actingAs($user)->put('/categories/' . $category->id, $category->toArray());

        $response->assertRedirect('/');
    }

    public function test_toggle_active_should_toggle_category()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $response = $this->actingAs($adminUser)->get('/categories/' . $category->id . '/toggle-active');

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_deleted' => !$category->is_deleted
        ]);
    }

    public function test_toggle_active_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $category = Category::first();
        $response = $this->actingAs($user)->get('/categories/' . $category->id . '/toggle-active');

        $response->assertRedirect('/');
    }

    public function test_destroy_should_delete_category()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $category = new Category(['name' => 'Test category']);
        $category->save();
        $response = $this->actingAs($adminUser)->delete('/categories/' . $category->id);

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    public function test_destroy_should_redirect_back_if_normal_user()
    {
        $user = User::factory()->create();
        $category = Category::first();
        $response = $this->actingAs($user)->delete('/categories/' . $category->id);

        $response->assertRedirect('/');
    }

    public function test_destroy_not_found_should_redirect_back_with_flash_message()
    {
        $uuid = Str::uuid();
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->delete("/categories/$uuid");

        $response->assertRedirect('/categories');
        $response->assertSessionHas('flash_notification');
    }

}

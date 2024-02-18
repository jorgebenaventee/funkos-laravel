<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Funko;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FunkoControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_should_return_funkos_index()
    {
        $response = $this->get('/');

        $response->assertViewIs('funkos.index');
    }

    public function test_should_return_filtered_funkos()
    {
        $name = Funko::first()->name;

        $response = $this->get('/?search=' . $name);

        $response->assertViewIs('funkos.index');
        $response->assertViewHas('funkos', function ($funkos) use ($name) {
            return $funkos->first()->name === $name;
        });
    }


    public function test_details_should_get_correct_funko()
    {
        $response = $this->get('/funkos/1');

        $response->assertViewIs('funkos.show');
        $response->assertViewHas('funko', function ($funko) {
            return $funko->id === 1;
        });
    }

    public function test_create_should_return_view()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $categoryIds = Category::pluck('id')->toArray();
        $response = $this->actingAs($adminUser)->get('/funkos/create');

        $response->assertViewIs('funkos.create');
        $response->assertViewHas('categories', function ($categories) use ($categoryIds) {
            return array_diff($categoryIds, $categories->pluck('id')->toArray()) === [];
        });
    }

    public function test_create_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/funkos/create');

        $response->assertRedirect('/');
    }

    public function test_create_should_store_funko()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::factory()->make()->toArray();
        $funko['category_id'] = Category::first()->id;

        $response = $this->actingAs($adminUser)->post('/funkos', $funko);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('funkos', $funko);
    }

    public function test_do_create_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $funko = Funko::factory()->make()->toArray();
        $funko['category_id'] = Category::first()->id;

        $response = $this->actingAs($user)->post('/funkos', $funko);

        $response->assertRedirect('/');
    }

    public function test_create_invalid_should_show_errors()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::factory()->make(['name' => ''])->toArray();
        $funko['category_id'] = Category::first()->id;

        $response = $this->actingAs($adminUser)->post('/funkos', $funko);

        $response->assertSessionHasErrors('name');
    }


    public function test_edit_should_return_view()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $categoryIds = Category::pluck('id')->toArray();
        $response = $this->actingAs($adminUser)->get('/funkos/' . $funko->id . '/edit');

        $response->assertViewIs('funkos.update');
        $response->assertViewHas('funko', function ($funko) {
            return $funko->id === 1;
        });
        $response->assertViewHas('categories', function ($categories) use ($categoryIds) {
            return array_diff($categoryIds, $categories->pluck('id')->toArray()) === [];
        });
    }


    public function test_edit_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $funko = Funko::first();
        $response = $this->actingAs($user)->get('/funkos/' . $funko->id . '/edit');

        $response->assertRedirect('/');
    }

    public function test_edit_not_found_should_redirect_back_with_flash_message()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/funkos/999/edit');
        $response->assertRedirect('/');
        $response->assertSessionHas('flash_notification');
    }

    public function test_update_should_store_funko()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $funko->name = 'New Name';

        $response = $this->actingAs($adminUser)->put('/funkos/' . $funko->id, $funko->toArray());

        $response->assertRedirect('/');
        $this->assertDatabaseHas('funkos', ['name' => 'New Name']);
    }

    public function test_do_update_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $funko = Funko::first();
        $funko->name = 'New Name';

        $response = $this->actingAs($user)->put('/funkos/' . $funko->id, $funko->toArray());

        $response->assertRedirect('/');
    }

    public function test_update_invalid_should_show_errors()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $funko->name = '';

        $response = $this->actingAs($adminUser)->put('/funkos/' . $funko->id, $funko->toArray());

        $response->assertSessionHasErrors('name');
    }

    public function test_destroy_should_delete_funko()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();

        $response = $this->actingAs($adminUser)->delete('/funkos/' . $funko->id . '/delete');

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('funkos', ['id' => $funko->id]);
    }

    public function test_destroy_should_remove_funko_image_if_not_default()
    {
        $fakeStorage = Storage::fake('public');
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $funko->image = 'funkos/' . $funko->id . '.jpg';
        $funko->save();

        $response = $this->actingAs($adminUser)->delete('/funkos/' . $funko->id . '/delete');

        $response->assertRedirect('/');
        $fakeStorage->assertMissing('funkos/' . $funko->id . '.jpg');
    }

    public function test_do_destroy_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $funko = Funko::first();

        $response = $this->actingAs($user)->delete('/funkos/' . $funko->id . '/delete');

        $response->assertRedirect('/');
    }

    public function test_destroy_not_found_should_redirect_back_with_flash_message()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->delete('/funkos/999/delete');
        $response->assertRedirect('/');
        $response->assertSessionHas('flash_notification');
    }

    public function test_show_update_image_should_return_view()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $response = $this->actingAs($adminUser)->get('/funkos/' . $funko->id . '/image');

        $response->assertViewIs('funkos.update-image');
        $response->assertViewHas('funko', function ($funko) {
            return $funko->id === 1;
        });
    }

    public function test_show_update_image_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $funko = Funko::first();
        $response = $this->actingAs($user)->get('/funkos/' . $funko->id . '/image');

        $response->assertRedirect('/');
    }

    public function test_show_update_image_not_found_should_redirect_back_with_flash_message()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/funkos/999/image');
        $response->assertRedirect('/');
        $response->assertSessionHas('flash_notification');
    }

    public function test_update_image_should_update()
    {
        $fakeStorage = Storage::fake('public');
        $file = UploadedFile::fake()->image('funko.jpg');

        $adminUser = User::factory()->create(['role' => 'admin']);

        $funko = Funko::first();

        $response = $this->actingAs($adminUser)->post('/funkos/' . $funko->id . '/image', [
            'image' => $file
        ]);

        $response->assertRedirect('/');
        $fakeStorage->assertExists('funkos/' . $funko->id . '.jpg');
    }


    public function test_update_image_as_user_should_redirect_back()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('funko.jpg');
        $funko = Funko::first();

        $response = $this->actingAs($user)->post('/funkos/' . $funko->id . '/image', [
            'image' => $file
        ]);

        $response->assertRedirect('/');
    }

    public function test_update_image_invalid_should_show_errors()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $funko = Funko::first();
        $file = UploadedFile::fake()->create('funko.txt', 100);

        $response = $this->actingAs($adminUser)->post('/funkos/' . $funko->id . '/image', [
            'image' => $file
        ]);

        $response->assertSessionHasErrors('image');
    }

    public function test_update_image_not_found_should_redirect_back_with_flash_message()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->image('funko.jpg');
        $response = $this->actingAs($adminUser)->post('/funkos/999/image', [
            'image' => $file
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHas('flash_notification');
    }
}

<?php

namespace Tests\Feature;

use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ElevateFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function productData(Category $category): array
    {
        return ['name' => 'Test Custom Tee', 'category_id' => $category->id, 'description' => 'Kaos custom untuk komunitas.', 'price' => 85000, 'material' => 'Cotton combed', 'min_order' => 12, 'production_days' => 14, 'sizes' => ['S', 'M'], 'is_active' => 1, 'image' => UploadedFile::fake()->image('shirt.jpg')];
    }

    public function test_homepage_can_be_opened(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('YOUR VISION.')
            ->assertSee('images/favicon/android-chrome-192x192.png')
            ->assertSee('images/favicon/favicon.ico');
    }

    public function test_seeder_creates_ten_products_without_duplicates(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(10, Product::count());
        foreach (Product::all() as $product) {
            $this->assertFileExists(public_path($product->image));
        }
    }

    public function test_catalog_reads_products_from_database(): void
    {
        Product::factory()->create(['name' => 'Distinctive Tee']);
        $this->get(route('products.index'))->assertOk()->assertSee('Distinctive Tee');
    }

    public function test_product_detail_uses_slug(): void
    {
        $product = Product::factory()->create(['slug' => 'special-tee']);
        $this->get(route('products.show', $product))->assertOk()->assertSee($product->name);
    }

    public function test_category_filter_limits_catalog(): void
    {
        $target = Category::factory()->create(['slug' => 'target']);
        Product::factory()->for($target)->create(['name' => 'Shown Tee']);
        Product::factory()->create(['name' => 'Hidden Tee']);
        $this->get(route('products.index', ['category' => 'target']))
            ->assertSee('Shown Tee')->assertDontSee('Hidden Tee')
            ->assertSee('data-custom-select', false)
            ->assertSee('Semua kategori');
    }

    public function test_search_filters_catalog(): void
    {
        Product::factory()->create(['name' => 'Searchable Hoodie']);
        Product::factory()->create(['name' => 'Basic Tee']);
        $this->get(route('products.index', ['search' => 'Hoodie']))->assertSee('Searchable Hoodie')->assertDontSee('Basic Tee');
    }

    public function test_price_filter_accepts_zero_as_maximum(): void
    {
        Product::factory()->create(['price' => 85000]);
        $this->get(route('products.index', ['max_price' => 0]))->assertSee('0 produk ditemukan');
    }

    public function test_catalog_is_paginated(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for($category)->count(10)->create();
        $this->get(route('products.index'))->assertOk()->assertSee('10 produk ditemukan')->assertSee('page=2');
    }

    public function test_inactive_products_are_hidden_and_return_404(): void
    {
        $product = Product::factory()->create(['is_active' => false]);
        $this->get(route('products.index'))->assertDontSee($product->name);
        $this->get(route('products.show', $product))->assertNotFound();
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_user_cannot_access_panel_or_log_in_as_admin(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        auth()->logout();
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_log_in(): void
    {
        $user = User::factory()->admin()->create();
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_is_rejected(): void
    {
        $user = User::factory()->admin()->create();
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_create_product_and_upload_image(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.products.store'), $this->productData($category))->assertRedirect(route('admin.products.index'));
        $product = Product::firstOrFail();
        $this->assertSame('Test Custom Tee', $product->name);
        Storage::disk('public')->assertExists($product->image);
    }

    public function test_admin_can_update_product(): void
    {
        $product = Product::factory()->create();
        $data = $this->productData($product->category);
        unset($data['image']);
        $data['name'] = 'Updated Tee';
        $this->actingAs(User::factory()->admin()->create())->put(route('admin.products.update', $product), $data)->assertRedirect(route('admin.products.index'));
        $this->assertSame('Updated Tee', $product->fresh()->name);
    }

    public function test_admin_can_delete_product_and_inquiry_remains(): void
    {
        $product = Product::factory()->create();
        $inquiry = Inquiry::factory()->create(['product_id' => $product->id]);
        $this->actingAs(User::factory()->admin()->create())->delete(route('admin.products.destroy', $product))->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertNull($inquiry->fresh()->product_id);
    }

    public function test_invalid_upload_is_rejected(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $data = $this->productData($category);
        $data['image'] = UploadedFile::fake()->create('payload.php', 3, 'application/x-php');
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.products.store'), $data)->assertSessionHasErrors('image');
        $this->assertSame(0, Product::count());
    }

    public function test_required_validation_rejects_empty_product(): void
    {
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.products.store'), [])->assertSessionHasErrors(['name', 'category_id', 'description', 'price', 'material', 'min_order', 'image']);
    }

    public function test_maximum_name_length_is_validated(): void
    {
        $data = $this->productData(Category::factory()->create());
        $data['name'] = str_repeat('X', 151);
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.products.store'), $data)->assertSessionHasErrors('name');
    }

    public function test_price_must_be_numeric(): void
    {
        $data = $this->productData(Category::factory()->create());
        $data['price'] = 'not-a-number';
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.products.store'), $data)->assertSessionHasErrors('price');
    }

    public function test_category_product_relationship_works(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for($category)->create();
        $this->assertSame(1, $category->products()->count());
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for($category)->create();
        $this->actingAs(User::factory()->admin()->create())->delete(route('admin.categories.destroy', $category))->assertSessionHasErrors('category');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_inquiry_can_be_submitted(): void
    {
        $product = Product::factory()->create();
        $this->post(route('inquiries.store'), ['product_id' => $product->id, 'name' => 'Anisa', 'email' => 'anisa@example.com', 'phone' => '081234567890', 'quantity' => 12, 'message' => 'Butuh desain komunitas.'])->assertRedirect(route('contact'));
        $this->assertDatabaseHas('inquiries', ['name' => 'Anisa', 'product_id' => $product->id]);
    }

    public function test_admin_can_update_inquiry_status(): void
    {
        $inquiry = Inquiry::factory()->create();
        $this->actingAs(User::factory()->admin()->create())->patch(route('admin.inquiries.update', $inquiry), ['status' => 'completed'])->assertRedirect();
        $this->assertSame('completed', $inquiry->fresh()->status);
    }

    public function test_logout_ends_session(): void
    {
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_business_settings_can_be_updated(): void
    {
        BusinessSetting::factory()->create();
        $this->actingAs(User::factory()->admin()->create())->put(route('admin.settings.update'), ['company_name' => 'PT New Name', 'brand_name' => 'NEW BRAND', 'description' => 'Updated description'])->assertRedirect();
        $this->assertDatabaseHas('business_settings', ['company_name' => 'PT New Name']);
    }

    public function test_admin_can_create_and_update_category(): void
    {
        $this->actingAs(User::factory()->admin()->create())->post(route('admin.categories.store'), ['name' => 'New Category'])->assertRedirect(route('admin.categories.index'));
        $category = Category::firstOrFail();
        $this->put(route('admin.categories.update', $category), ['name' => 'Renamed Category'])->assertRedirect(route('admin.categories.index'));
        $this->assertSame('renamed-category', $category->fresh()->slug);
    }

    public function test_public_and_admin_pages_render(): void
    {
        $this->seed(DatabaseSeeder::class);
        foreach (['about', 'process', 'contact', 'admin.login'] as $name) {
            $this->get(route($name))->assertOk();
        }

        $this->actingAs(User::factory()->admin()->create());
        foreach (['admin.dashboard', 'admin.products.index', 'admin.products.create', 'admin.categories.index', 'admin.categories.create', 'admin.inquiries.index', 'admin.settings.edit'] as $name) {
            $this->get(route($name))->assertOk();
        }
    }
}

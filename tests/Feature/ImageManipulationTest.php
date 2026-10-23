<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ImageManipulationTest extends TestCase
{
    private string $originalPublicPath;

    private string $temporaryPublicPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalPublicPath = app()->publicPath();
        $this->temporaryPublicPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravel-image-test-'.uniqid();
        File::ensureDirectoryExists($this->temporaryPublicPath);
        app()->usePublicPath($this->temporaryPublicPath);
    }

    protected function tearDown(): void
    {
        app()->usePublicPath($this->originalPublicPath);
        File::deleteDirectory($this->temporaryPublicPath);

        parent::tearDown();
    }

    public function test_uploaded_image_is_resized_and_saved(): void
    {
        $response = $this->post(route('gambar.upload'), [
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Gambar berhasil di-resize!');
        $response->assertSessionHas('processed_image');

        $files = $this->uploadedImages();
        $this->assertCount(1, $files);
        $this->assertSame([300, 200], array_slice(getimagesize($files[0]->getPathname()), 0, 2));

        $imageUrl = session('processed_image');
        $this->get('/upload-gambar')
            ->assertOk()
            ->assertSee('<img', false)
            ->assertSee($imageUrl);
    }

    public function test_uploaded_image_is_cropped_and_saved(): void
    {
        $this->post(route('gambar.upload'), [
            'operation' => 'crop',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ])->assertSessionHas('success', 'Gambar berhasil di-crop!');

        $files = $this->uploadedImages();
        $this->assertCount(1, $files);
        $this->assertSame([200, 200], array_slice(getimagesize($files[0]->getPathname()), 0, 2));
    }

    public function test_uploaded_image_is_saved_with_watermark(): void
    {
        $this->post(route('gambar.upload'), [
            'operation' => 'watermark',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
            'watermark' => UploadedFile::fake()->image('watermark.png', 50, 50),
        ])->assertSessionHas('success', 'Watermark berhasil ditambahkan!');

        $this->assertCount(1, $this->uploadedImages());
    }

    public function test_uploaded_image_is_rotated_and_saved(): void
    {
        $this->post(route('gambar.upload'), [
            'operation' => 'rotate',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ])->assertSessionHas('success', 'Gambar berhasil diputar!');

        $this->assertCount(1, $this->uploadedImages());
    }

    public function test_uploaded_image_is_converted_to_png(): void
    {
        $this->post(route('gambar.upload'), [
            'operation' => 'convert',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ])->assertSessionHas('success', 'Gambar berhasil diubah ke format PNG!');

        $files = $this->uploadedImages();
        $this->assertCount(1, $files);
        $this->assertSame('png', $files[0]->getExtension());
        $this->assertSame(IMAGETYPE_PNG, getimagesize($files[0]->getPathname())[2]);
    }

    public function test_uploaded_image_can_be_displayed_directly_without_saving(): void
    {
        $response = $this->post(route('gambar.upload'), [
            'operation' => 'direct',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ]);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/jpeg');
        $this->assertSame([600, 400], array_slice(getimagesizefromstring($response->getContent()), 0, 2));
        $this->assertDirectoryDoesNotExist($this->temporaryPublicPath.DIRECTORY_SEPARATOR.'uploads');
    }

    public function test_watermark_operation_requires_a_watermark_image(): void
    {
        $this->from('/upload-gambar')->post(route('gambar.upload'), [
            'operation' => 'watermark',
            'photo' => UploadedFile::fake()->image('product.jpg', 600, 400),
        ])->assertRedirect('/upload-gambar')
            ->assertSessionHasErrors('watermark');
    }

    private function uploadedImages(): array
    {
        return File::files($this->temporaryPublicPath.DIRECTORY_SEPARATOR.'uploads');
    }
}

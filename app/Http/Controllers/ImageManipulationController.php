<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Format;
use Intervention\Image\Laravel\Facades\Image;

class ImageManipulationController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function process(Request $request)
    {
        $request->merge(['operation' => $request->input('operation', 'resize')]);
        $validated = $request->validate([
            'operation' => 'required|in:resize,crop,watermark,rotate,convert,direct',
        ]);

        return match ($validated['operation']) {
            'resize' => $this->resize($request),
            'crop' => $this->crop($request),
            'watermark' => $this->watermark($request),
            'rotate' => $this->rotate($request),
            'convert' => $this->convertFormat($request),
            'direct' => $this->showDirect($request),
        };
    }

    public function resize(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $file = $request->file('photo');
        $filename = $this->filename('resized', $file->extension());

        Image::decode($file)->resize(300, 200)
            ->save($this->uploadPath($filename), quality: 75);

        return $this->redirectWithPreview($filename, 'Gambar berhasil di-resize!');
    }

    public function crop(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $file = $request->file('photo');
        $filename = $this->filename('cropped', $file->extension());

        Image::decode($file)->crop(200, 200, 100, 100)
            ->save($this->uploadPath($filename));

        return $this->redirectWithPreview($filename, 'Gambar berhasil di-crop!');
    }

    public function watermark(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'watermark' => 'required|image|max:2048',
        ]);
        $file = $request->file('photo');
        $filename = $this->filename('watermark', $file->extension());

        Image::decode($file)
            ->insert(Image::decode($request->file('watermark')), 10, 10, 'bottom-right')
            ->save($this->uploadPath($filename));

        return $this->redirectWithPreview($filename, 'Watermark berhasil ditambahkan!');
    }

    public function rotate(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $file = $request->file('photo');
        $filename = $this->filename('rotated', $file->extension());

        Image::decode($file)->rotate(45)
            ->save($this->uploadPath($filename));

        return $this->redirectWithPreview($filename, 'Gambar berhasil diputar!');
    }

    public function convertFormat(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $file = $request->file('photo');
        $filename = $this->filename('converted', 'png');

        Image::decode($file)->encodeUsingFormat(Format::PNG)
            ->save($this->uploadPath($filename));

        return $this->redirectWithPreview($filename, 'Gambar berhasil diubah ke format PNG!');
    }

    public function showDirect(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $file = $request->file('photo');

        return response()->image(Image::decode($file), 'jpg');
    }

    private function filename(string $prefix, string $extension): string
    {
        return $prefix.'_'.Str::uuid().'.'.$extension;
    }

    private function redirectWithPreview(string $filename, string $message)
    {
        return back()
            ->with('success', $message)
            ->with('processed_image', asset('uploads/'.$filename));
    }

    private function uploadPath(string $filename): string
    {
        $directory = public_path('uploads');
        File::ensureDirectoryExists($directory);

        return $directory.DIRECTORY_SEPARATOR.$filename;
    }
}

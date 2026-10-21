<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;  
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'sku' => 'required|string|max:100|unique:products,sku',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
    ]);

    $file = $request->file('image');
    
    // 2. Jika ada file unggahan, proses gambar. Jika tidak, lanjutkan tanpa gambar.
    if ($file) {
        $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $original) . '.' . $ext;
        $folder = 'products';
        $path = $folder . '/' . $filename;

        // 3. Inisialisasi ImageManager dengan GD Driver
        $manager = new ImageManager(Driver::class);

      // 4. Membaca gambar dan mengubah ukurannya menjadi 800x800
        $image = $manager->decode($file->getRealPath())
                         ->cover(800, 800);

        // 5. Encode sesuai ekstensi (png atau jpg)
        if ($ext === 'png') {
            $encoded = $image->toPng(90); 
        } else {
            $encoded = $image->toJpeg(85);
        }

        // 6. Simpan ke disk public
        Storage::disk('public')->put($path, $encoded->toString());

        // 7. Sertakan path gambar ke data yang akan disimpan ke DB
        $data['image'] = $path;
    }

    // 8. Simpan ke tabel Product
    Product::create($data);

    // 9. Redirect kembali dengan pesan sukses
    return redirect()->route('products.index')->with('success', 'Produk ditambahkan');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

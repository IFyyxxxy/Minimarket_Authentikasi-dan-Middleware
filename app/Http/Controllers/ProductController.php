<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib dipanggil untuk memakai DB Query Builder

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap input pencarian (misal dari URL: /produk?q=Laptop)
        // Jika tidak ada input, default-nya 'Laptop'
        $keyword = $request->query('q', 'Laptop');

        $produk = DB::table('produk')
            ->select('id', 'nama_produk', 'kategori', 'harga')
            ->where('kategori', 'Elektronik')
            ->where('nama_produk', 'like', $keyword.'%')
            ->orderBy('harga', 'desc')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->offset(0)
            ->get();

        // Untuk uji coba, kita langsung tampilkan datanya dalam format JSON
        return response()->json($produk);
    }
}

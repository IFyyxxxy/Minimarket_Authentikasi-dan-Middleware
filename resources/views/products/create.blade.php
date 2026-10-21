<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <!-- Mengambil font bergaya pixel dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        /* Pengaturan Dasar & Font Pixel */
        * {
            box-sizing: border-box;
            font-family: 'VT323', monospace;
            letter-spacing: 1px;
        }

        /* Latar Belakang Gradient Dinamis agar efek kacanya terlihat */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            animation: gradientBG 10s ease infinite;
            padding: 20px;
            color: #fff;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container dengan tema Clear Glassmorphism + Pixel */
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            /* Border tegas dan shadow solid untuk kesan retro pixel */
            border: 4px solid rgba(255, 255, 255, 0.4);
            box-shadow: 10px 10px 0px rgba(0, 0, 0, 0.3);
            padding: 35px 40px;
            width: 100%;
            max-width: 550px;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.5);
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 25px;
            border-bottom: 4px dashed rgba(255, 255, 255, 0.5);
            padding-bottom: 10px;
        }

        /* Elemen Input Form */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 5px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.5);
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            /* Latar belakang transparan untuk input */
            background: rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.6);
            color: #fff;
            font-size: 1.4rem;
            outline: none;
            transition: all 0.2s;
        }

        /* Efek saat input diklik (Focus) */
        input:focus, textarea:focus {
            background: rgba(0, 0, 0, 0.4);
            border-color: #00ffcc;
            box-shadow: 5px 5px 0px rgba(0, 255, 204, 0.4);
        }

        input[type="file"] {
            padding: 8px;
            background: transparent;
            border: 2px dashed rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        /* Tombol ala Pixel Art */
        button {
            width: 100%;
            padding: 15px;
            margin-top: 15px;
            background: rgba(0, 255, 204, 0.2);
            backdrop-filter: blur(5px);
            border: 4px solid #00ffcc;
            color: #fff;
            font-size: 1.8rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.1s ease;
            box-shadow: 6px 6px 0px rgba(0, 0, 0, 0.4);
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.8);
        }

        button:hover {
            background: #00ffcc;
            color: #000;
            text-shadow: none;
        }

        button:active {
            box-shadow: 2px 2px 0px rgba(0, 0, 0, 0.4);
            transform: translate(4px, 4px);
        }

        /* Pesan Alert Notifikasi */
        .alert-success {
            background: rgba(0, 255, 0, 0.2);
            border: 3px solid #00ff00;
            padding: 10px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.5);
            font-size: 1.3rem;
        }

        .alert-error {
            background: rgba(255, 0, 0, 0.2);
            border: 3px solid #ff0000;
            padding: 10px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.5);
            font-size: 1.3rem;
        }
        
        ul { margin: 0; padding-left: 25px; }
    </style>
</head>
<body>

    <div class="glass-container">
        <h1>Tambah Produk</h1>
        
        <!-- Tampilkan Pesan Sukses Jika Ada -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tampilkan Pesan Error Validasi Jika Ada -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" name="name" required placeholder="Masukkan nama...">
            </div>

            <div class="form-group">
                <label>Kategori ID (Opsional):</label>
                <input type="number" name="category_id" placeholder="ID kategori...">
            </div>

            <div class="form-group">
                <label>SKU:</label>
                <input type="text" name="sku" required placeholder="Kode produk...">
            </div>

            <div class="form-group">
                <label>Harga (Price):</label>
                <input type="number" name="price" required placeholder="0">
            </div>

            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stock" required placeholder="0">
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="description" rows="3" placeholder="Tulis deskripsi produk..."></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Produk (Max 2MB):</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit">Simpan Produk</button>
        </form>
    </div>

</body>
</html>
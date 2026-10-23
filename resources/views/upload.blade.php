<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Acara 31 - Manipulasi Gambar</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Upload & Manipulasi Gambar</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('gambar.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p>
            <label for="photo">Pilih gambar:</label>
            <input id="photo" type="file" name="photo" accept="image/*" required>
        </p>
        <p>
            <label for="watermark">Pilih gambar watermark (khusus operasi watermark):</label>
            <input id="watermark" type="file" name="watermark" accept="image/*">
        </p>
        <p>Pilih operasi:</p>
        <button type="submit" name="operation" value="resize">Upload & Resize</button>
        <button type="submit" name="operation" value="crop">Crop Gambar</button>
        <button type="submit" name="operation" value="watermark">Tambah Watermark</button>
        <button type="submit" name="operation" value="rotate">Rotate 45°</button>
        <button type="submit" name="operation" value="convert">Ubah ke PNG</button>
        <button type="submit" name="operation" value="direct">Tampilkan Langsung</button>
    </form>

    @if(session('processed_image'))
        <h3>Hasil Manipulasi</h3>
        <img src="{{ session('processed_image') }}" alt="{{ session('success') }}" style="max-width: 100%; height: auto;">
    @endif
</body>
</html>
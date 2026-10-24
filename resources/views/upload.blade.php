<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload & Manipulasi Gambar</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Upload & Manipulasi Gambar</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <p>
            <label for="photo">Pilih gambar:</label><br>
            <input id="photo" type="file" name="photo" accept="image/*" required>
        </p>
        
        <p>
            <label for="watermark">Pilih gambar watermark (khusus operasi watermark):</label><br>
            <input id="watermark" type="file" name="watermark_file" accept="image/*">
        </p>
        
        <p>Pilih operasi:</p>
        <button type="submit" formaction="{{ route('gambar.resize') }}">Upload & Resize</button>
        <button type="submit" formaction="{{ route('gambar.crop') }}">Crop Gambar</button>
        <button type="submit" formaction="{{ route('gambar.watermark') }}">Tambah Watermark</button>
        <button type="submit" formaction="{{ route('gambar.rotate') }}">Rotate 45°</button>
        <button type="submit" formaction="{{ route('gambar.convert') }}">Ubah ke PNG</button>
        <button type="submit" formaction="{{ route('gambar.show') }}">Tampilkan Langsung</button>
    </form>
</body>
</html>
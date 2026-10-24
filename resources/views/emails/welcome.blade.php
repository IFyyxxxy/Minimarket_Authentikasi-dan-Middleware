<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #10b981, #3b82f6); color: #ffffff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 1px; }
        .content { padding: 30px 20px; color: #333333; line-height: 1.6; font-size: 16px; text-align: center; }
        .btn { display: inline-block; padding: 12px 30px; margin: 20px 0; background-color: #10b981; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3); }
        .footer { background-color: #f1f1f1; padding: 15px; text-align: center; color: #888888; font-size: 14px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>MINIMARKET KITA</h1>
        </div>
        <div class="content">
            <h2>Halo, {{ $user->name }}! 🎉</h2>
            <p>Terima kasih banyak telah bergabung dan mendaftar di aplikasi Minimarket kami. Kami sangat senang menyambutmu!</p>
            <p>Mulai sekarang, kamu bisa menikmati berbagai kemudahan transaksi dan mengecek tagihan (invoice) langsung dari dasbormu.</p>
            <a href="#" class="btn">Mulai Belanja</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Minimarket Kita. All rights reserved.
        </div>
    </div>
</body>
</html>
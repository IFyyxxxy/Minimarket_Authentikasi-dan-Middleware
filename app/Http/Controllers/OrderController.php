<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function invoice($id) // Pastikan parameternya hanya $id
    {
        // 1. KITA BUAT DATA INVOICE PALSU
        $invoice = new \stdClass();
        $invoice->id = $id;
        $invoice->created_at = \Carbon\Carbon::now();
        
        // 2. KITA BUAT DATA ITEM PERTAMA (Tanpa butuh tabel products)
        $item1 = new \stdClass();
        $item1->product = new \stdClass();
        $item1->product->name = 'Beras Makmur 5Kg'; // Nama produk langsung ditulis di sini
        $item1->price = 65000;
        $item1->quantity = 2;
        $item1->total = 130000;

        // 3. KITA BUAT DATA ITEM KEDUA
        $item2 = new \stdClass();
        $item2->product = new \stdClass();
        $item2->product->name = 'Minyak Goreng Sunco 2L';
        $item2->price = 35000;
        $item2->quantity = 1;
        $item2->total = 35000;

        // Gabungkan item ke dalam invoice
        $invoice->items = [$item1, $item2];
        
        // Hitung Grand Total
        $invoice->total = 165000;

        // 4. GENERATE PDF DARI DATA PALSU TERSEBUT
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.invoice', ['invoice' => $invoice]);

        // 5. DOWNLOAD FILE PDF
        return $pdf->download('invoice_pesanan_' . $invoice->id . '.pdf');
    }
    public function store()
{
    // 1. Simulasi data order (karena butuh variabel $order yang punya id dan total)
    $order = new \stdClass();
    $order->id = rand(100, 999);
    $order->total = 165000;

    // 2. Trigger Event Broadcast
    event(new OrderPlaced($order, Auth::user()));

    // 3. Pesan sukses (Bisa diganti redirect ke halaman lain nantinya)
    return "Pesanan berhasil diproses dan notifikasi real-time sedang dikirim!";
}
}
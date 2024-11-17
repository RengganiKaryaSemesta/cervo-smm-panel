<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ServiceReport;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class Dashboard extends Component
{
    // public function mount(){
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])->post(
    //         "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . env('GEMINI_AI_KEY'),
    //         [
    //             "contents" => [
    //                 [
    //                     "parts" => [
    //                         ["text" => "Write a story about a magic backpack."]
    //                     ]
    //                 ]
    //             ]
    //         ]
    //     );
        
    //     // Cek respons
    //     if ($response->failed()) {
    //         dd($response->json()); // Untuk debugging jika terjadi error
    //     }
        
    //     dd($response->json());
    // }
    public function getData(): array
    {
        $grafikTren = [
            'dates' => ['2024-09-01', '2024-09-02', '2024-09-03', '2024-09-04', '2024-09-05', '2024-09-06', '2024-09-07'],
            'stok_masuk' => [100, 120, 90, 110, 130, 95, 105],
            'stok_keluar' => [50, 60, 40, 70, 65, 45, 60],
            'stok_akhir' => [50, 60, 50, 40, 65, 50, 45]
        ];
        $stokGudang = collect([
            ['gudang' => 'Gudang A', 'total_stok' => 300],
            ['gudang' => 'Gudang B', 'total_stok' => 200],
            ['gudang' => 'Gudang C', 'total_stok' => 400],
        ]);

        $stokGrade = collect([
            ['grade' => 'Grade A', 'total_stok' => 500],
            ['grade' => 'Grade B', 'total_stok' => 300],
            ['grade' => 'Grade C', 'total_stok' => 100],
        ]);
        return [
            'stokGudang' => $stokGudang,
            'stokGrade' => $stokGrade,
            'grafikTren' => $grafikTren,
            'stock_almost_out' => collect([
                ['name' => 'Tembakau Virginia', 'stock' => 50],
                ['name' => 'Cengkeh A', 'stock' => 30],
                ['name' => 'Tembakau Burley', 'stock' => 80],
                ['name' => 'Cengkeh B', 'stock' => 20],
                ['name' => 'Tembakau Oriental', 'stock' => 60],
            ]),
            'latest_stock' => [
                ["color" => "danger", "progressbar" => "100", "title" => "Gudang A"],
                ["color" => "success", "progressbar" => "20", "title" => "Gudang B"],
                ["color" => "success", "progressbar" => "40", "title" => "Gudang C"],
                ["color" => "warning", "progressbar" => "70", "title" => "Gudang D"],
                ["color" => "warning", "progressbar" => "50", "title" => "Gudang E"],
                ["color" => "purple", "progressbar" => "90", "title" => "Gudang F"],
            ],
            'kinerja_supplier_berdasarkan_penyusutan' => [
                ["color" => "danger", "progressbar" => "80", "title" => "UD Maju Jaya"],
                ["color" => "danger", "progressbar" => "75", "title" => "Suplier B"],
                ["color" => "danger", "progressbar" => "70", "title" => "Suplier C"],
                ["color" => "warning", "progressbar" => "60", "title" => "UD Jahe"],
                ["color" => "warning", "progressbar" => "50", "title" => "UD Mekar"],
            ],
            'kinerja_supplier' => [
                [
                    'name' => 'Supplier A',
                    'total_po' => 26,
                    'po_selesai' => 20,
                    'po_terlambat' => 5,
                    'po_gagal' => 1,
                    'kinerja' => 92
                ],
                [
                    'name' => 'Supplier B',
                    'total_po' => 17,
                    'po_selesai' => 15,
                    'po_terlambat' => 2,
                    'po_gagal' => 0,
                    'kinerja' => 100
                ],
                [
                    'name' => 'Supplier C',
                    'total_po' => 35,
                    'po_selesai' => 25,
                    'po_terlambat' => 7,
                    'po_gagal' => 3,
                    'kinerja' => 85
                ]
            ]
        ];
    }
    public function render()
    {
        return view('livewire.admin.dashboard', array_merge(
            $this->getData(),
        ))->title('Dashboard')->layout('layouts.admin.app');
    }
}

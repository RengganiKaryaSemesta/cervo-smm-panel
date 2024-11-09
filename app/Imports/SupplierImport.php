<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Notifications\ImportNotification;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SupplierImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, ShouldQueue, WithEvents
{
    protected $importedBy;
    public function __construct($userId)
    {
        $this->importedBy = User::find($userId);
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $supplier              = new Supplier;
        $supplier->code        = ($row['alias'] ?? $this->generateAlias($row['name']));
        $supplier->name        = $row['name'];
        $supplier->address     = $row['address'];
        $supplier->postal_code = $row['postal_code'];
        $supplier->phone       = $row['phone'];
        $supplier->tax_id      = $row['tax_id'];
        $supplier->bank        = $row['bank'];
        return $supplier;
    }
    public function generateAlias($name)
    {
        $name = preg_replace(
            "/\s*\(.*?\)\s*/",
            "",
            $name
        );
        // Memecah nama menjadi array berdasarkan spasi
        $words = explode(
            " ",
            $name
        );

        // Ambil huruf pertama dari setiap kata dan gabungkan menjadi alias
        $alias = "";
        foreach ($words as $word) {
            $alias .= strtoupper(
                substr(
                    $word,
                    0,
                    1
                )
            );
        }

        return $alias . sprintf(
            "%02d",
            Supplier::getLastCounterCode() + 1
        );
    }
    public function rules() : array
    {
        return [
            '*.alias'       => 'nullable|string|unique:suppliers,code',
            '*.name'        => 'required|string',
            '*.address'     => 'nullable|string',
            '*.postal_code' => 'nullable|string',
            '*.phone'       => 'nullable|string',
            '*.tax_id'      => 'nullable|string',
            '*.bank'        => 'nullable|string',
        ];
    }
    public function chunkSize() : int
    {
        return 1000;
    }
    public function registerEvents() : array
    {
        return [
            AfterImport::class  => function (AfterImport $event) {
                // Notifikasi berhasil
                $data = [
                    'title'  => 'Supplier import.',
                    'detail' => 'Proses import data selesai tanpa error.',
                ];

                Notification::sendNow(
                    $this->importedBy,
                    new ImportNotification($data)
                );
            },

            ImportFailed::class => function (ImportFailed $event) {
                $errorMessage = $event->getException()->getMessage();

                // Log error untuk referensi
                Log::error("Import gagal: " . $errorMessage);

                // Menyusun data untuk notifikasi
                $data = [
                    'title'  => 'Supplier import',
                    'detail' => $errorMessage
                ];
                Notification::sendNow(
                    $this->importedBy,
                    new ImportNotification($data)
                );
            },
        ];
    }
}

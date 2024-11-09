<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\MaterialType;
use App\Models\MaterialTaste;
use App\Models\MaterialCategory;
use App\Enums\MaterialTasteGrade;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Notifications\ImportNotification;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MaterialImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, WithEvents
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
        $name = $row['daerah'] . ($row['rasa'] ? '-' . $row['rasa'] : null);
        if (Material::where(
            'name',
            'ILIKE',
            '%' . $name . '%'
        )->exists()) {
            // If it exists, skip the creation by returning null
            return null;
        }
        // Find the supplier by code
        $supplier = Supplier::where(
            'code',
            $row['supl']
        )->first();

        // Retrieve or assign a default taste grade based on the 'rasa' value
        $taste = null;

        if (! empty($row['rasa'])) {
            $tasteName = trim(strtoupper($row['rasa']));

            // Mencari data yang cocok dengan menggunakan LIKE
            $taste = MaterialTaste::where(
                'name',
                'ILIKE',
                '%' . $tasteName . '%'
            )->first();

            // Jika tidak ditemukan, buat data baru
            if (! $taste) {
                $taste = MaterialTaste::create(['name' => $tasteName]);
            }
        }
        $type = null;

        if (! empty($row['bentuk'])) {
            $typeName = trim(strtoupper($row['bentuk']));

            // Mencari data yang cocok dengan menggunakan LIKE
            $type = MaterialType::where(
                'name',
                'ILIKE',
                '%' . $typeName . '%'
            )->first();

            // Jika tidak ditemukan, buat data baru
            if (! $type) {
                $type = MaterialType::create(['name' => $typeName]);
            }
        }

        // Find the material category by name
        $category = MaterialCategory::where(
            'name',
            'ILIKE',
            '%' . $row['kategori'] . '%'
        )->first();
        // jika sudah ada name di db skip saja 
        $material                       = new Material;
        $material->name                 = $name;
        $material->unit_id              = 2;
        $material->region               = $row['daerah'];
        $material->supplier_id          = $supplier?->id;
        $material->material_taste_id    = $taste?->id;
        $material->material_type_id     = $type?->id;
        $material->material_category_id = $category?->id;

        return $material;
    }
    public function chunkSize() : int
    {
        return 500;
    }
    public function rules() : array
    {
        return [
            '*.daerah'   => 'required|string',
            '*.supl'     => 'required|string',
            '*.bentuk'   => 'required|string',
            '*.rasa'     => 'nullable|string',
            '*.kategori' => 'required|string',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'daerah'   => 'HEADER DAERAH',
            'supl'     => 'HEADER SUPL',
            'bentuk'   => 'HEADER BENTUK',
            'rasa'     => 'HEADER RASA',
            'kategori' => 'HEADER KATEGORI',
        ];
    }
    public function registerEvents() : array
    {
        return [
            AfterImport::class  => function (AfterImport $event) {
                // Notifikasi berhasil
                $data = [
                    'title'  => 'Material import',
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
                    'title'  => 'Material import',
                    'detail' => 'Terjadi kesalahan saat import: ' . $errorMessage
                ];
                Notification::sendNow(
                    $this->importedBy,
                    new ImportNotification($data)
                );
            },
        ];
    }
}

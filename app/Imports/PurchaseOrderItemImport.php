<?php

namespace App\Imports;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Helpers\CleanMaskDecimal;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Notifications\ImportNotification;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Exports\DuplicatePurchaseOrderItemExport;
use App\Notifications\ImportPurchaseOrderItemDuplicateNotification;

class PurchaseOrderItemImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, WithEvents
{
    protected               $importedBy;
    public static           $duplicateRow  = [];
    protected PurchaseOrder $purchaseOrder;
    public function __construct($userId, $purchaseOrderId)
    {
        $this->importedBy    = User::find($userId);
        $this->purchaseOrder = PurchaseOrder::find($purchaseOrderId);
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $exists = PurchaseOrderItem::where(
            'purchase_order_id',
            $this->purchaseOrder->id
        )->where(
                'basket_number',
                $row['no_bal']
            )->exists();
        if ($exists) {
            self::$duplicateRow[] = [
                'no_bal' => $row['no_bal'],
                'bruto'  => $row['bruto'],
                'neto'   => $row['neto'],
                'harga'  => $row['harga'],
            ];
            return null;
        }
        $purchaseOrderItem                    = new PurchaseOrderItem;
        $purchaseOrderItem->basket_number     = $row['no_bal'];
        $purchaseOrderItem->gross_weight      = $row['bruto'];
        $purchaseOrderItem->net_weight        = $row['neto'];
        $purchaseOrderItem->amount            = $row['harga'];
        $purchaseOrderItem->material_id       = $this->purchaseOrder->material_id;
        $purchaseOrderItem->purchase_order_id = $this->purchaseOrder->id;
        $purchaseOrderItem->total_amount = $row['neto'] * $row['harga'];
        $purchaseOrderItem->save();
        return $purchaseOrderItem;
    }
    public function chunkSize() : int
    {
        return 500;
    }
    public function rules() : array
    {
        return [
            '*.no_bal' => 'required|numeric',
            '*.bruto'  => 'required|numeric',
            '*.neto'   => 'required|numeric',
            '*.harga'  => 'nullable|numeric',
        ];
    }
    public function getTotal()
    {
        $totals                                           = PurchaseOrderItem::selectRaw(
            "SUM(CASE WHEN is_additional_item = FALSE THEN gross_weight ELSE 0 END) as total_original_gross_weight,
             SUM(gross_weight) as total_gross_weight,
             SUM(net_weight) as total_net_weight,
             SUM(total_amount) as total_amount1"
        )
            ->where(
                'purchase_order_id',
                $this->purchaseOrder->id
            )
            ->first();
        $this->purchaseOrder->total_original_gross_weight = $totals->total_original_gross_weight / 1000;
        $this->purchaseOrder->total_gross_weight          = $totals->total_gross_weight / 1000;
        $this->purchaseOrder->total_net_weight            = $totals->total_net_weight / 1000;
        $this->purchaseOrder->total_amount                = $totals->total_amount1;
        $this->purchaseOrder->save();
    }
    public function registerEvents() : array
    {
        return [
            AfterImport::class  => function (AfterImport $event) {
                // Notifikasi berhasil
                $data = [
                    'title'  => 'PO import',
                    'detail' => 'Proses import data selesai tanpa error.',
                ];
                $this->getTotal();
                if (count(self::$duplicateRow) > 0) {
                    $filePath = 'duplicates/duplicate_po_items_' . time() . '.xlsx';
                    // Simpan file Excel di storage public
                    Excel::store(
                        new DuplicatePurchaseOrderItemExport(self::$duplicateRow),
                        $filePath,
                        'public'
                    );

                    // URL yang dapat diakses publik
                    $fileUrl = Storage::url($filePath);

                    // Kirim notifikasi dengan tautan unduhan
                    Notification::sendNow(
                        $this->importedBy,
                        new ImportNotification(
                            [
                                'title'  => 'Duplikat Import PO Item',
                                'detail' => "Data duplikat ditemukan. Silakan <a href='$fileUrl' target='_blank' class='text-blue-700'>klik di sini</a> untuk mengunduh file dan melihat data duplikat.",
                            ]
                        )
                    );
                }
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
                    'title'  => 'PO import',
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

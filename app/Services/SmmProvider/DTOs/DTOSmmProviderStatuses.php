<?php
namespace App\Services\SmmProvider\DTOs;
class DTOSmmProviderStatuses
{
        public string $charge;
        public string $start_count;
        public string $status;
        public string $remains;
        public string $currency;
        public function __construct(array $data)
        {
                $price             = str($data['charge'] ?? '0')->replace(
                        ',',
                        ''
                )->value(); // Ambil nilai string
                $this->charge      = number_format(
                        (float) $price,
                        2,
                        ',',
                        '.'
                );
                $this->status      = $data['status'] ?? 'Failed';
                $this->start_count = $data['start_count'] ?? 0;
                $this->remains     = $data['remains'] ?? 0;
                $this->currency    = $data['currency'] ?? 'Rupiah';
        }
        public static function fromArray(array $data) : self
        {
                return new self($data);
        }
}
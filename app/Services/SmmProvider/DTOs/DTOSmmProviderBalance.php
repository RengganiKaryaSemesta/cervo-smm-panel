<?php
namespace App\Services\SmmProvider\DTOs;
class DTOSmmProviderBalance
{
        public string $balance;
        public string $currency;
        public function __construct(array $data)
        {
                $this->balance  = number_format(
                        $data['balance'] ?? 0,
                        2,
                        ",",
                        "."
                );
                $this->currency = $data['currency'] ?? '$';
        }
        public static function fromArray(array $data) : self
        {
                return new self($data);
        }
}
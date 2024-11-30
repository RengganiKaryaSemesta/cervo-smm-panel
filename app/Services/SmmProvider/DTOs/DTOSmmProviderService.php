<?php
namespace App\Services\SmmProvider\DTOs;
class DTOSmmProviderService
{
        public int    $service;
        public string $name;
        public string $type;
        public string $category;
        public string $rate;
        public string $note;
        public int    $min;
        public int    $max;
        public int    $rate_number;
        public bool   $refill;
        public bool   $cancel;
        public function __construct(array $data)
        {
                $this->service     = $data['service'];
                $this->name        = $data['name'];
                $this->type        = $data['type'];
                $this->category    = $data['category'];
                $this->rate_number = $data['rate'] ?? 0;
                $this->rate        = number_format(
                        $data['rate'],
                        2,
                        ',',
                        '.'
                );
                $this->min         = $data['min'] ?? 0;
                $this->max         = $data['max'] ?? 0;
                $this->cancel      = $data['cancel'] ?? FALSE;
                $this->refill      = $data['refill'] ?? FALSE;
                $this->note        = $data['note'] ?? "";
        }
        public static function fromArray(array $data) : self
        {
                return new self($data);
        }
}
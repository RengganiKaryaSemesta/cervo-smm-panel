<?php
namespace App\Services\SmmProvider\DTOs;
class DTOSmmProviderService
{
        public int    $service;
        public string $name;
        public string $type;
        public string $category;
        public string $rate;
        public int    $min;
        public int    $max;
        public bool   $refill;
        public bool   $cancel;
        public function __construct(array $data)
        {
                $this->service  = $data['service'];
                $this->name     = $data['name'];
                $this->type     = $data['type'];
                $this->category = $data['category'];
                $this->rate     = number_format(
                        $data['rate'],
                        2,
                        ',',
                        '.'
                );
                $this->min      = $data['min'] ?? 0;
                $this->max      = $data['max'] ?? 0;
                $this->cancel   = $data['cancel'] ?? false;
                $this->refill   = $data['refill'] ?? false;
        }
        public static function fromArray(array $data) : self
        {
                return new self($data);
        }
}
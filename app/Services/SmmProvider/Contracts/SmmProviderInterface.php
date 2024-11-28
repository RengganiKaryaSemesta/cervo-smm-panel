<?php

namespace App\Services\SmmProvider\Contracts;

use Illuminate\Support\Collection;

interface SmmProviderInterface
{
    public function order(array $data): Collection;

    public function status(int $orderId): Collection;

    public function services(): Collection;

    public function balance(): Collection;
}

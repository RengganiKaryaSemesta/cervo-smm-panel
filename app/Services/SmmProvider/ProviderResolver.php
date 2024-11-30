<?php

namespace App\Services\SmmProvider;

use App\Models\SmmProvider;
use Exception;

class ProviderResolver
{
        /**
         * Mapping antara nama service ke class provider
         *
         * @var array<string, string>
         */
        protected array $providerMap = [
                'ApiSmmProvider'   => \App\Services\SmmProvider\ApiSmmProvider::class,
                'ApiSmmProviderV2' => \App\Services\SmmProvider\ApiSmmProviderV2::class,
        ];

        /**
         * Resolve dan kembalikan instance class provider berdasarkan nama API service.
         *
         * @param string $apiService Nama API service
         * @return \App\Services\SmmProvider\Contracts\SmmProviderInterface
         * @throws Exception
         */
        public function resolve(SmmProvider $smmProvider) : \App\Services\SmmProvider\Contracts\SmmProviderInterface
        {
                // Cek apakah nama API service ada dalam mapping
                if (! array_key_exists(
                        $smmProvider->api_service,
                        $this->providerMap)) {
                        throw new Exception("Service '{$smmProvider->api_service}' tidak ditemukan.");
                }

                // Ambil nama class provider dari mapping
                $providerClass = $this->providerMap[$smmProvider->api_service];

                // Pastikan class provider ada
                if (! class_exists($providerClass)) {
                        throw new Exception("Provider class '{$providerClass}' tidak ditemukan.");
                }

                // Buat instance dari class provider menggunakan Laravel container
                $providerInstance = app(
                        $providerClass,
                        [
                                "api_url"    => $smmProvider->api_url,
                                "api_key"    => $smmProvider->api_key,
                                "secret_key" => $smmProvider->secret_key,
                        ]);

                // Pastikan instance tersebut mengimplementasikan SmmProviderInterface
                if (! $providerInstance instanceof \App\Services\SmmProvider\Contracts\SmmProviderInterface) {
                        throw new Exception("Provider '{$providerClass}' harus mengimplementasikan SmmProviderInterface.");
                }

                return $providerInstance;
        }
}

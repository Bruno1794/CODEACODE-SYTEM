<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiFocusNfeService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://api.focusnfe.com.br/v2/empresas'; // Defina a URL base da API dry_run=1
    }

    public function post(array $data = [])
    {
        $response = Http::withBasicAuth('Uj4lahyNaX9ejdvluKfD2Em83QOzXVj1','')
            ->post("{$this->baseUrl}/", $data);

        return $response->json();

    }

    public function put(int $id ,array $data = [])
    {
        $response = Http::withBasicAuth('Uj4lahyNaX9ejdvluKfD2Em83QOzXVj1','')
            ->put("{$this->baseUrl}/".$id, $data);

        return $response->json();

    }

    public function delete(int $id)
    {
        $response = Http::withBasicAuth('Uj4lahyNaX9ejdvluKfD2Em83QOzXVj1','')
            ->delete("{$this->baseUrl}/".$id);

        return $response->json();

    }

}

<?php

namespace App\McpTools;

use PhpMcp\Server\Attributes\McpTool;
use PhpMcp\Server\Attributes\Schema;
use Illuminate\Support\Facades\Http;

class ValidarDniReniec
{
    /**
     * Valida un DNI a través de la API de Decolecta.
     *
     * @param string $dni El número de DNI a validar.
     * @return array
     */
    #[McpTool(name: 'validar_dni_reniec', description: 'Valida un DNI usando la API de Decolecta.')]
    public function __invoke(
        #[Schema(description: 'El número de DNI a validar.')]
        string $dni
    ): array
    {
        $response = Http::get('https://api.decolecta.com/v1/reniec/dni', [
            'numero' => $dni,
        ]);

        return $response->json();
    }
}
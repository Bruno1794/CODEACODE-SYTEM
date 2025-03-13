<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CertificateController extends Controller
{
    //

    public function store(Request $request): JsonResponse
    {
        $userLogado = Auth::user();
        // Lê o arquivo e converte para base64
        //  $arquivoCertificado = base64_encode(file_get_contents($request->file('certificado')->getRealPath()));

        $arquivo = $request->file('certificado_');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $caminho = $arquivo->storeAs('certificados', $nomeArquivo, 'local');
        Certificate::create([
            'nome_certificado' => $arquivo->getClientOriginalName(),
            'arquivo_certificado' => $caminho,
            'senha_certificado' => Hash::make($request->senha, ['rounds' => 12]),
            'data_expiracao' => $request->data_expiracao,
            'company_id' => $userLogado->company_id,
        ]);
        return response()->json(['message' => 'Certificado salvo com sucesso!'], 200);
    }
}

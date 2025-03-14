<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpseclib3\File\X509;

class CertificateController extends Controller
{
    //

    public function store(Request $request, Company $company): JsonResponse
    {
        $arquivo = $request->file('certificado_');
        $senha = $request->input('senha_certificado');


        // Tentando ler o certificado
        try {

            $pkcs12 = file_get_contents($arquivo);


            $certs = [];
           openssl_pkcs12_read($pkcs12, $certs, $senha);



           if (!isset($certs['cert'])) {
                return response()->json(['error' => 'Certificado inválido ou senha incorreta'], 400);
            }

            $x509 = new X509();
            $cert = $x509->loadX509($certs['cert']);

            // Pegando a data de validade
            $dataExpiracao = $cert['tbsCertificate']['validity']['notAfter']['utcTime'] ??
                $cert['tbsCertificate']['validity']['notAfter']['generalTime'];


            // Convertendo para formato Laravel
            $dataExpiracaoFormatada = \Carbon\Carbon::createFromFormat('ymdHis\Z', $dataExpiracao)
                ->format('Y-m-d H:i:s');

            return response()->json([
                'validade' => $dataExpiracaoFormatada
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar o certificado'], 500);
        }


        /* $userLogado = Auth::user();
         $arquivo = $request->file('certificado_');
         $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
         $caminho = $arquivo->storeAs('certificados/'.$company->name, $nomeArquivo, 'local');

         $arquivoCertificado = base64_encode(file_get_contents($request->file('certificado_')->getRealPath()));
         dd($arquivoCertificado);


         Certificate::create([
             'nome_certificado' => $arquivo->getClientOriginalName(),
             'arquivo_certificado' => $caminho,
             'senha_certificado' => Hash::make($request->senha, ['rounds' => 12]),
             'data_expiracao' => $request->data_expiracao,
             'company_id' => $userLogado->type_user === "FULL" ? $company->id : $userLogado->company_id,
         ]);*/
        // return response()->json(['message' => 'Certificado salvo com sucesso!'], 200);
    }
}

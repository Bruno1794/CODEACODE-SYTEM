<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Company;
use App\Services\ApiFocusNfeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CertificateController extends Controller
{
    //
    public function __construct(ApiFocusNfeService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @OA\Post(
     *     path="/api/certificates/{id}",
     *     summary="Rota para de importação do certificado",
     *     description="Este endpoint permite o upload de um arquivo e dados adicionais via multipart/form-data.",
     *     operationId="uploadFile",
     *     tags={"Rota para de importação do certificado"},
    security={{"bearerAuth":{}}},
    @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID da empresa",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *     requestBody={
     * @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *           type="object",
     *           required={"certificado", "senha"},
     *           @OA\Property(
     *             property="certificado",
     *             type="string",
     *             format="binary",
     *             description="Arquivo a ser enviado"
     *           ),
     *           @OA\Property(
     *             property="senha",
     *             type="string",
     *             description="Senha do Certificado"
     *           )
     *         )
     *       )
     *     },
     *     responses={
     * @OA\Response(
     *         response=200,
     *         description="Certificado Importado com seucesso",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="success", type="boolean", example="true"),
     *           @OA\Property(property="message", type="string", example="Certificado Salvo com suecesso!"),
     *
     *         )
     *       )
     *     }
     * )
     */
    public function store(Request $request, Company $company): JsonResponse
    {
        $userLogado = Auth::user();
        $certificado = Certificate::where('company_id', $company->id)->first();


        //deleto o certificado do banco e deleto o certificado da pasta
        if ($certificado) {
            unlink(storage_path('app/private/' . $certificado->arquivo_certificado));
            Certificate::destroy($certificado->id);
        }

        $arquivoCertificado = base64_encode(file_get_contents($request->file('certificado')->getRealPath()));
        $idFocus = Company::where('id', $company->id)->first();

        $data = [
            "arquivo_certificado_base64" => $arquivoCertificado,
            "senha_certificado" => $request->senha
        ];
        $dados = $this->apiService->put($idFocus->id_nf, $data);

        if (!isset($dados['codigo'])) {
            $arquivo = $request->file('certificado');
            $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('certificados/' . $company->name, $nomeArquivo, 'local');

            Certificate::create([
                'nome_certificado' => $arquivo->getClientOriginalName(),
                'arquivo_certificado' => $caminho,
                'senha_certificado' => $request->senha,
                'data_expiracao' => $dados['certificado_valido_ate'],
                'company_id' => $userLogado->type_user === "FULL" ? $company->id : $userLogado->company_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Certificado salvo com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => $dados['erros'][0]['mensagem']
            ]);
        }
    }

}

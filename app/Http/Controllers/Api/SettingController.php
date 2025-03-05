<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingNf;
use App\Services\ApiFocusNfeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(ApiFocusNfeService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @OA\Put(
     *     path="/api/settings/{id}",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Alterar Dados das configuração de emissao",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="Passar o ID da configuração",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(

     *
    @OA\JsonContent(
     *              required={"name", "cpf_cnpj"},
     *              @OA\Property(property="cpf_cnpj_contabilidade", type="string", format="text", example="41055038000149"),
     *              @OA\Property(property="habilita_nfe", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="habilita_nfce", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="exibe_impostos_adicionais_danfe", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="exibe_unidade_tributaria_danfe", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="exibe_sempre_volumes_danfe", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="enviar_email_destinatario", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="discrimina_impostos", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="csc_nfce_producao", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="id_token_nfce_producao", type="boolean", format="boolean", example="0"),
     *              @OA\Property(property="proximo_numero_nfe_producao", type="integer", format="integer", example="123"),
     *              @OA\Property(property="proximo_numero_nfe_homologacao", type="integer", format="integer", example="123"),
     *              @OA\Property(property="serie_nfe_producao", type="integer", format="integer", example="1"),
     *              @OA\Property(property="serie_nfe_homologacao", type="integer", format="integer", example="1"),
     *              @OA\Property(property="serie_nfce_producao", type="integer", format="integer", example="1"),
     *              @OA\Property(property="serie_nfce_homologacao", type="integer", format="integer", example="1"),

    )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Configurações Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Dados atualizados com sucesso!"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Nao foi possivel atualizar o setting"
     *     )
     * )
     */
    public function update(Request $request, SettingNf $settingNf): JsonResponse
    {
        $idFocus = Company::where('id', $settingNf->company_id)->first();

        if ($idFocus->id_nf) {
            $data = [
                'cpf_cnpj_contabilidade' => $request->cpf_cnpj_contabilidade,
                'habilita_nfe' => $request->habilita_nfe,
                'habilita_nfce' => $request->habilita_nfce,
                'exibe_impostos_adicionais_danfe' => $request->exibe_impostos_adicionais_danfe,
                'exibe_unidade_tributaria_danfe' => $request->exibe_unidade_tributaria_danfe,
                'exibe_sempre_volumes_danfe' => $request->exibe_sempre_volumes_danfe,
                'enviar_email_destinatario' => $request->enviar_email_destinatario,
                'discrimina_impostos' => $request->discrimina_impostos,
                'csc_nfce_producao' => $request->csc_nfce_producao,
                'id_token_nfce_producao' => $request->id_token_nfce_producao,
                'csc_nfce_homologacao' => $request->csc_nfce_homologacao,
                'id_token_nfce_homologacao' => $request->id_token_nfce_homologacao,
                'proximo_numero_nfe_producao' => $request->proximo_numero_nfe_producao,
                'proximo_numero_nfe_homologacao' => $request->proximo_numero_nfe_homologacao,
                'serie_nfe_producao' => $request->serie_nfe_producao,
                'serie_nfe_homologacao' => $request->serie_nfe_homologacao,
                'serie_nfce_producao' => $request->serie_nfce_producao,
                'serie_nfce_homologacao' => $request->serie_nfce_homologacao,
            ];

            $dados = $this->apiService->put($idFocus->id_nf, $data);

            $settingNf->update([
                'cpf_cnpj_contabilidade' => $dados['cpf_cnpj_contabilidade'],
                'habilita_nfe' => $dados['habilita_nfe'],
                'habilita_nfce' => $dados['habilita_nfce'],
                'exibe_impostos_adicionais_danfe' => $dados['exibe_impostos_adicionais_danfe'],
                'exibe_unidade_tributaria_danfe' => $dados['exibe_unidade_tributaria_danfe'],
                'exibe_sempre_volumes_danfe' => $dados['exibe_sempre_volumes_danfe'],
                'enviar_email_destinatario' => $dados['enviar_email_destinatario'],
                'discrimina_impostos' => $dados['discrimina_impostos'],
                'csc_nfce_producao' => $dados['csc_nfce_producao'],
                'id_token_nfce_producao' => $dados['id_token_nfce_producao'],
                'csc_nfce_homologacao' => $dados['csc_nfce_homologacao'],
                'id_token_nfce_homologacao' => $dados['id_token_nfce_homologacao'],
                'proximo_numero_nfe_producao' => $dados['proximo_numero_nfe_producao'],
                'proximo_numero_nfe_homologacao' => $dados['proximo_numero_nfe_homologacao'],
                'serie_nfe_producao' => $dados['serie_nfe_producao'],
                'serie_nfe_homologacao' => $dados['serie_nfe_homologacao'],
                'serie_nfce_producao' => $dados['serie_nfce_producao'],
                'serie_nfce_homologacao' => $dados['habilita_nfe'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Nao foi possivel atualizar o setting",
            ], 500);
        }


        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso!',
        ]);
    }
}

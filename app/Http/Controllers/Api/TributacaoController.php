<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tributacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TributacaoController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/tributacoes",
     *     tags={"Rota Tributações"},
     *     summary="Listar todas tributações da empresa",
     *
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de tributaçao cadastrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="tributacoes", type="object",
     *               @OA\Property(property="id", type="string", format="text", example="1"),
     *               @OA\Property(property="nome", type="string", format="text", example="Tributação para venda de bebida"),
     *               @OA\Property(property="pis_aliquota_porcentual", type="decimal", format="decimal", example="1"),
     *               @OA\Property(property="cofins_aliquota_porcentual", type="decimal", format="decimal", example="2"),
     *               @OA\Property(property="icms_aliquota", type="decimal", format="decimal", example="5"),
     *               @OA\Property(property="cfop_id", type="integer", format="decimal", example="6"),
     *               @OA\Property(property="icms_origem_id", type="integer", format="decimal", example="7"),
     *               @OA\Property(property="icms_situacao_tributaria_id", type="integer", format="decimal", example="9"),
     *               @OA\Property(property="pis_situacao_tributaria_id", type="integer", format="decimal", example="4"),
     *               @OA\Property(property="cofins_situacao_tributaria_id", type="integer", format="decimal", example="3"),
     *               @OA\Property(property="ativo", type="integer", format="decimal", example="1"),

     * )
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }

        $tributacao = Tributacao::where('ativo', 1)
            ->where('company_id', $userLogado->company_id)
            ->get();

        return response()->json([
            'success' => true,
            'tributacoes' => $tributacao
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tributacoes",
     *     tags={"Rota Tributações"},
     *     summary="Cadastro de Tributações",
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(

     *
    @OA\JsonContent(
     *              required={"nome"},
     *              @OA\Property(property="nome", type="string", format="text", example="Tributação para venda de bebida"),
     * *              @OA\Property(property="icms_aliquota", type="decimal", format="decimal", example="12"),
     * *              @OA\Property(property="pis_aliquota_porcentual", type="decimal", format="decimal", example="1"),
     * *              @OA\Property(property="cofins_aliquota_porcentual", type="decimal", format="decimal", example="4"),
     * *              @OA\Property(property="cfop_id", type="decimal", format="decimal", example="3"),
     * *              @OA\Property(property="icms_origem_id", type="decimal", format="decimal", example="2"),
     * *              @OA\Property(property="icms_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *              @OA\Property(property="pis_situacao_tributaria_id", type="decimal", format="decimal", example="6"),
     * *              @OA\Property(property="cofins_situacao_tributaria_id", type="decimal", format="decimal", example="3"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Tributaçao cadastrado com seucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="tributacao", type="object",
     * *               @OA\Property(property="nome", type="string", format="text", example="Tributação para venda de bebida"),
     * *               @OA\Property(property="icms_aliquota", type="decimal", format="decimal", example="1"),
     * *               @OA\Property(property="pis_aliquota_porcentual", type="decimal", format="decimal", example="2"),
     * *               @OA\Property(property="cofins_aliquota_porcentual", type="decimal", format="decimal", example="3"),
     * *               @OA\Property(property="cfop_id", type="decimal", format="decimal", example="3"),
     * *               @OA\Property(property="icms_origem_id", type="decimal", format="decimal", example="2"),
     * *               @OA\Property(property="icms_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *               @OA\Property(property="pis_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *               @OA\Property(property="cofins_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     *
     *
     * * )
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function Store(Request $request): JsonResponse
    {
        $userLogado = Auth::user();
        $tributacao = Tributacao::create([
            'nome' => $request->nome,
            'icms_aliquota' => $request->icms_aliquota,
            'pis_aliquota_porcentual' => $request->pis_aliquota_porcentual,
            'cofins_aliquota_porcentual' => $request->cofins_aliquota_porcentual,
            'cfop_id' => $request->cfop_id,
            'icms_origem_id' => $request->icms_origem_id,
            'icms_situacao_tributaria_id' => $request->icms_situacao_tributaria_id,
            'pis_situacao_tributaria_id' => $request->pis_situacao_tributaria_id,
            'cofins_situacao_tributaria_id' => $request->cofins_situacao_tributaria_id,
            'company_id' => $userLogado->company_id
        ]);

        return response()->json([
            'success' => true,
            'tributacao' => $tributacao
        ], 200);
    }




    /**
     * @OA\Put(
     *     path="/api/tributacoes",
     *     tags={"Rota Tributações"},
     *     summary="Update de Tributações",
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(

     *
    @OA\JsonContent(
     *              required={"nome"},
     *              @OA\Property(property="nome", type="string", format="text", example="Tributação para venda de bebida"),
     * *              @OA\Property(property="icms_aliquota", type="decimal", format="decimal", example="12"),
     * *              @OA\Property(property="pis_aliquota_porcentual", type="decimal", format="decimal", example="1"),
     * *              @OA\Property(property="cofins_aliquota_porcentual", type="decimal", format="decimal", example="4"),
     * *              @OA\Property(property="cfop_id", type="decimal", format="decimal", example="3"),
     * *              @OA\Property(property="icms_origem_id", type="decimal", format="decimal", example="2"),
     * *              @OA\Property(property="icms_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *              @OA\Property(property="pis_situacao_tributaria_id", type="decimal", format="decimal", example="6"),
     * *              @OA\Property(property="cofins_situacao_tributaria_id", type="decimal", format="decimal", example="3"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Tributaçao Alterada com seucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="tributacao", type="object",
     * *               @OA\Property(property="nome", type="string", format="text", example="Tributação para venda de bebida"),
     * *               @OA\Property(property="icms_aliquota", type="decimal", format="decimal", example="1"),
     * *               @OA\Property(property="pis_aliquota_porcentual", type="decimal", format="decimal", example="2"),
     * *               @OA\Property(property="cofins_aliquota_porcentual", type="decimal", format="decimal", example="3"),
     * *               @OA\Property(property="cfop_id", type="decimal", format="decimal", example="3"),
     * *               @OA\Property(property="icms_origem_id", type="decimal", format="decimal", example="2"),
     * *               @OA\Property(property="icms_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *               @OA\Property(property="pis_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     * *               @OA\Property(property="cofins_situacao_tributaria_id", type="decimal", format="decimal", example="4"),
     *
     *
     * * )
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function Updade(Request $request, Tributacao $tributacao): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->company_id !== $tributacao->company_id) {
            return response()->json([
                'success' => false,
                'msg' => "Você não tem permissão para atualizar esta tributação."
            ], 403); // Usando 403 para indicar falta de permissão
        }

        // Atualizando os dados
        $tributacao->update($request->only([
            'nome',
            'icms_aliquota',
            'pis_aliquota_porcentual',
            'cofins_aliquota_porcentual',
            'cfop_id',
            'icms_origem_id',
            'icms_situacao_tributaria_id',
            'pis_situacao_tributaria_id',
            'cofins_situacao_tributaria_id'
        ]));

        // Retornando a resposta de sucesso
        return response()->json([
            'success' => true,
            'tributacao' => $tributacao
        ], 200);
    }


    /**
     * @OA\Put(
     *     path="/api/tributacoes-status",
     *     tags={"Rota Tributações"},
     *     summary="Update de Tributações",
     *  security={{"bearerAuth":{}}},
     *          @OA\Parameter(
     *  *         name="id",
     *  *         in="path",
     *  *         required=true,
     *  *         description="ID",
     *  *         @OA\Schema(type="integer", example=1)
     *  *     ),


     *

     * @OA\Response(
     *          response=200,
     *          description="Tributaçao Alterada com seucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Tributação ativada/desatavda"),


     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updateStatus(Tributacao $tributacao): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }


        $tributacao->update([
            'ativo' => $tributacao->ativo ? 0 : 1
        ]);
        return response()->json([
            'success' => true,
            'message' => $tributacao->ativo ? "Tributação ativada" : "Tributação desativada"
        ], 200);
    }
}

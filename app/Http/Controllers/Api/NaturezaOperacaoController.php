<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NaturezaOperacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NaturezaOperacaoController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/natureza",
     *     tags={"Rota Naturaza de Operação"},
     *     summary="Listar todas natureza de operaçao",
     *          summary="Listar todas ncm da empresa",
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de natureza de operação",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="naturezas", type="object",
     *               @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDAS DE MERCADORIA"),
     *               @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="ENTRADA"),

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
        $natureza = NaturezaOperacao::where('company_id', $userLogado->company_id)
            ->where('active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'naturezas' => $natureza
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/natureza",
     *     tags={"Rota Naturaza de Operação"},
     *     summary="Cadastro de Natureza de operação",
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *      description="Regime tributario:
     * 1 = Simples Nacional, 2 = Simples Nacional - Excesso de Sublimite, 3 = Regime Normal'",
     *
    @OA\JsonContent(
     *              required={"nome_ncm", "codigo_ncm"},
     *              @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDAS DE MERCADORIA"),
     * *              @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="ENTRADA"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Ncm cadastrado com seucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="natureza", type="object",
     * *               @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDAS DE MERCADORIA"),
     * *               @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="ENTRADA"),
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
    public function store(Request $request): JsonResponse
    {
        $userLogado = Auth::user();
        $natureza = NaturezaOperacao::create([
            'nome_natureza_operacao' => $request->nome_natureza_operacao,
            'tipo_natureza_operacao' => $request->tipo_natureza_operacao,
            'company_id' => $userLogado->company_id,
        ]);

        return response()->json([
            'success' => true,
            'natureza' => $natureza
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/natureza/{id}",
     *     tags={"Rota Naturaza de Operação"},
     *     summary="Altera dados da Naturaza de Operação",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *              required={"nome_natureza_operacao", "tipo_natureza_operacao"},
     *              @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDA DE MERCADORIA FORA DO ESTADO"),
     *              @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="SAIDA"),
    )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Naturaza de operação Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="natureza", type="object",
     * * *               @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDA DE MERCADORIA FORA DO ESTADO"),
     * * *               @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="SAIDA"),
     * *
     * * * )
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function update(Request $request, NaturezaOperacao $naturezaOperacao): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->company_id === $naturezaOperacao->company_id) {
            $naturezaOperacao->update([
                'nome_natureza_operacao' => $request->nome_natureza_operacao,
                'tipo_natureza_operacao' => $request->tipo_natureza_operacao,
            ]);
            return response()->json([
                'success' => true,
                'natureza' => $naturezaOperacao

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'mesage' => "Naturaza nao pertence a essa empresa"
            ], 401);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/natureza-status/{id}",
     *     tags={"Rota Naturaza de Operação"},
     *     summary="Ativando e desativando a natureza de operação",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *

     * @OA\Response(
     *          response=200,
     *          description="Naturaza de operação Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="natureza", type="object",
     * * *               @OA\Property(property="nome_natureza_operacao", type="string", format="text", example="VENDAS DE MERCADORIA"),
     * * *               @OA\Property(property="tipo_natureza_operacao", type="string", format="text", example="SAIDA"),
     * * *               @OA\Property(property="active", type="boolean", format="text", example="0"),
     * *
     * * * )
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updateStatus(NaturezaOperacao $naturezaOperacao): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->company_id === $naturezaOperacao->company_id) {
            $naturezaOperacao->update([
                'active' => $naturezaOperacao->active ? 0 : 1,

            ]);
            return response()->json([
                'success' => true,
                'natureza' => $naturezaOperacao

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'mesage' => "Naturaza nao pertence a essa empresa"
            ], 401);
        }
    }
}

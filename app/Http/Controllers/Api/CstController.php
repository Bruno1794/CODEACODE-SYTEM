<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cofins_situacao_tributaria;
use App\Models\Icms_origem;
use App\Models\Icms_situacao_tributaria;
use App\Models\Pis_situacao_tributaria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CstController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/icmsOrigem",
     *     tags={"Rota CSTs"},
     *     summary="Listar todas ICMS DE ORIGEM",
     *
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de ICMS DE ORIGIEM",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="icms_origem", type="object",
     *               @OA\Property(property="id", type="string", format="text", example="1"),
     *               @OA\Property(property="codigo", type="string", format="text", example="Tributação para venda de bebida"),
     *               @OA\Property(property="descricao", type="string", format="string", example="Nacional"),

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
    public function icmsOrigem(): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }

        $icmsOrigem = Icms_origem::get();

        return response()->json([
            'success' => true,
            'icms_origem' => $icmsOrigem
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/icmsSituacaoTributaria",
     *     tags={"Rota CSTs"},
     *     summary="Listar todas ICMS SITUAÇÃO TRIBUTARIA",
     *
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de ICMS SITUAÇÃO TRIBUTARIA",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="icms_situacao_tributaria", type="object",
     *               @OA\Property(property="id", type="string", format="text", example="1"),
     *               @OA\Property(property="codigo", type="string", format="text", example="Tributação para venda de bebida"),
     *               @OA\Property(property="descricao", type="string", format="string", example="Nacional"),

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
    public function icmsSituacaoTributaria(): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }

        $icmsOrigem = Icms_situacao_tributaria::get();

        return response()->json([
            'success' => true,
            'icms_situacao_tributaria' => $icmsOrigem
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pisSituacaoTributaria",
     *     tags={"Rota CSTs"},
     *     summary="Listar todas PIS SITUAÇÃO TRIBUTARIA",
     *
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de PIS SITUAÇÃO TRIBUTARIA",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="pis_situacao_tributaria", type="object",
     *               @OA\Property(property="id", type="string", format="text", example="1"),
     *               @OA\Property(property="codigo", type="string", format="text", example="Tributação para venda de bebida"),
     *               @OA\Property(property="descricao", type="string", format="string", example="Nacional"),

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
    public function PisSituacaoTributaria(): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }

        $icmsOrigem = Pis_situacao_tributaria::get();

        return response()->json([
            'success' => true,
            'pis_situacao_tributaria' => $icmsOrigem
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/cofinsSituacaoTributaria",
     *     tags={"Rota CSTs"},
     *     summary="Listar todas COFINS SITUAÇÃO TRIBUTARIA",
     *
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de PIS SITUAÇÃO TRIBUTARIA",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="cofins_situacao_tributaria", type="object",
     *               @OA\Property(property="id", type="string", format="text", example="1"),
     *               @OA\Property(property="codigo", type="string", format="text", example="Tributação para venda de bebida"),
     *               @OA\Property(property="descricao", type="string", format="string", example="Nacional"),

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
    public function CofinsSituacaoTributaria(): JsonResponse
    {
        $userLogado = Auth::user();
        if (!$userLogado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);  // Código de status para não autorizado
        }

        $icmsOrigem = Cofins_situacao_tributaria::get();

        return response()->json([
            'success' => true,
            'cofins_situacao_tributaria' => $icmsOrigem
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CFOP;
use App\Models\NaturezaOperacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CFOPController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/cfop",
     *     tags={"Rota CFOPS"},
     *     summary="Listar todos os CFOPS ATIVO",
     *  security={{"bearerAuth":{}}},
     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de cfops",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="cfops", type="object",
     *               @OA\Property(property="id", type="integer", format="text", example="1"),
     *               @OA\Property(property="codigo", type="string", format="text", example="VENDAS DE MERCADORIA"),
     *               @OA\Property(property="descricao", type="string", format="text", example="ENTRADA"),
     *               @OA\Property(property="active", type="boolean", format="text", example="1"),
     *               @OA\Property(property="natureza_operacoes_id", type="integer", format="text", example="1"),
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
        $user = Auth::user();
        $cfops = CFOP::where('company_id', $user->company_id)
            ->where('active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'cfops' => $cfops,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/cfop",
     *     tags={"Rota CFOPS"},
     *     summary="Cadastro de cfops",
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(

     *
    @OA\JsonContent(
     *              required={"codigo", "descricao"},
     *              @OA\Property(property="codigo", type="string", format="text", example="5102"),
     * *              @OA\Property(property="descricao", type="string", format="text", example="Venda dentro do estado"),
     * *              @OA\Property(property="natureza_operacoes_id", type="interger", format="text", example="1"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="CFOP Cadastrado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="mesage", type="string", example="CFOP cadastrado com sucesso"),

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
        $validaNatureza = NaturezaOperacao::where('id', $request->natureza_operacoes_id)
            ->where('company_id', $userLogado->company_id)->first();
        if ($validaNatureza) {
            CFOP::create([
                'codigo' => $request->codigo,
                'descricao' => $request->descricao,
                'natureza_operacoes_id' => $request->natureza_operacoes_id,
                'company_id' => $userLogado->company_id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mesage' => "Natureza de operação não encontrado"
            ], 400);
        }

        return response()->json([
            'success' => true,
            'mesage' => "CFOP cadastrado com sucesso"
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/cfop/{id}",
     *     tags={"Rota CFOPS"},
     *     summary="Altera dados do cfop",
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
     *              required={"codigo", "descricao"},
     *              @OA\Property(property="codigo", type="string", format="text", example="5102"),
     *              @OA\Property(property="descricao", type="string", format="text", example="Venda dentro do estado"),
     *              @OA\Property(property="natureza_operacoes_id", type="interger", format="text", example="1"),
    )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="CFOP Atualizado",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="mesage", type="string", example="CFOP atualizado com sucesso"),


     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function update(CFOP $cfop, Request $request): JsonResponse
    {
        $userLogado = Auth::user();

        if ($userLogado->company_id === $cfop->company_id) {
            $validaNatureza = NaturezaOperacao::where('id', $request->natureza_operacoes_id)
                ->where('company_id', $userLogado->company_id)->first();
            if ($validaNatureza) {
                $cfop->update([
                    'codigo' => $request->codigo,
                    'descricao' => $request->descricao,
                    'natureza_operacoes_id' => $request->natureza_operacoes_id,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'mesage' => "CFOP cadastrado com sucesso"
                ], 200);
            }
        } else {
            return response()->json([
                'success' => true,
                'mesage' => "CFOP não pertence a essa empresa"
            ], 200);
        }

        return response()->json([
            'success' => true,
            'mesage' => "CFOP atualizado com sucesso"
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/cfop-status/{id}",
     *     tags={"Rota CFOPS"},
     *     summary="Ativando e desativando CFOP",
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
     *          description="CFOP Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="mesage", type="boolean", example="CFOP Ativado com sucesso"),

     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updateSatus(CFOP $cfop): JsonResponse
    {

        $userLogado = Auth::user();
        $validaNatureza = NaturezaOperacao::where('id', $cfop->natureza_operacoes_id)
            ->where('company_id', $userLogado->company_id)->first();
        if ($validaNatureza) {
            $cfop->update([
                'active' => $cfop->active ? 0 : 1
            ]);
        }
        return response()->json([
            'success' => true,
            'mesage' => $cfop->active ? "CFOP Ativado com sucesso" : "CFOP Desativado com sucesso"
        ]);
    }
}

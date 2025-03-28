<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NCM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NCMController extends Controller
{
    //
    /**
     * @OA\Get(
     *     path="/api/ncm",
     *     tags={"Rota NCM"},
     *     summary="Listar todas ncm da empresa",
     *          summary="Listar todas ncm da empresa",
     *  security={{"bearerAuth":{}}},

     *
     * @OA\Response(
     *          response=200,
     *          description="Lista de ncm cadastrada=o",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="ncm", type="object",
     *               @OA\Property(property="nome_ncm", type="string", format="text", example="produtos das indústrias alimentares e bebidas;"),
     *               @OA\Property(property="codigo_ncm", type="string", format="text", example="28.041.00"),

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
        $ncm = NCM::where('company_id', $userLogado->company_id)
            ->where('active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'ncm' => $ncm
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/ncm",
     *     tags={"Rota NCM"},
     *     summary="Cadastro de NCM",
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *      description="Regime tributario:
     * 1 = Simples Nacional, 2 = Simples Nacional - Excesso de Sublimite, 3 = Regime Normal'",
     *
    @OA\JsonContent(
     *              required={"nome_ncm", "codigo_ncm"},
     *              @OA\Property(property="nome_ncm", type="string", format="text", example="Produtos das indústrias alimentares e bebidas"),
     * *              @OA\Property(property="codigo_ncm", type="string", format="text", example="28.041.00"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Ncm cadastrado com seucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="ncm", type="object",
     * *               @OA\Property(property="nome_ncm", type="string", format="text", example="produtos das indústrias alimentares e bebidas;"),
     * *               @OA\Property(property="codigo_ncm", type="string", format="text", example="28.041.00"),
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
        $ncm = NCM::create([
            'nome_ncm' => $request->nome_ncm,
            'codigo_ncm' => $request->codigo_ncm,
            'company_id' => $userLogado->company_id,

        ]);
        return response()->json([
            'success' => true,
            'ncm' => $ncm
        ]);
    }



    /**
     * @OA\Put(
     *     path="/api/ncm/{id}",
     *     tags={"Rota NCM"},
     *     summary="Altera dados do NCM",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID do NCM",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *              required={"nome_ncm", "codigo_ncm"},
     *              @OA\Property(property="nome_ncm", type="string", format="text", example="produtos das indústrias alimentares e bebidas"),
     *              @OA\Property(property="codigo_ncm", type="string", format="text", example="28.041.00"),
              )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="NCM Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="ncm", type="object",
     * * *               @OA\Property(property="nome_ncm", type="string", format="text", example="produtos das indústrias alimentares e bebidas;"),
     * * *               @OA\Property(property="codigo_ncm", type="string", format="text", example="28.041.00"),
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
    public function update(Request $request, NCM $ncm): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->company_id === $ncm->company_id) {
            $ncm->update([
                'nome_ncm' => $request->nome_ncm,
                'codigo_ncm' => $request->codigo_ncm,
            ]);
            return response()->json([
                'success' => true,
                'ncm' => $ncm
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'mensage' => "NCM nao pertece a sua Empresa"
            ], 400);
        }
    }
}

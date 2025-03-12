<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //



    /**
     * @OA\Put(
     *     path="/api/update-password/{id}",
     *     tags={"Rota para de gerenciar usuario"},
     *     summary="Altera senha do Usuario",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID do usuário a ser buscado",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *
     *              @OA\Property(property="password", type="password", format="text", example="051161Tu"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Usuário autenticado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Password changed successfully!"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updatePassword(Request $request, User $user): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->type_user === "FULL") {
            $user->update([
                'password' => Hash::make($request->password, ['rounds' => 12])
            ]);

            return response()->json([
                "success" => true,
                "message" => "Senha alterada com sucesso!"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Você não tem permissão para alterar a senha!"
            ], 401);
        }
    }
}

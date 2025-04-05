<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Rota de Acesso e Logout"},
     *     summary="Realiza login do usuário",
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *              required={"username", "password"},
     *              @OA\Property(property="username", type="string", format="text", example="bruno1020"),
     *              @OA\Property(property="password", type="string", format="password", example="123456")
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Usuário autenticado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="token", type="string", example="3|UGgrNtJ7juz9Of4l7OAxsa8VQilWKA30SpzYSSf4d889ca70"),
     *              @OA\Property(property="user", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Bruno Costa"),
     *                  @OA\Property(property="username", type="string", format="text", example="bruno1020"),
     *                  @OA\Property(property="type_user", type="ENUM", format="text", example="FULL"),
     *                  @OA\Property(property="status", type="boolean", format="text", example="1"),
     *              )
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();


            if ($user->type_user === "FULL") {
                $token = $user->createToken('CODENF')->plainTextToken;
            } else {
                if ($user->type_user !== "FULL") {
                    $company = Company::where('id', $user->company_id)
                        ->where('date_expiration', '>', now())
                        ->where('status', 1)->first();
                    if ($company) {
                        $token = $user->createToken('CODENF')->plainTextToken;
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Entre em contato com seu fornecedor'
                        ], 401);
                    }
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuario ou senha invalidos'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Rota de Acesso e Logout"},
     *     summary="Realiza o logout do usuario logado atravez do token de autenticação",
    *       security={{"bearerAuth":{}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Logout realizado com sucesso!",
     *
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */

    public function logout(): JsonResponse
    {
        $user = Auth::check();
        if ($user) {
            $user = User::where('id', Auth::id())->first();
            $user->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => "Logout realizado com sucesso!"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'mesage' => "Falha ao realizar logout"
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class CompanyController extends Controller
{
    //
    /**
     * @OA\Post(
     *     path="/api/companys",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Cadastro de empresas",
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *              required={"name", "cpf_cnpj"},
     *              @OA\Property(property="name", type="string", format="text", example="PEPEU 09351223343"),
     *              @OA\Property(property="cpf_cnpj", type="string", format="text", example="41055038000149"),
     *              @OA\Property(property="name_fantasy", type="string", format="text", example="Pepeus Bar LTDA"),
     *              @OA\Property(property="address", type="string", format="text", example="Rua Antonio Mesias"),
     *              @OA\Property(property="number_addres", type="string", format="text", example="10"),
     *              @OA\Property(property="district_addres", type="string", format="text", example="CENTRO"),
     *              @OA\Property(property="city", type="string", format="text", example="Terr Rica"),
     *              @OA\Property(property="state", type="string", format="text", example="PR"),
     *              @OA\Property(property="cep", type="string", format="text", example="87890-000"),
     *              @OA\Property(property="inscription_state", type="string", format="text", example="ISENTO"),
     *              @OA\Property(property="phone", type="string", format="text", example="(44) 998212-815"),
     *              @OA\Property(property="name_user", type="string", format="text", example="bruno Costa"),
     *              @OA\Property(property="username", type="string", format="text", example="bruno2525"),
     *              @OA\Property(property="password", type="string", format="password", example="2020"),
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Usuário autenticado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Company added successfully"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */

    public function post(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'type_user' => "ADMIN",
                'user_id' => Auth::id(),
                'password' => Hash::make($request->password, ['rounds' => 12]),
            ]);

            Company::create([
                'name' => $request->name,
                'cpf_cnpj' => $request->cpf_cnpj,
                'name_fantasy' => $request->name_fantasy,
                'address' => $request->address,
                'number_addres' => $request->number_addres,
                'district_addres' => $request->district_addres,
                'city' => $request->city,
                'state' => $request->state,
                'cep' => $request->cep,
                'inscription_state' => $request->inscription_state,
                'phone' => $request->phone,
                'date_expiration' => Carbon::now()->addDays(30),
                'user_id' => $user->id,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Company added successfully',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/companys",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Listar todas empresas",
     *          summary="Realiza o logout do usuario logado atravez do token de autenticação",
     *      @OA\Parameter(
     *  *         name="status",
     *  *         in="header",
     *  *         required=true,
     *  *         description="Passar no parametro 1 para ativos e 0 para Inativos'",
     *  *         @OA\Schema(type="string", example="1")
     *  *     ),
     *
     * @OA\Response(
     *          response=200,
     *          description="Lista da empresa cadastrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="companey", type="object",
     *                   @OA\Property(property="name", type="string", format="text", example="PEPEU 09351223343"),
     *               @OA\Property(property="cpf_cnpj", type="string", format="text", example="41055038000149"),
     *               @OA\Property(property="name_fantasy", type="string", format="text", example="Pepeus Bar LTDA"),
     *               @OA\Property(property="address", type="string", format="text", example="Rua Antonio Mesias"),
     *               @OA\Property(property="number_addres", type="string", format="text", example="10"),
     *               @OA\Property(property="district_addres", type="string", format="text", example="CENTRO"),
     *               @OA\Property(property="city", type="string", format="text", example="Terr Rica"),
     *               @OA\Property(property="state", type="string", format="text", example="PR"),
     *               @OA\Property(property="cep", type="string", format="text", example="87890-000"),
     *               @OA\Property(property="inscription_state", type="string", format="text", example="ISENTO"),
     *               @OA\Property(property="phone", type="string", format="text", example="(44) 998212-815"),
     *               @OA\Property(property="date_expiration", type="date", format="text", example="2025-05-10"),
     *
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
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $companey = Company::where('user_id', Auth::id())
            ->where('status', $request->status ? 1 : 0)
            ->get();
        return response()->json([
            'success' => true,
            'companey' => $companey,
        ], 200);
    }
}

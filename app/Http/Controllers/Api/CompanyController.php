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
     *  security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *      description="Regime tributario:
     * 1 = Simples Nacional, 2 = Simples Nacional - Excesso de Sublimite, 3 = Regime Normal'",
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
     *              @OA\Property(property="regime_tributário", type="integer", format="text", example="(44) 998212-815"),
     *              @OA\Property(property="name_user", type="string", format="text", example="bruno Costa"),
     *              @OA\Property(property="username", type="string", format="text", example="bruno2525"),
     *              @OA\Property(property="password", type="string", format="password", example="2020"),
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Salvo empresa com sucesso",
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
            $company = Company::create([
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
                'regime_tributário' => $request->regime_tributário,
                'date_expiration' => Carbon::now()->addDays(30),
                'user_id' => Auth::id(),
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'type_user' => "ADMIN",
                'company_id' => $company->id,
                'password' => Hash::make($request->password, ['rounds' => 12]),
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
     *          summary="Lista Todas empresas Cadastrada",
     *  security={{"bearerAuth":{}}},
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
        if ($user->type_user === "FULL") {
            $companey = Company::where('status', $request->status ? $request->status : 1)
                ->get();
            return response()->json([
                'success' => true,
                'companey' => $companey,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page",
            ], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/companys-users/{id}",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Busca todos os usuarios referente a empresa passado pelo id",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID da empresa que deseja buscar os usuarios",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="user", type="object",
     * *                  @OA\Property(property="id", type="integer", example=1),
     * *                  @OA\Property(property="name", type="string", example="Bruno Costa"),
     * *                  @OA\Property(property="username", type="string", format="text", example="bruno1020"),
     * *                  @OA\Property(property="type_user", type="ENUM", format="text", example="FULL"),
     * *                  @OA\Property(property="status", type="boolean", format="text", example="1"),
     * *              )
     * *          )
     * *      ),
     * @OA\Response(
     *          response=200,
     *          description="Listando empresa",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Company updated successfully"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function indexUsers(Company $company): JsonResponse
    {
        $userLogado = Auth::user();
        if ($userLogado->type_user === "FULL") {
            $user = User::where('company_id', $company->id)->get();
            return response()->json([
                'success' => true,
                'users' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page",
            ], 401);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/companys-status/{id}",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Alterar o status para Ativo ou Inativo",
     *          summary="Se a empresta estiver Ativa e receber essa requicição ela Desativa ou visse versa.",
     *       security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * * *         name="id",
     * * *         in="path",
     * * *         required=true,
     * * *         description="ID do usuário a ser buscado",
     * * *         @OA\Schema(type="integer", example=1)
     * * *     ),
     *
     * @OA\Response(
     *
     *          response=200,
     *          description="Company updated successfully",
     *     @OA\JsonContent(
     *               @OA\Property(property="success", type="boolean", example="true"),
     *               @OA\Property(property="message", type="string", example="Company updated successfully"),
     *
     *           )
     *       ),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updateStatus(Company $company)
    {
        if (Auth::check()) {
            $company->update([
                'status' => $company->status ? 0 : 1
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully',
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/companys/{id}",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Altera dados do cadastro da empresa",
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
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Empresa Atualizada",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Company updated successfully"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        $user = Auth::user();
        if ($user->type_user === "FULL") {
            $company->update([
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
                'regime_tributário' => $request->regime_tributário,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permission to access this page",
            ], 401);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/companys-renew/{id}",
     *     tags={"Rota de empresas que vai utilizar o sistema"},
     *     summary="Renovar empresa",
     *  security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     * *         name="id",
     * *         in="path",
     * *         required=true,
     * *         description="ID da empresa",
     * *         @OA\Schema(type="integer", example=1)
     * *     ),
     *
     *     @OA\RequestBody(
     *      description="Credenciais do usuário",
     *
    @OA\JsonContent(
     *
     *              @OA\Property(property="mes", type="string", format="text", example="1"),

     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Usuário renovado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Company renew successfully"),
     *
     *          )
     *      ),
     * @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function updateDataExpiration(Request $request, Company $company)
    {

        if (Auth::check()) {
            $company->update([
                'date_expiration' =>  Carbon::parse($company->date_expiration)->addMonths($request->mes)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Company renew successfully',
        ], 200);
    }


}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingNf;
use App\Models\User;
use App\Services\ApiFocusNfeService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class CompanyController extends Controller
{
    protected ApiFocusNfeService $apiService;

    public function __construct(ApiFocusNfeService $apiService)
    {
        $this->apiService = $apiService;
    }
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
     *              @OA\Property(property="nome", type="string", format="text", example="PEPEU 09351223343"),
     * *              @OA\Property(property="nome_fantasia", type="string", format="text", example="Pepeus Bar LTDA"),
     * *              @OA\Property(property="inscricao_estadual", type="string", format="text", example="Isento"),
     * *              @OA\Property(property="cnpj", type="string", format="text", example="123232434343"),
     * *              @OA\Property(property="regime_tributario", type="integer", format="integer", example="1"),
     * *              @OA\Property(property="email", type="string", format="email", example="bruno@gmail.com"),
     * *              @OA\Property(property="telefone", type="string", format="text", example="44998212815"),
     * *              @OA\Property(property="logradouro", type="string", format="text", example="Rua Acre"),
     * *              @OA\Property(property="numero", type="string", format="text", example="1234"),
     * *              @OA\Property(property="complemento", type="string", format="text", example="Casa"),
     * *              @OA\Property(property="bairro", type="string", format="text", example="Centro"),
     * *              @OA\Property(property="cep", type="string", format="text", example="87890000"),
     * *              @OA\Property(property="municipio", type="string", format="text", example="Terra Rica"),
     * *              @OA\Property(property="uf", type="string", format="text", example="PR"),
     * *              @OA\Property(property="name", type="string", format="text", example="Bruno Costa"),
     * *              @OA\Property(property="username", type="string", format="text", example="bruno1020"),
     * *              @OA\Property(property="password", type="string", format="password", example="2020"),
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
            $data = [
                'nome' => $request->nome,
                'nome_fantasia' => $request->nome_fantasia,
                'inscricao_estadual' => $request->inscricao_estadual,
                'inscricao_municipal' => $request->inscricao_municipal,
                'cnpj' => $request->cnpj,
                'regime_tributario' => $request->regime_tributario,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cep' => $request->cep,
                'municipio' => $request->municipio,
                'uf' => $request->uf,

            ];
            $dados = $this->apiService->post($data);


            if ($dados) {
                $company = Company::create([
                    'id_nf' => $dados['id'],
                    'name' => $dados['nome'],
                    'cpf_cnpj' => $dados['cnpj'],
                    'name_fantasy' => $dados['nome_fantasia'],
                    'address' => $dados['logradouro'],
                    'number_addres' => $dados['numero'],
                    'district_addres' => $dados['bairro'],
                    'city' => $dados['municipio'],
                    'state' => $dados['uf'],
                    'cep' => $dados['cep'],
                    'inscription_state' =>$dados['inscricao_estadual'] ? $dados['inscricao_estadual'] : "ISENTO",
                    'phone' => $dados['telefone'],
                    'regime_tributario' => $dados['regime_tributario'],
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

                SettingNf::create([
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
                    'serie_nfce_homologacao' => $dados['serie_nfce_homologacao'],
                    'company_id' => $company->id,
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Empresa salva com sucesso',
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
                'message' => "Você não tem permissão para acessar esta página",
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
                'message' => "Você não tem permissão para acessar esta página",
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
     *              required={"nome", "cnpj"},
     *              @OA\Property(property="nome", type="string", format="text", example="PEPEU 09351223343"),
     *              @OA\Property(property="nome_fantasia", type="string", format="text", example="Pepeus Bar LTDA"),
     *              @OA\Property(property="logradouro", type="string", format="text", example="Rua Antonio Mesias"),
     *              @OA\Property(property="numero", type="string", format="text", example="10"),
     *              @OA\Property(property="bairro", type="string", format="text", example="CENTRO"),
     *              @OA\Property(property="municipio", type="string", format="text", example="Terr Rica"),
     *              @OA\Property(property="uf", type="string", format="text", example="PR"),
     *              @OA\Property(property="cep", type="string", format="text", example="87890-000"),
     *              @OA\Property(property="inscricao_estadual", type="string", format="text", example="ISENTO"),
     *              @OA\Property(property="telefone", type="string", format="text", example="(44) 998212-815"),
     *               @OA\Property(property="regime_tributario", type="integer", format="number", example="1"),          )
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

            $data = [
                'nome' => $request->nome,
                'nome_fantasia' => $request->nome_fantasia,
                'inscricao_estadual' => $request->inscricao_estadual,
                'inscricao_municipal' => $request->inscricao_municipal,
                'regime_tributario' => $request->regime_tributario,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cep' => $request->cep,
                'municipio' => $request->municipio,
                'uf' => $request->uf,
            ];
          $dados = $this->apiService->put($company->id_nf, $data);


            $company->update([
                'name' => $dados['nome'],
                'name_fantasy' => $dados['nome_fantasia'],
                'address' => $dados['logradouro'],
                'number_addres' => $dados['numero'],
                'district_addres' => $dados['bairro'],
                'city' => $dados['municipio'],
                'state' =>$dados['uf'],
                'cep' => $dados['cep'],
                'inscription_state' =>$dados['inscricao_estadual'] ? $dados['inscricao_estadual'] : "ISENTO",
                'phone' => $dados['telefone'],
                'regime_tributario' => $dados['regime_tributario'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Empresa atualizda com sucesso',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Você não tem permissão para acessar esta página",
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
     *              @OA\Property(property="mes", type="integer", format="integer", example="1"),
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Usuário renovado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Renovado com sucesso"),
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
                'date_expiration' => Carbon::parse($company->date_expiration)->addMonths($request->mes)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Renovado com sucesso',
        ], 200);
    }


}


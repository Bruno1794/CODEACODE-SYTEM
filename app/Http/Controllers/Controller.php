<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API CODE-NFE",
 *      description="Documentação da API gerada com Swagger no Laravel",
 *      @OA\Contact(
 *          email="brunocostasilva62@gmail.com"
 *      )
 * ),
 * @OA\Tag(
 *          name="Rota de Acesso e Logout",
 *          description="Endpoints relacionados a pedidos"
 *      ),
 * @OA\Tag(
 *           name="Rota de empresas que vai utilizar o sistema",
 *           description="Endpoints relacionados a empresas do sistema (FULL)"
 *       ),
 * @OA\Tag(
 *            name="Rota para de gerenciar usuario",
 *            description="Endpoints relacionados a usuarios (FULL)"
 *        ),
 * @OA\Tag(
 * name="Rota para de configuração da NFe",
 * description="Endpoints relacionados a configuração da NFe"
 * ),
 * @OA\Tag(
 * name="Rota para de importação do certificado",
 * description="Endpoints relacionados a inportação do certificado"
 * ),
 * @OA\Tag(
 *  name="Rota NCM",
 *  description="Endpoints relacionados a ncm - (admin)"
 *  ),
 * @OA\Tag(
 * name="Rota Naturaza de Operação",
 * description="Endpoints relacionados a natureza de operação - (admin)"
 * ),
 * @OA\Tag(
 * name="Rota CFOPS",
 * description="Endpoints relacionados CFOPS - (admin)"
 * ),
 * @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT",
 *          description="Autenticação via Bearer Token"
 *      )
 *  ),
 *
 */
abstract class Controller
{
    //
}

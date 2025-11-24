<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @OA\Info(
 *   title="API Books Laravel v5.8",
 *   version="1.0.0",
 *   description="API RESTful para gestión de autores, libros y usuarios con autenticación JWT."
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8000/api",
 *   description="Servidor local de desarrollo"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 *
 * @OA\Schema(
 *   schema="ApiResponse",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean"),
 *     @OA\Property(property="message", type="string"),
 *     @OA\Property(property="data", type="object")
 *   }
 * )
 *
 * @OA\Schema(
 *   schema="Author",
 *   type="object",
 *   required={"name","email"},
 *   properties={
 *     @OA\Property(property="id_author", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Gabriel García Márquez"),
 *     @OA\Property(property="email", type="string", format="email", example="gabo@example.com"),
 *     @OA\Property(property="bio", type="string", example="Novelista colombiano del realismo mágico"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 *   }
 * )
 *
 * @OA\Schema(
 *   schema="Book",
 *   type="object",
 *   required={"title","id_author"},
 *   properties={
 *     @OA\Property(property="id_book", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Cien años de soledad"),
 *     @OA\Property(property="description", type="string", example="Novela emblemática del realismo mágico."),
 *     @OA\Property(property="published_at", type="string", format="date", example="2025-11-24"),
 *     @OA\Property(property="available", type="boolean", example=true),
 *     @OA\Property(property="id_author", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 *   }
 * )
 *
 * @OA\Schema(
 *   schema="User",
 *   type="object",
 *   required={"name","email"},
 *   properties={
 *     @OA\Property(property="id_user", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Reviewer"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 *   }
 * )
 *
 * @OA\Tag(name="Auth", description="Autenticación JWT")
 * @OA\Tag(name="Authors", description="Operaciones sobre autores")
 * @OA\Tag(name="Books", description="Operaciones sobre libros")
 * @OA\Tag(name="Users", description="Operaciones sobre usuarios")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Post(
     *   path="/auth/register",
     *   tags={"Auth"},
     *   summary="Registro de usuario y emisión de token",
     *   description="Crea un usuario y devuelve un JWT para autenticación inmediata.",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nickname","email","password"},
     *       @OA\Property(property="nickname", type="string", example="Miguel"),
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", example="secret")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Usuario registrado y token emitido",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="user", ref="#/components/schemas/User"),
     *         @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         @OA\Property(property="token_type", type="string", example="bearer"),
     *         @OA\Property(property="expires_in", type="integer", example=3600)
     *       }
     *     )
     *   ),
     *   @OA\Response(response=422, description="Validación fallida (email duplicado, datos incompletos)")
     * )
     */
    public function docAuthRegister() {}

    /**
     * @OA\Post(
     *   path="/auth/login",
     *   tags={"Auth"},
     *   summary="Login de usuario",
     *   description="Autentica y devuelve un token JWT.",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", example="secret")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Token JWT generado",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         @OA\Property(property="token_type", type="string", example="bearer"),
     *         @OA\Property(property="expires_in", type="integer", example=3600)
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Credenciales inválidas")
     * )
     */
    public function docAuthLogin() {}

    /**
     * @OA\Post(
     *   path="/auth/logout",
     *   tags={"Auth"},
     *   summary="Logout de usuario",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="Token invalidado")
     * )
     */
    public function docAuthLogout() {}

    /**
     * @OA\Get(
     *   path="/auth/me",
     *   tags={"Auth"},
     *   summary="Datos del usuario autenticado",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Información del usuario",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *   )
     * )
     */
    public function docAuthMe() {}

    /**
     * @OA\Get(
     *   path="/authors",
     *   tags={"Authors"},
     *   summary="Listar autores",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Lista de autores",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Author"))
     *   )
     * )
     */
    public function docAuthorsIndex() {}

    /**
     * @OA\Post(
     *   path="/authors",
     *   tags={"Authors"},
     *   summary="Crear autor",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","email"},
     *       @OA\Property(property="name", type="string", example="Gabriel García Márquez"),
     *       @OA\Property(property="email", type="string", format="email", example="gabo@example.com"),
     *       @OA\Property(property="bio", type="string", example="Novelista colombiano del realismo mágico")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Autor creado", @OA\JsonContent(ref="#/components/schemas/Author")),
     *   @OA\Response(response=422, description="Validación fallida")
     * )
     */
    public function docAuthorsStore() {}

    /**
     * @OA\Get(
     *   path="/authors/{id_author}",
     *   tags={"Authors"},
     *   summary="Obtener autor por ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_author", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Autor encontrado", @OA\JsonContent(ref="#/components/schemas/Author")),
     *   @OA\Response(response=404, description="Autor no encontrado")
     * )
     */
    public function docAuthorsShow() {}

    /**
     * @OA\Put(
     *   path="/authors/{id_author}",
     *   tags={"Authors"},
     *   summary="Actualizar autor",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_author", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Gabriel G. Márquez"),
     *       @OA\Property(property="email", type="string", format="email", example="gabo@example.com"),
     *       @OA\Property(property="bio", type="string", example="Autor latinoamericano")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Autor actualizado", @OA\JsonContent(ref="#/components/schemas/Author")),
     *   @OA\Response(response=404, description="Autor no encontrado")
     * )
     */
    public function docAuthorsUpdate() {}

    /**
     * @OA\Delete(
     *   path="/authors/{id_author}",
     *   tags={"Authors"},
     *   summary="Eliminar autor",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_author", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Autor eliminado"),
     *   @OA\Response(response=404, description="Autor no encontrado")
     * )
     */
    public function docAuthorsDelete() {}

    /**
     * @OA\Get(
     *   path="/books",
     *   tags={"Books"},
     *   summary="Listar libros",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Lista de libros",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *   )
     * )
     */
    public function docBooksIndex() {}

    /**
     * @OA\Post(
     *   path="/books",
     *   tags={"Books"},
     *   summary="Crear libro",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"title","id_author"},
     *       @OA\Property(property="title", type="string", example="Cien años de soledad"),
     *       @OA\Property(property="description", type="string", example="Novela emblemática del realismo mágico."),
     *       @OA\Property(property="published_at", type="string", format="date", example="2025-11-24"),
     *       @OA\Property(property="available", type="boolean", example=true),
     *       @OA\Property(property="id_author", type="integer", example=1)
     *     )
     *   ),
     *   @OA\Response(response=201, description="Libro creado", @OA\JsonContent(ref="#/components/schemas/Book")),
     *   @OA\Response(response=422, description="Validación fallida")
     * )
     */
    public function docBooksStore() {}

    /**
     * @OA\Get(
     *   path="/books/{id_book}",
     *   tags={"Books"},
     *   summary="Obtener libro por ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_book", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Libro encontrado", @OA\JsonContent(ref="#/components/schemas/Book")),
     *   @OA\Response(response=404, description="Libro no encontrado")
     * )
     */
    public function docBooksShow() {}

    /**
     * @OA\Put(
     *   path="/books/{id_book}",
     *   tags={"Books"},
     *   summary="Actualizar libro",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_book", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="title", type="string", example="Cien años de soledad (Edición revisada)"),
     *       @OA\Property(property="description", type="string", example="Edición con prólogo"),
     *       @OA\Property(property="published_at", type="string", format="date", example="2025-11-24"),
     *       @OA\Property(property="available", type="boolean", example=false),
     *       @OA\Property(property="id_author", type="integer", example=1)
     *     )
     *   ),
     *   @OA\Response(response=200, description="Libro actualizado", @OA\JsonContent(ref="#/components/schemas/Book")),
     *   @OA\Response(response=404, description="Libro no encontrado")
     * )
     */
    public function docBooksUpdate() {}

    /**
     * @OA\Delete(
     *   path="/books/{id_book}",
     *   tags={"Books"},
     *   summary="Eliminar libro",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_book", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Libro eliminado"),
     *   @OA\Response(response=404, description="Libro no encontrado")
     * )
     */
    public function docBooksDelete() {}

    /**
     * @OA\Get(
     *   path="/users",
     *   tags={"Users"},
     *   summary="Listar usuarios",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Lista de usuarios",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *   )
     * )
     */
    public function docUsersIndex() {}

    /**
     * @OA\Get(
     *   path="/users/{id_user}",
     *   tags={"Users"},
     *   summary="Obtener usuario por ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_user", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Usuario encontrado", @OA\JsonContent(ref="#/components/schemas/User")),
     *   @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function docUsersShow() {}

    /**
     * @OA\Post(
     *   path="/users",
     *   tags={"Users"},
     *   summary="Crear usuario",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","email","password"},
     *       @OA\Property(property="name", type="string", example="Reviewer"),
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", example="secret")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Usuario creado", @OA\JsonContent(ref="#/components/schemas/User")),
     *   @OA\Response(response=422, description="Validación fallida")
     * )
     */
    public function docUsersStore() {}

    /**
     * @OA\Put(
     *   path="/users/{id_user}",
     *   tags={"Users"},
     *   summary="Actualizar usuario",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_user", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Reviewer Updated"),
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", example="new-secret")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Usuario actualizado", @OA\JsonContent(ref="#/components/schemas/User")),
     *   @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function docUsersUpdate() {}

    /**
     * @OA\Delete(
     *   path="/users/{id_user}",
     *   tags={"Users"},
     *   summary="Eliminar usuario",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id_user", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Usuario eliminado"),
     *   @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function docUsersDelete() {}
}

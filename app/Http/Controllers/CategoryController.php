<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Categories List
     * @OA\Get (
     *     path="/api/categories",
     *     tags={"categories"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="category task"
     *                     ),     *           
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $category = Category::all();
            return response()->json([
                'status' => true,
                'categories' => $category,
                'httpCode' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 500
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Crea uan categoria
     * @OA\Post (
     *     path="/api/categories",
     *     tags={"categories"}
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *     ),
     *    @OA\RequestBody(
     *         required=true,
     *         description="Category details",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Category swaggger"),
     *         )
     *     ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     *      @OA\Response(
     *          response=405,
     *          description="Validation error",
     *      )
     *)
     *)
     */ 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'httpCode' => 422
            ]);
        }

        try {
            $category = Category::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Category afegida a la base de dades',
                'httpCode' => 201
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get category by id",
     *     description="Return a category by Id",
     *     operationId="getCategoryById",
     *     tags={"categories"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la categoria a recuperar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Categoria tobada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="category", type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(property="name", type="string", example="Categoria_nom"),
     *             ),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Categoria no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found"),
     *             @OA\Property(property="httpCode", type="integer", example=404)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error inesperado"),
     *             @OA\Property(property="httpCode", type="integer", example=500)
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found',
                'httpCode' => 404
            ]);
        }


        try {
            return response()->json([
                'status' => true,
                'task' => $category,
                'httpCode' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 500
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Udpate category by id",
     *     description="Update a category by Id",
     *     operationId="updateCategory",
     *     tags={"categories"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la categoria a actualizar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Info de la cagegoria a actualizar",
     *         @OA\JsonContent(
     *             required={"name", "description", "user_id"},
     *             @OA\Property(property="name", type="string", example="Categoria23", description="Nom de la categoria")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Categoria actualizada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Category updated"),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Categoria no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No query results for model [Category]"),
     *             @OA\Property(property="httpCode", type="integer", example=404)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="The name field is required.")
     *                 ),
     *             ),
     *             @OA\Property(property="httpCode", type="integer", example=422)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error inesperado"),
     *             @OA\Property(property="httpCode", type="integer", example=500)
     *         )
     *     )
     * )
     */


    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 404
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'httpCode' => 422
            ]);
        }

        try {
            $category->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Category updated',
                'httpCode' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 404
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="delete category by id",
     *     description="Elimina una categoria a través del id que es passa per paràmetre",
     *     operationId="deleteCategory",
     *     tags={"categories"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id de la categoria a eliminar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Categoria eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Task deleted successfully"),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Categoria no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No query results for model [Category]"),
     *             @OA\Property(property="errorCode", type="integer", example=404)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error de servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error inesperado al eliminar la tarea"),
     *             @OA\Property(property="httpCode", type="integer", example=500)
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errorCode' => 404
            ]);
        }

        try {
            Category::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully',
                'httpCode' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 500
            ]);
        }
    }
}

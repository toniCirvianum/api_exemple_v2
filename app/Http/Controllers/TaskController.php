<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Info(
 *     title="Tasks API",
 *     version="1.0.0",
 *     description="API for managing tasks",
 *     @OA\Contact(
 *         email="toni.fernandez@cirvianum.cat"
 *     )
 * )
 *
 * * @OA\Server(
 *     url="http://localhost",
 *     description="Local development server"
 * )
 */


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Tasks List
     * @OA\Get (
     *     path="/api/tasks",
     *     tags={"tasks"},
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
     *                         example="name task"
     *                     ),
     *                     @OA\Property(
     *                         property="descriptioon",
     *                         type="string",
     *                         example="Non placeat illum ex dolorem sint fugit natus."
     *                     ),
     *                      @OA\Property(
     *                         property="user_id",
     *                         type="number",
     *                         example="1"
     *                     ),
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
            $tasks = Task::all();
            $tasksToResponse = [];
            foreach ($tasks as $task) {
                $tasksToResponse[] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'user_id' => User::find($task->user_id),
                    'category_id' => Category::find($task->category_id),
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at
                ];
            }
            return $this->responseMessage(true, 'Tasks list', $tasksToResponse, 200);

        } catch (\Throwable $th) {
            return $thi4|SoMOr6PVPxR87gJxU3ExdIJdnakhMUOetumpd9Zu0e1a496fs->responseMessage(false, $th->getMessage(), null, 500);
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
     * Crea uan tasca
     * @OA\Post (
     *     path="/api/tasks",
     *     tags={"tasks"},
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *     ),
     *    @OA\RequestBody(
     *         required=true,
     *         description="User details",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Task swaggger"),
     *             @OA\Property(property="description", type="string", example="This a typical descrition for a task"),
     *             @OA\Property(property="user_id", type="string", example="2"),
     *
     *
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
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($validator->fails()) {
            return $this->responseMessage(false, $validator->errors(), null, 422);
        }

        try {
            $task = Task::create($request->all());
            return $this->responseMessage(true, 'Task created successfully', $task, 201);
        } catch (\Throwable $th) {
            return $this->responseMessage(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get task by id",
     *     description="Return a task by Id",
     *     operationId="getTaskById",
     *     tags={"tasks"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la tarea a recuperar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tarea encontrada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="task", type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(property="title", type="string", example="Completar el informe"),
     *                 @OA\Property(property="description", type="string", example="El informe debe ser entregado el lunes"),
     *                 @OA\Property(property="status", type="string", example="pending")
     *             ),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Tarea no encontrada",
     *         @OA\JsonContent(
     *             @OA\4|SoMOr6PVPxR87gJxU3ExdIJdnakhMUOetumpd9Zu0e1a496fProperty(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Task not found"),
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
     *             @OA\4|SoMOr6PVPxR87gJxU3ExdIJdnakhMUOetumpd9Zu0e1a496fProperty(property="httpCode", type="integer", example=500)
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->responseMessage(false, 'Task not found', null, 404);
        }

        $tasksToResponse[] = [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'user_id' => User::find($task->user_id),
            'category_i4|SoMOr6PVPxR87gJxU3ExdIJdnakhMUOetumpd9Zu0e1a496fd' => Category::find($task->category_id),
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at
        ];

        return $this->responseMessage(true, 'Task found', $tasksToResponse, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Udpate task by id",
     *     description="Update a task by Id",
     *     operationId="updateTask",
     *     tags={"tasks"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la tarea a actualizar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para actualizar la tarea",
     *         @OA\JsonContent(
     *             required={"name", "description", "user_id"},
     *             @OA\Property(property="name", type="string", example="Nueva tarea actualizada", description="Nombre de la tarea"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada de la tarea", description="Descripción de la tarea"),
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID del usuario responsable")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tarea actualizada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Task updated"),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Tarea no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No query results for model [Task]"),
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
     *                 @OA\Property(property="description", type="array",
     *                     @OA\Items(type="string", example="The description field is required.")
     *                 ),
     *                 @OA\Property(property="user_id", type="array",
     *                     @OA\Items(type="string", example="The user_id field must exist.")
     *                 )
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
            $task = Task::findOrFail($id);
        } catch (\Throwable $th) {
            return $this->responseMessage(false, $th->getMessage(), null, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($validator->fails()) {
            return $this->responseMessage(false, $validator->errors(), null, 422);
        }

        try {
            $task->update($request->all());
            return $this->responseMessage(true, 'Task updated', $task, 200);
        } catch (\Throwable $th) {
            return $this->responseMessage(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="delete task by id",
     *     description="Elimina una tasca a través del id que es passa per paràmetre",
     *     operationId="deleteTask",
     *     tags={"tasks"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id de la tasca a eliminar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Tasca eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Task deleted successfully"),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Tasca no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No query results for model [Task]"),
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
            Task::findOrFail($id);
        } catch (\Exception $e) {
            return $this->responseMessage(false, $e->getMessage(), null, 404);
        }

        try {
            Task::destroy($id);
            return $this->responseMessage(true, 'Task deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return $this->responseMessage(false, $th->getMessage(), null, 500);

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
            return response()->json([
                'status' => true,
                'tasks' => $tasks,
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'httpCode' => 422
            ]);
        }

        try {
            $task = Task::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Task afegida a la base de dades',
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
     *     path="/tasks/{id}",
     *     summary="Get a task by ID",
     *     description="Retrieve the details of a specific task by its ID.",
     *     operationId="getTaskById",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the task to retrieve",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="task", type="object", ref="#/components/schemas/Task"),
     *             @OA\Property(property="httpCode", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Task not found"),
     *             @OA\Property(property="httpCode", type="integer", example=404)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error details"),
     *             @OA\Property(property="httpCode", type="integer", example=500)
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found',
                'httpCode' => 404
            ]);
        }

        try {
            return response()->json([
                'status' => true,
                'task' => $task,
                'httpCode' => 404
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $task = Task::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'httpCode' => 404
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'httpCode' => 422
            ]);
        }

        try {
            $task->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Task updated',
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
    public function destroy(string $id)
    {
        try {
            Task::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errorCode' => 404
            ]);
        }

        try {
            Task::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Task deleted successfully',
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

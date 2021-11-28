<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Capsule;
use App\Services\CapsuleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CapsuleController extends Controller
{
    protected $capsuleService;

    public function __construct(CapsuleService $capsuleService)
    {
        $this->capsuleService = $capsuleService;
    }
    /**
     * @OA\Get(
     *     path="/api/capsules",
     *     tags={"capsule"},
     *     @OA\Parameter(
     *         name="status",
     *         description="Filter",
     *         required=false,
     *         in="query",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Display a listing of capsules.",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *         {
     *              "bearerAuth": {},
     *
     *          }
     *     }
     * )
     */
    public function index()
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->capsuleService->listFilterCapsule();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }


    /**
     * @OA\Get(
     *     path="/api/capsules/{capsule_serial}",
     *     tags={"capsule"},
     *     @OA\Parameter(
     *         name="capsule_serial",
     *         description="Capsule Serial",
     *         required=true,
     *         in="path",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Display a capsule.",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *         {
     *             "bearerAuth": {},
     *
     *         }
     *     }
     * )
     */
    public function show($capsule_serial)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->capsuleService->showCapsule($capsule_serial);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

}

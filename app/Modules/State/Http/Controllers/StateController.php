<?php
declare(strict_types=1);

namespace App\Modules\State\Http\Controllers;

use App\Modules\State\Services\StateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StateController extends Controller
{
    private StateService $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }
    public function getStatesActive(): JsonResponse
    {
        try{
            return response()->json($this->stateService->getStatesActive(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
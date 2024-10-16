<?php
declare(strict_types=1);

namespace App\Modules\City\Http\Controllers;

use App\Modules\City\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    private CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }
    public function getCitiesByState(int $stateId): JsonResponse
    {
        try{
            return response()->json($this->cityService->getCitiesByState($stateId), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
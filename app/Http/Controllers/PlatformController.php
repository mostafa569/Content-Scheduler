<?php

namespace App\Http\Controllers;

use App\Services\PlatformService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    protected $platformService;

    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }

    public function index()
    {
        return $this->platformService->getAllPlatforms();
    }

    public function toggle(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|boolean'
        ]);

        $active = $this->platformService->togglePlatform($id, $request->active);

        return response()->json([
            'message' => 'Platform toggled successfully',
            'active' => $active
        ]);
    }
}

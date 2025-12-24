<?php

namespace App\Services;

use App\Repositories\PlatformRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PlatformService
{
    protected $platformRepository;

    public function __construct(PlatformRepository $platformRepository)
    {
        $this->platformRepository = $platformRepository;
    }

    public function getAllPlatforms()
    {
        return $this->platformRepository->all();
    }

    public function getActivePlatformsForUser()
    {
        return $this->platformRepository->getActiveForUser(Auth::user());
    }

    public function togglePlatform($platformId, $active)
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages([
                'user' => 'Unauthenticated'
            ]);
        }

        return $this->platformRepository->toggleActive($user, $platformId, $active);
    }
}

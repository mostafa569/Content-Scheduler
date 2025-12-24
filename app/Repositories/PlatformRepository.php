<?php

namespace App\Repositories;

use App\Models\Platform;

class PlatformRepository
{
    public function all()
    {
        return Platform::all();
    }

    public function getActiveForUser($user)
    {
        return $user->platforms()->wherePivot('active', true)->get();
    }

    public function toggleActive($user, $platformId, $active = true)
    {
        $platform = $user->platforms()
            ->where('platform_id', $platformId)
            ->first();

        if (!$platform) {
            $user->platforms()->attach($platformId, ['active' => $active]);
        } else {
            $user->platforms()->updateExistingPivot($platformId, [
                'active' => $active
            ]);
        }

        return $active;
    }
}

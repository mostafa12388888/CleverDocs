<?php

namespace App\Enum\Company;

use App\Enum\Enum;

class AvatarEnum extends Enum
{
    const AVATARS = [
        [
            'id' => 1,
            'src' => '/avatar.png',
            'bgColor' => '#FFD964',
        ],
        [
            'id' => 2,
            'src' => '/avatar-2.png',
            'bgColor' => '#6ADB93',
        ],
        [
            'id' => 3,
            'src' => '/avatar-3.png',
            'bgColor' => '#DAA7FF',
        ],
        [
            'id' => 4,
            'src' => '/avatar-4.png',
            'bgColor' => '#92B870',
        ],
        [
            'id' => 5,
            'src' => '/avatar-5.png',
            'bgColor' => '#F24520',
        ],
    ];
    /**
     * ids
     *
     * @return array
     */
    public static function ids(): array
    {
        return collect(self::AVATARS)
            ->pluck('id')
            ->toArray();
    }
    /**
     * findById
     *
     * @param  mixed $id
     * @return array
     */
    public static function findById(?int $id): ?array
    {
        if (!$id) {
            return null;
        }

        return collect(self::AVATARS)
            ->firstWhere('id', $id);
    }
}

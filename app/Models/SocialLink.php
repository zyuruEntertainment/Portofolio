<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['platform', 'url', 'sort_order', 'is_active'])]
class SocialLink extends Model
{
    public static array $platforms = [
        'facebook' => 'https://www.facebook.com/',
        'instagram' => 'https://www.instagram.com/',
        'twitter' => 'https://x.com/',
        'x' => 'https://x.com/',
        'tiktok' => 'https://www.tiktok.com/',
        'youtube' => 'https://www.youtube.com/',
        'linkedin' => 'https://www.linkedin.com/in/',
        'github' => 'https://github.com/',
        'discord' => 'https://discord.com/invite/',
        'telegram' => 'https://t.me/',
        'threads' => 'https://www.threads.net/@',
        'snapchat' => 'https://www.snapchat.com/add/',
    ];

    public function detectedPlatform(): ?string
    {
        $url = parse_url((string) $this->url, PHP_URL_HOST);

        if (! $url) {
            return null;
        }

        $url = strtolower($url);

        foreach (static::$platforms as $platform => $base) {
            $host = parse_url($base, PHP_URL_HOST);
            if ($host && str_starts_with($url, $host)) {
                return $platform;
            }
        }

        return null;
    }

    public function isValid(): bool
    {
        return $this->detectedPlatform() !== null;
    }
}

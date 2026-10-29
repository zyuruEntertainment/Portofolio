<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['platform', 'url', 'sort_order', 'is_active'])]
class SocialLink extends Model
{
    private const PLATFORM_HOSTS = [
        'facebook' => ['facebook.com', 'www.facebook.com', 'm.facebook.com'],
        'instagram' => ['instagram.com', 'www.instagram.com'],
        'twitter' => ['x.com', 'www.x.com', 'twitter.com', 'www.twitter.com'],
        'x' => ['x.com', 'www.x.com', 'twitter.com', 'www.twitter.com'],
        'tiktok' => ['tiktok.com', 'www.tiktok.com'],
        'youtube' => ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be'],
        'linkedin' => ['linkedin.com', 'www.linkedin.com'],
        'github' => ['github.com', 'www.github.com'],
        'discord' => ['discord.com', 'www.discord.com', 'discord.gg'],
        'telegram' => ['t.me', 'telegram.me'],
        'threads' => ['threads.net', 'www.threads.net'],
        'snapchat' => ['snapchat.com', 'www.snapchat.com'],
    ];

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
        if (! is_string($this->url)) {
            return null;
        }

        $url = parse_url($this->url);

        if (! is_array($url) || strtolower($url['scheme'] ?? '') !== 'https') {
            return null;
        }

        $host = strtolower(rtrim($url['host'] ?? '', '.'));

        foreach (self::PLATFORM_HOSTS as $platform => $hosts) {
            if (in_array($host, $hosts, true)) {
                return $platform;
            }
        }

        return null;
    }

    public function isValid(): bool
    {
        if (! is_string($this->platform) || ! is_string($this->url)) {
            return false;
        }

        $url = parse_url($this->url);
        $hosts = self::PLATFORM_HOSTS[$this->platform] ?? [];

        if (! is_array($url) || strtolower($url['scheme'] ?? '') !== 'https') {
            return false;
        }

        $host = strtolower(rtrim($url['host'] ?? '', '.'));

        return in_array($host, $hosts, true);
    }
}

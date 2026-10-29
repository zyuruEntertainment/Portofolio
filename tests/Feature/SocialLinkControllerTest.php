<?php

namespace Tests\Feature;

use App\Models\SocialLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_social_media_page_shows_active_links_only(): void
    {
        SocialLink::create([
            'platform' => 'github',
            'url' => 'https://github.com/zyuru',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        SocialLink::create([
            'platform' => 'twitter',
            'url' => 'https://x.com/zyuru',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $this->get(route('social-media'))
            ->assertOk()
            ->assertSee('Github')
            ->assertDontSee('TWITTER');
    }

    public function test_public_social_media_page_shows_links_in_sort_order(): void
    {
        SocialLink::create([
            'platform' => 'github',
            'url' => 'https://github.com/zyuru',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SocialLink::create([
            'platform' => 'instagram',
            'url' => 'https://www.instagram.com/zyuru',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $response = $this->get(route('social-media'));
        $response->assertOk();
        $response->assertSeeInOrder(['Instagram', 'Github']);
    }

    public function test_public_social_media_page_shows_empty_message_when_no_links(): void
    {
        $this->get(route('social-media'))
            ->assertOk()
            ->assertSee('No social links available yet.');
    }

    public function test_public_social_media_page_does_not_link_to_invalid_legacy_urls(): void
    {
        SocialLink::create([
            'platform' => 'facebook',
            'url' => 'https://www.facebook.com.attacker.example/zyuru',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $this->get(route('social-media'))
            ->assertOk()
            ->assertSee('No social links available yet.')
            ->assertDontSee('facebook.com.attacker.example');
    }
}

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
            ->assertSee('GITHUB')
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
        $response->assertSeeInOrder(['INSTAGRAM', 'GITHUB']);
    }

    public function test_public_social_media_page_shows_empty_message_when_no_links(): void
    {
        $this->get(route('social-media'))
            ->assertOk()
            ->assertSee('No social links available yet.');
    }
}

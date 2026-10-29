<?php

namespace Tests\Feature;

use App\Models\SocialLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_html_response_includes_browser_security_headers(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        $policy = $response->headers->get('Content-Security-Policy');

        $this->assertIsString($policy);
        $this->assertStringContainsString("frame-ancestors 'none'", $policy);
        $this->assertStringNotContainsString("'unsafe-inline'", $policy);
        $this->assertSame(1, preg_match("/script-src 'self' 'nonce-([^']+)'/", $policy, $matches));
        $this->assertStringContainsString('<script nonce="'.$matches[1].'">', $response->getContent());
    }

    public function test_inline_social_logo_style_uses_the_policy_nonce(): void
    {
        SocialLink::create([
            'platform' => 'github',
            'url' => 'https://github.com/zyuru',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $response = $this->get('/social-media')->assertOk();
        $policy = $response->headers->get('Content-Security-Policy');

        $this->assertIsString($policy);
        $this->assertSame(1, preg_match("/style-src 'self' 'nonce-([^']+)'/", $policy, $matches));
        $this->assertStringContainsString('<style nonce="'.$matches[1].'">', $response->getContent());
    }
}

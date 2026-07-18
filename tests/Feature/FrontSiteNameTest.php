<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontSiteNameTest extends TestCase
{
    public function test_header_shows_site_name_from_setting(): void
    {
        $html = view('layouts.header', [
            'menus' => collect(),
            'setting' => (object) ['site_name' => 'テスト株式会社'],
        ])->render();

        $this->assertStringContainsString('テスト株式会社', $html);
        $this->assertStringNotContainsString('株式会社サンプル', $html);
    }
}

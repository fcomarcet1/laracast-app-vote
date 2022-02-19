<?php

namespace Tests\Feature\Gravatar;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

// TODO: Add tests for Gravatar
class GravatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_a_test(): void
    {
        // create user
        $user = User::factory()->create([
            'name' => 'Andre',
            'email' => 'afakeemail@fakeemail.com',
        ]);

        // get gravatar image
        $gravatarUrl = $user->getAvatar();

        // create response for gravatar
        $response = Http::get($user->getAvatar());

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-1.png',
            $gravatarUrl
        );
        $this->assertTrue($response->successful());
    }

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_z_test(): void
    {
        $user = User::factory()->create([
            'name' => 'Andre',
            'email' => 'zfakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-26.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_0_test(): void
    {
        $user = User::factory()->create([
            'name' => 'Andre',
            'email' => '0fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-27.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_9_test(): void
    {
        $user = User::factory()->create([
            'name' => 'Andre',
            'email' => '9fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-36.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }

}

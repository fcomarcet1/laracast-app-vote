<?php

namespace Tests\Feature\Gravatar;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GravatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_generate_gravatar_defualt_image_when_no_email_found_first_character_a()
    {}

    /** @test */
    public function user_can_generate_gravatar_defualt_image_when_no_email_found_first_character_z()
    {}

    /** @test */
    public function user_can_generate_gravatar_defualt_image_when_no_email_found_first_character_0()
    {}

    /** @test */
    public function user_can_generate_gravatar_defualt_image_when_no_email_found_first_character_9()
    {}

}

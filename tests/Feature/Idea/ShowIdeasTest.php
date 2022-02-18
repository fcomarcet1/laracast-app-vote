<?php
declare(strict_types=1);

namespace Idea;

use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function listOfIdeasShowsOnMainPageTest(): void
    {
        //create ideas
        $firstIdea = Idea::factory()->create([
            'title' => 'First idea',
            'description' => 'First idea description',
        ]);

        $secondIdea = Idea::factory()->create([
            'title' => 'Second idea',
            'description' => 'Second idea description',
        ]);

        // create response
        $response = $this->get(route('idea.index'));

        // check response
        $response->assertSuccessful();
        $response->assertSee($firstIdea->title);
        $response->assertSee($firstIdea->description);
        $response->assertSee($secondIdea->title);
        $response->assertSee($secondIdea->description);
        $response->assertStatus(200);


    }

}

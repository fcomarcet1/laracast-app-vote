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

    // test for single idea shows in detail idea page
    /** @test */
    public function singleIdeaShowsInDetailIdeaPageTest(): void
    {
        //create idea
        $idea = Idea::factory()->create([
            'title' => 'First idea',
            'description' => 'First idea description',
        ]);

        // create response
        $response = $this->get(route('idea.show', $idea));

        // check response
        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertStatus(200);
    }

    //test for ideas pagination
    /** @test */
    public function ideasPaginationWorksTest(): void
    {
        // create paginate ideas(11)
        $ideas = Idea::factory(Idea::PAGINATION_COUNT + 1)->create();

        $firstIdea = Idea::find(1);
        $firstIdea->title = 'First idea';
        $firstIdea->description = 'First idea description';
        $firstIdea->save();

        $elevenIdea = Idea::find(11);
        $elevenIdea->title = 'Eleven idea';
        $elevenIdea->description = 'Eleven idea description';
        $elevenIdea->save();

        // create response for check I can see first 10 ideas and don't see 11 in page 1
        $response = $this->get('/');
        $response->assertSee($firstIdea->title);
        $response->assertDontSee($firstIdea->title);

        // create response for check I can see 11 in page 2 and don't see firstideas.
        $response = $this->get('/?page=2');
        $response->assertSee($elevenIdea->title);
        $response->assertDontSee($firstIdea->title);

    }

    /** @test */
    public function sameIdeaTitleAndDifferentSlugs(): void
    {
        // create ideas
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Another Description for my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));
        $response->assertSuccessful();
        $response->assertStatus(200);
        $this->assertSame(request()->path(), 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));
        $response->assertSuccessful();
        $response->assertStatus(200);
        $this->assertSame(request()->path(), 'ideas/my-first-idea-1');
    }



}

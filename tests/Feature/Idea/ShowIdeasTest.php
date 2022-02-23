<?php
declare(strict_types=1);

namespace Idea;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// TODO: test for show ideas with category
class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function listOfIdeasShowsOnMainPageTest(): void
    {
        // Create user
        $user = User::factory()->create();

        // Create categories
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        // Create 2 different status
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);

        //create ideas
        $firstIdea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'First idea',
            'description' => 'First idea description',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id
        ]);

        $secondIdea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'Second idea',
            'description' => 'Second idea description',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id
        ]);

        // create response
        $response = $this->get(route('idea.index'));

        // check response
        $response->assertSuccessful();
        $response->assertSee($firstIdea->title);
        $response->assertSee($firstIdea->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Open</div>', false);

        $response->assertSee($secondIdea->title);
        $response->assertSee($secondIdea->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee('<div class="bg-purple text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Considering</div>', false);

        $response->assertStatus(200);

    }

    // test for single idea shows in detail idea page
    /** @test */
    public function singleIdeaShowsInDetailIdeaPageTest(): void
    {
        // Create user
        $user = User::factory()->create();

        // Create category
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        // create status
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);


        //create idea
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'First idea',
            'description' => 'First idea description',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id
        ]);

        // create response
        $response = $this->get(route('idea.show', $idea));

        // check response
        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Open</div>', false);
        $response->assertStatus(200);
    }

    //test for ideas pagination
    /** @test */
    public function ideasPaginationWorksTest(): void
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        // create paginate ideas(11)
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

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
        $response->assertSee($elevenIdea->title);
        $response->assertDontSee($firstIdea->title);

        // create response for check I can see 11 in page 2 and don't see firstideas.
        $response = $this->get('/?page=2');
        $response->assertSee($elevenIdea->title);
        $response->assertDontSee($firstIdea->title);

    }

    /** @test */
    public function sameIdeaTitleAndDifferentSlugs(): void
    {
        $user = User::factory()->create();

        // create category
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        // create status
        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        // create ideas
        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'description' => 'Another Description for my first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
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

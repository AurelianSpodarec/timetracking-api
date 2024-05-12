<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Timer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TimerController
 */
final class TimerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $timers = Timer::factory()->count(3)->create();

        $response = $this->get(route('timers.index'));

        $response->assertOk();
        $response->assertViewIs('timer.index');
        $response->assertViewHas('timers');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('timers.create'));

        $response->assertOk();
        $response->assertViewIs('timer.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimerController::class,
            'store',
            \App\Http\Requests\TimerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $startTime = Carbon::parse($this->faker->dateTime());
        $endTime = $this->faker->word();
        $manualEntry = $this->faker->boolean();
        $updatedManually = $this->faker->boolean();
        $user_id = $this->faker->word();
        $project_id = $this->faker->word();

        $response = $this->post(route('timers.store'), [
            'startTime' => $startTime->toDateTimeString(),
            'endTime' => $endTime,
            'manualEntry' => $manualEntry,
            'updatedManually' => $updatedManually,
            'user_id' => $user_id,
            'project_id' => $project_id,
        ]);

        $timers = Timer::query()
            ->where('startTime', $startTime)
            ->where('endTime', $endTime)
            ->where('manualEntry', $manualEntry)
            ->where('updatedManually', $updatedManually)
            ->where('user_id', $user_id)
            ->where('project_id', $project_id)
            ->get();
        $this->assertCount(1, $timers);
        $timer = $timers->first();

        $response->assertRedirect(route('timers.index'));
        $response->assertSessionHas('timer.id', $timer->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $timer = Timer::factory()->create();

        $response = $this->get(route('timers.show', $timer));

        $response->assertOk();
        $response->assertViewIs('timer.show');
        $response->assertViewHas('timer');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $timer = Timer::factory()->create();

        $response = $this->get(route('timers.edit', $timer));

        $response->assertOk();
        $response->assertViewIs('timer.edit');
        $response->assertViewHas('timer');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimerController::class,
            'update',
            \App\Http\Requests\TimerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $timer = Timer::factory()->create();
        $startTime = Carbon::parse($this->faker->dateTime());
        $endTime = $this->faker->word();
        $manualEntry = $this->faker->boolean();
        $updatedManually = $this->faker->boolean();
        $user_id = $this->faker->word();
        $project_id = $this->faker->word();

        $response = $this->put(route('timers.update', $timer), [
            'startTime' => $startTime->toDateTimeString(),
            'endTime' => $endTime,
            'manualEntry' => $manualEntry,
            'updatedManually' => $updatedManually,
            'user_id' => $user_id,
            'project_id' => $project_id,
        ]);

        $timer->refresh();

        $response->assertRedirect(route('timers.index'));
        $response->assertSessionHas('timer.id', $timer->id);

        $this->assertEquals($startTime, $timer->startTime);
        $this->assertEquals($endTime, $timer->endTime);
        $this->assertEquals($manualEntry, $timer->manualEntry);
        $this->assertEquals($updatedManually, $timer->updatedManually);
        $this->assertEquals($user_id, $timer->user_id);
        $this->assertEquals($project_id, $timer->project_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $timer = Timer::factory()->create();

        $response = $this->delete(route('timers.destroy', $timer));

        $response->assertRedirect(route('timers.index'));

        $this->assertModelMissing($timer);
    }
}

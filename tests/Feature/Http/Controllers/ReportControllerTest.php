<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReportController
 */
final class ReportControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $reports = Report::factory()->count(3)->create();

        $response = $this->get(route('reports.index'));

        $response->assertOk();
        $response->assertViewIs('report.index');
        $response->assertViewHas('reports');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('reports.create'));

        $response->assertOk();
        $response->assertViewIs('report.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReportController::class,
            'store',
            \App\Http\Requests\ReportStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $filePath = $this->faker->word();
        $user_id = $this->faker->word();

        $response = $this->post(route('reports.store'), [
            'name' => $name,
            'filePath' => $filePath,
            'user_id' => $user_id,
        ]);

        $reports = Report::query()
            ->where('name', $name)
            ->where('filePath', $filePath)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $reports);
        $report = $reports->first();

        $response->assertRedirect(route('reports.index'));
        $response->assertSessionHas('report.id', $report->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $report = Report::factory()->create();

        $response = $this->get(route('reports.show', $report));

        $response->assertOk();
        $response->assertViewIs('report.show');
        $response->assertViewHas('report');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $report = Report::factory()->create();

        $response = $this->get(route('reports.edit', $report));

        $response->assertOk();
        $response->assertViewIs('report.edit');
        $response->assertViewHas('report');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReportController::class,
            'update',
            \App\Http\Requests\ReportUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $report = Report::factory()->create();
        $name = $this->faker->name();
        $filePath = $this->faker->word();
        $user_id = $this->faker->word();

        $response = $this->put(route('reports.update', $report), [
            'name' => $name,
            'filePath' => $filePath,
            'user_id' => $user_id,
        ]);

        $report->refresh();

        $response->assertRedirect(route('reports.index'));
        $response->assertSessionHas('report.id', $report->id);

        $this->assertEquals($name, $report->name);
        $this->assertEquals($filePath, $report->filePath);
        $this->assertEquals($user_id, $report->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $report = Report::factory()->create();

        $response = $this->delete(route('reports.destroy', $report));

        $response->assertRedirect(route('reports.index'));

        $this->assertModelMissing($report);
    }
}

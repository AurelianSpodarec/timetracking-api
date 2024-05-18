<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportStoreRequest;
use App\Http\Requests\ReportUpdateRequest;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(Request $request): \Inertia\Response|\Inertia\ResponseFactory
    {
        $reports = Report::all();

        return inertia('report/edit', [
            'reports' =>  $reports,
        ]);
    }

    public function create(Request $request): Response
    {
        return inertia('report/create');
    }

    public function store(ReportStoreRequest $request): RedirectResponse
    {
        $report = Report::create($request->validated());

        $request->session()->flash('report.id', $report->id);

        return redirect()->route('reports.index');
    }

    public function show(Request $request, Report $report): Response
    {
        return inertia('report/show', [
            'report' =>  $report,
        ]);
    }

    public function edit(Request $request, Report $report): Response
    {
        return inertia('report/edit', [
            'report' =>  $report,
        ]);
    }

    public function update(ReportUpdateRequest $request, Report $report): RedirectResponse
    {
        $report->update($request->validated());

        $request->session()->flash('report.id', $report->id);

        return redirect()->route('reports.index');
    }

    public function destroy(Request $request, Report $report): RedirectResponse
    {
        $report->delete();

        return redirect()->route('reports.index');
    }
}

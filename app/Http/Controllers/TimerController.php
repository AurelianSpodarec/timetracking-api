<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimerStoreRequest;
use App\Http\Requests\TimerUpdateRequest;
use App\Models\Timer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Response;

class TimerController extends Controller
{
    public function index(Request $request): Response
    {
        $timers = Timer::all();

        return inertia('timer/index', [
            'timers' =>  $timers,
        ]);
    }

    public function create(Request $request): Response
    {
        return inertia('timer.create');
    }

    public function store(TimerStoreRequest $request): RedirectResponse
    {
        $timer = Timer::create($request->validated());

        $request->session()->flash('timer.id', $timer->id);

        return redirect()->route('timers.index');
    }

    public function show(Request $request, Timer $timer): Response
    {
        return inertia('timer/show', [
            'timer' =>  $timer,
        ]);
    }

    public function edit(Request $request, Timer $timer): Response
    {
        return inertia('timer/edit', [
            'timer' =>  $timer,
        ]);
    }

    public function update(TimerUpdateRequest $request, Timer $timer): RedirectResponse
    {
        $timer->update($request->validated());

        $request->session()->flash('timer.id', $timer->id);

        return redirect()->route('timers.index');
    }

    public function destroy(Request $request, Timer $timer): RedirectResponse
    {
        $timer->delete();

        return redirect()->route('timers.index');
    }
}

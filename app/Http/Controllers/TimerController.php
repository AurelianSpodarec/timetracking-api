<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimerStoreRequest;
use App\Http\Requests\TimerUpdateRequest;
use App\Models\Timer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimerController extends Controller
{
    public function index(Request $request): View
    {
        $timers = Timer::all();

        return view('timer.index', compact('timers'));
    }

    public function create(Request $request): View
    {
        return view('timer.create');
    }

    public function store(TimerStoreRequest $request): RedirectResponse
    {
        $timer = Timer::create($request->validated());

        $request->session()->flash('timer.id', $timer->id);

        return redirect()->route('timers.index');
    }

    public function show(Request $request, Timer $timer): View
    {
        return view('timer.show', compact('timer'));
    }

    public function edit(Request $request, Timer $timer): View
    {
        return view('timer.edit', compact('timer'));
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

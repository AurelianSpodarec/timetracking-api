<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $clients = Client::where('user_id', $user->id)->get();

        // Return JSON response with clients data
        return response()->json([
            'success' => true,
            'data' => [
                'clients' => $clients,
            ],
        ]);
    }

    public function create(Request $request): View
    {
        return view('client.create');
    }

    public function store(ClientStoreRequest $request): RedirectResponse
    {
        $client = Client::create($request->validated());

        $request->session()->flash('client.id', $client->id);

        return redirect()->route('clients.index');
    }

    public function show(Request $request, Client $client)
    {
        //return view('client.show', compact('client'));
        return $this->success([
            'clients' => $client,
        ]);
    }

    public function edit(Request $request, Client $client): View
    {
        return view('client.edit', compact('client'));
    }

    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        $request->session()->flash('client.id', $client->id);

        return redirect()->route('clients.index');
    }

    public function destroy(Request $request, Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index');
    }
}

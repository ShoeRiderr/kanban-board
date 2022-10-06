<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        return view('modules.clients.index');
    }

    public function create(): View
    {
        return view('modules.clients.create');
    }

    public function edit(Client $client): View
    {
        return view('modules.clients.edit', [
            'client' => $client,
        ]);
    }
}

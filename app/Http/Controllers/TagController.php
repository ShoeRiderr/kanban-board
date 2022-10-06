<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('modules.tags.index');
    }

    public function create(): View
    {
        return view('modules.tags.create');
    }

    public function edit(Tag $tag): View
    {
        return view('modules.tags.edit', [
            'tag' => $tag,
        ]);
    }
}

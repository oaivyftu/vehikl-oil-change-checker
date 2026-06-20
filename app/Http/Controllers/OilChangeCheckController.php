<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOilChangeCheckRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OilChangeCheckController extends Controller
{
    public function create(): View
    {
        return view('oil-change-checks.create');
    }

    public function store(StoreOilChangeCheckRequest $request): RedirectResponse
    {
        $request->validated();

        return redirect()
            ->route('oil-change-checks.create')
            ->with('status', 'Your information is valid.');
    }
}

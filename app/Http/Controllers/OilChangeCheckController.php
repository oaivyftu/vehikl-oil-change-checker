<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOilChangeCheckRequest;
use App\Models\OilChangeCheck;
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
        $oilChangeCheck = OilChangeCheck::create($request->validated());

        return redirect()->route('oil-change-checks.show', $oilChangeCheck);
    }

    public function show(int $id): View
    {
        return view('oil-change-checks.show', [
            'oilChangeCheck' => OilChangeCheck::findOrFail($id),
        ]);
    }
}

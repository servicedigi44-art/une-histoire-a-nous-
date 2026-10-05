<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TimeCapsuleRequest;
use App\Models\Friend;
use App\Models\TimeCapsule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TimeCapsuleController extends Controller
{
    public function index(): View
    {
        $capsules = TimeCapsule::with('friend')->orderBy('unlock_at')->get();
        $friends = Friend::ordered()->get();

        return view('admin.capsules.index', compact('capsules', 'friends'));
    }

    public function store(TimeCapsuleRequest $request): RedirectResponse
    {
        TimeCapsule::create($request->validated());

        return back()->with('status', 'Capsule créée.');
    }

    public function update(TimeCapsuleRequest $request, TimeCapsule $capsule): RedirectResponse
    {
        $capsule->update($request->validated());

        return back()->with('status', 'Capsule mise à jour.');
    }

    public function destroy(TimeCapsule $capsule): RedirectResponse
    {
        $capsule->delete();

        return back()->with('status', 'Capsule supprimée.');
    }
}

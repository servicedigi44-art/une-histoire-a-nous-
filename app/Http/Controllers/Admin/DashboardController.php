<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Friend;
use App\Models\Media;
use App\Models\Memory;
use App\Models\PersonalMessage;
use App\Models\TimeCapsule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'chapters' => Chapter::count(),
            'chapters_active' => Chapter::where('is_active', true)->count(),
            'memories' => Memory::count(),
            'media' => Media::count(),
            'friends' => Friend::count(),
            'messages' => PersonalMessage::count(),
            'capsules' => TimeCapsule::count(),
            'capsules_locked' => TimeCapsule::where('unlock_at', '>', now())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

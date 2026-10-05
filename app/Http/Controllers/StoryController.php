<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\PersonalMessage;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\View\View;

class StoryController extends Controller
{
    public function opening(): View
    {
        return view('story.opening', [
            'siteTitle' => Setting::get('site_title', 'Une histoire a nous'),
        ]);
    }

    public function play(): View
    {
        $slides = Slide::active()->ordered()->get()->map(function ($slide) {
            return [
                'kind' => 'slide',
                'type' => $slide->type,
                'url' => media_url_for_slide($slide),
                'caption' => $slide->caption,
                'date' => $slide->slide_date,
            ];
        });

        $friends = Friend::active()->ordered()->get()->map(function ($friend) {
            return [
                'kind' => 'friend',
                'name' => $friend->name,
                'nickname' => $friend->nickname,
                'bio' => $friend->bio,
                'photo' => friend_photo_url($friend, 'now'),
            ];
        });

        $messages = PersonalMessage::visible()->with(['author', 'recipient'])->get()->map(function ($message) {
            return [
                'kind' => 'message',
                'author' => $message->author->name,
                'recipient' => $message->recipient->name,
                'content' => $message->content,
            ];
        });

        $items = collect()
            ->concat($slides)
            ->concat($friends)
            ->concat($messages)
            ->values();

        return view('story.play', [
            'items' => $items,
            'siteTitle' => Setting::get('site_title', 'Une histoire a nous'),
        ]);
    }
}
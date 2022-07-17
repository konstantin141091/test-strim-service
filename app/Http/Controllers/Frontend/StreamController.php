<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StreamRequest;
use App\Models\Stream;
use App\Models\StreamPassword;
use App\Services\AntMediaService;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function create() {
        return view('stream.create');
    }

    public function store(StreamRequest $request) {
        $ant_media_service = new AntMediaService();
        $create = $ant_media_service->create($request);
        if($create) {
            return back()->with('success', 'Stream create');
        }else {
            return back()->with('error', 'Can not create stream');
        }
    }

    public function show(Stream $stream) {
        $ant_media_service = new AntMediaService();
        $broadcast_obj = $ant_media_service->getBroadcast($stream->stream_id);
        return view('stream.show', [
            'stream' => $stream,
            'broadcast_obj' => $broadcast_obj
        ]);
    }

    public function passwordForm($stream_id) {
        return view('stream.password_form', [
            'stream_id' => $stream_id,
        ]);
    }

    public function checkPasswordForm(Request $request, $stream_id) {
        $request->validate([
            'password' => ['required', 'string'],
        ]);
        $stream_password = StreamPassword::query()
            ->where('stream_id', $stream_id)
            ->where('user_id', $request->user()->id)
            ->first();
        if (is_null($stream_password)) {
            return redirect()->route('message')->with('site_message', 'You can not see this stream.');
        }

        if ($stream_password->checkPassword($request->input('password'))) {
            return redirect()->route('stream.show', $stream_id);
        }else {
            return back()->with('error', 'False password');
        }
    }
}

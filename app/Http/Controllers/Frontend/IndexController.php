<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use App\Services\AntMediaService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $streams = Stream::query()->paginate('9');
        return view('index', [
            'streams' => $streams
        ]);
    }

    public function message() {
        return view('message');
    }
}

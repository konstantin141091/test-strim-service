<?php

namespace App\Http\Middleware;

use App\Models\StreamPassword;
use Closure;
use Illuminate\Http\Request;

class CheckUserStream
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $parse_url = explode('/', $request->getRequestUri());
        $stream_id = (int) end($parse_url);
        $stream_password = StreamPassword::query()
            ->where('stream_id', $stream_id)
            ->where('user_id', $request->user()->id)
            ->first();
        if (is_null($stream_password)) {
            return redirect()->route('message')->with('site_message', 'You can not see this stream.');
        }

        if (!$stream_password->status) {
            return redirect()->route('stream-password', $stream_id);
        }
        return $next($request);
    }
}

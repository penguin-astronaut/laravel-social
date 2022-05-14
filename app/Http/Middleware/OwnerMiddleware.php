<?php

namespace App\Http\Middleware;

use App\Models\Books;
use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    /**
     * Check if user book and add book to request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->id()) {
            return redirect()->route('login');
        }

        $book = Books::where('id', $request->route('book'))
            ->where('user_id', auth()->id())
            ->firstOrFail();


        $request->merge(['book' => $book]);

        return $next($request);
    }
}

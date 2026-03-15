<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SyncPassportTokenStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user) {
            $token = $user->token();
            if ($token) {
                if ($token->revoked || ($token->expires_at && $token->expires_at->lt(now()))) {
                    LoginHistory::where('token_id', $token->id)
                        ->where('status', 'active')
                        ->update([
                            'status' => 'expired',
                            'logged_out_at' => now(),
                        ]);
                }
            }
        }
        return $next($request);
    }
}

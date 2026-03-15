<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;

class CheckUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->is_active) {

            if ($user->token()) {
                $tokenId = $user->token()->id;
                app(TokenRepository::class)->revokeAccessToken($tokenId);
            }

            return response()->json([
                'message' => __('validation.messages.inactive_account')
            ], 401);
        }

        return $next($request);
    }
}

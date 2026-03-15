<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $lang = $this->_handleRequestLang();
        App::setLocale($lang);
        $response = $next($request);
        $response->headers->set('Content-Language', $lang);
        return $response;
    }

    /**
     * @param $lang
     *
     * @return string|Exception
     */
    private function _handleRequestLang(): Exception|string
    {
        $lang = request()->header('Content-Language') ? : config('app.locale');
        $supportedLanguages = config('locale.system_languages');
        if (!array_key_exists($lang, $supportedLanguages)) {
            $lang = config('app.locale');
        }
        return $lang;
    }



}

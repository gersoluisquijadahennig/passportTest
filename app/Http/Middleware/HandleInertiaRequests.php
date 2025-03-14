<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'admin.dashboard-vue';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return env('APP_VERSION', '1.0.0');
    }

    public function versionPhp(Request $request): ?string
    {
        return phpversion();
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            //add data user Auth in all page
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'rut' => $request->user()->rut,
                        'email' => $request->user()->email,
                        'alias' => $request->user()->alias,
                        'establecimiento_id' => $request->user()->establecimiento_id,
                        'current_realm' => $request->current_realm,
                    ] : null,
                ];
            }
        ]);
    }
}

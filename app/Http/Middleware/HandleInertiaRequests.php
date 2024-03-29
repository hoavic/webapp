<?php

namespace App\Http\Middleware;

use Hoadev\CoreBlog\Models\Post;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'message' => session('message')
            ],
            'admin' => $this->shareInAdmin($request),

        ];
    }

    public function rootView(Request $request): string
    {
        if ($request->routeIs('permalink.*')) {
            return 'layouts.guest';
        }

        if ($request->routeIs('*.popup')) {
            return 'layouts.popup';
        }

        return $this->rootView;
    }

    public function shareInAdmin(Request $request) {
        if($request->routeIs('admin.*') || $request->routeIs('profile.*') || $request->routeIs('teams.*') || $request->routeIs('dashboard') ) {
            /* dd(config('coreblog.admin_bar')); */
            return [
                    'admin_bar' => config('coreblog.admin_bar'),
                    'menu' => config('coreblog.menu'),
                    'post_types' => config('coreblog.post_types'),
                    'taxonomies' => config('coreblog.taxonomies'),
                    'pending_contact' => Post::where('status', 'pending')->count()
                ];
        }
    }
}

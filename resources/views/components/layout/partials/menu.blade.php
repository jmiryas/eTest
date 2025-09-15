{{-- <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <li class="menu-item active">
                <a href="javascript:void(0)" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-smart-home"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ti tabler-smart-home"></i>
                    <div data-i18n="Users">Users</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item active">
                        <a href="dashboards-analytics.html" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-chart-pie-2"></i>
                            <div data-i18n="Analytics">Roles</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside> --}}

@php
    $nav = config('navigation', []);
    $user = auth()->user();

    $canSee = function ($perms) use ($user) {
        if (is_null($perms)) {
            return true;
        }
        if (!$user) {
            return false;
        }

        if (is_array($perms)) {
            if (method_exists($user, 'hasAnyPermission')) {
                return $user->hasAnyPermission($perms);
            }
            foreach ($perms as $p) {
                if ($user->can($p) || (method_exists($user, 'hasPermissionTo') && $user->hasPermissionTo($p))) {
                    return true;
                }
            }
            return false;
        }

        if (method_exists($user, 'hasPermissionTo') && $user->hasPermissionTo($perms)) {
            return true;
        }
        return $user->can($perms);
    };

    $isActive = function ($route) {
        if (!$route) {
            return false;
        }
        if (is_array($route)) {
            foreach ($route as $r) {
                if (request()->routeIs($r)) {
                    return true;
                }
            }
            return false;
        }
        return request()->routeIs($route);
    };

    $buildUrl = function ($route) {
        if (!$route) {
            return 'javascript:void(0)';
        }
        if (is_string($route) && str_contains($route, '*')) {
            return '#';
        }
        if (is_string($route) && Route::has($route)) {
            try {
                return route($route);
            } catch (\Throwable $e) {
                return '#';
            }
        }
        return '#';
    };
@endphp

<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            {{-- Render items sequentially (no extra group headers to preserve Vuexy horizontal style) --}}
            @foreach ($nav as $group => $items)
                @foreach ($items as $item)
                    @php
                        $title = $item['title'] ?? '';
                        $icon = $item['icon'] ?? '';
                        $sub = $item['submenus'] ?? null;

                        // Decide visibility:
                        $visible = false;
                        if (!empty($sub) && is_array($sub)) {
                            foreach ($sub as $sm) {
                                if (!empty($sm['route']) && $canSee($sm['permissions'] ?? null)) {
                                    $visible = true;
                                    break;
                                }
                            }
                        } else {
                            if (!empty($item['route']) && $canSee($item['permissions'] ?? null)) {
                                $visible = true;
                            }
                        }
                        if (!$visible) {
                            continue;
                        }

                        $hasSub = !empty($sub) && is_array($sub);

                        // For items WITHOUT submenu: mark parent active when route matches
                        $parentActive = !$hasSub && $isActive($item['route'] ?? null);

                        $url = $buildUrl($item['route'] ?? null);
                    @endphp

                    <li class="menu-item {{ $parentActive ? 'active' : '' }}">
                        @if ($hasSub)
                            {{-- Parent with submenu: do NOT mark active here; children will be marked --}}
                            <a href="javascript:void(0)" class="menu-link menu-toggle">
                                {!! $icon !!}
                                <div data-i18n="{{ $title }}">{{ $title }}</div>
                            </a>

                            <ul class="menu-sub">
                                @foreach ($sub as $submenu)
                                    @php
                                        $sTitle = $submenu['title'] ?? '';
                                        $sRoute = $submenu['route'] ?? null;
                                        $sIcon = $submenu['icon'] ?? '';

                                        if (empty($sRoute)) {
                                            continue;
                                        } // skip submenu without route
                                        if (!$canSee($submenu['permissions'] ?? null)) {
                                            continue;
                                        }
                                        $sUrl = $buildUrl($sRoute);
                                        $sActive = $isActive($sRoute) ? 'active' : '';
                                    @endphp

                                    <li class="menu-item {{ $sActive }}">
                                        <a href="{{ $sUrl }}" class="menu-link">
                                            {{-- submenu usually text-only per your example --}}
                                            {!! $sIcon !!}
                                            <div data-i18n="{{ $sTitle }}">{{ $sTitle }}</div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{-- Simple top-level link --}}
                            <a href="{{ $url }}" class="menu-link">
                                {!! $icon !!}
                                <div data-i18n="{{ $title }}">{{ $title }}</div>
                            </a>
                        @endif
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</aside>

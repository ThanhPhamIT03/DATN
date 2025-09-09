<section id="admin-slidebar" class="p-2 m-0">
    {{-- Logo --}}
    <div class="admin-logo pb-2">
        <h6 class="m-0">Sơn Thảo Mobile</h6>
        <p class="mb-0">Trang quản trị</p>
    </div>

    {{-- Menu --}}
    <div class="admin-menu list-group pt-4">
        @foreach (config('menu') as $index => $menu)
            @php
                $hasChildren = !empty($menu['children']);
                $isActiveParent = false;

                if ($hasChildren) {
                    // Menu cha có con: active nếu route con đang active
                    $isActiveParent = collect($menu['children'])
                        ->pluck('route')
                        ->contains(function ($route) {
                            return $route && request()->routeIs($route);
                        });
                } else {
                    // Menu cha không có con: active nếu route hiện tại trùng route menu
                    $isActiveParent = !empty($menu['route']) && request()->routeIs($menu['route']);
                }
            @endphp

            @if ($hasChildren)
                <!-- Menu cha có con -->
                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $isActiveParent ? 'active-parent' : '' }}"
                    data-bs-toggle="collapse" href="#menu-{{ $index }}" role="button"
                    aria-expanded="{{ $isActiveParent ? 'true' : 'false' }}" aria-controls="menu-{{ $index }}">
                    <span><i class="{{ $menu['icon'] }} me-2"></i>{{ $menu['title'] }}</span>
                    <i class="bi bi-chevron-down"></i>
                </a>

                <div class="collapse {{ $isActiveParent ? 'show' : '' }}" id="menu-{{ $index }}">
                    @foreach ($menu['children'] as $child)
                        <a href="{{ $child['route'] ? route($child['route']) : '#' }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs($child['route']) ? 'active-item' : '' }}">
                            @if ($child['icon'])
                                <i class="{{ $child['icon'] }} me-2"></i>
                            @endif
                            {{ $child['title'] }}
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Menu cha không có con -->
                <a href="{{ $menu['route'] ? route($menu['route']) : '#' }}"
                    class="list-group-item list-group-item-action d-flex align-items-center {{ $isActiveParent ? 'active-item' : '' }}">
                    <i class="{{ $menu['icon'] }} me-2"></i> {{ $menu['title'] }}
                </a>
            @endif
        @endforeach
    </div>
    <style>
    </style>
</section>

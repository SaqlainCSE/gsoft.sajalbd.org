<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">{{ __('Menu') }}</li>
                @foreach ($menus as $menu)
                    <li>
                        <a href="{{ $menu['path'] }}" class="waves-effect @if(isset($menu['submenus']) && count($menu['submenus']) > 0) has-arrow @endif">
                            <i class="mdi {{ $menu['icon'] }}"></i>
                            @if(isset($menu['badge']))
                                <span class="badge rounded-pill bg-@if(isset($menu['badge_color'])) {{ $menu['badge_color'] }} @else primary @endif float-end">{{ $menu['badge'] }}</span>
                            @endif
                            <span>{{ $menu['title'] }}</span>
                        </a>
                        @if(isset($menu['submenus']) && count($menu['submenus']) > 0)
                            <ul class="sub-menu" aria-expanded="false">
                                @foreach ($menu['submenus'] as $submenu)
                                    <li><a href="{{ $submenu['path'] }}">{{ $submenu['title'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
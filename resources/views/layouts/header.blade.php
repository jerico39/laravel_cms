<header>
    <h1>{{ $setting?->site_name ?? 'サイト名未設定' }}</h1>
    <nav>
        @foreach($menus as $menu)
            @if($menu->children->count() > 0 || $menu->menuItems->count() > 0)
                <div class="dropdown">
                    <a href="#">{{ $menu->name }}</a>
                    <div class="dropdown-content">
                        @foreach($menu->children as $child)
                            <a href="{{ $child->url }}">{{ $child->name }}</a>
                        @endforeach
                        @foreach($menu->menuItems as $item)
                            <a href="{{ $item->url }}">{{ $item->title }}</a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $menu->url }}">{{ $menu->name }}</a>
            @endif
        @endforeach
    </nav>
</header>
<nav>
    <ul class="horizental-menu col-12">
        @php
            $menu = App\Menu::whereName('admin')->with('parent_items.children')->first();
        @endphp
        @foreach ($menu->parent_items as $item)
            @if (count($item->children) < 1)
            <li>
                <a target="{{ $item->target }}" href="{{ ($item->route) ? route($item->route) : $item->url }}"><i class="{{ $item->icon_class ?: '' }}"></i>{{ $item->title }}</a>
            </li>
            @else
                <li>
                    <p><i class="{{ $item->icon_class ?: '' }}"></i>{{ $item->title }}<i class="opener fa fa-angle-right float-right"></i></p>
                    <ul>
                    @foreach ($item->children as $child)
                        <li class="sub"><a href="{{ ($child->route) ? route($child->route) : $child->url }}"><i class="{{ $child->icon_class ?: '' }}"></i>{{ $child->title }}</a></li>
                    @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-power-off"></i> @lang('ZEL::admin.logout')</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </ul>
</nav>

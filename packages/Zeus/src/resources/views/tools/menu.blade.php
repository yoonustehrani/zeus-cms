<nav>
    <ul class="horizental-menu col-12">
        @php
            $menu = App\Menu::whereName('admin')->with([
                'parent_items' => function($q) { $q->with('children')->orderBy('order', 'asc'); }
            ])->first();
            $extentions = \Zeus::get_extentions();
        @endphp
        @foreach ($menu->parent_items as $item)
            @if (count($item->children) < 1)
            <li>
                <a target="{{ $item->target }}" href="{{ ($item->route) ? route($item->route) : $item->url }}"><i class="{{ $item->icon_class ?: '' }}"></i>{{ $item->title }}</a>
            </li>
            @else
                <li class="has_sub">
                    <p>
                        <a target="{{ $item->target }}" href="{{ ($item->route) ? route($item->route) : $item->url }}">
                            <i class="{{ $item->icon_class ?: '' }}"></i>{{ $item->title }}
                        </a>
                        <i class="opener fa fa-angle-right float-right"></i>
                    </p>
                    <ul>
                    @foreach ($item->children as $child)
                        <li class="sub"><a href="{{ ($child->route) ? route($child->route) : $child->url }}"><i class="{{ $child->icon_class ?: '' }}"></i>{{ $child->title }}</a></li>
                    @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
        @foreach ($extentions as $item)
            @if ($item['menu'])
                @if (isset($item['menu']['children']) && count($item['menu']['children']) < 1)
                <li>
                    <a target="{{ $item['menu']['target'] }}" href="{{ isset($item['menu']['route']) ? route($item['menu']['route']) : $item['menu']['url'] }}"><i class="{{ isset($item['menu']['icon_class']) ? $item['menu']['icon_class'] : '' }}"></i>{{ $item['menu']['title'] }}</a>
                </li>
                @else
                    <li class="has_sub">
                        <p>
                            <a target="{{ $item['menu']['target'] }}" href="{{ isset($item['menu']['route']) ? route($item['menu']['route']) : $item['menu']['url'] }}">
                                <i class="{{ $item['menu']['icon_class'] ?: '' }}"></i>{{ $item['menu']['title'] }}
                            </a>
                            <i class="opener fa fa-angle-right float-right"></i>
                        </p>
                        <ul>
                        @foreach ($item['menu']['children'] as $child)
                            <li class="sub"><a href="{{ isset($child['route']) ? route($child['route']) : $child['url'] }}"><i class="{{ $child['icon_class'] ?: '' }}"></i>{{ $child['title'] }}</a></li>
                        @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        @endforeach
        <li>
            <a href="{{ route('logout') }}" id="toggle-logout">
                <i class="fas fa-power-off"></i> @lang('ZEL::admin.logout')
            </a>
        </li>
        <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
    </ul>
</nav>

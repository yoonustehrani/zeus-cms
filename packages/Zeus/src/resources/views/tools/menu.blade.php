<nav>
    <ul class="horizental-menu col-12">
        <li><a href="{{ route('RomanCamp.') }}"><i class="fas fa-home"></i>@lang('ZEL::admin.dashboard')</a></li>
         {{--
        <li><p><i class="fas fa-font"></i>@lang('CMSL::admin.text')
        <i class="opener fa fa-angle-left float-left"></i></p>
            <ul>
                <li class="sub"><a href="{{ route('Admin.pages.index') }}">صفحات</a></li>
                <li class="sub"><a href="{{ route('Admin.posts.index') }}">نوشته ها</a></li>
            </ul>
        </li>
        <li><p><i class="fas fa-server"></i><i class="opener fa fa-angle-left float-left"></i>@lang('CMSL::admin.information')</p>
            <ul>
                <li class="sub"><a href="{{ route('Admin.tags.index') }}"><i class="fas fa-tags"></i> تگ ها</a></li>
                <li class="sub"><a href="{{ route('Admin.categories.index') }}"><i class="fas fa-tags"></i> دسته بندی ها</a></li>
                <li class="sub"><a href="{{ route('Admin.comments.index') }}"><i class="fas fa-comments"></i> کامنت ها</a></li>
                <li class="sub"><a href="{{ route('Admin.keywords.index') }}"><i class="fas fa-search"></i> کلمات کلیدی</a></li>
            </ul>
        </li>
        <li><a href="{{ route('Admin.tickets.index') }}"><i class="fas fa-ticket-alt"></i> @lang('CMSL::admin.tickets')</a></li>
        <li><a href="{{ route('Admin.files.index') }}"><i class="far fa-file-video ml-0"></i><i class="far fa-file-audio"></i> @lang('CMSL::admin.files')</a></li>
        <li><p><i class="fas fa-edit"></i><i class="opener fa fa-angle-left float-left"></i>@lang('CMSL::admin.writers')</p>
            <ul>
                <li class="sub"><a href="{{ route('Admin.writers.index', ['active' => 1, 'title' => \Lang::get('CMSL::admin.writers-list')]) }}"><i class="fas fa-user-edit"></i> @lang('CMSL::admin.writers-list')</a></li>
                <li class="sub"><a href="{{ route('Admin.writers.index', ['active' => 2, 'title' => \Lang::get('CMSL::admin.writers-request')]) }}"><i class="fas fa-list-alt"></i> @lang('CMSL::admin.writers-request')</a></li>
                <li class="sub"><a href="{{ route('Admin.writers.index', ['certified' => true, 'title' => \Lang::get('CMSL::admin.golden-writers')]) }}"><i class="golden fas fa-feather-alt"></i> @lang('CMSL::admin.golden-writers')</a></li>
            </ul>
        </li>
        <li><a href="{{ route('Admin.podcasts.index') }}"><i class="fas fa-podcast"></i> @lang('CMSL::admin.podcasts')</a></li>
		<li><a href="{{ route('Admin.menus.index') }}"><i class="fas fa-bars"></i> @lang('CMSL::admin.menus')</a></li>
        <li><a href="{{ route('Admin.sliders.index') }}"><i class="far fa-images"></i> @lang('CMSL::admin.sliders')</a></li>
        <li><a href="{{ route('Admin.users.index') }}"><i class="fas fa-users"></i> @lang('CMSL::admin.users')</a></li> --}}
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-power-off"></i> @lang('ZEL::admin.logout')</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </ul>
</nav>

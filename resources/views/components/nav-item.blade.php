
<li class="nav-item {{ $attributes->get('href') === Request::url() ? 'active' : '' }}">
    <a class="nav-link" href="{{ $attributes->get('href') }}">
        {{ $slot }}
    </a>
</li>
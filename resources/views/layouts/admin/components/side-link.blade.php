@props([
    'icon' => 'mdi mdi-view-dashboard-outline',
    'label' => 'Dashboard',
    'route' => '',
])
<li class="menu-item">
    <a href="{{route($route)}}" wire:navigate class="menu-link {{request()->routeIs($route) ? 'active' : ''}}">
        <span class="menu-icon"><i class="{{ $icon }}"></i></span>
        <span class="menu-text"> {{ $label }} </span>
    </a>
</li>

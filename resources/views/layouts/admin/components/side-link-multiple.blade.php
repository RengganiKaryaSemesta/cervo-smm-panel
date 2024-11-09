@props([
    'icon' => 'mdi mdi-email-outline',
    'label' => 'Email',
    'childrens' => [
        ['label' => 'Inbox', 'route' => 'inb', 'permissions' => '', 'route_param' => null],
        ['label' => 'Email Template', 'route' => '/temp', 'permissions' => '', 'route_param' => null],
    ],
])
@php
    $isActive = false;
    foreach ($childrens as $item) {
        if (request()->routeIs($item['route'].'*')) {
            $isActive = true;
            break;
        }
    }
@endphp
<li class="menu-item" wire:ignore>
    <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link fc-collapse {{ $isActive ? 'open' : '' }}">
        <span class="menu-icon"><i class="{{ $icon }}"></i></span>
        <span class="menu-text text-wrap"> {{ $label }} </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="sub-menu {{ $isActive ? '' : 'hidden' }} ">
        @foreach ($childrens as $item)
            @can($item['permissions'])
                <li class="menu-item">
                    <a href="{{ route($item['route'], isset($item['route_param']) ? $item['route_param'] : null) }}"
                        wire:navigate class="menu-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <span class="menu-text text-wrap">{{ $item['label'] }}
                        </span>
                    </a>
                </li>
            @endcan
        @endforeach
    </ul>
</li>

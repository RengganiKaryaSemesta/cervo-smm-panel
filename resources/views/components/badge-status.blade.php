@props(['status'=>'pending'])

@php
    if ($status === 'pending') {
        $cssClass = 'bg-yellow-300/10 text-yellow-700';
    } elseif ($status === 'waitingApproval') {
        $cssClass = 'bg-orange-300/10 text-orange-700';
    } elseif ($status === 'approved') {
        $cssClass = 'bg-purple-300/10 text-purple-700';
    } elseif ($status === 'inProgress') {
        $cssClass = 'bg-blue-300/10 text-blue-700';
    } elseif ($status === 'completed') {
        $cssClass = 'bg-green-300/10 text-green-700';
    } elseif ($status === 'cancelled') {
        $cssClass = 'bg-red-300/10 text-red-700';
    } else {
        $cssClass = 'bg-gray-300/10 text-gray-700';
    }
@endphp

<span class="inline-flex whitespace-nowrap items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium {{ $cssClass }} capitalize">
    {{ $slot }}
</span>

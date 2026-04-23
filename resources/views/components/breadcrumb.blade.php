@props(['items' => []])

@php
    if (empty($items)) {
        $routeName = Route::currentRouteName();
        $segments = $routeName ? explode('.', $routeName) : [];
        
        $items = [];
        
        if (count($segments) > 0) {
            $role = $segments[0];
            
            // Home / Dashboard Link
            if (Route::has($role . '.dashboard')) {
                $items[] = [
                    'label' => 'Home',
                    'url' => route($role . '.dashboard'),
                    'icon' => 'fa-solid fa-house'
                ];
            } else {
                $items[] = [
                    'label' => 'Home',
                    'url' => url('/dashboard'),
                    'icon' => 'fa-solid fa-house'
                ];
            }
            
            // Middle items
            if (count($segments) >= 2) {
                if ($segments[1] !== 'dashboard') {
                    $module = $segments[1];
                    $label = ucwords(str_replace(['-', '_'], ' ', $module));
                    
                    // Try to link to index if it exists
                    $indexRoute = $role . '.' . $module . '.index';
                    $url = Route::has($indexRoute) ? route($indexRoute) : null;
                    
                    $items[] = [
                        'label' => $label,
                        'url' => $url
                    ];
                    
                    // Add the third segment if it's not 'index'
                    if (isset($segments[2]) && $segments[2] !== 'index') {
                        $action = $segments[2];
                        $items[] = [
                            'label' => ucwords(str_replace(['-', '_'], ' ', $action)),
                            'url' => null // current page
                        ];
                    }
                }
            }
        }
    }
    
    // Ensure the last item is never clickable
    if (count($items) > 0) {
        $items[count($items) - 1]['url'] = null;
    }
@endphp

@if(count($items) > 0)
<nav aria-label="breadcrumb" class="flex items-center text-xs sm:text-sm font-medium text-slate-500 mb-1 overflow-x-auto whitespace-nowrap hide-scrollbar">
    <ol class="flex items-center">
        @foreach($items as $index => $item)
            <li class="flex items-center">
                @if(!$loop->first)
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                @endif
                
                @if($item['url'])
                    <a href="{{ $item['url'] }}" class="flex items-center hover:text-indigo-600 transition-colors">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }} mr-1.5 opacity-80"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="flex items-center text-slate-800 dark:text-slate-200 font-bold">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }} mr-1.5 opacity-80"></i>
                        @endif
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<style>
    /* Hide scrollbar for breadcrumb but allow scrolling */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endif

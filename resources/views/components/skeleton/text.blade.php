@props(['lines' => 3])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    @for ($i = 0; $i < $lines; $i++)
        @php
            // Make the last line slightly shorter for a more natural look
            $width = ($i === $lines - 1 && $lines > 1) ? 'w-2/3' : 'w-full';
            
            // Randomize width slightly if there are many lines
            if ($lines > 2 && $i !== $lines - 1) {
                $widthClass = ['w-full', 'w-11/12', 'w-full', 'w-10/12'][array_rand([0,1,2,3])];
                $width = $widthClass;
            }
        @endphp
        <div class="shimmer h-4 {{ $width }} rounded-full"></div>
    @endfor
</div>

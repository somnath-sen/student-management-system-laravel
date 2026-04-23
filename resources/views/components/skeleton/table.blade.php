@props(['rows' => 5])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <!-- Table Header Skeleton -->
            <thead class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700">
                <tr>
                    <th class="px-6 py-4"><div class="shimmer h-3 w-20 rounded-full"></div></th>
                    <th class="px-6 py-4"><div class="shimmer h-3 w-24 rounded-full"></div></th>
                    <th class="px-6 py-4"><div class="shimmer h-3 w-16 rounded-full"></div></th>
                    <th class="px-6 py-4"><div class="shimmer h-3 w-20 rounded-full"></div></th>
                    <th class="px-6 py-4 text-right"><div class="shimmer h-3 w-12 rounded-full ml-auto"></div></th>
                </tr>
            </thead>
            
            <!-- Table Body Skeleton -->
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                @for ($i = 0; $i < $rows; $i++)
                    <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="shimmer h-8 w-8 rounded-full flex-shrink-0"></div>
                                <div class="shimmer h-4 w-32 rounded-full"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4"><div class="shimmer h-4 {{ ['w-24', 'w-32', 'w-20', 'w-28'][$i % 4] }} rounded-full"></div></td>
                        <td class="px-6 py-4"><div class="shimmer h-4 w-16 rounded-full"></div></td>
                        <td class="px-6 py-4"><div class="shimmer h-6 w-20 rounded-full"></div></td>
                        <td class="px-6 py-4 text-right">
                            <div class="shimmer h-8 w-8 rounded-lg ml-auto"></div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

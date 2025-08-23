@php
    $classes = 'inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 px-3 py-2 text-xs uppercase font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>

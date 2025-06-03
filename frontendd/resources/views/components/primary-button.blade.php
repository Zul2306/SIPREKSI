<button {{ $attributes->merge(['type' => 'submit', 'class' => '
    inline-flex items-center px-4 py-2
    bg-blue-600 dark:bg-blue-400
    border border-transparent rounded-md
    font-semibold text-xs text-white dark:text-blue-900
    uppercase tracking-widest
    hover:bg-blue-700 dark:hover:bg-blue-300
    focus:bg-blue-700 dark:focus:bg-blue-300
    active:bg-blue-800 dark:active:bg-blue-500
    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-blue-200
    transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>

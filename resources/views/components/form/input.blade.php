@props([
    'name'        => '',
    'label'       => '',
    'type'        => 'text',
    'placeholder' => '',
    'value'       => null,
    'error'       => null,
    'hint'        => null,
    'required'    => false,
    'disabled'    => false,
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => '
                    w-full px-3.5 py-2.5 rounded-lg text-sm
                    bg-white dark:bg-gray-800
                    border transition-colors duration-150
                    text-gray-900 dark:text-white
                    placeholder-gray-400 dark:placeholder-gray-500
                    focus:outline-none focus:ring-2 focus:ring-offset-0
                    disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 dark:disabled:bg-gray-900/50
                    ' . ($error
                        ? 'border-red-400 dark:border-red-500 focus:border-red-400 focus:ring-red-300 dark:focus:ring-red-500/30'
                        : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                    )
            ]) }}
        />

        @if($error)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
        @endif
    </div>

    @if($hint && !$error)
        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
            {{ $error }}
        </p>
    @endif
</div>

@props([
    'name'        => '',
    'label'       => '',
    'placeholder' => '',
    'value'       => null,
    'error'       => null,
    'hint'        => null,
    'required'    => false,
    'disabled'    => false,
    'rows'        => 4,
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

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            'class' => '
                w-full px-3.5 py-2.5 rounded-lg text-sm resize-y
                bg-white dark:bg-gray-800
                border transition-colors duration-150
                text-gray-900 dark:text-white
                placeholder-gray-400 dark:placeholder-gray-500
                focus:outline-none focus:ring-2 focus:ring-offset-0
                disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-550 dark:disabled:bg-gray-900/50
                ' . ($error
                    ? 'border-red-400 dark:border-red-500 focus:border-red-400 focus:ring-red-300 dark:focus:ring-red-500/30'
                    : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                )
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if($hint && !$error)
        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
            {{ $error }}
        </p>
    @endif
</div>

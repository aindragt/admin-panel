@props([
    'name'     => '',
    'label'    => '',
    'value'    => '',
    'checked'  => false,
    'disabled' => false,
    'hint'     => null,
])

<div class="flex items-start gap-3">
    <div class="flex items-center h-5 mt-0.5">
        <input
            type="radio"
            id="{{ $name }}_{{ $value }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ old($name) == $value || $checked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="
                w-4 h-4
                text-indigo-600 dark:text-indigo-500
                bg-white dark:bg-gray-800
                border-gray-300 dark:border-gray-600
                focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-2 focus:ring-offset-1
                disabled:opacity-50 disabled:cursor-not-allowed
                cursor-pointer
            "
        />
    </div>
    <div>
        @if($label)
            <label for="{{ $name }}_{{ $value }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer {{ $disabled ? 'opacity-50' : '' }}">
                {{ $label }}
            </label>
        @endif
        @if($hint)
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $hint }}</p>
        @endif
    </div>
</div>

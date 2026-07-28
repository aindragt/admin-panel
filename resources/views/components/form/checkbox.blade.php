@props(['name', 'label', 'value' => '1', 'checked' => false, 'disabled' => false, 'hint' => ''])

<div class="flex items-start mb-4">
    <div class="flex items-center h-5">
        <input
            type="checkbox"
            id="{{ $name }}_{{ $value }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked(old($name, $checked))
            @disabled($disabled)
            {{ $attributes->merge(['class' => 'w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:checked:bg-indigo-500 dark:focus:ring-offset-gray-900 transition duration-200' . ($disabled ? ' opacity-50 cursor-not-allowed' : '')]) }}
        >
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $name }}_{{ $value }}" class="font-medium text-gray-700 dark:text-gray-300 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">{{ $label }}</label>
        @if($hint)
            <p class="text-gray-500 dark:text-gray-400">{{ $hint }}</p>
        @endif
    </div>
</div>
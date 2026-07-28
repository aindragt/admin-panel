@props(['name', 'label', 'value', 'checked' => false, 'disabled' => false])

<div class="flex items-center mb-4">
    <input
        type="radio"
        id="{{ $name }}_{{ $value }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @disabled($disabled)
        {{ $attributes->merge(['class' => 'w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:checked:bg-indigo-500 dark:focus:ring-offset-gray-900 transition duration-200' . ($disabled ? ' opacity-50 cursor-not-allowed' : '')]) }}
    >
    <label for="{{ $name }}_{{ $value }}" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
        {{ $label }}
    </label>
</div>
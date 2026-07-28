@props(['name', 'label' => '', 'rows' => 4, 'placeholder' => '', 'value' => '', 'error' => '', 'hint' => '', 'required' => false, 'disabled' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @disabled($disabled)
        @required($required)
        {{ $attributes->merge(['class' => 'block w-full rounded-md shadow-sm sm:text-sm resize-y transition-colors duration-200 ' . ($error ? 'border-red-400 text-red-900 focus:border-red-500 focus:ring-red-500 dark:bg-red-900/20 dark:border-red-500 dark:text-red-400' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white') . ($disabled ? ' bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500' : '')]) }}
    >{{ old($name, $value) }}</textarea>
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @elseif($hint)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif
</div>
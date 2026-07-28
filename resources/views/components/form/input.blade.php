@props(['name', 'label' => '', 'type' => 'text', 'placeholder' => '', 'value' => '', 'error' => '', 'hint' => '', 'required' => false, 'disabled' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @disabled($disabled)
            @required($required)
            {{ $attributes->merge(['class' => 'block w-full rounded-md shadow-sm sm:text-sm transition-colors duration-200 ' . ($error ? 'border-red-400 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 dark:bg-red-900/20 dark:border-red-500 dark:text-red-400' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white') . ($disabled ? ' bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500' : '')]) }}
        >
        @if($error)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
            </div>
        @endif
    </div>
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @elseif($hint)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif
</div>
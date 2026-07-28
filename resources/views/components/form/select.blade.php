@props(['name', 'label' => '', 'options' => [], 'selected' => '', 'error' => '', 'placeholder' => '', 'required' => false, 'disabled' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @disabled($disabled)
            @required($required)
            {{ $attributes->merge(['class' => 'block w-full appearance-none rounded-md shadow-sm sm:text-sm transition-colors duration-200 pr-10 ' . ($error ? 'border-red-400 text-red-900 focus:border-red-500 focus:ring-red-500 dark:bg-red-900/20 dark:border-red-500 dark:text-red-400' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white') . ($disabled ? ' bg-gray-50 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500' : '')]) }}
        >
            @if($placeholder)
                <option value="" disabled {{ empty($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            @foreach($options as $val => $text)
                <option value="{{ $val }}" {{ (string) $selected === (string) $val ? 'selected' : '' }}>{{ $text }}</option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 dark:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
        </div>
    </div>
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
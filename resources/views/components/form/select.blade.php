@props([
    'name'     => '',
    'label'    => '',
    'options'  => [],
    'selected' => null,
    'error'    => null,
    'hint'     => null,
    'required' => false,
    'disabled' => false,
    'placeholder' => 'Pilih salah satu...',
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
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => '
                    w-full px-3.5 py-2.5 pr-10 rounded-lg text-sm appearance-none
                    bg-white dark:bg-gray-800
                    border transition-colors duration-150
                    text-gray-900 dark:text-white
                    focus:outline-none focus:ring-2 focus:ring-offset-0
                    disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 dark:disabled:bg-gray-900/50
                    ' . ($error
                        ? 'border-red-400 dark:border-red-500 focus:border-red-400 focus:ring-red-300 dark:focus:ring-red-500/30'
                        : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                    )
            ]) }}
        >
            <option value="" disabled {{ !$selected ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>
            @foreach($options as $val => $lbl)
                <option value="{{ $val }}" {{ old($name, $selected) == $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>

        {{-- Custom chevron icon --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @if($hint && !$error)
        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">
            {{ $error }}
        </p>
    @endif
</div>

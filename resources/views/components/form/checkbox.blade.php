@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'hint' => null,
])

@php
    $inputId = $attributes->get('id', $name . '_' . $value);
@endphp

<div class="flex items-start gap-2.5">
    <div class="flex h-5 items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ $value }}"
            @checked(old($name, $checked))
            @if ($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => 'h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600
                    focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0
                    disabled:cursor-not-allowed disabled:opacity-50',
            ]) }}
        />
    </div>

    <div class="text-sm leading-5">
        @if ($label)
            <label for="{{ $inputId }}" class="font-medium text-gray-700 dark:text-gray-300 {{ $disabled ? 'opacity-50' : '' }}">
                {!! $label !!}
            </label>
        @endif
        @if ($hint)
            <p class="text-gray-400 dark:text-gray-500">{{ $hint }}</p>
        @endif
    </div>
</div>
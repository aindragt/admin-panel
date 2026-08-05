@props([
    'name',
    'label'      => '',
    'hint'       => null,
    'checked'    => false,
    'disabled'   => false,
    'id'         => null,
])

@php $id = $id ?? $name; @endphp

<div x-data="{ isOn: {{ $checked ? 'true' : 'false' }} }" class="flex items-start gap-3">
    {{-- Hidden input untuk menyimpan value form --}}
    <input type="hidden" name="{{ $name }}" :value="isOn ? '1' : '0'">

    {{-- Toggle Button --}}
    <button
        type="button"
        role="switch"
        id="{{ $id }}"
        :aria-checked="isOn.toString()"
        @click="{{ $disabled ? '' : 'isOn = !isOn' }}"
        :class="isOn ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600'"
        class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent
               transition-colors duration-200 ease-in-out
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
               dark:focus:ring-offset-gray-900
               {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
        {{ $disabled ? 'disabled' : '' }}
    >
        {{-- Toggle Knob --}}
        <span
            :class="isOn ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-md
                   ring-0 transition-transform duration-200 ease-in-out"
        ></span>
    </button>

    {{-- Label & Hint --}}
    @if ($label)
        <div class="flex flex-col">
            <label @click="{{ $disabled ? '' : 'isOn = !isOn' }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 {{ $disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }} select-none">
                {{ $label }}
            </label>
            @if ($hint)
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $hint }}</p>
            @endif
        </div>
    @endif
</div>

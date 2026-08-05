@props([
    'name',
    'label'       => null,
    'placeholder' => 'Pilih opsi...',
    'options'     => [],
    'selected'    => null,
    'error'       => null,
    'hint'        => null,
    'required'    => false,
    'disabled'    => false,
])

@php
    $inputId = $name;
    $hasError = filled($error);
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $inputId }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div
        x-data="{
            open: false,
            search: '',
            selected: '{{ old($name, $selected) }}',
            selectedLabel: '',
            options: {{ Js::from($options) }},
            get filteredOptions() {
                if (!this.search) return this.options;
                const q = this.search.toLowerCase();
                return Object.fromEntries(
                    Object.entries(this.options).filter(([val, label]) =>
                        label.toLowerCase().includes(q)
                    )
                );
            },
            selectOption(value, label) {
                this.selected = value;
                this.selectedLabel = label;
                this.open = false;
                this.search = '';
            },
            init() {
                if (this.selected && this.options[this.selected]) {
                    this.selectedLabel = this.options[this.selected];
                } else {
                    this.selectedLabel = '{{ $placeholder }}';
                }
            }
        }"
        x-init="init()"
        @keydown.escape="open = false"
        @click.outside="open = false"
        class="relative"
    >
        {{-- Hidden Input untuk Form Submit --}}
        <input type="hidden" name="{{ $name }}" :value="selected">

        {{-- Dropdown Trigger Button --}}
        <button
            type="button"
            @click="open = !open"
            {{ $disabled ? 'disabled' : '' }}
            class="flex items-center justify-between w-full px-3.5 py-2.5 rounded-lg border text-sm shadow-sm transition text-left focus:outline-none focus:ring-2
                bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50 dark:disabled:bg-gray-800
                {{ $hasError
                    ? 'border-red-400 focus:border-red-400 focus:ring-red-300/60'
                    : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300/60 dark:focus:ring-indigo-500/30' }}"
        >
            <span :class="selected ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500'" x-text="selectedLabel"></span>
            
            {{-- Chevron Icon --}}
            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown Content Panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-30 w-full mt-1.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg overflow-hidden"
            style="display: none;"
        >
            {{-- Search Input Area --}}
            <div class="p-2 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari..."
                        class="w-full pl-8 pr-3 py-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>
            </div>

            {{-- List Options Area --}}
            <ul class="max-h-48 overflow-y-auto py-1 divide-y divide-gray-50 dark:divide-gray-800/40">
                <template x-for="[val, label] in Object.entries(filteredOptions)" :key="val">
                    <li>
                        <button
                            type="button"
                            @click="selectOption(val, label)"
                            :class="selected === val ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                            class="flex items-center justify-between w-full px-3 py-2 text-xs transition-colors text-left"
                        >
                            <span x-text="label"></span>
                            
                            {{-- Checkmark Icon --}}
                            <template x-if="selected === val">
                                <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </template>
                        </button>
                    </li>
                </template>

                {{-- Empty State Options --}}
                <li x-show="Object.keys(filteredOptions).length === 0" class="px-3 py-3 text-xs text-gray-500 dark:text-gray-400 text-center">
                    Tidak ada opsi yang cocok.
                </li>
            </ul>
        </div>
    </div>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-gray-400 dark:text-gray-500">{{ $hint }}</p>
    @endif
</div>

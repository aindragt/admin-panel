@props([
    'name',
    'label'     => null,
    'accept'    => '*',
    'maxSize'   => '5MB',
    'hint'      => null,
    'error'     => null,
    'multiple'  => false,
])

@php
    $inputId = $name;
    $hasError = filled($error);
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $inputId }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <div x-data="{
        fileName: null,
        fileSize: null,
        isDragOver: false,
        handleFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.fileName = file.name;
            const bytes = file.size;
            this.fileSize = bytes > 1048576
                ? (bytes / 1048576).toFixed(1) + ' MB'
                : (bytes / 1024).toFixed(0) + ' KB';
        },
        clearFile() {
            this.fileName = null;
            this.fileSize = null;
            this.$refs.fileInput.value = '';
        }
    }" class="w-full">
        {{-- Area Upload Zone --}}
        <label
            x-show="!fileName"
            for="{{ $inputId }}"
            @dragover.prevent="isDragOver = true"
            @dragleave.prevent="isDragOver = false"
            @drop.prevent="isDragOver = false; $refs.fileInput.files = $event.dataTransfer.files; handleFile({target: $refs.fileInput})"
            :class="isDragOver 
                ? 'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-900/10' 
                : 'border-gray-300 dark:border-gray-700 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/5 bg-white dark:bg-gray-900'"
            class="flex flex-col items-center justify-center w-full min-h-[120px] rounded-xl border-2 border-dashed cursor-pointer transition-all"
        >
            {{-- Cloud Upload SVG Icon --}}
            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">Klik untuk unggah</span>
                atau seret & lepas file di sini
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                {{ $accept !== '*' ? strtoupper(str_replace(['.', '/*'], ['', ''], $accept)) . ' · ' : '' }}Maks. {{ $maxSize }}
            </p>
        </label>

        {{-- Preview File setelah diunggah --}}
        <div
            x-show="fileName"
            class="flex items-center gap-3 p-4 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/20"
            style="display: none;"
        >
            {{-- Document Check SVG Icon --}}
            <svg class="w-8 h-8 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate" x-text="fileName"></p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="fileSize"></p>
            </div>
            <button
                type="button"
                @click="clearFile()"
                class="text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors flex-shrink-0"
                title="Hapus File"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Native Input File tersembunyi --}}
        <input
            type="file"
            id="{{ $inputId }}"
            name="{{ $name }}"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            class="hidden"
            x-ref="fileInput"
            @change="handleFile($event)"
        >
    </div>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-gray-400 dark:text-gray-500">{{ $hint }}</p>
    @endif
</div>

@extends('layouts.app')

@section('title', 'Data Table')
@section('page-title', 'Data Table')

@section('content')
<div class="mx-auto max-w-6xl space-y-6 px-4 py-8">

    <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Data Table</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Contoh tabel data dengan search, badge, aksi, dan pagination — menggunakan dummy data.
        </p>
    </div>

    @php
        $users = [
            ['id' => 1,  'name' => 'Budi Santoso',      'email' => 'budi@example.com',      'role' => 'Administrator', 'status' => 'active',     'joined' => '1 Jan 2024'],
            ['id' => 2,  'name' => 'Siti Nurhaliza',     'email' => 'siti@example.com',      'role' => 'Editor',        'status' => 'active',     'joined' => '3 Jan 2024'],
            ['id' => 3,  'name' => 'Agus Wijaya',        'email' => 'agus@example.com',      'role' => 'Viewer',        'status' => 'inactive',   'joined' => '10 Jan 2024'],
            ['id' => 4,  'name' => 'Rina Marlina',       'email' => 'rina@example.com',      'role' => 'Editor',        'status' => 'active',     'joined' => '15 Jan 2024'],
            ['id' => 5,  'name' => 'Dedi Kurniawan',     'email' => 'dedi@example.com',      'role' => 'Viewer',        'status' => 'suspended',  'joined' => '22 Jan 2024'],
            ['id' => 6,  'name' => 'Putri Ayu Lestari',  'email' => 'putri@example.com',     'role' => 'Administrator', 'status' => 'active',     'joined' => '2 Feb 2024'],
            ['id' => 7,  'name' => 'Hendra Gunawan',     'email' => 'hendra@example.com',    'role' => 'Editor',        'status' => 'inactive',   'joined' => '9 Feb 2024'],
            ['id' => 8,  'name' => 'Maya Sari',          'email' => 'maya@example.com',      'role' => 'Viewer',        'status' => 'active',     'joined' => '14 Feb 2024'],
            ['id' => 9,  'name' => 'Fajar Ramadhan',     'email' => 'fajar@example.com',     'role' => 'Editor',        'status' => 'active',     'joined' => '20 Feb 2024'],
            ['id' => 10, 'name' => 'Lestari Handayani',  'email' => 'lestari@example.com',   'role' => 'Administrator', 'status' => 'suspended',  'joined' => '27 Feb 2024'],
        ];

        $roleStyles = [
            'Administrator' => 'bg-purple-50 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400',
            'Editor'        => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
            'Viewer'        => 'bg-gray-100 text-gray-600 dark:bg-gray-500/10 dark:text-gray-400',
        ];

        $statusStyles = [
            'active'    => ['label' => 'Aktif',     'text' => 'text-emerald-700 dark:text-emerald-400', 'bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'dot' => 'bg-emerald-500'],
            'inactive'  => ['label' => 'Nonaktif',  'text' => 'text-gray-600 dark:text-gray-400',       'bg' => 'bg-gray-100 dark:bg-gray-500/10',      'dot' => 'bg-gray-400'],
            'suspended' => ['label' => 'Suspended', 'text' => 'text-red-700 dark:text-red-400',         'bg' => 'bg-red-50 dark:bg-red-500/10',         'dot' => 'bg-red-500'],
        ];

        $getInitials = function (string $name) {
            $parts = explode(' ', trim($name));
            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts) - 1] ?? '', 0, 1));
            return $initials;
        };

        $avatarPalette = ['bg-indigo-500', 'bg-rose-500', 'bg-amber-500', 'bg-teal-500', 'bg-violet-500', 'bg-sky-500'];
    @endphp

    {{-- scope x-data untuk mendeteksi pilihan bulk checkboxes --}}
    <div x-data="{
        selectedRows: [],
        allRows: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        get isAllSelected() {
            return this.allRows.length > 0 && this.selectedRows.length === this.allRows.length;
        },
        get hasSelection() {
            return this.selectedRows.length > 0;
        },
        toggleAll() {
            if (this.isAllSelected) {
                this.selectedRows = [];
            } else {
                this.selectedRows = [...this.allRows];
            }
        },
        clearSelection() {
            this.selectedRows = [];
        }
    }">
        <x-table.wrapper title="Daftar Pengguna" subtitle="Total {{ count($users) }} pengguna">
            <x-slot name="toolbar">
                <div class="w-full sm:w-64">
                    <x-form.input name="search" placeholder="Cari nama atau email..." />
                </div>
                <div x-data="{ filterOpen: false }" @click.outside="filterOpen = false" class="relative">
                    <button
                        type="button"
                        @click="filterOpen = !filterOpen"
                        :class="filterOpen ? 'bg-indigo-50 text-indigo-700 border-indigo-300 dark:bg-indigo-900/20 dark:text-indigo-400 dark:border-indigo-700' : 'bg-white text-gray-700 border-gray-300 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700'"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border text-sm font-medium shadow-sm transition hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="filterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="filterOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-full mt-2 z-30 w-72 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xl p-4 space-y-4"
                        style="display: none;"
                    >
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            📌 Filter Pengguna
                        </p>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                            <select class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                                <option value="">Semua Role</option>
                                <option value="admin">Administrator</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <div class="flex flex-col gap-1.5">
                                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                    <input type="radio" name="filter_status" value="" checked class="h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 focus:ring-indigo-500">
                                    Semua Status
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                    <input type="radio" name="filter_status" value="active" class="h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 focus:ring-indigo-500">
                                    Aktif
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                    <input type="radio" name="filter_status" value="inactive" class="h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 focus:ring-indigo-500">
                                    Nonaktif
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" @click="filterOpen = false" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                Reset
                            </button>
                            <button type="button" @click="filterOpen = false" class="px-4 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-sm font-medium text-white transition-colors">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <x-form.button variant="primary" size="sm">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" clip-rule="evenodd" />
                    </svg>
                    Tambah Data
                </x-form.button>
            </x-slot>

            <table class="w-full min-w-[880px] divide-y divide-gray-100 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <x-table.th class="w-10 px-4 py-3">
                            <input
                                type="checkbox"
                                :checked="isAllSelected"
                                :indeterminate="selectedRows.length > 0 && !isAllSelected"
                                @change="toggleAll()"
                                class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600
                                       focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 cursor-pointer"
                            />
                        </x-table.th>
                        <x-table.th sortable sorted="asc">Nama</x-table.th>
                        <x-table.th sortable>Email</x-table.th>
                        <x-table.th>Role</x-table.th>
                        <x-table.th>Status</x-table.th>
                        <x-table.th sortable>Bergabung</x-table.th>
                        <x-table.th class="text-right">Aksi</x-table.th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($users as $index => $user)
                        <tr
                            class="table-row-in group transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-800/40"
                            style="animation-delay: {{ $index * 40 }}ms"
                        >
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <input
                                    type="checkbox"
                                    value="{{ $user['id'] }}"
                                    x-model="selectedRows"
                                    class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600
                                           focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 cursor-pointer"
                                />
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-xs font-semibold text-white transition-transform duration-150 group-hover:scale-105 {{ $avatarPalette[$index % count($avatarPalette)] }}">
                                        {{ $getInitials($user['name']) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $user['name'] }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">ID #{{ str_pad($user['id'], 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5 text-sm text-gray-600 dark:text-gray-400">
                                {{ $user['email'] }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $roleStyles[$user['role']] }}">
                                    {{ $user['role'] }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5">
                                @php $status = $statusStyles[$user['status']]; @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                    <span class="relative flex h-1.5 w-1.5">
                                        @if ($user['status'] === 'active')
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full {{ $status['dot'] }} opacity-60"></span>
                                        @endif
                                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                    </span>
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5 text-sm text-gray-500 dark:text-gray-400">
                                {{ $user['joined'] }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                <x-table.row-actions row-id="{{ $user['id'] }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <x-slot name="footer">
                <x-table.pagination :current="1" :last="10" :from="1" :to="10" :total="97" />
            </x-slot>
        </x-table.wrapper>

        {{-- Bulk Actions Floating Bar --}}
        <div
            x-show="hasSelection"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40
                   flex items-center gap-4 px-5 py-3 rounded-xl shadow-2xl
                   bg-gray-900 dark:bg-gray-800 border border-gray-700 dark:border-gray-600 pointer-events-auto"
            style="display: none;"
        >
            {{-- Jumlah Terpilih --}}
            <span class="text-sm font-medium text-white">
                <span x-text="selectedRows.length" class="font-bold text-indigo-400"></span>
                baris dipilih
            </span>

            <div class="w-px h-5 bg-gray-600 dark:bg-gray-500"></div>

            {{-- Tombol Hapus Terpilih --}}
            <button type="button"
                class="flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-sm font-medium
                       bg-red-600 hover:bg-red-700 text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Terpilih
            </button>

            {{-- Tombol Batal --}}
            <button type="button"
                @click="clearSelection()"
                class="text-sm font-medium text-gray-400 hover:text-white transition-colors focus:outline-none"
            >
                Batal
            </button>
        </div>
    </div>

</div>

<style>
    /* Animasi fade-in untuk card tabel saat halaman dimuat */
    @keyframes tableFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .table-fade-in {
        animation: tableFadeIn 0.4s ease-out both;
    }

    /* Animasi stagger untuk setiap baris tabel */
    @keyframes rowFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .table-row-in {
        animation: rowFadeIn 0.35s ease-out both;
    }

    @media (prefers-reduced-motion: reduce) {
        .table-fade-in,
        .table-row-in {
            animation: none;
        }
    }
</style>
@endsection
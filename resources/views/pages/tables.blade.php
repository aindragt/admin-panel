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

    <x-table.wrapper title="Daftar Pengguna" subtitle="Total {{ count($users) }} pengguna">
        <x-slot name="toolbar">
            <div class="w-full sm:w-64">
                <x-form.input name="search" placeholder="Cari nama atau email..." />
            </div>
            <x-form.button variant="secondary" size="sm">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                </svg>
                Filter
            </x-form.button>
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
                    <x-table.th>
                        <x-form.checkbox name="select_all" value="1" />
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
                            <x-form.checkbox name="selected_users[]" :value="$user['id']" />
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

                        <td class="whitespace-nowrap px-5 py-3.5">
                            <div class="flex items-center justify-end gap-1 opacity-0 transition-all duration-200 translate-x-1 group-hover:translate-x-0 group-hover:opacity-100">
                                <button type="button" title="Lihat" class="rounded-lg p-1.5 text-gray-500 transition-all duration-150 hover:scale-110 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.147.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button type="button" title="Edit" class="rounded-lg p-1.5 text-blue-500 transition-all duration-150 hover:scale-110 hover:bg-blue-50 dark:hover:bg-blue-500/10">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z" />
                                        <path d="M11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button type="button" title="Hapus" class="rounded-lg p-1.5 text-red-500 transition-all duration-150 hover:scale-110 hover:bg-red-50 dark:hover:bg-red-500/10">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-slot name="footer">
            <x-table.pagination :current="1" :last="10" :from="1" :to="10" :total="97" />
        </x-slot>
    </x-table.wrapper>

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
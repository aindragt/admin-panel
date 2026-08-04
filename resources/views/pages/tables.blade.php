@extends('layouts.app')

@section('title', 'Data Table — ' . config('app.name'))
@section('page-title', 'Data Table')

@section('content')
@php
    $users = [
        ['id' => 1,  'name' => 'Budi Santoso',     'email' => 'budi@example.com',     'role' => 'Administrator', 'status' => 'active',    'joined' => '1 Jan 2024'],
        ['id' => 2,  'name' => 'Siti Rahayu',      'email' => 'siti@example.com',     'role' => 'Editor',        'status' => 'active',    'joined' => '15 Jan 2024'],
        ['id' => 3,  'name' => 'Ahmad Fauzi',      'email' => 'ahmad@example.com',    'role' => 'Viewer',        'status' => 'inactive',  'joined' => '20 Feb 2024'],
        ['id' => 4,  'name' => 'Dewi Lestari',     'email' => 'dewi@example.com',     'role' => 'Editor',        'status' => 'active',    'joined' => '12 Mar 2024'],
        ['id' => 5,  'name' => 'Rizky Pratama',    'email' => 'rizky@example.com',    'role' => 'Viewer',        'status' => 'suspended', 'joined' => '5 Apr 2024'],
        ['id' => 6,  'name' => 'Maya Putri',       'email' => 'maya@example.com',     'role' => 'Editor',        'status' => 'inactive',  'joined' => '18 May 2024'],
        ['id' => 7,  'name' => 'Hendra Wijaya',    'email' => 'hendra@example.com',   'role' => 'Administrator', 'status' => 'active',    'joined' => '23 Jun 2024'],
        ['id' => 8,  'name' => 'Fitri Handayani',  'email' => 'fitri@example.com',    'role' => 'Viewer',        'status' => 'active',    'joined' => '10 Jul 2024'],
        ['id' => 9,  'name' => 'Rudi Hartono',     'email' => 'rudi@example.com',     'role' => 'Editor',        'status' => 'suspended', 'joined' => '29 Aug 2024'],
        ['id' => 10, 'name' => 'Ayu Kusuma',       'email' => 'ayu@example.com',      'role' => 'Viewer',        'status' => 'active',    'joined' => '14 Sep 2024'],
    ];
@endphp

<div class="space-y-6">
    <x-table.wrapper title="Daftar Pengguna" subtitle="Kelola data semua pengguna sistem, atur hak akses, dan pantau status mereka.">
        <x-slot name="toolbar">
            {{-- Search Bar --}}
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" placeholder="Cari data..." class="w-full pl-9 pr-4 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition">
            </div>

            {{-- Filter Button --}}
            <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
            </button>

            {{-- Add Data Button --}}
            <button class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm shadow-indigo-500/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Data</span>
            </button>
        </x-slot>

        {{-- Slot Utama: Table --}}
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 text-gray-500 dark:text-gray-400">
                    <th class="w-12 px-5 py-3 text-left">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500">
                    </th>
                    <x-table.th :sortable="true" sorted="asc">Nama</x-table.th>
                    <x-table.th>Email</x-table.th>
                    <x-table.th>Role</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th>Tanggal Bergabung</x-table.th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($users as $user)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                        {{-- Checkbox --}}
                        <td class="px-5 py-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        {{-- Nama + Avatar --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user['name'], 0, 1)) }}{{ strtoupper(substr(strrchr($user['name'], ' '), 1, 1)) ?: '' }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $user['name'] }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 font-mono mt-0.5">ID: #{{ str_pad($user['id'], 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Email --}}
                        <td class="px-5 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                            {{ $user['email'] }}
                        </td>
                        {{-- Role Badge --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if ($user['role'] === 'Administrator') bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400
                                @elseif ($user['role'] === 'Editor') bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @else bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 @endif">
                                {{ $user['role'] }}
                            </span>
                        </td>
                        {{-- Status Badge --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if ($user['status'] === 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                @elseif ($user['status'] === 'inactive') bg-gray-100 text-gray-500 dark:bg-gray-800/40 dark:text-gray-400
                                @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @endif">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if ($user['status'] === 'active') bg-emerald-500
                                    @elseif ($user['status'] === 'inactive') bg-gray-400
                                    @else bg-red-500 @endif"></span>
                                @if ($user['status'] === 'active') Aktif
                                @elseif ($user['status'] === 'inactive') Nonaktif
                                @else Suspended @endif
                            </span>
                        </td>
                        {{-- Tanggal --}}
                        <td class="px-5 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                            {{ $user['joined'] }}
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                {{-- View Button --}}
                                <button type="button" title="View Detail" class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800/60 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                {{-- Edit Button --}}
                                <button type="button" title="Edit Data" class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950/40 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                {{-- Delete Button --}}
                                <button type="button" title="Delete Data" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginasi Real menggunakan Komponen --}}
        <x-slot name="footer">
            <x-table.pagination current="1" last="10" from="1" to="10" total="100" />
        </x-slot>
    </x-table.wrapper>
</div>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                        <div class="mb-8">
                            <x-biru-link href="{{ route('tugas.create', $program->id) }}">Tambah Tugas</x-biru-link>
                        </div>
                    @endif
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tugas
                                    </th>
                                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                        <th scope="col" class="px-6 py-3">
                                            Dibuat Oleh
                                        </th>
                                    @endif
                                    <th scope="col" class="px-6 py-3">
                                        Deadline
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tugass as $index => $tugas)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $tugass->firstItem() + $index }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $tugas->judul }}
                                        </td>
                                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                            <td class="px-6 py-4">
                                                {{ $tugas->user->name }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4">
                                            {{ $tugas->deadline }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('tugas.showDetailTugas', ['program' => $tugas->program_id, 'tugas' => $tugas->id]) }}"
                                                class=" inline-flex items-center ml-3 px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                Lihat Detail Tugas
                                            </a>
                                            <a href="{{ route('tugas.edit', $tugas->id) }}" aria-current="page"
                                                class="ml-3 px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $tugass->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

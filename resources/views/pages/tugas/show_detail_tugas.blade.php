<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('tugas.showByProgram', $program->id) }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-3xl font-bold dark:text-white">{{ $tugas->judul }}</h3>
                    </div>
                    <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">
                        Deadline: {{ $tugas->deadline }}
                    </p>
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                        <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                            Ditambahkan oleh {{ $tugas->user->name }}
                        </p>
                    @endif
                    <div class="mb-4">
                        <div class="mb-4">
                            <p class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ $tugas->deskripsi }}</p>
                        </div>
                        <a href=""
                            class="inline-flex items-center text-lg text-blue-600 dark:text-blue-500 hover:underline">
                            Download Tugas
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                        <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                            {{ $tugas->updated_at->format('l, d-m-Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

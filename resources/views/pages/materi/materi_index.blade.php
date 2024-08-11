<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-wrap text-gray-900 dark:text-gray-100">
                    @foreach ($programs as $program)
                        <div
                            class="max-w-sm p-6 mx-3 mb-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <a href="{{ route('materi.showByProgram', $program->id) }}">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $program->nama }}</h5>
                            </a>
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                    Ditambahkan oleh {{ $program->user->name }}
                                    <br>
                                    Tanggal Input {{ $program->created_at->format('d-m-Y, H:i') }}
                                    <br>
                                    Tanggal Edit {{ $program->updated_at->format('d-m-Y, H:i') }}
                                </p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $program->deskripsi }}
                                </p>
                            @endif
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $program->materi_count }}
                                Materi
                            </p>
                            <a href="{{ route('materi.showByProgram', $program->id) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Lihat Materi
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <a href="{{ route('materi.create', $program->id) }}"
                                    class="inline-flex items-center ml-3 px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Tambah Materi
                                </a>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

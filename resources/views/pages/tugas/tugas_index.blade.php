<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('tugas.index') }}"
                    class="max-w-xs mx-auto mt-4 sm:ml-auto sm:mr-5 sm:max-w-sm lg:ml-auto lg:mr-5 lg:max-w-sm">
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="search" name="search" value="{{ request()->input('search') }}"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search Program" />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                    </div>
                </form>
                <div class="p-6 flex flex-wrap text-gray-900 dark:text-gray-100">
                    @if ($programs->isEmpty())
                        <div class="w-full text-center text-gray-500 dark:text-gray-400">
                            <p>Anda Belum Mendaftar Program</p>
                        </div>
                    @else
                        @foreach ($programs as $program)
                            <div
                                class="max-w-sm p-6 mx-3 mb-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="{{ route('materi.showByProgram', $program->id) }}">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $program->nama }}</h5>
                                </a>
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                    <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                        Ditambahkan oleh {{ $program->user?->name ?? 'deleted' }}
                                        <br>
                                        Tanggal Input {{ $program->created_at->format('d-m-Y, H:i') }}
                                        <br>
                                        Tanggal Edit {{ $program->updated_at->format('d-m-Y, H:i') }}
                                    </p>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        {{ $program->deskripsi }}
                                    </p>
                                @endif
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $program->tugas_count }}
                                    Tugas
                                </p>
                                <a href="{{ route('tugas.showByProgram', $program->id) }}"
                                    class=" inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Lihat Tugas
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

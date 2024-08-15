<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('materi.index') }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold mb-5 dark:text-white">Materi untuk Program: {{ $program->nama }}</h3>
                    @forelse($materis as $materi)
                        <div class=" mb-3 mt-5">
                            <h4 class="text-2xl mb-2 font-bold dark:text-white">{{ $materi->judul }}</h4>
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                    Ditambahkan oleh {{ $materi->user->name }}
                                    <br>
                                    Tanggal Input {{ $materi->created_at->format('l, d-m-Y, H:i') }}
                                    <br>
                                    Tanggal Edit {{ $materi->updated_at->format('l, d-m-Y, H:i') }}
                                </p>
                            @endif
                            <p class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ $materi->deskripsi }}</p>
                            <a href="{{ route('materi.download', $materi->id) }}"
                                class="inline-flex items-center text-lg text-blue-600 dark:text-blue-500 hover:underline">
                                Download Materi
                                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                            <br>
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="{{ route('materi.edit', $materi->id) }}" aria-current="page"
                                        class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                        Edit
                                    </a>
                                    <form action="{{ route('materi.destroy', $materi->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium  rounded-e-lg  focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 delete-button">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    @empty
                        <p class="mt-3 text-gray-500 dark:text-gray-400">Belum ada materi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

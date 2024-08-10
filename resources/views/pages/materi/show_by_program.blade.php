<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('materi.index') }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materi') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-3xl font-bold dark:text-white">Materi untuk Program: {{ $program->nama }}</h3>

                    <a href="{{ route('materi.create') }}" class="btn btn-primary mb-3">Tambah Materi</a>

                    @forelse($materis as $materi)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $materi->judul }}</h5>
                                <p class="card-text">{{ $materi->deskripsi }}</p>
                                <a href="{{ Storage::url($materi->file) }}" class="btn btn-info" target="_blank">Lihat
                                    File</a>
                                {{-- <a href="{{ route('materi.edit', $materi->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('materi.destroy', $materi->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">Hapus</button>
                                </form> --}}
                            </div>
                        </div>
                    @empty
                        <p class="mt-3 text-gray-500 dark:text-gray-400">Tidak ada materi untuk program ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

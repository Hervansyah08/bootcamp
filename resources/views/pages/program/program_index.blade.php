<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('program.create') }}">Tambah</a>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Edit By</th>
                                <th>Tanggal Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $index => $program)
                            <tr>
                                <td>{{ $programs->firstItem() + $index }}</td>
                                <td>{{ $program->nama }}</td>
                                <td>{{ $program->deskripsi }}</td>
                                <td>{{ $program->status }}</td>
                                <td>{{ $program->user->name }}</td>
                                <td>{{ $program->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

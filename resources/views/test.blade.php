

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Program
                </th>
                <th scope="col" class="px-6 py-3">
                    Deskripsi
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Edit By
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal Input
                </th>
                <th scope="col" class="px-6 py-3">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $index => $program)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $programs->firstItem() + $index }}
                </th>
                <td class="px-6 py-4">
                    {{ $program->nama }}
                </td>
                <td class="px-6 py-4">
                    {{ $program->deskripsi }}
                </td>
                <td class="px-6 py-4">
                    {{ $program->status }}
                </td>
                <td class="px-6 py-4">
                    {{ $program->user->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $program->created_at->format('d-m-Y H:i') }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('program.edit', $program->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('program.destroy', $program->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

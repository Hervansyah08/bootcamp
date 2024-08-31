<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('tugas.index') }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
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
                                    @if (Auth::check() && Auth::user()->role == 'user')
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                    @endif
                                    <th scope="col" class="px-6 py-3">
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
                                                {{ $tugas->user?->name ?? 'deleted' }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4">
                                            {{ $tugas->deadline }}
                                        </td>
                                        @if (Auth::check() && Auth::user()->role == 'user')
                                            <td class="px-6 py-4">
                                                {{ $tugas->status }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 ">
                                            <a href="{{ route('tugas.showDetailTugas', ['program' => $tugas->program_id, 'tugas' => $tugas->id]) }}"
                                                class=" inline-flex items-center mr-2 px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                Lihat Detail Tugas
                                            </a>
                                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                                <div class="inline-flex rounded-md shadow-sm mt-3 " role="group">
                                                    <a href="{{ route('tugas.edit', $tugas->id) }}" aria-current="page"
                                                        class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('tugas.destroy', $tugas->id) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm font-medium  rounded-e-lg  focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 delete-button">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 mb-2">
                        {{ $tugass->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah pengiriman form langsung

                const form = this.closest('form');

                Swal.fire({
                    title: "Apa anda yakin?",
                    text: "Data yang sudah terhapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan AJAX untuk mengirim form
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(form)
                        }).then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: "Data berhasil dihapus!",
                                    icon: "success",
                                    text: "Klik tombol Oke untuk melanjutkan.",
                                    confirmButtonText: "Oke"
                                }).then(() => {
                                    location
                                        .reload(); // Reload halaman setelah penghapusan berhasil
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi masalah saat menghapus data.",
                                    icon: "error"
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: "Terjadi kesalahan yang tidak terduga.",
                                icon: "error"
                            });
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>

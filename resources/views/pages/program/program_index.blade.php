<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Program') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg lg:relative">
                <div class="p-6 text-gray-900 dark:text-gray-100 ">
                    <x-biru-link href="{{ route('program.create') }}">Tambah </x-biru-link>
                    <form action="{{ route('program.search') }}" method="GET"
                        class="w-full mt-6 lg:absolute lg:right-7 lg:top-4 lg:mt-0 lg:max-w-sm">
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
                            <input type="search" id="default-search" name="search"
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search Program dan Deskripsi" />
                            <button type="submit"
                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                    <br>
                    <div class="relative overflow-x-auto lg:mt-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                        Tanggal Edit
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $index => $program)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $programs->firstItem() + $index }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $program->nama }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $program->deskripsi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $program->status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $program->user?->name ?? 'deleted' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $program->created_at->format('l, d-m-Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $program->updated_at->format('l, d-m-Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                                <a href="{{ route('program.edit', $program->id) }}" aria-current="page"
                                                    class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('program.destroy', $program->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="px-4 py-2 text-sm font-medium  rounded-e-lg  focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 delete-button">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{ $programs->links() }}
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

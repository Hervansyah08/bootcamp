<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('quiz.index') }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl text-center font-bold mb-5 dark:text-white">Quiz untuk Program:
                        {{ $program->nama }}
                    </h3>
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                        <div class="mb-8">
                            <x-biru-link href="{{ route('quiz.create', $program->id) }}">Tambah Quiz</x-biru-link>
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
                                        Judul
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Link
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Detail
                                    </th>
                                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                        <th scope="col" class="px-6 py-3">
                                            Edit By
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tanggal Input
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Aksi
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizs as $index => $quiz)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $quizs->firstItem() + $index }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $quiz->judul }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $quiz->link }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $quiz->detail ?? '-' }}
                                        </td>
                                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                            <td class="px-6 py-4">
                                                {{ $quiz->user?->name ?? 'deleted' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $quiz->created_at->format('l, d-m-Y, H:i') }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 ">
                                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                                <div class="inline-flex rounded-md shadow-sm mt-3 " role="group">
                                                    <a href="{{ route('quiz.edit', $quiz->id) }}" aria-current="page"
                                                        class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('quiz.destroy', $quiz->id) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="delete-button px-4 py-2 text-sm font-medium  rounded-e-lg  focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 delete-button">
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
                        {{ $quizs->links() }}
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
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!",
                    backdrop: true,  // Menambahkan latar belakang gelap
                    allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Tunggu sebentar, sedang menghapus quiz.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        // Gunakan AJAX untuk mengirim form
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(form)
                        }).then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: "Quiz Berhasil Dihapus",
                                    icon: "success",
                                    confirmButtonText: "Oke",
                                    backdrop: true,  // Menambahkan latar belakang gelap
                                    allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                                }).then(() => {
                                    location.reload(); // Reload halaman setelah penghapusan berhasil
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi masalah saat menghapus data.",
                                    icon: "error",
                                    backdrop: true,  // Menambahkan latar belakang gelap
                                    allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: "Terjadi kesalahan yang tidak terduga.",
                                icon: "error",
                                backdrop: true,  // Menambahkan latar belakang gelap
                                allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                            });
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>

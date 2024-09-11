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
                            Edit by {{ $tugas->user?->name ?? 'deleted' }}
                        </p>
                    @endif
                    <div class="mb-6">
                        <div class="mb-4">
                            <p class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ $tugas->deskripsi }}</p>
                        </div>
                        <a href="{{ route('tugas.download', $tugas->id) }}"
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
                        <p>
                            Waktu tersisa : {{ $remainingTime }}
                        </p>
                    </div>
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                        <div class="mb-4 lg:flex">
                            <div class="mb-8 lg:mr-3 lg:mb-0">
                                <x-biru-link
                                    href="{{ route('pengumpulan.create', [$program->id, $tugas->id]) }}">Kirimkan
                                    Pengajuan (Tugas)</x-biru-link>
                            </div>
                            <x-biru-link
                                href="{{ route('pengumpulan.index', ['program' => $tugas->program_id, 'tugas' => $tugas->id]) }}">
                                Lihat Semua Pengajuan</x-biru-link>
                        </div>
                    @else
                        <div class="mb-4">
                            @if ($pengumpulan)
                                <div class="flex mb-2">
                                    <a href="{{ route('pengumpulan.edit', $pengumpulan->id) }}"
                                        class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Edit
                                        Pengajuan</a>
                                    <form
                                        action="{{ route('pengumpulan.destroyForUser', [$program->id, $tugas->id, $pengumpulan->id]) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                            id="delete-button-{{ $pengumpulan->id }}">Hapus Pengajuan</button>
                                    </form>
                                </div>
                                <h4 class="text-xl font-bold mb-4 dark:text-white">Status Pengajuan</h4>
                                <div class="relative overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                Status Pengajuan
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                {{ $pengumpulan->status ? 'Sudah Melakukan Pengajuan' : 'Belum ada pengajuan yang dibuat ' }}
                                            </th>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Terakhir diubah
                                            </th>
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                {{ $pengumpulan->updated_at->format('l, d-m-Y, H:i') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                Judul
                                            </th>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                {{ $pengumpulan->judul }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Deskripsi
                                            </th>
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                {{ $pengumpulan->deskripsi ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                File
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <a
                                                    href="{{ route('pengumpulan.download', $pengumpulan->id) }}">{{ $pengumpulan->file }}</a>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            @else
                                <x-biru-link
                                    href="{{ route('pengumpulan.create', [$program->id, $tugas->id]) }}">Kirimkan
                                    Pengajuan (Tugas)</x-biru-link>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[id^="delete-button-"]').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah pengiriman form langsung
                    
                    console.log('Delete button clicked'); // Ini untuk debug

                    const masterId = this.id.replace('delete-button-', '');
                    const form = document.querySelector(`form.delete-form[action*="${masterId}"]`); // Menggunakan selector query

                    if (!form) {
                        console.error('Form not found for ID:', masterId); // Menampilkan pesan kesalahan jika form tidak ditemukan
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        backdrop: true,  // Menambahkan latar belakang gelap
                        allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Tunggu sebentar, sedang menghapus pengajuan.',
                                icon: 'info',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
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
                                        title: "Pengajuan Berhasil Dihapus",
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        backdrop: true,  // Menambahkan latar belakang gelap
                                        allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                                    }).then(() => {
                                        location.reload(); // Reload halaman setelah penghapusan berhasil
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi masalah saat menghapus data.',
                                        icon: 'error',
                                        backdrop: true,  // Menambahkan latar belakang gelap
                                        allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                                    });
                                }
                            }).catch(error => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan yang tidak terduga.',
                                    icon: 'error',
                                    backdrop: true,  // Menambahkan latar belakang gelap
                                    allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

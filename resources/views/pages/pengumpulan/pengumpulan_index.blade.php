<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('tugas.showDetailTugas', [$program->id, $tugas->id]) }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
            Back
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h4 class="text-2xl mb-4 font-bold dark:text-white">Pengajuan Tugas - {{ $tugas->judul }}</h4>

                    @if ($pengumpulans->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">Belum Ada Pengajuan.</p>
                    @else
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Username
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Judul
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Deskripsi
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            File
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Terakhir diubah
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumpulans as $index => $pengumpulan)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $pengumpulans->firstItem() + $index }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $pengumpulan->user->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $pengumpulan->judul }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $pengumpulan->deskripsi ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a
                                                    href="{{ route('pengumpulan.download', $pengumpulan->id) }}">{{ $pengumpulan->file }}</a>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $pengumpulan->updated_at->format('l, d-m-Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                                    <a href="{{ route('pengumpulan.edit', $pengumpulan->id) }}"
                                                        aria-current="page"
                                                        class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                        Edit
                                                    </a>
                                                    <form id="delete-form-{{ $pengumpulan->id }}"
                                                        action="{{ route('pengumpulan.destroy', [$program->id, $tugas->id, $pengumpulan->id]) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            id="delete-button-{{ $pengumpulan->id }}"
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
                    @endif
                    {{ $pengumpulans->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="delete-button-"]').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah pengiriman form langsung
                    console.log('Delete button clicked'); // Tambahkan ini untuk debug

                    const masterId = this.id.replace('delete-button-', '');
                    const form = document.getElementById('delete-form-' + masterId);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        backdrop: true, // Menambahkan latar belakang gelap
                        allowOutsideClick: false // Menonaktifkan klik di luar pop-up
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log(
                                'Confirmation received'); // Tambahkan ini untuk debug
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: new FormData(form)
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        backdrop: true, // Menambahkan latar belakang gelap
                                        allowOutsideClick: false // Menonaktifkan klik di luar pop-up
                                    }).then(() => {
                                        location
                                            .reload(); // Reload halaman setelah penghapusan berhasil
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi masalah saat menghapus data.',
                                        icon: 'error',
                                        backdrop: true, // Menambahkan latar belakang gelap
                                        allowOutsideClick: false // Menonaktifkan klik di luar pop-up
                                    });
                                }
                            }).catch(error => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan yang tidak terduga.',
                                    icon: 'error',
                                    backdrop: true, // Menambahkan latar belakang gelap
                                    allowOutsideClick: false // Menonaktifkan klik di luar pop-up
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

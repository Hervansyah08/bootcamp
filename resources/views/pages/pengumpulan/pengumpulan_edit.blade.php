<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pengajuan (Tugas)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="edit-form" action="{{ route('pengumpulan.update', $pengumpulan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="program_id" value="{{ $pengumpulan->program_id }}">
                        <input type="hidden" name="tugas_id" value="{{ $pengumpulan->tugas_id }}">
                        <div class="mb-4">
                            <label for="judul"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                                Pengumpulan</label>
                            <input type="text" name="judul" id="judul" value="{{ $pengumpulan->judul }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $pengumpulan->deskripsi }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file">Upload file (Opsional)</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" type="file" id="file" name="file">
                            @if ($pengumpulan->file)
                                <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">File
                                    saat
                                    ini: {{ $pengumpulan->file }}</p>
                            @endif
                        </div>
                        <div class="flex">
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <a href="{{ route('pengumpulan.index', [$pengumpulan->program_id, $pengumpulan->tugas_id]) }}"
                                    class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
                            @endif
                            @if (Auth::check() && Auth::user()->role == 'user')
                                <a href="{{ route('tugas.showDetailTugas', [$pengumpulan->program_id, $pengumpulan->tugas_id]) }}"
                                    class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
                            @endif
                            <button type="button" id="edit-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit
                                Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('edit-button').addEventListener('click', function() {
        const judul = document.getElementById('judul').value.trim();
        const fileInput = document.getElementById('file');
        const file = fileInput.files.length > 0 ? fileInput.files[0] : null;
        const maxFileSize = 20 * 1024 * 1024; // 20 MB
        const allowedFileFormats = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];

        // Mendapatkan peran pengguna dari Blade
        const userRole = "{{ Auth::user()->role }}";

        // Validasi kolom Judul
        if (!judul) {
            Swal.fire({
                title: 'Lengkapi Semua Kolom',
                text: 'Kolom Judul tidak boleh kosong.',
                icon: 'error',
                confirmButtonText: 'OK',
                backdrop: true,
                allowOutsideClick: false
            });
            return; 
        }

        // Validasi format file
        if (file) {
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedFileFormats.includes(fileExtension)) { // Menggunakan allowedFileFormats
            Swal.fire({
                title: 'Format File Tidak Didukung',
                text: `Format file yang diperbolehkan: ${allowedFileFormats.join(', ')}.`,
                icon: 'error',
                confirmButtonText: 'OK',
                backdrop: true,
                allowOutsideClick: false
            });
            return; 
        }

        // Validasi ukuran file
        if (file.size > maxFileSize) {
            Swal.fire({
                title: 'Ukuran File Terlalu Besar',
                text: 'Ukuran file melebihi batas maksimal: 20 MB.',
                icon: 'warning',
                confirmButtonText: 'OK',
                backdrop: true,
                allowOutsideClick: false
            });
            return;
        }
    }

        // Konfirmasi perubahan
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: 'Anda ingin menyimpan perubahan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            backdrop: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah perubahan pengajuan tugas.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    backdrop: true,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                const form = document.getElementById('edit-form');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                }).then(response => {
                    Swal.close(); 
                    if (response.ok) {
                        Swal.fire({
                            title: 'Pengumpulan Berhasil Diperbarui',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            backdrop: true,
                            allowOutsideClick: false
                        }).then(() => {
                            if (userRole === 'admin' || userRole === 'super_admin') {
                                window.location.href =
                                    "{{ route('pengumpulan.index', [$pengumpulan->program_id, $pengumpulan->tugas_id]) }}";
                            } else {
                                window.location.href =
                                    "{{ route('tugas.showDetailTugas', [$pengumpulan->program_id, $pengumpulan->tugas_id]) }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi masalah saat mengubah data.',
                            icon: 'error',
                            backdrop: true,
                            allowOutsideClick: false
                        });
                    }
                }).catch(error => {
                    Swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan yang tidak terduga.',
                        icon: 'error',
                        backdrop: true,
                        allowOutsideClick: false
                    });
                });
            }
        });
    });
    </script>
</x-app-layout>

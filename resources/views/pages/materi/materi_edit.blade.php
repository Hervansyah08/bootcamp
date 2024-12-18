<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Materi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-bold mb-3 dark:text-white">Edit materi untuk Program:
                        {{ $materi->program->nama }}
                    </h6>
                    <form id="edit-form" action="{{ route('materi.update', $materi->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="program_id" value="{{ $materi->program_id }}">
                        <div class="mb-3">
                            <label for="judul"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ $materi->judul }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $materi->deskripsi }}</textarea>
                        </div>

                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">File
                            (opsional)</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" type="file" id="file" name="file">
                        @if ($materi->file)
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">File saat
                                ini: {{ basename($materi->file) }}</p>
                        @endif
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="video">Video
                                (opsional)</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" type="file" id="video" name="video">
                            @if ($materi->video)
                                <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Video
                                    saat
                                    ini: {{ basename($materi->video) }}</p>
                            @endif
                        </div>
                        <div class="flex">
                            <a href="{{ route('materi.showByProgram', $materi->program_id) }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="edit-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit
                                Materi</button>
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
            const videoInput = document.getElementById('video');
            
            // Validasi format file yang diperbolehkan
            const allowedFileFormats = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
            const allowedVideoFormats = ['mp4', 'mov', 'ogg', 'qt', 'avi', 'mkv'];

            // Ambil file yang diupload
            const file = fileInput.files[0];
            const video = videoInput.files[0];

            // Fungsi untuk mendapatkan ekstensi file
            const getFileExtension = (fileName) => {
                return fileName.split('.').pop().toLowerCase();
            };

            // Validasi ukuran file dan video
            const maxFileSize = 20 * 1024 * 1024; // 20 MB
            const maxVideoSize = 300 * 1024 * 1024; // 300 MB

            let fileSizeValid = true;
            let videoSizeValid = true;

            if (file && file.size > maxFileSize) {
                fileSizeValid = false;
            }

            if (video && video.size > maxVideoSize) {
                videoSizeValid = false;
            }

            // Cek apakah judul kosong
            if (!judul) {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Judul tidak boleh kosong.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
                return; // Stop form submission if validation fails
            }

            // Validasi file
            if (file && !allowedFileFormats.includes(getFileExtension(file.name))) {
                Swal.fire({
                    title: 'Format File Tidak Valid',
                    text: `Format file : ${allowedFileFormats.join(', ')}`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
                return;
            }

            // Validasi video
            if (video && !allowedVideoFormats.includes(getFileExtension(video.name))) {
                Swal.fire({
                    title: 'Format Video Tidak Valid',
                    text: `Format video : ${allowedVideoFormats.join(', ')}`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
                return;
            }

            // Validasi ukuran file dan video
            if (!fileSizeValid) {
                Swal.fire({
                    title: 'Ukuran File Terlalu Besar',
                    text: `Ukuran file melebihi batas maksimal: 20 MB`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
                return;
            }

            if (!videoSizeValid) {
                Swal.fire({
                    title: 'Ukuran Video Terlalu Besar',
                    text: `Ukuran video melebihi batas maksimal: 300 MB`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
                return;
            }

            Swal.fire({
                title: 'Apakah anda yakin?',
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
                    // Menampilkan pop-up "Uploading..."
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Tunggu sebentar, sedang mengunggah perubahan materi.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false, // Tidak ada tombol konfirmasi
                        didOpen: () => {
                            Swal.showLoading(); // Menampilkan animasi loading
                        }
                    });

                    // Submit form with AJAX
                    const form = document.getElementById('edit-form');

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
                                title: 'Materi Berhasil Diperbarui',
                                icon: 'success',
                                confirmButtonText: 'Oke',
                                backdrop: true,
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href = "{{ route('materi.showByProgram', $materi->program_id) }}";
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

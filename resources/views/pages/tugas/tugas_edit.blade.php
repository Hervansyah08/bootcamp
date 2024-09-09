<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-bold mb-3 dark:text-white">Edit tugas untuk Program:
                        {{ $tugas->program->nama }}
                    </h6>
                    <form id="edit-form" action="{{ route('tugas.update', $tugas->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="program_id" value="{{ $tugas->program_id }}">
                        <div class="mb-3">
                            <label for="judul"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ $tugas->judul }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $tugas->deskripsi }}</textarea>
                        </div>

                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">File
                            (opsional)</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" type="file" id="file" name="file">
                        @if ($tugas->file)
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">File saat
                                ini: {{ basename($tugas->file) }}</p>
                        @endif
                        <div class="mb-5">
                            <label for="deadline"
                                class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Deadline</label>
                            <input type="datetime-local" id="deadline" name="deadline"
                                value="{{ old('deadline', $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i') : '') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="flex">
                            <a href="{{ route('tugas.showByProgram', $tugas->program_id) }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="edit-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit
                                Tugas</button>
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
            const deadline = document.getElementById('deadline').value.trim();
            const fileInput = document.getElementById('file');
            const allowedFileTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
            const maxFileSize = 20 * 1024 * 1024; // 20 MB
            let fileTypeValid = true;
            let fileSizeValid = true;

            // Cek tipe file dan ukuran file jika ada file yang diupload
            if (fileInput.files.length > 0) {
                const fileExtension = fileInput.files[0].name.split('.').pop().toLowerCase();
                if (!allowedFileTypes.includes(fileExtension)) {
                    fileTypeValid = false;
                }

                // Validasi ukuran file
                if (fileInput.files[0].size > maxFileSize) {
                    fileSizeValid = false;
                }
            }

            if (!judul && !deadline && !fileInput.files.length) {
                Swal.fire({
                    title: 'Kolom Kosong',
                    text: 'Kolom Judul, Deadline, dan File masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            if (!judul && !deadline) {
                Swal.fire({
                    title: 'Kolom Kosong',
                    text: 'Kolom Judul dan Deadline masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            if (!judul) {
                Swal.fire({
                    title: 'Kolom Judul Kosong',
                    text: 'Kolom Judul masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            if (!deadline) {
                Swal.fire({
                    title: 'Kolom Deadline Kosong',
                    text: 'Kolom Deadline masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            if (!fileTypeValid && fileInput.files.length > 0) {
                Swal.fire({
                    title: 'Format File Tidak Didukung',
                    text: 'Silakan unggah file dengan format: pdf, doc, docx, ppt, pptx, zip, rar.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            if (!fileSizeValid && fileInput.files.length > 0) {
                Swal.fire({
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file melebihi batas maksimal: 20 MB.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
                return;
            }

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda ingin menyimpan perubahan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menampilkan pop-up "Uploading..."
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Tunggu sebentar, sedang mengunggah perubahan tugas.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form dengan AJAX
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
                        Swal.close(); // Menutup pop-up "Uploading..." setelah mendapat respon

                        if (response.ok) {
                            Swal.fire({
                                title: 'Data berhasil diubah!',
                                icon: 'success',
                                confirmButtonText: 'Oke',
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href = "{{ route('tugas.showByProgram', $tugas->program_id) }}"; // Redirect setelah berhasil
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi masalah saat mengubah data.',
                                icon: 'error',
                                allowOutsideClick: false
                            });
                        }
                    }).catch(error => {
                        Swal.close(); // Menutup pop-up "Uploading..." jika ada error

                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan yang tidak terduga.',
                            icon: 'error',
                            allowOutsideClick: false
                        });
                    });
                }
            });
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-bold mb-3 dark:text-white">Tambah Tugas untuk Program: {{ $program->nama }}</h6>
                    <form id="tugas-form" action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <div class="mb-3">
                            <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="judul" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file">Upload file</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" type="file" id="file" name="file" required>
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Format: pdf,doc,docx,ppt,pptx,zip,rar | Ukuran Maksimal : 20 MB</p>
                        </div>
                        <div class="mb-5">
                            <label for="deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Deadline</label>
                            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline', $tugas->deadline ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="flex">
                            <a href="{{ route('tugas.showByProgram', $program->id) }}" class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="simpan-button" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Upload Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('simpan-button').addEventListener('click', function() {
            const judul = document.getElementById('judul').value.trim();
            const fileInput = document.getElementById('file');
            const deadline = document.getElementById('deadline').value.trim();

            const file = fileInput.files.length;
            const allowedFileTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
            const maxFileSize = 20 * 1024 * 1024; // 20 MB
            let fileTypeValid = true;
            let fileSizeValid = true;

            if (file > 0) {
                const fileExtension = fileInput.files[0].name.split('.').pop().toLowerCase();
                if (!allowedFileTypes.includes(fileExtension)) {
                    fileTypeValid = false;
                }

                // Validasi ukuran file
                if (fileInput.files[0].size > maxFileSize) {
                    fileSizeValid = false;
                }
            }

            // Check for each condition independently and show appropriate alert
            if (judul === '' && file === 0 && deadline === '') {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom Judul, File, dan Deadline masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (judul === '' && file === 0) {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom Judul dan File masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (file === 0 && deadline === '') {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom File dan Deadline masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (judul === '' && deadline === '') {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom Judul dan Deadline masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (judul === '') {
                Swal.fire({
                    title: "Judul Masih Kosong",
                    text: "Silakan isi judul untuk tugas.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (file === 0) {
                Swal.fire({
                    title: "File Masih Kosong",
                    text: "Silakan unggah File.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (deadline === '') {
                Swal.fire({
                    title: "Deadline Masih Kosong",
                    text: "Silakan isi deadline untuk tugas.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!fileTypeValid) {
                Swal.fire({
                    title: "Format File Tidak Didukung",
                    text: "Silakan unggah file dengan format: pdf, doc, docx, ppt, pptx, zip, rar.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!fileSizeValid) {
                Swal.fire({
                    title: "Ukuran File Terlalu Besar",
                    text: "Ukuran file melebihi batas maksimal: 20 MB.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else {
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah tugas.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Kirim form menggunakan AJAX
                const form = document.getElementById('tugas-form');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Mengirimkan token CSRF
                    }
                })
                .then(response => {
                    Swal.close(); // Tutup pop-up loading
                    if (response.ok) {
                        Swal.fire({
                            title: "Tugas Berhasil Ditambah",
                            icon: "success",
                            confirmButtonText: "OK",
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('tugas.showByProgram', $program->id) }}"; // Redirect setelah sukses
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat mengunggah materi.",
                            icon: "error",
                            confirmButtonText: "OK",
                            allowOutsideClick: false
                        });
                    }
                })
                .catch(error => {
                    Swal.close(); // Tutup pop-up loading jika ada error
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan saat mengunggah materi.",
                        icon: "error",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                });
            }
        });
    </script>
</x-app-layout>

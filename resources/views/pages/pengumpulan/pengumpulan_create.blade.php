<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kirimkan Pengajuan (Tugas)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="submission-form" action="{{ route('pengumpulan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                            <div class="mb-4">
                                <label for="user_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                <select id="user_id" name="user_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" selected>Pilih User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="mb-4">
                            <label for="judul"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                                Pengumpulan</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file">Upload file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" type="file" id="file" name="file"
                                required>
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Format:
                                pdf,doc,docx,ppt,pptx,zip,rar | Ukuran Maksimal : 20 MB</p>
                        </div>
                        <div class="flex">
                            <a href="{{ route('tugas.showDetailTugas', [$program->id, $tugas->id]) }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>

                            <button type="button" id="simpan-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Submit
                                Pengumpulan</button>
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
            const file = fileInput.files.length;
            const user_id = document.getElementById('user_id') ? document.getElementById('user_id').value : null;

            // Mendapatkan peran pengguna dari variabel JavaScript
            const userRole = @json(Auth::user()->role);

            // Daftar format file yang diizinkan
            const allowedFileTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
            const maxFileSize = 20 * 1024 * 1024; // 20 MB
            let fileTypeValid = true;
            let fileSizeValid = true;

            // Jika ada file yang diunggah, periksa ekstensi file dan ukuran file
            if (file > 0) {
                const fileExtension = fileInput.files[0].name.split('.').pop().toLowerCase();
                if (!allowedFileTypes.includes(fileExtension)) {
                    fileTypeValid = false;
                }
                if (fileInput.files[0].size > maxFileSize) {
                    fileSizeValid = false;
                }
            }

            // Validasi berdasarkan peran pengguna
            if (userRole === 'admin' || userRole === 'super_admin') {
                if (user_id === null || user_id === '') {
                    Swal.fire({
                        title: "Pilih User",
                        text: "Silakan pilih User.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else if (judul === '' && file === 0) {
                    Swal.fire({
                        title: "Lengkapi Semua Kolom",
                        text: "Isi Judul, dan Unggah File.",
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
                } else if (judul === '') {
                    Swal.fire({
                        title: "Kolom Judul Masih Kosong",
                        text: "Silakan isi kolom Judul.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else if (file === 0) {
                    Swal.fire({
                        title: "Kolom File Masih Kosong",
                        text: "Silakan unggah File.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else {
                    submitForm();
                }
            } else {
                // Validasi untuk user biasa
                if (judul === '' && file === 0) {
                    Swal.fire({
                        title: "Lengkapi Semua Kolom",
                        text: "Isi Judul dan Unggah File.",
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
                } else if (judul === '') {
                    Swal.fire({
                        title: "Kolom Judul Masih Kosong",
                        text: "Silakan isi kolom Judul.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else if (file === 0) {
                    Swal.fire({
                        title: "Kolom File Masih Kosong",
                        text: "Silakan unggah File.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else {
                    submitForm();
                }
            }
        });

        function submitForm() {
            // Tampilkan pop-up "Uploading..."
            Swal.fire({
                title: 'Uploading...',
                text: 'Tunggu sebentar, sedang mengunggah pengajuan tugas.',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim form menggunakan AJAX
            const form = document.getElementById('submission-form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                Swal.close(); // Tutup pop-up loading
                if (response.ok) {
                    Swal.fire({
                        title: "Pengajuan Berhasil Dikirim",
                        icon: "success",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('tugas.showDetailTugas', [$program->id, $tugas->id]) }}"; // Redirect setelah sukses
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Terjadi kesalahan saat mengirim pengajuan.",
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
                    text: "Terjadi kesalahan saat mengirim pengajuan.",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            });
        }
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Materi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-bold mb-3 dark:text-white">Tambah Materi untuk Program: {{ $program->nama }}
                    </h6>
                    <form id="materi-form" action="{{ route('materi.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <div class="mb-3">
                            <label for="judul"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="judul" id="judul"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file">Upload file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" type="file" id="file" name="file"
                                required>
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Format:
                                pdf,doc,docx,ppt,pptx,zip,rar | Ukuran Maksimal : 20 MB</p>
                        </div>
                        <div class="mb-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="video">Upload Video</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help" type="file" id="video" name="video"
                                required>
                            <p class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Format:
                                mp4,mov,ogg,qt,avi,mkv | Ukuran Maksimal : 300 MB</p>
                        </div>

                        <div class="flex">
                            <a href="{{ route('materi.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="simpan-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Upload
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
        document.getElementById('simpan-button').addEventListener('click', function() {
            const judul = document.getElementById('judul').value.trim();
            const fileInput = document.getElementById('file');
            const videoInput = document.getElementById('video');

            const file = fileInput.files[0];
            const video = videoInput.files[0];

            // Allowed file types and sizes
            const allowedFileTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
            const allowedVideoTypes = ['mp4', 'mov', 'ogg', 'qt', 'avi', 'mkv'];
            const maxFileSize = 20 * 1024 * 1024; // 20 MB
            const maxVideoSize = 300 * 1024 * 1024; // 300 MB

            let fileTypeValid = true;
            let videoTypeValid = true;
            let fileSizeValid = true;
            let videoSizeValid = true;

            // Check file type and size
            if (file) {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (!allowedFileTypes.includes(fileExtension)) {
                    fileTypeValid = false;
                }
                if (file.size > maxFileSize) {
                    fileSizeValid = false;
                }
            }

            // Check video type and size
            if (video) {
                const videoExtension = video.name.split('.').pop().toLowerCase();
                if (!allowedVideoTypes.includes(videoExtension)) {
                    videoTypeValid = false;
                }
                if (video.size > maxVideoSize) {
                    videoSizeValid = false;
                }
            }

            // Check each condition
            if (judul === '' && !file && !video) {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom Judul, File, dan Video masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (judul === '' && !file) {
                Swal.fire({
                    title: "Lengkapi Kolom",
                    text: "Kolom Judul dan File masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (judul === '' && !video) {
                Swal.fire({
                    title: "Lengkapi Kolom",
                    text: "Kolom Judul dan Video masih kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!file && !video) {
                Swal.fire({
                    title: "Lengkapi Kolom",
                    text: "Kolom File dan Video masih kosong.",
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
            } else if (!file) {
                Swal.fire({
                    title: "Kolom File Masih Kosong",
                    text: "Silakan unggah File.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!video) {
                Swal.fire({
                    title: "Kolom Video Masih Kosong",
                    text: "Silakan unggah Video.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!fileTypeValid) {
                Swal.fire({
                    title: "Format File Tidak Valid",
                    text: `Format file : ${allowedFileTypes.join(', ')}`,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!videoTypeValid) {
                Swal.fire({
                    title: "Format Video Tidak Valid",
                    text: `Format video : ${allowedVideoTypes.join(', ')}`,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!fileSizeValid) {
                Swal.fire({
                    title: "Ukuran File Terlalu Besar",
                    text: `Ukuran file melebihi batas maksimal: 20 MB`,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else if (!videoSizeValid) {
                Swal.fire({
                    title: "Ukuran Video Terlalu Besar",
                    text: `Ukuran video melebihi batas maksimal: 300 MB`,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } else {
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah materi.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Use AJAX to submit the form and handle the response
                const form = document.getElementById('materi-form');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    Swal.close(); // Close loading popup
                    if (response.ok) {
                        Swal.fire({
                            title: "Materi Berhasil Ditambah",
                            icon: "success",
                            confirmButtonText: "OK",
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('materi.index') }}"; // Redirect on success
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
                    Swal.close(); // Close loading popup on error
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

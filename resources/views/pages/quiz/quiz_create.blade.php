<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-bold mb-3 dark:text-white">Tambah Quiz untuk Program:
                        {{ $program->nama }}
                    </h6>
                    <form id="quiz-form" action="{{ route('quiz.store') }}" method="POST" novalidate>
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
                            <label for="detail"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail
                                (Opsional)</label>
                            <textarea name="detail" id="detail" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="link"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Link
                            </label>
                            <textarea name="link" id="link" rows="4" required
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>

                        <div class="flex">
                            <a href="{{ route('quiz.showByProgram', $program->id) }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="submit" id="simpan-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('quiz-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Stop form submission

            const judul = document.getElementById('judul').value.trim();
            const link = document.getElementById('link').value.trim();

            if (judul === '' && link === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Judul dan Link masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (judul === '') {
                Swal.fire({
                    title: 'Kolom Judul Masih Kosong',
                    text: 'Kolom Judul tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (link === '') {
                Swal.fire({
                    title: 'Kolom Link Kosong',
                    text: 'Kolom Link tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else {
                // Tampilkan pop-up 'Uploading...'
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah quiz.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Menampilkan indikator loading
                    }
                });

                // Submit form dengan AJAX
                const form = document.getElementById('quiz-form');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        Swal.fire({
                            title: 'Quiz Berhasil Ditambah',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            backdrop: true,
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.href = "{{ route('quiz.showByProgram', $program->id) }}";
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menambahkan jadwal kelas.',
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
    </script>
</x-app-layout>

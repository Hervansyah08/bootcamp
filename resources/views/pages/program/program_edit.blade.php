<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="edit-form" action="{{ route('program.update', $program->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Program</label>
                            <input type="text" name="nama" id="nama" value="{{ $program->nama }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $program->deskripsi }}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option value="Active" {{ $program->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $program->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="flex">
                            <a href="{{ route('program.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="edit-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
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
            const nama = document.getElementById('nama').value.trim();

            // Validasi untuk kolom 'nama'
            if (!nama) {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama Program tidak boleh kosong.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: true,  // Menambahkan latar belakang gelap
                    allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                });
                return; // Stop form submission if validation fails
            }

            // Konfirmasi sebelum mengirimkan form
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda ingin menyimpan perubahan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                backdrop: true,  // Menambahkan latar belakang gelap
                allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Tunggu sebentar, sedang mengunggah perubahan program.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        backdrop: true,
                        willOpen: () => {
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
                        if (response.ok) {
                            Swal.fire({
                                title: 'Program Berhasil Diperbarui',
                                icon: 'success',
                                confirmButtonText: 'Oke',
                                backdrop: true,  // Menambahkan latar belakang gelap
                                allowOutsideClick: false  // Menonaktifkan klik di luar pop-up
                            }).then(() => {
                                window.location.href = "{{ route('program.index') }}"; // Redirect setelah berhasil
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi masalah saat mengubah data.',
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
    </script>
</x-app-layout>

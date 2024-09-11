<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="program-form" action="{{ route('program.store') }}" method="POST">
                        @csrf
                        @if (Auth::user()->role === 'super_admin')
                            <div class="mb-6">
                                <label for="user_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Username Admin</label>
                                <select id="user_id" name="user_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Admin</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="mb-6">
                            <label for="nama"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Program</label>
                            <input type="text" name="nama" id="nama"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="flex">
                            <a href="{{ route('program.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button id="simpan-button" type="button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('simpan-button').addEventListener('click', function () {
            const nama = document.getElementById('nama').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const user_id = document.getElementById('user_id') ? document.getElementById('user_id').value : '';

            if (user_id === 'Pilih Admin') {
                Swal.fire({
                    title: "Pilih Admin Terlebih Dahulu",
                    text: "Anda harus memilih admin sebelum melanjutkan.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (nama === '') {
                Swal.fire({
                    title: "Lengkapi Semua Kolom",
                    text: "Kolom Nama Program tidak boleh kosong.",
                    icon: "warning",
                    confirmButtonText: "OK",
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else {
                // Tampilkan pop-up 'Uploading...'
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah program.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Menampilkan indikator loading
                    }
                });

                // Submit form dengan AJAX
                const form = document.getElementById('program-form');
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
                            title: 'Program Berhasil Ditambah.',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            backdrop: true,
                            allowOutsideClick: false
                        }).then(() => {
                            // Redirect atau lakukan aksi lain setelah sukses
                            window.location.href = "{{ route('program.index') }}"; // Sesuaikan dengan URL yang diinginkan
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data.',
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="user-form" action="{{ route('user.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-6">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            </label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <div class="mb-6">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <div class="mb-6">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <div class="flex items-center mt-4">
                            <input id="show_password" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="show_password" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Show Passwords') }}</label>
                        </div>
                        <div class="flex mt-4">
                            <a href="{{ route('user.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button id="simpan-button" type="submit"
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
        document.getElementById('user-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Stop form submission

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

            if (name === '' && email === '' && password === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Semua kolom masih kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && email === '' && password === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama, Email dan Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && email === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama, Email dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && password === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama, Password dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (email === '' && password === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Email, Password dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && email === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama dan Email tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (email === '' && password === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Email dan Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (email === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Email dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && password === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama dan Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom Nama dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (password === '' && passwordConfirmation === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Kolom password dan Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (name === '') {
                Swal.fire({
                    title: 'Kolom Nama Kosong',
                    text: 'Kolom Nama tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (email === '') {
                Swal.fire({
                    title: 'Kolom Email Kosong',
                    text: 'Kolom Email tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (password === '') {
                Swal.fire({
                    title: 'Kolom Password Kosong',
                    text: 'Kolom Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (passwordConfirmation === '') {
                Swal.fire({
                    title: 'Kolom Confirm Password Kosong',
                    text: 'Kolom Confirm Password tidak boleh kosong.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else if (password !== passwordConfirmation) {
                Swal.fire({
                    title: 'Password Tidak Sama',
                    text: 'Kolom Password dan Confirm password tidak sama.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    backdrop: true,
                    allowOutsideClick: false
                });
            } else {
                // Tampilkan pop-up 'Uploading...'
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah data user.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Menampilkan indikator loading
                    }
                });

                // Submit form dengan AJAX
                const form = document.getElementById('user-form');
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
                            title: 'User Berhasil Ditambah.',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            backdrop: true,
                            allowOutsideClick: false
                        }).then(() => {
                            // Redirect atau lakukan aksi lain setelah sukses
                            window.location.href = "{{ route('user.index') }}"; // Sesuaikan dengan URL yang diinginkan
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


        document.getElementById('show_password').addEventListener('change', function () {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const isChecked = this.checked;
            passwordInput.type = isChecked ? 'text' : 'password';
            passwordConfirmationInput.type = isChecked ? 'text' : 'password';
        });
    </script>
</x-app-layout>

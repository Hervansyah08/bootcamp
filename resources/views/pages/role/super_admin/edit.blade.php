<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Super Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="edit-form" action="{{ route('super-admin.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            </label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <div class="mb-6">
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <select id="role" name="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User
                                </option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super
                                    Admin
                                </option>
                            </select>
                        </div>
                        <div class="flex">
                            <a href="{{ route('super-admin.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="submit" id="edit-button"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('edit-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Stop form submission

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();

            if (name === '' && email === '') {
                Swal.fire({
                    title: 'Lengkapi Semua Kolom',
                    text: 'Semua kolom masih kosong.',
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
            } else {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda ingin menyimpan perubahan ini?",
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
                            text: 'Tunggu sebentar, sedang mengunggah perubahan super admin.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            backdrop: true,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form with AJAX
                        const form = document.getElementById('edit-form');
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
                                    title: 'Super Admin Berhasil Diperbarui',
                                    icon: 'success',
                                    confirmButtonText: 'Oke',
                                    backdrop: true,
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = "{{ route('super-admin.index') }}";
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menambahkan data user.',
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
            }
        });
    </script>
</x-app-layout>

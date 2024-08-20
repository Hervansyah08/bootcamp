<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="edit-form" action="{{ route('master.update', $master->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email</label>
                                <input type="email" id="email" name="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->email }}" required />
                            </div>
                            <div>
                                <label for="nama"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Nama</label>
                                <input type="text" id="nama" name="nama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->nama }}" required />
                            </div>
                            <div>
                                <label for="gender"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                                    Kelamin</label>
                                <select id="gender" name="gender"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="Pria" {{ $master->gender == 'Pria' ? 'selected' : '' }}>Pria
                                    </option>
                                    <option value="Wanita" {{ $master->gender == 'Wanita' ? 'selected' : '' }}>Wanita
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="tanggal_lahir "
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->tanggal_lahir }}" required />
                            </div>
                            <div>
                                <label for="alamat"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Alamat</label>
                                <input type="text" id="alamat" name="alamat"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->alamat }}" required />
                            </div>
                            <div>
                                <label for="no_hp"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No HP</label>
                                <input type="text" id="no_hp" name="no_hp"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->no_hp }}" required />
                            </div>
                            <div>
                                <label for="status_pekerjaan"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Status Pekerjaan</label>
                                <select id="status_pekerjaan" name="status_pekerjaan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Status Pekerjaan</option>
                                    <option value="Pelajar"
                                        {{ $master->status_pekerjaan == 'Pelajar' ? 'selected' : '' }}>Pelajar</option>
                                    <option value="Fresh Graduate"
                                        {{ $master->status_pekerjaan == 'Fresh Graduate' ? 'selected' : '' }}>Fresh
                                        Graduate</option>
                                    <option value="Karyawan"
                                        {{ $master->status_pekerjaan == 'Karyawan' ? 'selected' : '' }}>Karyawan
                                    </option>
                                    <option value="Lain - Lain"
                                        {{ $master->status_pekerjaan == 'Lain - Lain' ? 'selected' : '' }}>Lain - Lain
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="instansi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instansi</label>
                                <input type="text" id="instansi" name="instansi"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $master->instansi }}" required />
                            </div>
                            <div>
                                <label for="program_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Pilih Program</label>
                                <select id="program_id" name="program_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Program</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}"
                                            {{ $master->program_id == $program->id ? 'selected' : '' }}>
                                            {{ $program->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="info"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Darimana Anda
                                    Mengetahui Program Ini</label>
                                <select id="info" name="info"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih</option>
                                    <option value="Facebook" {{ $master->info == 'Facebook' ? 'selected' : '' }}>
                                        Facebook
                                    </option>
                                    <option value="Instagram" {{ $master->info == 'Instagram' ? 'selected' : '' }}>
                                        Instagram</option>
                                    <option value="Twitter" {{ $master->info == 'Twitter' ? 'selected' : '' }}>
                                        Twitter</option>
                                    <option value="Teman / Keluarga"
                                        {{ $master->info == 'Teman / Keluarga' ? 'selected' : '' }}>Teman / Keluarga
                                    </option>
                                    <option value="Lain - Lain" {{ $master->info == 'Lain - Lain' ? 'selected' : '' }}>
                                        Lain - Lain
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="tipe_kelas"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                                    Kelas (Opsional)</label>
                                <select id="tipe_kelas" name="tipe_kelas"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Kelas</option>
                                    <option value="Course" {{ $master->tipe_kelas == 'Course' ? 'selected' : '' }}>
                                        Course
                                    </option>
                                    <option value="Lengkap" {{ $master->tipe_kelas == 'Lengkap' ? 'selected' : '' }}>
                                        Lengkap</option>
                                    <option value="Dokumen" {{ $master->tipe_kelas == 'Dokumen' ? 'selected' : '' }}>
                                        Dokumen</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="motivasi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivasi
                                (Opsional)</label>
                            <textarea id="motivasi" name="motivasi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $master->motivasi }}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option selected>Pilih</option>
                                <option value="Active" {{ $master->status == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="Pending" {{ $master->status == 'Pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="Inactive" {{ $master->status == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        <div class="flex">
                            <a href="{{ route('master.index') }}"
                                class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                            <button type="button" id="edit-button"
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
        document.getElementById('edit-button').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda ingin menyimpan perubahan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form with AJAX
                    const form = document.getElementById('edit-form');

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new FormData(form)
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: 'Data berhasil diubah!',
                                icon: 'success',
                                confirmButtonText: 'Oke'
                            }).then(() => {
                                window.location.href =
                                    "{{ route('master.index') }}"; // Redirect setelah berhasil
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi masalah saat mengubah data.',
                                icon: 'error'
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan yang tidak terduga.',
                            icon: 'error'
                        });
                    });
                }
            });
        });
    </script>
</x-app-layout>

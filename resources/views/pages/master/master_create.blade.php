<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="registrationForm" action="{{ route('master.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                                <div>
                                    <label for="user_id"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Username</label>
                                    <select id="user_id" name="user_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option selected>Pilih User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email</label>
                                <input type="email" id="email" name="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
                            </div>
                            <div>
                                <label for="nama"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Nama</label>
                                <input type="text" id="nama" name="nama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
                            </div>
                            <div>
                                <label for="gender"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                                    Kelamin</label>
                                <select id="gender" name="gender"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <div>
                                <label for="tanggal_lahir "
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
                            </div>
                            <div>
                                <label for="alamat"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Alamat</label>
                                <input type="text" id="alamat" name="alamat"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
                            </div>
                            <div>
                                <label for="no_hp"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No
                                    HP</label>
                                <input type="text" id="no_hp" name="no_hp"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
                            </div>
                            <div>
                                <label for="status_pekerjaan"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Status Pekerjaan</label>
                                <select id="status_pekerjaan" name="status_pekerjaan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Status Pekerjaan</option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Fresh Graduate">Fresh Graduate</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Lain - Lain">Lain - Lain</option>
                                </select>
                            </div>
                            <div>
                                <label for="instansi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instansi</label>
                                <input type="text" id="instansi" name="instansi"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required />
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
                                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="info"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Darimana
                                    Anda
                                    Mengetahui Program Ini</label>
                                <select id="info" name="info"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="Teman / Keluarga">Teman / Keluarga</option>
                                    <option value="Lain - Lain">Lain - Lain</option>
                                </select>
                            </div>
                            <div>
                                <label for="tipe_kelas"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                                    Kelas</label>
                                <select id="tipe_kelas" name="tipe_kelas"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Pilih Kelas</option>
                                    <option value="Course">Course</option>
                                    <option value="Lengkap">Lengkap</option>
                                    <option value="Dokumen">Dokumen</option>
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <label for="motivasi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivasi
                                (Opsional)</label>
                            <textarea id="motivasi" name="motivasi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                </div>
                <div class="flex ml-6 mb-4">
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                        <a href="{{ route('master.index') }}"
                            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                    @endif
                    @if (Auth::user()->role == 'user')
                        <a href="{{ route('dashboard') }}"
                            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Batal</a>
                    @endif

                    <button type="submit"
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah submit form default

                // Mendapatkan nilai dari elemen form
                const email = document.getElementById('email').value;
                const nama = document.getElementById('nama').value;
                const tanggal_lahir = document.getElementById('tanggal_lahir').value;
                const alamat = document.getElementById('alamat').value;
                const no_hp = document.getElementById('no_hp').value;
                const status_pekerjaan = document.getElementById('status_pekerjaan').value;
                const instansi = document.getElementById('instansi').value;
                const gender = document.getElementById('gender').value;
                const program_id = document.getElementById('program_id').value;
                const info = document.getElementById('info').value;
                const tipe_kelas = document.getElementById('tipe_kelas').value;

                // Buat array untuk menyimpan pesan error
                let errors = [];

                // Cek apakah field kosong atau pilihannya adalah opsi placeholder
                if (!email) errors.push('Kolom Email masih kosong.');
                if (!nama) errors.push('Kolom Nama masih kosong.');
                if (!tanggal_lahir) errors.push('Kolom Tanggal Lahir masih kosong.');
                if (!alamat) errors.push('Kolom Alamat masih kosong.');
                if (!no_hp) errors.push('Kolom No HP masih kosong.');
                if (gender === 'Pilih Jenis Kelamin') errors.push('Kolom Jenis Kelamin harus dipilih.');
                if (status_pekerjaan === 'Pilih Status Pekerjaan') errors.push('Kolom Status Pekerjaan harus dipilih.');
                if (!instansi) errors.push('Kolom Instansi masih kosong.');
                if (program_id === 'Pilih Program') errors.push('Kolom Program harus dipilih.');
                if (info === 'Pilih') errors.push('Kolom Informasi sumber harus dipilih.');
                if (tipe_kelas === 'Pilih Kelas') errors.push('Kolom Tipe Kelas harus dipilih.');

                // Jika ada error, tampilkan pesan dan hentikan submit form
                if (errors.length > 0) {
                    Swal.fire({
                        title: 'Lengkapi Semua Kolom',
                        html: errors.join('<br>'),
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                    return; // Hentikan submit form
                }

                // Tampilkan pesan "Uploading..." setelah semua kolom terisi
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Tunggu sebentar, sedang mengunggah data.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form menggunakan Axios
                axios.post('{{ route('master.store') }}', new FormData(this))
                    .then(response => {
                        console.log(response.data); // Debugging response

                        // Hapus pesan "Uploading..." setelah proses selesai
                        Swal.close();

                        const userRole = '{{ Auth::user()->role }}';

                        if (userRole === 'admin' || userRole === 'super_admin') {
                            Swal.fire({
                                title: 'Pendaftaran Berhasil',
                                icon: 'success',
                                confirmButtonText: 'OKE',
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('master.index') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Pendaftaran Berhasil',
                                text: 'Tekan "OKE" untuk melakukan konfirmasi pendaftaran dan pembayaran. Terima Kasih.',
                                icon: 'success',
                                confirmButtonText: 'OKE',
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const message =
                                        `Saya ingin melakukan konfirmasi pendaftaran dan pembayaran.%0AEmail : ${encodeURIComponent(email)}%0ANama : ${encodeURIComponent(nama)}%0ATerimakasih.`;
                                    console.log(message); // Debugging WhatsApp message
                                    window.location.href =
                                        `https://wa.me/6281803354180?text=${message}`;
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error during form submission:', error);
                        console.log(error.response); // Debugging error response
                        Swal.close(); // Hapus pesan "Uploading..." jika ada error
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    });
            });
        });
    </script>
</x-app-layout>

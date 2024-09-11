<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('materi.index') }}"
            class="mr-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Back</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl lg:max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold mb-5 dark:text-white">Materi untuk Program: {{ $program->nama }}</h3>
                    @forelse($materis as $materi)
                        <div class="mb-3 mt-5">
                            <h4 class="text-2xl mb-2 font-bold dark:text-white">{{ $materi->judul }}</h4>
                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                    Edit by {{ $materi->user?->name ?? 'deleted' }}
                                    <br>
                                    Tanggal Input {{ $materi->created_at->format('l, d-m-Y, H:i') }}
                                    <br>
                                    Tanggal Edit {{ $materi->updated_at->format('l, d-m-Y, H:i') }}
                                </p>
                            @endif
                            <p class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ $materi->deskripsi }}
                            </p>
                            <div class="mb-3">
                                <!-- Logika untuk menampilkan file atau video berdasarkan tipe_kelas -->
                                @if ($tipeKelas == 'all' || $tipeKelas == 'Dokumen' || $tipeKelas == 'Lengkap')
                                    @if ($materi->file)
                                        <a href="{{ route('materi.download', $materi->id) }}"
                                            class="inline-flex items-center text-lg text-blue-600 dark:text-blue-500 hover:underline">
                                            Download Materi
                                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </a>
                                    @endif
                                @endif
                            </div>

                            <div class="mb-4">
                                @if ($tipeKelas == 'all' || $tipeKelas == 'Course' || $tipeKelas == 'Lengkap')
                                    @if ($materi->video)
                                        <button type="button" data-modal-target="video-modal-{{ $materi->id }}"
                                            data-modal-toggle="video-modal-{{ $materi->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Lihat Video
                                        </button>

                                        <!-- Modal -->
                                        <div id="video-modal-{{ $materi->id }}" tabindex="-1"
                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                            <div class="relative w-full h-full max-w-2xl md:h-auto">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <div
                                                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Video Materi
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-toggle="video-modal-{{ $materi->id }}">
                                                            <svg class="w-5 h-5" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M1 1l12 12M1 13L13 1" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <div class="p-6 space-y-6">
                                                        <video class="w-full" autoplay muted controls
                                                            controlsList="nodownload">
                                                            <source
                                                                src="{{ route('materi.streamVideo', basename($materi->video)) }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'))
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="{{ route('materi.edit', $materi->id) }}" aria-current="page"
                                        class="px-4 py-2 text-sm font-medium rounded-s-lg focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                        Edit
                                    </a>
                                    <form action="{{ route('materi.destroy', $materi->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="px-4 py-2 text-sm font-medium rounded-e-lg focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 delete-button">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="mt-3 text-gray-500 dark:text-gray-400">Belum ada materi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah pengiriman form langsung

                const form = this.closest('form');

                Swal.fire({
                    title: "Apa anda yakin?",
                    text: "Data yang sudah terhapus tidak dapat dikembalikan!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus",
                    backdrop: true, // Menampilkan latar belakang gelap
                    allowOutsideClick: false // Mencegah klik di luar pop-up
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Tunggu sebentar, sedang menghapus materi.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Gunakan AJAX untuk mengirim form
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
                                    title: "Materi Berhasil Dihapus",
                                    icon: "success",
                                    confirmButtonText: "Oke",
                                    backdrop: true, // Menampilkan latar belakang gelap
                                    allowOutsideClick: false // Mencegah klik di luar pop-up
                                }).then(() => {
                                    location.reload(); // Reload halaman setelah penghapusan berhasil
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi masalah saat menghapus data.",
                                    icon: "error"
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: "Terjadi kesalahan yang tidak terduga.",
                                icon: "error"
                            });
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Madjou Skill Academy') }}
        </h2>
    </x-slot>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class=" text-center mb-3 text-5xl font-extrabold dark:text-white">Bootcamp Program</h1>
                    <p
                        class="mb-10 text-lg text-center font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                        Berkarir di bidang impian melalui Madjou Skill Academy</p>
                    <div class="grid grid-cols-1  lg:grid-cols-2 justify-center">
                        @foreach ($programs as $program)
                            <div
                                class="max-w-md p-6 mx-auto mb-7 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="{{ route('master.create') }}">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $program->nama }}
                                    </h5>
                                </a>

                                <p class="mb-2 text-lg text-gray-500 md:text-xl dark:text-gray-400">
                                    {{ $program->deskripsi }}
                                </p>

                                <a href="{{ route('master.create') }}"
                                    class="inline-flex mt-3 items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Let's Join
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="text-4xl text-center font-extrabold dark:text-white mb-8">Our Class Program</h2>
                    <div class="flex flex-wrap mb-7 justify-center gap-10">
                        <!-- Kelas Dokumen -->
                        <div
                            class="max-w-md lg:max-w-xs p-6  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Dokumen</h3>
                            <p class="mb-4 text-gray-700 dark:text-gray-300">
                                Kelas ini hanya menyediakan materi dalam bentuk dokumen, serta kegiatan bootcamp
                                yang mencakup tugas, kelas interaktif, dan kuis untuk pengalaman belajar yang
                                menyeluruh.
                            </p>
                            <a href="{{ route('master.create') }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                Let's Join
                            </a>
                        </div>

                        <!-- Kelas Lengkap -->
                        <div
                            class="max-w-md lg:max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Lengkap</h3>
                            <p class="mb-4 text-gray-700 dark:text-gray-300">
                                Kelas ini menyediakan materi lengkap berupa dokumen dan video, serta kegiatan bootcamp
                                yang mencakup tugas, kelas interaktif, dan kuis untuk pengalaman belajar yang
                                menyeluruh.
                            </p>
                            <a href="{{ route('master.create') }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Let's Join
                            </a>
                        </div>

                        <!-- Kelas Course -->
                        <div
                            class="max-w-md lg:max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Course</h3>
                            <p class="mb-4 text-gray-700 dark:text-gray-300">
                                Kelas ini hanya berfokus pada materi berbentuk video, cocok untuk pembelajaran visual
                                dan interaktif.
                            </p>
                            <a href="{{ route('master.create') }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-500 dark:hover:bg-purple-600 dark:focus:ring-purple-800">
                                Let's Join
                            </a>
                        </div>
                    </div>
                    <!-- WhatsApp Floating Button with Font Awesome Icon -->
                    <a href="https://wa.me/6281803354180"
                        class="fixed bottom-5 right-5 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 flex items-center gap-2"
                        target="_blank" aria-label="Chat via WhatsApp">
                        <!-- Font Awesome WhatsApp Icon -->
                        <i class="fab fa-whatsapp fa-lg"></i>
                        Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

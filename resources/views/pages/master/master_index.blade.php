<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg lg:relative">
                <div class="p-6 text-gray-900 dark:text-gray-100 ">
                    <x-biru-link href="{{ route('master.create') }}">Tambah </x-biru-link>
                    {{-- <form action="{{ route('program.search') }}" method="GET"
                        class="w-full mt-6 lg:absolute lg:right-7 lg:top-4 lg:mt-0 lg:max-w-sm">
                        <label for="default-search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="default-search" name="search"
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search Program dan Deskripsi" />
                            <button type="submit"
                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form> --}}
                    <br>
                    <div class="relative overflow-x-auto lg:mt-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jenis Kelamin
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal Lahir
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        No HP
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Status Pekerjaan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Instansi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Program
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Info
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Motivasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Tanggal Input
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masters as $index => $master)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $masters->firstItem() + $index }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $master->user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->nama }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->gender }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->tanggal_lahir }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->alamat }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->no_hp }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->status_pekerjaan }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->instansi }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->program->nama }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->info }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->motivasi }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $master->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                                {{-- <a href="{{ route('program.edit', $program->id) }}" aria-current="page"
                                                    class="px-4 py-2 text-sm font-medium  rounded-s-lg  focus:z-10 focus:ring-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                                    Edit
                                                </a> --}}
                                                {{-- <form action="{{ route('program.destroy', $program->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium  rounded-e-lg  focus:z-10 focus:ring-2 text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                        Hapus
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{ $masters->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
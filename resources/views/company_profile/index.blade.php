<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Informasi Gudang/Perusahaan</h3>

                    <div class="mb-4">
                        <p class="font-bold">Nama Perusahaan:</p>
                        <p>PT. Gudang Jaya Abadi</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold">Alamat:</p>
                        <p>Jl. Raya Industri No. 123, Kawasan Industri, Bekasi, Jawa Barat</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold">Telepon:</p>
                        <p>(021) 1234 5678</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold">Email:</p>
                        <p>info@gudangjaya.com</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold">Deskripsi:</p>
                        <p>PT. Gudang Jaya Abadi adalah penyedia layanan pergudangan terkemuka yang berdedikasi untuk menyediakan solusi penyimpanan yang efisien dan aman bagi berbagai jenis komoditas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-form-section submit="updateMahasiswa">
    <x-slot name="title">
        {{ __('Informasi Mahasiswa') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Perbarui informasi mahasiswa termasuk NIM, Telepon, Prodi, Kelas, dan Foto KTM.') }}
    </x-slot>

    <x-slot name="form">
        <!-- NIM -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="nim" value="NIM" />
            <x-input id="nim" type="text" class="mt-1 block w-full" wire:model.defer="nim" />
            @error('nim') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Telepon -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="telepon" value="Telepon" />
            <x-input id="telepon" type="text" class="mt-1 block w-full" wire:model.defer="telepon" />
            <x-input-error for="telepon" class="mt-2" />
        </div>

        <!-- Prodi -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="id_prodi" value="Program Studi" />
            <select wire:model="id_prodi" id="id_prodi" class="form-select block w-full mt-1">
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodiList as $prodi)
                    <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
            <x-input-error for="id_prodi" class="mt-2" />
        </div>

        <!-- Kelas -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="id_kelas" value="Kelas" />
            <div class="flex gap-2 items-center">
                <select wire:model="id_kelas" id="id_kelas" class="form-select block w-full mt-1">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>

                {{-- Tombol reset selalu tampil --}}
                <button type="button" style="background-color:red"
                        wire:click="resetKelas"
                        class="text-sm text-white px-3 py-1 rounded mt-1 visibility-visible opacity-100">
                    Reset
                </button>

            </div>
            <x-input-error for="id_kelas" class="mt-2" />
        </div>



        <!-- Upload Foto KTM -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="foto_ktm" value="Upload Foto KTM" />
            <input type="file" id="foto_ktm" wire:model="foto_ktm" class="mt-1 block w-full">

            @if ($foto_ktm)
                <p class="mt-2 text-sm text-gray-600">Preview Foto KTM Baru:</p>
                <img src="{{ $foto_ktm->temporaryUrl() }}" class="h-32 rounded">
            @elseif ($foto_ktm_preview)
                <p class="mt-2 text-sm text-gray-600">Foto KTM Saat Ini:</p>
                <img src="{{ asset('storage/' . $foto_ktm_preview) }}" class="h-32 rounded">
            @endif

            <x-input-error for="foto_ktm" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Data berhasil diperbarui.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="foto_ktm">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

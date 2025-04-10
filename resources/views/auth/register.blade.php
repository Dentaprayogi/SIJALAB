<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Nama Lengkap') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- NIM -->
            <div class="mt-4">
                <x-label for="nim" value="NIM" />
                <x-input id="nim" class="block mt-1 w-full" type="text" name="nim" required autofocus />
            </div>

            <!-- Telepon -->
            <div class="mt-4">
                <x-label for="telepon" value="Telepon" />
                <x-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" required />
            </div>

            <!-- Prodi -->
            <div class="mt-4">
                <x-input-label for="id_prodi" value="Program Studi" />
                <select id="id_prodi" name="id_prodi" class="block mt-1 w-full" required>
                    <option value="" selected disabled >-- Pilih Prodi --</option>
                    @foreach ($prodiList as $prodi)
                        <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kelas -->
            <div class="mt-4">
                <x-input-label for="id_kelas" value="Kelas" />
                <select id="id_kelas" name="id_kelas" class="block mt-1 w-full" required>
                    <option value="" selected disabled >-- Pilih Kelas --</option>
                    <!-- akan diisi lewat JS -->
                </select>
            </div>


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const prodiSelect = document.getElementById('id_prodi');
                const kelasSelect = document.getElementById('id_kelas');
                const form = document.querySelector('form'); // Ambil elemen form
        
                prodiSelect.addEventListener('change', function () {
                    const idProdi = this.value;
        
                    // Reset opsi kelas dengan default yang disabled
                    kelasSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelas --</option>';
        
                    if (idProdi) {
                        fetch(`/get-kelas/${idProdi}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(kelas => {
                                    const option = document.createElement('option');
                                    option.value = kelas.id_kelas;
                                    option.textContent = kelas.nama_kelas;
                                    kelasSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Error ambil kelas:', error);
                            });
                    }
                });
        
                // Cegah submit form jika kelas belum dipilih
                form.addEventListener('submit', function (e) {
                    if (!kelasSelect.value) {
                        e.preventDefault();
                        alert('Silakan pilih kelas terlebih dahulu.');
                        kelasSelect.focus();
                    }
                });
            });
        </script>        
    </x-authentication-card>
</x-guest-layout>

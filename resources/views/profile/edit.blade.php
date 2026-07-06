<x-superadmin-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Profile</h1>
        <p class="text-slate-500 mt-1 font-medium">Perbarui informasi akun dan keamanan Anda.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            <span class="font-bold text-sm">Profil berhasil diperbarui.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Profile Info Form (Span 7) -->
        <div class="md:col-span-7 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Profil</h2>
            
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-6">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-200 shadow-sm">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <input type="file" name="photo" id="photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-blue/10 file:text-brand-blue hover:file:bg-brand-blue/20 cursor-pointer transition-colors">
                            <p class="mt-2 text-xs text-slate-500 font-medium">Format: JPG, PNG. Maks: 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                        </div>
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-brand-blue hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition-colors text-sm shadow-md flex items-center gap-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Form (Span 5) -->
        <div class="md:col-span-5 flex flex-col gap-6">
            <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex-1">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Ubah Password</h2>
                
                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-bold text-slate-700 mb-1">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Password Baru</label>
                        <input id="password" name="password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3 px-6 rounded-xl transition-colors text-sm">
                            Perbarui Password
                        </button>
                    </div>

                    @if (session('status') === 'password-updated')
                        <p class="text-sm font-bold text-emerald-600 text-center mt-3">Password diperbarui.</p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-superadmin-layout>

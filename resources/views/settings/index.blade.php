@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#1C1917]">Pengaturan</h1>
        <p class="text-sm text-primary mt-1">Kelola tampilan, identitas bisnis, dan manajemen karyawan Anda di sini.</p>
    </div>

    {{-- Top row: Theme + Business Identity --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Appearance --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-start gap-3 mb-5">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-[#1C1917]">Tampilan & Tema</h2>
                    <p class="text-xs text-[#78716C]">Ubah warna dasar aplikasi Anda.</p>
                </div>
            </div>

            <p class="text-sm font-semibold text-[#1C1917] mb-3">Warna Aksen Utama</p>
            <div class="flex gap-3 mb-5">
                @foreach(['#F97316' => true, '#3B82F6' => false, '#10B981' => false, '#8B5CF6' => false, '#EC4899' => false] as $color => $active)
                <button class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 {{ $active ? 'ring-2 ring-offset-2 ring-current' : '' }}"
                        style="background-color: {{ $color }}; color: {{ $color }}">
                    @if($active)
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    @endif
                </button>
                @endforeach
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-[#1C1917]">Mode Gelap</p>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-stone-200 peer-checked:bg-primary rounded-full peer transition-all
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:rounded-full after:h-5 after:w-5
                                after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>
        </div>

        {{-- Business Identity --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-start gap-3 mb-5">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-[#1C1917]">Identitas Bisnis</h2>
                    <p class="text-xs text-[#78716C]">Kelola logo dan informasi kedai.</p>
                </div>
            </div>

            <form id="business-identity-form" enctype="multipart/form-data">
                @csrf
                <div class="flex items-start gap-4 mb-4">
                    <div class="relative">
                        {{-- Logo preview --}}
                        <div id="logo-container" class="w-16 h-16 bg-stone-700 rounded-full flex items-center justify-center overflow-hidden">
                            @if(isset($settings['logo']) && $settings['logo'])
                                <img id="logo-preview" src="{{ Storage::url($settings['logo']) }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <span id="logo-text" class="text-white text-xs font-bold">COFFEE</span>
                                <img id="logo-preview" src="" alt="Logo" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        {{-- Edit icon button --}}
                        <button type="button" onclick="document.getElementById('logo-file-input').click()"
                                class="absolute bottom-0 right-0 w-6 h-6 bg-primary rounded-full flex items-center justify-center hover:bg-[#EA580C] transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        {{-- Hidden file input --}}
                        <input type="file" id="logo-file-input" name="logo" accept="image/*" class="hidden"
                                onchange="settingsModule.previewLogo(this)">
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-[#1C1917] mb-1">Logo Bisnis</p>
                        <p class="text-xs text-[#78716C] mb-3">Disarankan PNG atau JPG berukuran 500×500px dengan ukuran file maksimal 2MB.</p>
                        <div class="flex gap-2">
                            <button type="button" onclick="document.getElementById('logo-file-input').click()"
                                    class="px-3 py-1.5 bg-primary hover:bg-[#EA580C] text-white text-xs font-semibold rounded-xl transition-colors">
                                Unggah Foto
                            </button>
                            <button type="button" onclick="settingsModule.removeLogo()"
                                    class="px-3 py-1.5 border border-stone-200 text-xs font-semibold text-[#78716C] rounded-xl hover:bg-stone-50 transition-colors">
                                Hapus
                            </button>
                        </div>
                        <p id="logo-filename" class="text-xs text-green-600 mt-1 hidden"></p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Nama Bisnis</label>
                    <input type="text" name="business_name" value="{{ $settings['business_name'] ?? 'Apipi Coffee' }}"
                            class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
                </div>

                <button type="submit" id="save-identity-btn"
                        class="w-full py-2.5 bg-primary hover:bg-[#EA580C] text-white rounded-2xl text-sm font-semibold transition-colors">
                    Simpan Perubahan
                </button>
                <p id="save-success-msg" class="text-xs text-green-600 text-center mt-2 hidden">✓ Perubahan berhasil disimpan!</p>
            </form>
        </div>
    </div>

    {{-- Employee Management --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-stone-100">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-[#1C1917]">Manajemen Karyawan</h2>
                    <p class="text-xs text-[#78716C]">Atur hak akses dan status akun staf.</p>
                </div>
            </div>
            @if(auth()->user()->role === 'manager')
            <button onclick="settingsModule.openAddEmployee()"
                    class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-[#EA580C] text-white rounded-2xl text-sm font-semibold transition-colors shadow-lg shadow-orange-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v8M8 12h8"/>
                </svg>
                + Tambah Karyawan
            </button>
            @endif
        </div>

        <table class="w-full">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="text-left py-3 px-6 text-xs font-bold text-[#78716C] uppercase tracking-wider">Nama Karyawan</th>
                    <th class="text-left py-3 px-4 text-xs font-bold text-[#78716C] uppercase tracking-wider">Peran</th>
                    <th class="text-left py-3 px-4 text-xs font-bold text-[#78716C] uppercase tracking-wider">Email</th>
                    <th class="text-left py-3 px-4 text-xs font-bold text-[#78716C] uppercase tracking-wider">Status</th>
                    <th class="text-left py-3 px-4 text-xs font-bold text-[#78716C] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($employees as $employee)
                <tr class="hover:bg-stone-50 transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}"
                                class="w-9 h-9 rounded-full object-cover">
                            <div>
                                <p class="text-sm font-semibold text-[#1C1917]">{{ $employee->name }}</p>
                                <p class="text-xs text-[#78716C]">ID: {{ $employee->employee_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-1 bg-orange-100 text-primary text-xs font-bold rounded-lg uppercase">
                            {{ strtoupper($employee->role) }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-sm text-[#78716C]">{{ $employee->email }}</td>
                    <td class="py-4 px-4">
                        <span class="flex items-center gap-1.5 text-sm font-medium {{ $employee->status === 'active' ? 'text-green-600' : 'text-stone-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $employee->status === 'active' ? 'Aktif' : ($employee->status === 'leave' ? 'Cuti' : 'Nonaktif') }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->role === 'manager')
                            {{-- Edit button --}}
                            <button onclick="settingsModule.openEditEmployee({{ $employee->id }}, '{{ addslashes($employee->name) }}', '{{ $employee->email }}', '{{ $employee->role }}', '{{ $employee->status }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg border border-blue-200 text-blue-500 hover:bg-blue-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            {{-- Delete button --}}
                            <button onclick="settingsModule.openDeleteEmployee({{ $employee->id }}, '{{ addslashes($employee->name) }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg border border-red-200 text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @else
                            <span class="text-xs text-stone-300">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Add Employee Modal --}}
<div id="add-employee-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="settingsModule.closeAddEmployee()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6">
        <div class="flex items-start justify-between mb-5">
            <h2 class="text-xl font-bold text-[#1C1917]">Tambah Karyawan Baru</h2>
            <button onclick="settingsModule.closeAddEmployee()" class="text-stone-400 hover:text-[#1C1917]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="add-employee-form" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Nama Karyawan</label>
                <input type="text" name="name" placeholder="Nama lengkap"
                        class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Email Karyawan</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" name="email" placeholder="contoh@email.com"
                            class="w-full pl-10 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Peran Karyawan</label>
                <div class="flex gap-2" id="role-btns">
                    @foreach(['cashier' => 'Kasir', 'admin' => 'Admin', 'manager' => 'Manager'] as $val => $label)
                    <button type="button" data-role="{{ $val }}"
                            class="role-btn px-4 py-2 rounded-2xl text-sm font-semibold border-2 transition-colors
                                    {{ $val === 'cashier' ? 'border-primary text-primary bg-white' : 'border-stone-200 text-[#78716C] hover:border-stone-300' }}"
                            onclick="settingsModule.selectRole(this)">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
                <input type="hidden" name="role" id="selected-role" value="cashier">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="settingsModule.closeAddEmployee()"
                        class="flex-1 py-3 text-sm font-semibold border-2 border-stone-200 rounded-2xl text-[#78716C] hover:border-stone-300 transition-colors">Batal</button>
                <button type="submit"
                        class="flex-1 py-3 bg-primary hover:bg-[#EA580C] text-white rounded-2xl text-sm font-semibold transition-colors">Tambah Karyawan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Employee Modal --}}
<div id="edit-employee-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="settingsModule.closeEditEmployee()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6">
        <div class="flex items-start justify-between mb-5">
            <h2 class="text-xl font-bold text-[#1C1917]">Edit Karyawan</h2>
            <button onclick="settingsModule.closeEditEmployee()" class="text-stone-400 hover:text-[#1C1917]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-employee-form" class="space-y-4">
            @csrf
            <input type="hidden" id="edit-employee-id">
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Nama Karyawan</label>
                <input type="text" id="edit-emp-name" name="name"
                        class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Email</label>
                <input type="email" id="edit-emp-email" name="email"
                        class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Peran</label>
                <select id="edit-emp-role" name="role"
                        class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none bg-white">
                    <option value="cashier">Kasir</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1C1917] mb-1.5">Status</label>
                <select id="edit-emp-status" name="status"
                        class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-primary/30 outline-none bg-white">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                    <option value="leave">Cuti</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="settingsModule.closeEditEmployee()"
                        class="flex-1 py-3 text-sm font-semibold border-2 border-stone-200 rounded-2xl text-[#78716C]">Batal</button>
                <button type="submit"
                        class="flex-1 py-3 bg-primary hover:bg-[#EA580C] text-white rounded-2xl text-sm font-semibold transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Employee Modal --}}
<div id="delete-employee-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="settingsModule.closeDeleteEmployee()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-[#1C1917] mb-2">Hapus Karyawan</h2>
        <p id="delete-emp-text" class="text-sm text-[#78716C] mb-6"></p>
        <input type="hidden" id="delete-employee-id">
        <div class="flex gap-3">
            <button onclick="settingsModule.closeDeleteEmployee()"
                    class="flex-1 py-3 text-sm font-semibold border-2 border-stone-200 rounded-2xl text-[#78716C]">Batal</button>
            <button onclick="settingsModule.confirmDeleteEmployee()"
                    class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white rounded-2xl text-sm font-semibold transition-colors">Hapus</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const settingsModule = {
    // ── Logo Upload ──────────────────────────────────
    previewLogo(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('logo-preview');
                const text = document.getElementById('logo-text');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (text) text.classList.add('hidden');
                document.getElementById('logo-filename').textContent = '✓ ' + file.name;
                document.getElementById('logo-filename').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    },

    removeLogo() {
        const preview = document.getElementById('logo-preview');
        const text = document.getElementById('logo-text');
        preview.src = '';
        preview.classList.add('hidden');
        if (text) { text.classList.remove('hidden'); }
        document.getElementById('logo-file-input').value = '';
        document.getElementById('logo-filename').classList.add('hidden');
    },

    // ── Employee ──────────────────────────────────────
    openAddEmployee() { document.getElementById('add-employee-modal').classList.remove('hidden'); },
    closeAddEmployee() {
        document.getElementById('add-employee-modal').classList.add('hidden');
        document.getElementById('add-employee-form').reset();
    },

    openEditEmployee(id, name, email, role, status) {
        document.getElementById('edit-employee-id').value = id;
        document.getElementById('edit-emp-name').value = name;
        document.getElementById('edit-emp-email').value = email;
        document.getElementById('edit-emp-role').value = role;
        document.getElementById('edit-emp-status').value = status;
        document.getElementById('edit-employee-modal').classList.remove('hidden');
    },
    closeEditEmployee() { document.getElementById('edit-employee-modal').classList.add('hidden'); },

    openDeleteEmployee(id, name) {
        document.getElementById('delete-employee-id').value = id;
        document.getElementById('delete-emp-text').innerHTML = `Hapus karyawan <strong>${name}</strong>? Tindakan ini tidak bisa dibatalkan.`;
        document.getElementById('delete-employee-modal').classList.remove('hidden');
    },
    closeDeleteEmployee() { document.getElementById('delete-employee-modal').classList.add('hidden'); },

    async confirmDeleteEmployee() {
        const id = document.getElementById('delete-employee-id').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const res = await fetch(`/settings/employees/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) window.location.reload();
        else alert(data.message || 'Gagal menghapus karyawan');
    },

    selectRole(btn) {
        document.querySelectorAll('.role-btn').forEach(b => {
            b.classList.remove('border-primary', 'text-primary');
            b.classList.add('border-stone-200', 'text-[#78716C]');
        });
        btn.classList.add('border-primary', 'text-primary');
        btn.classList.remove('border-stone-200', 'text-[#78716C]');
        document.getElementById('selected-role').value = btn.dataset.role;
    }
};

// ── Business Identity Form Submit ─────────────────────
document.getElementById('business-identity-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('save-identity-btn');
    btn.textContent = 'Menyimpan...';
    btn.disabled = true;

    const formData = new FormData(this);
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const res = await fetch('{{ route("settings.identity.update") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token },
        body: formData
    });
    const data = await res.json();

    btn.textContent = 'Simpan Perubahan';
    btn.disabled = false;

    if (data.success) {
        document.getElementById('save-success-msg').classList.remove('hidden');
        setTimeout(() => document.getElementById('save-success-msg').classList.add('hidden'), 3000);
    } else {
        alert(data.message || 'Gagal menyimpan');
    }
});

// ── Add Employee Submit ───────────────────────────────
document.getElementById('add-employee-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const res = await fetch('{{ route("settings.employees.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) window.location.reload();
    else alert(json.message || 'Gagal menambah karyawan');
});

// ── Edit Employee Submit ──────────────────────────────
document.getElementById('edit-employee-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-employee-id').value;
    const data = Object.fromEntries(new FormData(this));
    const res = await fetch(`/settings/employees/${id}?_method=PUT`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) window.location.reload();
    else alert(json.message || 'Gagal update karyawan');
});
</script>
@endpush
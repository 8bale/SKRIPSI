{{-- filepath: resources/views/Pengurangan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ambil Suku Cadang: ' . $barang->nama_barang . ' - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

@section('content')
    {{-- Breadcrumb --}}
    <ul class="breadcrumb-custom">
        <li>
            <a href="{{ route('barang.index') }}" class="d-inline-flex align-items-center gap-1.5">
                <i class="fa-solid fa-house"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li><a href="{{ route('pengurangan.index') }}">Riwayat Pengambilan</a></li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">Ambil Suku Cadang</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">Pengambilan Suku Cadang Mekanik</h1>
                <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                    <i class="fa-solid fa-hand-holding-box me-1"></i> Form Pengambilan
                </span>
            </div>
            <p class="page-subtitle">Catat pemakaian suku cadang dan kurangi stok fisik gudang secara otomatis.</p>
        </div>
        <a href="{{ route('barang.index') }}"
            class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
            style="font-size: 13px;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-3 mb-4 p-3 rounded-3" role="alert">
            <i class="fa-solid fa-circle-exclamation fs-5 text-danger mt-0.5"></i>
            <div class="flex-grow-1">
                <div class="fw-bold mb-1 text-dark" style="font-size: 13.5px;">Terdapat kesalahan pada formulir pengambilan:</div>
                <ul class="mb-0 ps-3 small text-danger fw-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kolom Kiri: Formulir Pengambilan --}}
        <div class="col-lg-7">
            <div class="card form-card-clean">

                {{-- Card Header --}}
                <div class="card-header bg-white p-3.5 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="item-icon-box" style="width: 38px; height: 38px; background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                            <i class="fa-solid fa-hand-holding-box fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Formulir Pengambilan Barang</h6>
                            <span class="text-muted small">Stok di database akan otomatis berkurang sesuai jumlah yang diambil.</span>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 11px;">
                        <span class="text-danger">*</span> Wajib diisi
                    </span>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pengurangan.store', $barang->id_barang) }}" method="POST">
                        @csrf

                        {{-- Jumlah yang Diambil --}}
                        <div class="mb-4">
                            <label for="jumlah" class="form-label-gys">
                                <span>Jumlah yang Diambil <span class="text-danger">*</span></span>
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">
                                    Stok Gudang: <strong class="text-dark">{{ $barang->stock }} Unit</strong>
                                </span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-cubes-stacked"></i></span>
                                <input type="number"
                                    class="form-control form-control-custom @error('jumlah') is-invalid @enderror"
                                    id="jumlah" name="jumlah" min="1" max="{{ $barang->stock }}"
                                    value="{{ old('jumlah', 1) }}" required autofocus>
                                <span class="input-group-text-right">Unit</span>
                            </div>
                            @error('jumlah')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center mt-1.5">
                                    <span class="form-hint m-0">Masukkan jumlah unit fisik yang riil diambil dari rak gudang.</span>
                                    <span class="small fw-semibold text-primary" id="previewSisaStok">
                                        Sisa: {{ max(0, $barang->stock - old('jumlah', 1)) }} Unit
                                    </span>
                                </div>
                            @enderror
                        </div>

                        {{-- Nama Mekanik --}}
                        <div class="mb-4">
                            <label for="nama_mekanik" class="form-label-gys">
                                <span>Nama Mekanik / Teknisi Pengambil <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-user-gear"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('nama_mekanik') is-invalid @enderror"
                                    id="nama_mekanik" name="nama_mekanik"
                                    value="{{ old('nama_mekanik', auth()->user()->name) }}"
                                    placeholder="Contoh: Budi Santoso / Tim Mekanik Roll Mill Line 1"
                                    required>
                            </div>
                            @error('nama_mekanik')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Otomatis terisi nama akun Anda, dapat disesuaikan jika mewakili anggota tim lain.
                                </div>
                            @enderror
                        </div>

                        {{-- Shift Kerja --}}
                        @php
                            $defaultShift = old('shift');
                            if (!$defaultShift) {
                                $userName = auth()->user()->name ?? '';
                                if (str_contains($userName, 'Regu 1') || str_contains($userName, 'Shift 1')) {
                                    $defaultShift = 'Shift 1';
                                } elseif (str_contains($userName, 'Regu 2') || str_contains($userName, 'Shift 2')) {
                                    $defaultShift = 'Shift 2';
                                } elseif (str_contains($userName, 'Regu 3') || str_contains($userName, 'Shift 3')) {
                                    $defaultShift = 'Shift 3';
                                } elseif (str_contains($userName, 'Non-Shift') || str_contains($userName, 'Non Shift')) {
                                    $defaultShift = 'Non-Shift';
                                }
                            }
                        @endphp
                        <div class="mb-4">
                            <label for="shift" class="form-label-gys">
                                <span>Shift Kerja <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-regular fa-clock"></i></span>
                                <select class="form-select form-select-custom @error('shift') is-invalid @enderror"
                                    id="shift" name="shift" required>
                                    <option value="" disabled {{ $defaultShift ? '' : 'selected' }}>
                                        -- Pilih Shift Kerja --
                                    </option>
                                    <option value="Shift 1"   {{ $defaultShift == 'Shift 1'   ? 'selected' : '' }}>Shift 1 (Pagi)</option>
                                    <option value="Shift 2"   {{ $defaultShift == 'Shift 2'   ? 'selected' : '' }}>Shift 2 (Siang / Sore)</option>
                                    <option value="Shift 3"   {{ $defaultShift == 'Shift 3'   ? 'selected' : '' }}>Shift 3 (Malam)</option>
                                    <option value="Non-Shift" {{ $defaultShift == 'Non-Shift' ? 'selected' : '' }}>Non-Shift (Day Working)</option>
                                </select>
                            </div>
                            @error('shift')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Pilih shift kerja saat suku cadang ini diambil di lapangan.
                                </div>
                            @enderror
                        </div>

                        {{-- Note / Keperluan --}}
                        <div class="mb-4">
                            <label for="keperluan" class="form-label-gys">
                                <span>Note / Peruntukan Mesin <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box align-self-stretch" style="border-bottom-left-radius: 8px;">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </span>
                                <textarea class="form-control form-control-custom @error('keperluan') is-invalid @enderror"
                                    id="keperluan" name="keperluan" rows="3"
                                    placeholder="Tuliskan catatan peruntukan (contoh: Penggantian bearing motor gearbox pompa cooling bed line 2)"
                                    required>{{ old('keperluan') }}</textarea>
                            </div>
                            @error('keperluan')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Sebutkan unit mesin, nomor jalur produksi (line), atau alasan perbaikan terkait.
                                </div>
                            @enderror
                        </div>

                        {{-- Tanggal & Jam Pengambilan --}}
                        <div class="mb-4">
                            <label for="tanggal_ambil" class="form-label-gys">
                                <span>Waktu Pengambilan Barang</span>
                                <span class="badge bg-light text-muted border fw-normal" style="font-size: 10.5px;">WIB</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-clock"></i></span>
                                <input type="datetime-local"
                                    class="form-control form-control-custom @error('tanggal_ambil') is-invalid @enderror"
                                    id="tanggal_ambil" name="tanggal_ambil"
                                    value="{{ old('tanggal_ambil', now()->format('Y-m-d\TH:i')) }}">
                            </div>
                            @error('tanggal_ambil')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Waktu otomatis terisi realtime saat ini, ubah jika mencatat rekap lampau.
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4 border-light-subtle">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center gap-3">
                            <a href="{{ route('barang.index') }}"
                                class="btn btn-outline-secondary px-4 py-2 fw-semibold w-100 w-sm-auto" style="font-size: 13px;">
                                <i class="fa-solid fa-xmark me-1"></i> Batal
                            </a>
                            <button type="submit"
                                class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-2"
                                style="font-size: 13px;">
                                <i class="fa-solid fa-check"></i>
                                <span>Konfirmasi Pengambilan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rincian Barang & SOP --}}
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">

                {{-- Kartu Info Barang --}}
                <div class="card form-card-clean">
                    <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-box-open text-primary"></i>
                            <span>Rincian Barang yang Diambil</span>
                        </span>
                        <span class="badge bg-light text-secondary border font-monospace" style="font-size: 10.5px;">
                            #BRG-{{ str_pad($barang->id_barang, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <div class="card-body p-3.5">
                        <div class="d-flex align-items-start gap-3 pb-3 border-bottom mb-3">
                            <div class="item-icon-box" style="width: 44px; height: 44px; background-color: #eff6ff; color: #1d4ed8; border: none;">
                                <i class="fa-solid fa-gear fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">{{ $barang->nama_barang }}</h6>
                                @if ($barang->deskripsi)
                                    <p class="text-secondary small mb-0">{{ $barang->deskripsi }}</p>
                                @else
                                    <p class="text-muted small mb-0">Belum ada keterangan tambahan.</p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2.5 small">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Stok Fisik Tersedia:</span>
                                <span class="badge-stock badge-stock-safe" style="font-size: 12px;">{{ $barang->stock }} Unit</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Posisi Rak:</span>
                                <span class="badge-rack-pill">
                                    <i class="fa-solid fa-inbox text-secondary" style="font-size: 10px;"></i>
                                    <span>{{ $barang->rack?->nama_rack ?? 'Belum Ditentukan' }}</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Lokasi Gudang:</span>
                                <span class="text-dark fw-semibold d-inline-flex align-items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-danger opacity-75" style="font-size: 11px;"></i>
                                    <span>{{ $barang->rack?->lokasi ?? '-' }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SOP Pengambilan --}}
                <div class="card form-card-clean">
                    <div class="card-header bg-white p-3 border-bottom">
                        <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-check text-success"></i>
                            <span>SOP Pengambilan Suku Cadang (Workshop)</span>
                        </span>
                    </div>
                    <div class="card-body p-3.5">
                        <div class="d-flex flex-column gap-3 small text-secondary">
                            <div class="guideline-item">
                                <div class="guideline-number">1</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Kesesuaian Tipe & Spesifikasi</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Pastikan spare part yang diambil memiliki tipe/dimensi yang tepat sebelum dipasang pada mesin.
                                    </p>
                                </div>
                            </div>
                            <div class="guideline-item">
                                <div class="guideline-number">2</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Pencatatan Segera</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Segera submit formulir ini setelah barang diambil agar stok di sistem tetap akurat.
                                    </p>
                                </div>
                            </div>
                            <div class="guideline-item">
                                <div class="guideline-number">3</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Penulisan Note Jelas</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Tuliskan nama mesin atau alasan perbaikan agar riwayat pemakaian dapat diaudit dengan baik.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Live calculate remaining stock preview
    document.addEventListener('DOMContentLoaded', function () {
        const inputJumlah = document.getElementById('jumlah');
        const previewSisa = document.getElementById('previewSisaStok');
        const maxStock = {{ (int) $barang->stock }};

        if (inputJumlah && previewSisa) {
            inputJumlah.addEventListener('input', function () {
                const val = parseInt(this.value) || 0;
                const sisa = Math.max(0, maxStock - val);
                previewSisa.textContent = 'Sisa: ' + sisa + ' Unit';
                if (sisa === 0) {
                    previewSisa.className = 'small fw-bold text-danger';
                } else if (sisa <= 10) {
                    previewSisa.className = 'small fw-bold text-warning';
                } else {
                    previewSisa.className = 'small fw-semibold text-primary';
                }
            });
        }
    });
</script>
@endpush

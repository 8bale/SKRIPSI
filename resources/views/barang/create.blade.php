{{-- filepath: resources/views/barang/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Suku Cadang - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

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
        <li><a href="{{ route('barang.index') }}">Katalog Spare Part</a></li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">Tambah Suku Cadang</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title">Tambah Suku Cadang Baru</h1>
            <p class="page-subtitle">Daftarkan suku cadang mekanik baru ke dalam katalog inventaris gudang PT Garuda Yamato Steel.</p>
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
                <div class="fw-bold mb-1 text-dark" style="font-size: 13.5px;">Terdapat kesalahan pada isian formulir:</div>
                <ul class="mb-0 ps-3 small text-danger fw-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kolom Kiri: Formulir --}}
        <div class="col-lg-8">
            <div class="card form-card-clean">
                <div class="card-header bg-white p-3.5 border-bottom d-flex align-items-center gap-3">
                    <div class="item-icon-box" style="width: 38px; height: 38px; background-color: #eff6ff; color: #1d4ed8; border: none;">
                        <i class="fa-solid fa-box-open fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Formulir Pendaftaran Spare Part</h6>
                        <span class="text-muted small">Lengkapi data teknis dan posisi rak fisik barang.</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf

                        {{-- Nama Barang --}}
                        <div class="mb-4">
                            <label for="nama_barang" class="form-label-gys">
                                <span>Nama / Spesifikasi Suku Cadang <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-tag"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('nama_barang') is-invalid @enderror"
                                    id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                                    placeholder="Contoh: Bearing SKF 6205-2RSH / V-Belt B-45 / Seal Viton 45x65x10"
                                    required autofocus>
                            </div>
                            @error('nama_barang')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Sebutkan jenis suku cadang, nomor part pabrikan, atau ukuran teknis secara lengkap.
                                </div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            {{-- Jumlah Stok Awal --}}
                            <div class="col-md-6">
                                <label for="stock" class="form-label-gys">
                                    <span>Stok Fisik Awal <span class="text-danger">*</span></span>
                                </label>
                                <div class="input-group">
                                    <span class="input-icon-box"><i class="fa-solid fa-cubes-stacked"></i></span>
                                    <input type="number" min="0" step="1"
                                        class="form-control form-control-custom @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" value="{{ old('stock', '') }}"
                                        placeholder="Contoh: 25" required>
                                    <span class="input-group-text-right">Unit</span>
                                </div>
                                @error('stock')
                                    <div class="text-danger small mt-1.5 fw-medium">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                    </div>
                                @else
                                    <div class="form-hint">
                                        Jumlah unit fisik riil yang dimasukkan ke rak gudang.
                                    </div>
                                @enderror
                            </div>

                            {{-- Rak & Lokasi --}}
                            <div class="col-md-6">
                                <label for="id_rack" class="form-label-gys">
                                    <span>Posisi Titik Rak <span class="text-danger">*</span></span>
                                </label>
                                <div class="input-group">
                                    <span class="input-icon-box"><i class="fa-solid fa-warehouse"></i></span>
                                    <select class="form-select form-select-custom @error('id_rack') is-invalid @enderror"
                                        name="id_rack" id="id_rack" required>
                                        <option value="" disabled {{ old('id_rack') ? '' : 'selected' }}>
                                            -- Pilih Titik Rak Gudang --
                                        </option>
                                        @foreach ($racks as $rack)
                                            <option value="{{ $rack->id_rack }}"
                                                {{ old('id_rack') == $rack->id_rack ? 'selected' : '' }}>
                                                {{ $rack->nama_rack }} (Area: {{ $rack->lokasi }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('id_rack')
                                    <div class="text-danger small mt-1.5 fw-medium">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                    </div>
                                @else
                                    <div class="form-hint">
                                        Pilih nomor rak tempat suku cadang diletakkan.
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Fungsi & Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label-gys">
                                <span>Fungsi & Deskripsi Tambahan</span>
                                <span class="badge bg-light text-muted border fw-normal" style="font-size: 10.5px;">Opsional</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box align-self-stretch" style="border-bottom-left-radius: 8px;">
                                    <i class="fa-solid fa-align-left"></i>
                                </span>
                                <textarea class="form-control form-control-custom @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi" rows="3"
                                    placeholder="Jelaskan fungsi komponen, peruntukan mesin (misal: Roll Mill, Cooling Bed), atau catatan khusus lainnya">{{ old('deskripsi') }}</textarea>
                            </div>
                            @error('deskripsi')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Catatan peruntukan membantu teknisi mekanik dalam proses perbaikan mesin di lapangan.
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
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Suku Cadang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Info Rak & Panduan SOP --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">

                {{-- Kartu Titik Rak Tersedia --}}
                <div class="card form-card-clean">
                    <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-layer-group text-primary"></i>
                            <span>Titik Rak Tersedia</span>
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2 py-1">
                            {{ $racks->count() }} Titik Rak
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush small" style="max-height: 250px; overflow-y: auto;">
                            @forelse ($racks as $rack)
                                <div class="list-group-item px-3 py-2.5 d-flex align-items-center justify-content-between border-bottom">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 12.5px;">{{ $rack->nama_rack }}</div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            <i class="fa-solid fa-location-dot text-danger opacity-75 me-1"></i>
                                            Area: {{ $rack->lokasi }}
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 10.5px;">
                                        #ID-{{ $rack->id_rack }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-solid fa-inbox fs-4 mb-2 d-block opacity-50"></i>
                                    <span>Belum ada rak terdaftar di sistem</span>
                                </div>
                            @endforelse
                        </div>
                        <div class="p-2.5 text-center border-top bg-light-subtle">
                            <span class="text-muted" style="font-size: 11px;">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                Pastikan kode rak fisik sesuai sebelum menyimpan barang.
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kartu Panduan SOP --}}
                <div class="card form-card-clean">
                    <div class="card-header bg-white p-3 border-bottom">
                        <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-check text-success"></i>
                            <span>Panduan Penginputan (SOP Gudang)</span>
                        </span>
                    </div>
                    <div class="card-body p-3.5">
                        <div class="d-flex flex-column gap-3 small text-secondary">
                            <div class="guideline-item">
                                <div class="guideline-number">1</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Standar Nomenklatur Spare Part</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Tulis jenis, merk/tipe, dan ukuran spesifik (misal: <em>Bearing 6205 SKF</em>).
                                    </p>
                                </div>
                            </div>
                            <div class="guideline-item">
                                <div class="guideline-number">2</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Verifikasi Stok Fisik</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Pastikan unit barang dihitung secara fisik sebelum disimpan ke database.
                                    </p>
                                </div>
                            </div>
                            <div class="guideline-item">
                                <div class="guideline-number">3</div>
                                <div>
                                    <strong class="text-dark d-block mb-0.5">Penataan Lokasi Rak</strong>
                                    <p class="mb-0 text-muted" style="font-size: 11.5px;">
                                        Simpan barang pada rak sesuai fungsinya agar mempermudah respon cepat maintenance mesin.
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

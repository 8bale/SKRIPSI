{{-- filepath: resources/views/Rack/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Titik Rak ' . $rack->nama_rack . ' - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

@section('nav_badge')
    <span class="badge bg-white text-secondary border px-3 py-1.5 fw-bold rounded-pill">
        <i class="fa-solid fa-pen-to-square text-primary me-1"></i> Mode Edit
    </span>
@endsection

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
        <li><a href="{{ route('rack.index') }}">Manajemen Titik Rak</a></li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">Edit Rak #{{ $rack->id_rack }}</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">Edit Titik Rak</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11.5px;">
                    #ID-{{ $rack->id_rack }}
                </span>
            </div>
            <p class="page-subtitle">Perbarui penamaan kode rak atau keterangan zonasi area gudang workshop.</p>
        </div>
        <a href="{{ route('rack.index') }}"
            class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
            style="font-size: 13px;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Rak</span>
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

        {{-- Kolom Kiri: Formulir Edit --}}
        <div class="col-lg-7">
            <div class="card form-card-clean">
                <div class="card-header bg-white p-3.5 border-bottom d-flex align-items-center gap-3">
                    <div class="item-icon-box" style="width: 38px; height: 38px; background-color: #faf5ff; color: #7e22ce; border: none;">
                        <i class="fa-solid fa-pen-to-square fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Formulir Perubahan Titik Rak</h6>
                        <span class="text-muted small">Perubahan langsung diterapkan pada seluruh inventaris yang menempati rak ini.</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('rack.update', $rack->id_rack) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Rak --}}
                        <div class="mb-4">
                            <label for="nama_rack" class="form-label-gys">
                                <span>Nama / Kode Rak <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-inbox"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('nama_rack') is-invalid @enderror"
                                    id="nama_rack" name="nama_rack"
                                    value="{{ old('nama_rack', $rack->nama_rack) }}"
                                    placeholder="Contoh: RAK BEARING A1"
                                    required autofocus>
                            </div>
                            @error('nama_rack')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Nama rak yang dikenali oleh teknisi mekanik di workshop.
                                </div>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-4">
                            <label for="lokasi" class="form-label-gys">
                                <span>Lokasi Gudang / Area <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi"
                                    value="{{ old('lokasi', $rack->lokasi) }}"
                                    placeholder="Contoh: Area Barat - Zona A1"
                                    required>
                            </div>
                            @error('lokasi')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Keterangan zona area penyimpanan fisik di bengkel/workshop.
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4 border-light-subtle">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center gap-3">
                            <a href="{{ route('rack.index') }}"
                                class="btn btn-outline-secondary px-4 py-2 fw-semibold w-100 w-sm-auto" style="font-size: 13px;">
                                <i class="fa-solid fa-xmark me-1"></i> Batal
                            </a>
                            <button type="submit"
                                class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-2"
                                style="font-size: 13px;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan Rak</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status Barang Terkait --}}
        <div class="col-lg-5">
            <div class="card form-card-clean">
                <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-primary"></i>
                        <span>Status Inventaris Terkait</span>
                    </span>
                    <span class="badge {{ $rack->barangs_count > 0 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-light text-secondary border' }} fw-bold px-2 py-1">
                        {{ $rack->barangs_count }} Jenis Part
                    </span>
                </div>
                <div class="card-body p-3.5">
                    @if ($rack->barangs_count > 0)
                        <div class="alert alert-info border-0 d-flex align-items-start gap-2.5 mb-0 py-2.5 px-3 rounded-3" role="alert">
                            <i class="fa-solid fa-circle-info fs-5 text-primary mt-0.5"></i>
                            <div class="small">
                                Terdapat <strong>{{ $rack->barangs_count }} macam barang</strong> yang tersimpan di rak ini.
                                Perubahan nama atau lokasi rak akan langsung mempengaruhi label penempatan seluruh suku cadang tersebut.
                            </div>
                        </div>
                    @else
                        <div class="text-secondary small d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success fs-5"></i>
                            <div>
                                Rak ini saat ini kosong (tidak ada barang). Rak dapat dihapus jika sudah tidak digunakan di bengkel.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@extends('layouts.home')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center g-4">
        <!-- Card 1: Hari Ini -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow rounded text-center">
                <div class="card-body px-4 py-4">
                    <div class="mb-3">
                        <div class="stats-icon bg-primary text-white rounded-circle mx-auto p-3">
                            <i class="iconly-boldProfile fs-4"></i>
                        </div>
                    </div>
                    <h6 class="text-muted fw-semibold text-start">Jumlah Prediksi Hari Ini</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($countToday) }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 2: Bulanan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow rounded text-center">
                <div class="card-body px-4 py-4">
                    <div class="mb-3">
                        <div class="stats-icon bg-success text-white rounded-circle mx-auto p-3">
                            <i class="iconly-boldAdd-User fs-4"></i>
                        </div>
                    </div>
                    <h6 class="text-muted fw-semibold">Prediksi Bulanan</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($countMonthly) }}</h3>
                </div>
            </div>
        </div>

        <!-- Card 3: Jumlah Siswa -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow rounded text-center">
                <div class="card-body px-4 py-4">
                    <div class="mb-3">
                        <div class="stats-icon bg-danger text-white rounded-circle mx-auto p-3">
                            <i class="iconly-boldBookmark fs-4"></i>
                        </div>
                    </div>
                    <h6 class="text-muted fw-semibold">Jumlah Siswa Terdaftar</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($sumUser) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

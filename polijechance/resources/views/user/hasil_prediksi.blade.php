@extends('layouts.home')

@section('content')
<div class="container">
    <h1>Riwayat Prediksi Anda</h1>

    @forelse($predictions as $p)
        <div class="card mb-3">
            <div class="card-header">
                Prediksi #{{ $p->id }} <span class="float-end">{{ $p->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="card-body">
                <ul>
                    <li>RATA-RATA: {{ $p->rata_rata }}</li>
                    <li>MAT: {{ $p->mat }}</li>
                    <li>BIO: {{ $p->bio }}</li>
                    <li>KIM: {{ $p->kim }}</li>
                    <li>BIG: {{ $p->big }}</li>
                    <li>MODEL: {{ $p->filename }}</li>
                    <li>Nilai Sertifikat: {{ $p->certificate_score ?? '-' }}</li>
                    <li><strong>Prediksi Kelulusan:</strong> 
                        @php
                                $score = floatval(str_replace('%', '', $p->result));
                        @endphp
                                <span class="badge {{ $score < 50 ? 'bg-danger' : 'bg-success' }}">
                            {{ $p->result }}
                        </span>
                    </li>

                </ul>
            </div>
        </div>
    @empty
        <p>Belum ada prediksi yang selesai diproses.</p>
    @endforelse
</div>
@endsection

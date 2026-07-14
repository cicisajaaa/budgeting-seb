@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Input Setoran Baru</h2>
    <p>Project: <strong>{{ $project->nama_project }}</strong></p>

    <form action="{{ route('deposit.preview', $project->id) }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Tanggal Setoran Klien:</label><br>
            <input type="date" name="tanggal_setoran" required style="padding: 8px; width: 100%; max-width: 300px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Jumlah Setoran (Rp):</label><br>
            <input type="number" name="jumlah_setoran" required placeholder="Contoh: 30000000" style="padding: 8px; width: 100%; max-width: 300px;">
        </div>

        <button type="submit" class="btn btn-success">Hitung Pembagian Otomatis &rarr;</button>
        <a href="{{ route('dashboard') }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
</div>
@endsection
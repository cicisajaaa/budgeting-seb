@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Konfirmasi Pembagian Budget</h2>
    <p>Sistem telah menghitung pembagian secara otomatis berdasarkan aturan persentase. Anda bisa mengubah nominalnya secara manual jika diperlukan.</p>
    
    <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Total Setoran: Rp {{ number_format($jumlahSetoran, 0, ',', '.') }}</strong>
    </div>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('deposit.storeFinal', $project->id) }}" method="POST">
        @csrf
        <input type="hidden" name="jumlah_setoran" value="{{ $jumlahSetoran }}">
        <input type="hidden" name="tanggal_setoran" value="{{ $request->tanggal_setoran }}">

        <table>
            <thead>
                <tr>
                    <th>Divisi</th>
                    <th>Nominal Jatah (Bisa Diedit Manual)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($defaultDistributions as $dist)
                <tr>
                    <td>{{ $dist['nama_divisi'] }}</td>
                    <td>
                        <input type="number" name="distribusi[{{ $dist['division_id'] }}]" value="{{ $dist['nominal'] }}" required min="0" style="padding: 8px; width: 200px;">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <br>
        <button type="submit" class="btn btn-success">Simpan Final ke Database</button>
        <a href="javascript:history.back()" class="btn" style="background: #6c757d;">Kembali</a>
    </form>
</div>
@endsection
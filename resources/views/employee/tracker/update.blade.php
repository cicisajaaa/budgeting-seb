@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

<div>

<div class="welcome-label">
UPDATE PROGRESS
</div>


<h1>
{{ $task->nama_tugas }}
</h1>


<p>
{{ $task->proyek->nama_proyek ?? '-' }}
</p>


</div>



<a href="{{ route('daily-tracker.index') }}"
class="back-btn">

← Kembali

</a>

</div>





<div class="glass-panel">


<h2>
✏️ Tambah Aktivitas
</h2>


<form method="POST"
action="{{ route('daily-tracker.store',$task->id) }}">


@csrf



<div class="form-group">

<label>
Aktivitas
</label>


<textarea
name="aktivitas"
rows="4"
required
placeholder="Contoh: Membuat laporan progress proyek">
</textarea>


</div>





<div class="form-group">


<label>
Progress (%)
</label>


<input 
type="number"
name="progres"
min="0"
max="100"
value="{{ $task->progres_persen }}"
required>


</div>





<div class="form-group">


<label>
Anggaran Aktivitas
</label>


<input 
type="number"
name="anggaran_aktivitas"
min="0">


</div>





<div class="form-group">


<label>
Catatan
</label>


<textarea
name="catatan"
rows="3"
placeholder="Catatan tambahan">
</textarea>


</div>





<button class="update-btn">

💾 Simpan Progress

</button>



</form>


</div>


@endsection
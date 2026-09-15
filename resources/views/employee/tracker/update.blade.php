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

<style>

.welcome-card{
    width:100%;
}

.welcome-card h1{
    word-break:break-word;
    line-height:1.4;
}

.welcome-card p{
    word-break:break-word;
    line-height:1.5;
}

.glass-panel{
    width:100%;
    box-sizing:border-box;
}

.form-group{
    width:100%;
}

.form-group input,
.form-group textarea{
    width:100%;
    box-sizing:border-box;
}

.update-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    box-sizing:border-box;
}


/* ===============================
   RESPONSIVE
================================ */

@media(max-width:900px){

    .welcome-card{
        flex-direction:column;
        align-items:stretch;
        gap:15px;
        padding:20px;
        border-radius:20px;
    }

    .welcome-label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:21px;
        line-height:1.35;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
    }

    .back-btn{
        width:100%;
        min-height:42px;
        display:flex;
        align-items:center;
        justify-content:center;
        box-sizing:border-box;
    }

    .glass-panel{
        padding:20px;
        border-radius:20px;
        overflow:hidden;
    }

    .glass-panel h2{
        font-size:15px;
        line-height:1.4;
        margin-bottom:18px;
    }

    .form-group{
        margin-bottom:16px;
    }

    .form-group label{
        font-size:10px;
    }

    .form-group input,
    .form-group textarea{
        width:100%;
        box-sizing:border-box;
        font-size:11px;
    }

    .form-group input{
        height:42px;
    }

    .form-group textarea{
        min-height:90px;
    }

    .update-btn{
        width:100%;
        min-height:42px;
        font-size:11px;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
    }

    .welcome-card p{
        font-size:10px;
        line-height:1.5;
    }

    .back-btn{
        height:42px;
        font-size:10px;
    }

    .glass-panel{
        padding:15px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .glass-panel h2{
        font-size:14px;
        margin-bottom:15px;
    }

    .form-group{
        margin-bottom:14px;
    }

    .form-group label{
        font-size:9px;
        margin-bottom:6px;
    }

    .form-group input,
    .form-group textarea{
        padding:10px;
        font-size:10px;
        border-radius:11px;
    }

    .form-group input{
        height:42px;
    }

    .form-group textarea{
        min-height:85px;
    }

    .update-btn{
        width:100%;
        height:42px;
        min-height:42px;
        padding:8px 15px;
        font-size:10px;
        border-radius:11px;
    }

}

</style>




@endsection
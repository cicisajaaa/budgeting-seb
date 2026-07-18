@extends('layouts.app')

@section('content')

<div class="container py-4">


    {{-- HEADER --}}
    <div class="mb-4">

        <h2 class="fw-bold">
            Daily Tracker
        </h2>

        <p class="text-muted">
            Update progress pekerjaan dan aktivitas harian kamu
        </p>

    </div>



    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif





    @forelse($tasks as $task)


    <div class="card shadow-sm mb-4 border-0">


        <div class="card-body">


            <div class="d-flex justify-content-between align-items-start">


                <div>

                    <h4 class="fw-bold">
                        {{ $task->nama_task }}
                    </h4>


                    <small class="text-muted">

                        Project:
                        {{ $task->project->nama_project ?? '-' }}

                    </small>

                </div>



                <span class="badge 
                @if($task->status == 'done')
                    bg-success
                @elseif($task->status == 'progress')
                    bg-primary
                @else
                    bg-secondary
                @endif
                ">

                    {{ strtoupper($task->status) }}

                </span>


            </div>




            <hr>



            <div class="row">


                <div class="col-md-4">

                    <p class="mb-1">
                        <b>Prioritas</b>
                    </p>

                    <span class="badge bg-warning text-dark">
                        {{ $task->prioritas }}
                    </span>

                </div>



                <div class="col-md-4">

                    <p class="mb-1">
                        <b>Deadline</b>
                    </p>

                    {{ $task->deadline ?? '-' }}

                </div>



                <div class="col-md-4">

                    <p class="mb-1">
                        <b>Progress</b>
                    </p>

                    {{ $task->progress_persen }}%

                </div>


            </div>



            <br>



            {{-- PROGRESS BAR --}}

            <div class="progress" style="height:20px">

                <div
                class="progress-bar"
                role="progressbar"
                style="
                width: {{ $task->progress_persen }}%
                ">

                {{ $task->progress_persen }}%

                </div>

            </div>




            <hr>



            {{-- FORM UPDATE --}}

            <h5 class="fw-bold">
                Update Aktivitas
            </h5>



            <form method="POST"
            action="{{ route('daily-tracker.store') }}">


            @csrf


            <input type="hidden"
            name="task_id"
            value="{{ $task->id }}">



            <div class="mb-3">

                <label>
                    Aktivitas Hari Ini
                </label>

                <textarea
                name="aktivitas"
                class="form-control"
                rows="3"
                required></textarea>

            </div>




            <div class="row">


                <div class="col-md-6">

                    <label>
                        Progress (%)
                    </label>

                    <input
                    type="number"
                    name="progress"
                    min="0"
                    max="100"
                    class="form-control"
                    value="{{ $task->progress_persen }}"
                    required>

                </div>



                <div class="col-md-6">

                    <label>
                        Budget Activity
                    </label>

                    <input
                    type="number"
                    name="budget_activity"
                    class="form-control"
                    value="0">

                </div>


            </div>



            <br>



            <div class="mb-3">

                <label>
                    Catatan
                </label>


                <textarea
                name="catatan"
                class="form-control"></textarea>


            </div>




            <button class="btn btn-primary">

                Simpan Update

            </button>


            </form>




            <hr>




            {{-- HISTORY --}}

            <h5 class="fw-bold">
                Riwayat Aktivitas
            </h5>



            @forelse($task->activities as $activity)


            <div class="border rounded p-3 mb-2">


                <div class="d-flex justify-content-between">


                    <strong>
                        {{ $activity->tanggal }}
                    </strong>


                    <span>
                        {{ $activity->progress }}%
                    </span>


                </div>


                <p class="mb-1">

                    {{ $activity->aktivitas }}

                </p>


                <small class="text-muted">

                    Budget:
                    Rp {{ number_format($activity->budget_activity) }}

                </small>


                <br>


                <small>

                    {{ $activity->catatan }}

                </small>


            </div>


            @empty

                <p class="text-muted">
                    Belum ada aktivitas.
                </p>

            @endforelse




        </div>

    </div>



    @empty


        <div class="alert alert-info">

            Belum ada task untuk kamu.

        </div>


    @endforelse



</div>


@endsection
@extends('layouts.dashboard')

@section('content')


<div class="project-container">


{{-- ================= PROJECT HEADER ================= --}}

<div class="project-welcome-card">

    <div>

        <div class="project-welcome-label">
            MY PROJECT
        </div>


        <h1>
            Project Saya
        </h1>


        <p>
            Monitoring project dan task yang diberikan kepada kamu.
        </p>

    </div>


    <div class="project-date-box">
        {{date('d M Y')}}
    </div>


</div>





{{-- ================= LIST PROJECT ================= --}}

@forelse($projects as $project)


<div class="project-panel">



    <div class="project-card-header">


        <div>

            <h2>
                📁 {{$project->nama_project}}
            </h2>


            <p>
                Owner : {{$project->project_owner ?? '-'}}
            </p>


        </div>


    </div>





    {{-- SUMMARY --}}

    <div class="project-summary-box">


        <div>

            <span>
                Total Task
            </span>

            <strong>
                {{$project->tasks->count()}}
            </strong>

        </div>




        <div>

            <span>
                Selesai
            </span>

            <strong>
                {{$project->tasks->where('status','done')->count()}}
            </strong>

        </div>




        <div>

            <span>
                Progress Project
            </span>

            <strong>
                {{$project->progress_keseluruhan}}%
            </strong>

        </div>


    </div>





    <h3 class="project-section-title">
        📌 Task Saya
    </h3>





@foreach($project->tasks as $task)



<div class="project-task-card">



    <div class="project-task-main">



        <div class="project-task-title">


            <h4>
                {{$task->nama_task}}
            </h4>


            <p>
                {{$task->aktivitas ?? '-'}}
            </p>


        </div>





        <div class="project-task-progress">


            <div class="project-progress-label">

                <span>
                    Progress
                </span>


                <b>
                    {{$task->progress_persen}}%
                </b>


            </div>



            <div class="project-progress-track">


                <div class="project-progress-value"
                style="width:{{$task->progress_persen}}%">
                </div>


            </div>



        </div>





        <div class="project-activity-info">

            📝 {{$task->activities->count()}}
            Aktivitas

        </div>



    </div>





    <div class="project-task-side">



        @php
            $statusDeadline = $task->deadlineStatus();
        @endphp



        <span class="project-deadline {{$statusDeadline['color']}}">

            {{$statusDeadline['label']}}

        </span>





        <span class="project-status

        @if($task->status=='done')
        done

        @elseif($task->status=='progress')
        progress

        @else
        todo

        @endif

        ">

            {{strtoupper($task->status)}}

        </span>




        <div class="project-button-group">


            <a href="{{route('employee.task.show',$task->id)}}">

                Detail

            </a>




            <a href="{{route('daily-tracker.show',$task->id)}}"
            class="project-update-btn">

                Update

            </a>


        </div>



    </div>




</div>



@endforeach





</div>



@empty



<div class="project-panel">

    Belum ada project.

</div>



@endforelse



</div>
<style>

/* =================================================
PROJECT CONTAINER
================================================= */

.project-container{

    width:100%;
    max-width:100%;
    overflow:hidden;

}



/* =================================================
PROJECT WELCOME
================================================= */


.project-welcome-card{

    background:
    linear-gradient(
    135deg,
    #166534,
    #22c55e
    );

    padding:30px;

    border-radius:24px;

    color:white;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 15px 40px rgba(34,197,94,.25);

}



.project-welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:700;

    opacity:.8;

}



.project-welcome-card h1{

    font-size:30px;

    margin:8px 0;

}



.project-welcome-card p{

    font-size:13px;

    opacity:.9;

}



.project-date-box{


    background:white;

    color:#166534;

    padding:12px 20px;

    border-radius:30px;

    font-weight:700;

}



/* =================================================
PROJECT PANEL
================================================= */


.project-panel{


    background:
    rgba(255,255,255,.85);


    backdrop-filter:blur(15px);


    padding:25px;


    border-radius:24px;


    margin-bottom:25px;


    box-shadow:

    0 10px 30px rgba(15,23,42,.08);


    width:100%;


}





/* =================================================
PROJECT HEADER
================================================= */


.project-card-header h2{


    color:#166534;

    margin-bottom:6px;


}



.project-card-header p{


    color:#64748b;

    font-size:13px;


}







/* =================================================
SUMMARY
================================================= */


.project-summary-box{


    display:grid;


    grid-template-columns:repeat(3,1fr);


    gap:15px;


    margin:25px 0;


}





.project-summary-box div{


    background:#f8fafc;


    padding:18px;


    border-radius:18px;


}





.project-summary-box span{


    display:block;


    color:#64748b;


    font-size:12px;


    margin-bottom:8px;


}




.project-summary-box strong{


    font-size:24px;


    color:#166534;


}






.project-section-title{


    color:#1e293b;


    margin-bottom:15px;


}







/* =================================================
TASK CARD
================================================= */


.project-task-card{


    display:flex;


    justify-content:space-between;


    align-items:center;


    gap:25px;


    background:#f8fafc;


    padding:22px;


    border-radius:20px;


    margin-bottom:15px;


}




.project-task-main{


    flex:1;


    min-width:0;


}





.project-task-title h4{


    font-size:17px;


    color:#166534;


    margin-bottom:5px;


}





.project-task-title p{


    color:#64759b;


    font-size:13px;


}






/* =================================================
PROGRESS
================================================= */


.project-task-progress{


    margin-top:18px;


}





.project-progress-label{


    display:flex;


    justify-content:space-between;


    margin-bottom:8px;


    font-size:12px;


}





.project-progress-label b{


    color:#166534;


}





.project-progress-track{


    height:10px;


    width:80%;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}




.project-progress-value{


    height:100%;


    background:

    linear-gradient(
    90deg,
    #166534,
    #22c55e
    );


    border-radius:20px;


}






.project-activity-info{


    margin-top:12px;


    font-size:12px;


    color:#64748b;


}






/* =================================================
SIDE STATUS
================================================= */


.project-task-side{


    width:180px;


    text-align:right;


}




.project-deadline,


.project-status{


    display:block;


    padding:7px 12px;


    border-radius:20px;


    font-size:11px;


    font-weight:700;


    margin-bottom:8px;


}





.project-deadline.danger{


    background:#fee2e2;


    color:#991b1b;


}



.project-deadline.success{


    background:#dcfce7;


    color:#166534;


}



.project-deadline.secondary{


    background:#e2e8f0;


    color:#475569;


}






.project-status.todo{


    background:#e2e8f0;


    color:#475569;


}





.project-status.progress{


    background:#dbeafe;


    color:#1d4ed8;


}





.project-status.done{


    background:#dcfce7;


    color:#166534;


}







/* =================================================
BUTTON
================================================= */


.project-button-group{


    display:flex;


    justify-content:flex-end;


    gap:8px;


    margin-top:15px;


}




.project-button-group a{


    background:#166534;


    color:white;


    padding:9px 15px;


    border-radius:14px;


    font-size:12px;


    font-weight:700;


    text-decoration:none;


}





.project-button-group .project-update-btn{


    background:#2563eb;


}





.project-button-group a:hover{


    opacity:.85;


}


/* =================================================
RESPONSIVE
================================================= */


@media(max-width:1200px){


    .project-summary-box{

        grid-template-columns:repeat(2,1fr);

    }


}




@media(max-width:900px){


    .project-welcome-card{


        flex-direction:column;


        align-items:flex-start;


        gap:15px;


    }





    .project-task-card{


        flex-direction:column;


        align-items:flex-start;


    }





    .project-task-side{


        width:100%;


        text-align:left;


    }





    .project-button-group{


        justify-content:flex-start;


    }



    .project-progress-track{


        width:100%;


    }


}





@media(max-width:600px){


    .project-summary-box{


        grid-template-columns:1fr;


    }



    .project-panel{


        padding:18px;


    }



    .project-welcome-card{


        padding:22px;


    }



    .project-welcome-card h1{


        font-size:24px;


    }



}



/* =================================================
FIX AGAR TIDAK MENYEBAR KE LAYOUT
================================================= */


.project-container *{


    box-sizing:border-box;


}


</style>


@endsection
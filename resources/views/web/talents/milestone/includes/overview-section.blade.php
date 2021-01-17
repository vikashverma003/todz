<h3>Submission Details</h3>
<ul class="detailList" >
    <li>
        <h4>Start Date</h4>
        <p>-</p>
    </li>
    <li>
        <h4>Due Date</h4>
        <p>-</p>
    </li>
    <li>
        <h4>Completed On</h4>
        {{-- <p>{{@$project->talents->where('id',Auth::user()->id)[0]->pivot->no_of_hours}}</p> --}}
        <p>-</p>
    </li>
</ul>

@include('web.talents.milestone.includes.payment-overview')

<h3>Milestones</h3>
@if($milestones->isEmpty())
    <div class="milestoneDiv">
        <h5>
            <img src="{{asset('web/images/ic_work_experience.png')}}" alt="">
            You have not set up your milestones yet!
        </h5>
    </div>
@else
<div class="milestoneTableDiv">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">NAME</th>
            <th scope="col">START DATE</th>
            <th scope="col">DUE DATE</th>
            <th scope="col">HOURS</th>
            {{-- <th scope="col">SUBMITTED ON </th> --}}
            <th scope="col">PAYMENT</th>
            <th scope="col">STATUS</th>
          </tr>
        </thead>
        <tbody>
            @foreach($milestones as $key=> $milestone)
          <tr>
            <th>{{$milestone->title}}</th>
            <td>{{$milestone->start_date}}</td>
            <td>{{$milestone->due_date}}</td>
            <td>{{$milestone->no_of_hours}}</td>
            {{-- <td>-</td> --}}
            <td>-</td>
            <td>  @if($milestone->status==0)
                <span class="pending">Pending</span>
                    @else
            <span class="approved">Approved</span>
            @endif</td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
@endif
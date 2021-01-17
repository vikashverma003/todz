<h3>Submission Details</h3>
<ul class="detailList">
    <li>
        <h4>Start Date</h4>
        <p>-</p>
    </li>
    <li>
        <h4>Due Date</h4>
        <p>-</p>
    </li>
    <li>
        <h4>Completed on</h4>
        <p>-</p>
    </li>
</ul>
@include('web.client.dashboard.project-includes.payment-overview')

<h3>Milestones</h3>

<div class="milestoneTableDiv">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">NAME</th>
                <th scope="col">DUE DATE</th>
                <th scope="col">SUBMITTED ON </th>
                <th scope="col">PAYMENT</th>
                <th scope="col">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($project->clientMileStone($talent->id) as $milestone)
            <tr>
                <td>{{$milestone->title}}</td>
                <td>{{$milestone->due_date}}</td>
                <td>-</td>
                <td>${{$milestone->cost}}</td>
                <td>
                    @if($milestone->status == config('constants.milestone_status.PENDING'))
                    <span class="pending"> Pending</span>
                    @elseif($milestone->status == config('constants.milestone_status.APPROVED'))
                    <span class="approved"> Approved</span>
                    @endif
                </td>
            </tr>
            @empty
                <tr><td colspan="12" style="text-align: center;">No Milestone added yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('web.client.dashboard.project-includes.payment-overview')

<h3>Payment Details</h3>
<div class="milestoneTableDiv">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Milestone</th>
                <th scope="col">cost</th>
                {{-- <th scope="col">Due Date</th> --}}
                <th scope="col">Paid on</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $key=>$payment)
            <tr>
                <th> 
                    @if(ProjectManager::getProjectDuration($project->id,$talent->id)<=30)
                        100%
                    @else
                        @if($key<2)
                            25%
                        @else
                            50%
                        @endif
                    @endif
                </th>
                <td><span class="completed">{{$payment->amount}}</span></td>
                <td>{{date('d/m/Y',strtotime($payment->created_at))}}</td>
                <td><img src="{{asset('web/images/tick.png')}}" alt="">Paid</td>
                <td>
                    <a href="{{url('client/milestone-invoice/'.$payment->project_id.'/'.$payment->id)}}" target="_blank">
                        <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">Invoice
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <th colspan="12" style="text-align:center;" >No Payment Record</th>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
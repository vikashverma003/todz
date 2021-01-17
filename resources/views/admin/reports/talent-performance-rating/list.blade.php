@if($data->isNotEmpty())
    @php
        $i= 1;
    @endphp

    @foreach ($data as $row)
        <tr class="text-left">
            <td>{{$i}}</td>
            <td class="text-left">
                <a class="view" href="{{url('admin/talents/'.$row->id)}}" data-toggle="tooltip" title="View" target="_blank">
                    {{@$row->todz_id ?? 'N/A'}}
                </a>
            </td>
            <td>{{@$row->first_name}} {{@$row->last_name}}</td>
            <td>
                <?php
                    $skills = [];
                    $talent_skills = isset($row->talent->skills) ? $row->talent->skills->toArray() : [];
                    $skills = array_column($talent_skills, 'name');
                    $skills = implode(',', $skills);
                ?>
                {{$skills}}
            </td>
            <td>{{@$row->created_at ? date('d/m/Y', strtotime($row->created_at)) : 'N/A'}}</td>
            
            <td>
                <?php
                    $rating = [];
                    $talent_rating = isset($row->ratings) ? $row->ratings->toArray() : [];
                    $rating = array_column($talent_rating, 'rating');
                    $rating = array_sum($rating);
                    $rating = is_numeric($rating) ? $rating : 0;
                ?>
                {{$rating/5}}
            </td>
            
        </tr>
        @php $i++; @endphp
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="12">No Data Available</td>
    </tr>
@endif
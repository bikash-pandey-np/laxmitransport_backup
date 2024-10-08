@if($row->status == 'approved')
    <a href="javascript:void(0)"
       class="btn btn-success">Awarded</a>
@else

    <a href="{{ route('super_admin.loadboard.approve',$row->id) }}"
       class="btn btn-info">Approve</a>
    <a href="{{ route('super_admin.loadboard.reject',$row->id) }}"
       class="btn btn-danger">Reject</a>

@endif

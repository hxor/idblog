{!! Form::model($model, ['url' => $url_destroy, 'method' => 'DELETE']) !!}
    <a href="{{ $url_show }}" class="btn btn-sm btn-outline-info" style="padding-bottom: 0px; padding-top: 0px;">
        Show
        <span class="btn-label btn-label-right"><i class="fa fa-eye"></i></span>
    </a>
    <a href="{{ $url_edit }}" class="btn btn-sm btn-outline-secondary" style="padding-bottom: 0px; padding-top: 0px;">
        Edit
        <span class="btn-label btn-label-right"><i class="fa fa-edit"></i></span>
    </a>
    <button  
        type="submit" class="btn btn-sm btn-outline-danger" 
        style="padding-bottom: 0px; padding-top: 0px;"
        onclick="return confirm('Are you sure you want to delete this item?');"
    >
        Delete
        <span class="btn-label btn-label-right"><i class="fa fa-trash"></i></span>
    </button>
{!! Form::close() !!}
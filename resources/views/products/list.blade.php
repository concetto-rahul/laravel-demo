@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}} <a href="{{route('products.add')}}" class="btn btn-sm btn-info float-right">Add New Product</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">SKU Code</th>
                                <th scope="col">Add Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $list_key=>$list_val)
                            <tr>
                                <th scope="row">{{$list_key+1}}</th>
                                <td>@if($list_val['imageviewfile'])<img src="{{asset($list_val['imageviewfile'])}}" class="img-fluid">@endif</td>
                                <td>{{$list_val['name']}}</td>
                                <td>{{$list_val['sku_code']}}</td>
                                <td>{{$list_val['updated_at']->format('d/m/Y H:i A')}}</td>
                                <td>
                                    <a href="{{route('products.edit',$list_val['id'])}}">Edit</a>
                                    <a href="javascript:" data-hrefurl="{{route('products.delete',$list_val['id'])}}" class="delete_data">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$list->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal_view')
<div class="modal" id="delete_data" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are sure you want to delete the data?</p>
      </div>
      <div class="modal-footer">
      <form method="post" action="">
                        @method('DELETE')
                        @csrf
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete</button>
</form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('action_script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click','.delete_data',function(){
        $('#delete_data').find('form').attr('action',$(this).data('hrefurl'));
        $('#delete_data').modal('show');
    });
</script>
@endsection
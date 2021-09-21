@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>

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
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Register Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $list_key=>$list_val)
                            <tr>
                                <th scope="row">{{$list_key+1}}</th>
                                <td>{{$list_val['name']}}</td>
                                <td>{{$list_val['email']}}</td>
                                <td>{{$list_val['created_at']->format('d/m/Y H:i A')}}</td>
                                <td>
                                    <a href="{{url('user/edit/'.$list_val['id'])}}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

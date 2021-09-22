@extends('admin.layouts.app')

@section('css_libraries')
<link rel="stylesheet" href="{{ asset('admin_theme/modules/datatables/datatables.min.css') }}">
@endsection

@section('page_content')
<div class="main-wrapper">
    @include('admin.common.header')
    @include('admin.common.navigation')
      <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                @if(isset($title))
                <div class="section-header">
                    <h1>{{$title}}</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                        <div class="breadcrumb-item">{{$title}}</div>
                    </div>
                </div>
                @endif
                <div class="section-body">
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="product-table">
                                            <thead>
                                                <tr>     
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            </tbody>
                                                @foreach ($roles as $key => $role)
                                                <tr>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="{{ route('admin.roles.show',[app()->getLocale(),$role->id]) }}">Show</a>
                                                        @can('role-edit')
                                                            <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.edit',[app()->getLocale(),$role->id]) }}">Edit</a>
                                                        @endcan
                                                        @can('role-delete')
                                                            {!! Form::open(['method' => 'DELETE','route' => ['admin.roles.destroy',[app()->getLocale(),$role->id]],'style'=>'display:inline']) !!}
                                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
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
                </div>
            </section>
      </div>
    @include('admin.common.footer')
</div>
@endsection
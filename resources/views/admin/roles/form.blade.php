@extends('admin.layouts.app')
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
                                    {{ Form::open(['method' => 'post','route' => ['admin.roles.update', [app()->getLocale(),$role->id]]]) }}
                                        @method('PUT')
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            {{ $role->name }}
                                        </div>
                                        <div class="form-group">
                                            <label for="permission">Permission</label>
                                            <br>
                                            @foreach($permission as $value)
                                                <div class="form-check form-check-inline">
                                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'form-check-input','id' => $value->name.'-'.$value->id )) }}
                                                    <label class="form-check-label" for="{{ $value->name.'-'.$value->id }}">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('admin.roles.index',app()->getLocale())}}" class="btn btn-warning">Cancel</a>
                                    {{ Form::close() }}
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
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
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                {{ $role->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Permissions:</strong>
                                                @if(!empty($rolePermissions))
                                                    @foreach($rolePermissions as $v)
                                                        <label class="label label-success">{{ $v->name }},</label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
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
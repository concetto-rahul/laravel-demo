@extends('admin.layouts.app')

@php 
$id=isset($detail['id'])?$detail['id']:0;
$name=isset($detail['name'])?$detail['name']:old('name');
$sku_code=isset($detail['sku_code'])?$detail['sku_code']:old('sku_code');
$description=isset($detail['description'])?$detail['description']:old('description');
$imageviewfile=isset($detail['imageviewfile'])?$detail['imageviewfile']:old('imageviewfile');
@endphp

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
                                    @if(empty($detail))
                                    <form method="post" action="{{route('admin.product.store',[app()->getLocale()])}}" id="productForm" enctype="multipart/form-data">
                                    @else
                                    <form method="post" action="{{route('admin.product.update',[app()->getLocale(),$id])}}" id="productFormEdit" enctype="multipart/form-data">
                                        @method('PUT')
                                        @endif
                                        @csrf
                                        <input type="hidden" name="id" value="{{$id}}"/> 
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$name}}">
                                            @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="sku_code">SKU Code</label>
                                            <input type="text" class="form-control @error('sku_code') is-invalid @enderror" id="sku_code" name="sku_code" value="{{$sku_code}}">
                                            @error('sku_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{$description}}</textarea>
                                            @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="imageviewfile">Product Image</label>
                                            <input type="file" class="form-control @error('imageviewfile') is-invalid @enderror" id="imageviewfile" name="imageviewfile">
                                            @error('imageviewfile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('admin.product.index',app()->getLocale())}}" class="btn btn-warning">Cancel</a>
                                    </form>
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

@section('page_script')
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Product\StoreRequest', '#productForm') !!}
{!! JsValidator::formRequest('App\Http\Requests\Product\UpdateProduct', '#productFormEdit') !!}
@endsection
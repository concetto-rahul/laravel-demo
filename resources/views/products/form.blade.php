@extends('layouts.app')
@php 
$id=isset($detail['id'])?$detail['id']:0;
$name=isset($detail['name'])?$detail['name']:old('name');
$sku_code=isset($detail['sku_code'])?$detail['sku_code']:old('sku_code');
$description=isset($detail['description'])?$detail['description']:old('description');
$imageviewfile=isset($detail['imageviewfile'])?$detail['imageviewfile']:old('imageviewfile');
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(empty($detail))
                    <form method="post" action="{{route('products.save')}}" enctype="multipart/form-data">
                        @else
                    <form method="post" action="{{route('products.update',$id)}}" enctype="multipart/form-data">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

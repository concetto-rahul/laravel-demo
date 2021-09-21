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
                                                    <th>SKU Code</th>
                                                    <th>Added Date</th>
                                                    <th>Added By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
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
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
</div>
@endsection

@section('page_script')
<script>
    var pageModel = $("#deleteModal");
    var productTable = "{{ route('admin.product.table',app()->getLocale()) }}";
    var csrfToken = "{{csrf_token()}}";  
</script>
<script src="{{ asset('admin_theme/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin_theme/js/pages/product/product.js') }}"></script>
@endsection
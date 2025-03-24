@extends('layout/main')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('page-style')
<style>
    .text-red{
        color:red;
    }
</style>

@endsection

@section('content')
<div class="section-body mt-3">
    <div class="container-fluid">
       <!-- Breadcrumb and Button Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    {{-- <li class="breadcrumb-item active" aria-current="page"> <a href="#">Add Booking</a></li> --}}
                </ol>
            </nav>
        </div>
        <div class="row clearfix">
            <div class="col-12 col-sm-12">
                <div class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($category))
                                <form action="{{route('category.update', $category->id)}}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('category.store') }}" method="POST">
                            @endif
                            
                            @csrf
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <input class="form-control" name="id" type="hidden" value="{{ isset($category) ? $category->id : null }}">

                                        <div class="form-group">
                                            <label>Category Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="category_name" type="text" value="{{ old('category_name', isset($category) ? $category->name : '') }}" >
                                            @error('category_name')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Parent Category</label>
                                            <select class="form-control" name="parent_id" id="parent_id" >
                                                <option value="">Select Parent Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ isset($category) && $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                          
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right m-t-20">
                                        <button type="submit" class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')

<script>
    $(document).ready(function() 
    {
       
    });
</script>
@endsection
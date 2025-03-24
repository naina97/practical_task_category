@extends('layout/main')
@section('title', 'Booking')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
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
                    <li class="breadcrumb-item active" aria-current="page">Booking List</li>
                </ol>
            </nav>

            <div class="d-flex gap-2">
                <a href="{{ route('category.create') }}">
                    <button type="button" class="btn btn-danger">Add Categor</button>
                </a>
            </div>
        </div>
        @include('layout/toaster')
        <form class="list-table" method="get" action="{{route('category.index')}}">
            <div class="row clearfix">
                <div class="col-12 col-sm-12">
                    <div class="input-group mb-3">
                       <input type="text" name="q" class="form-control" placeholder="Search Category or Subcategory"
                            value="{{ request('q') }}">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-danger" title="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Categor Name</th>
                                                <th>Sub Categor Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>{{ $category->id }}</td>
                                                    <td> {{ $category->name }}</td>
                                                    <td>
                                                        @if($category->children->count())
                                                            <ul>
                                                                @foreach($category->children as $subCategory)
                                                                    <li>{{ $subCategory->name }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        
                                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                    
                                                    <td>{{$category->children->count()}}</td>
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
        </form>
    </div>
</div>
@endsection

@section('page-script')

@endsection
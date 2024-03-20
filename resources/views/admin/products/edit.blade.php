@extends('admin.layouts.master')

@section('title','Category Create Page')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="col-1 offset-1">
                            <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()" style="cursor: pointer;"></i>
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Pizza Details</h3>
                        </div>
                        <hr style="width: 300px; margin: 0 auto;">
                        <br>
                        @if (session('updateSuccess'))
                        <div class="col-6 offset-6">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid"></i> {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-4 offset-1">
                                <img src="{{ asset('Storage/'.$pizza->image) }}" alt="image" class="img-thumbnail">

                            </div>
                            <div class="col-5 offset-1">
                                <p><i class="fa-solid fa-note-sticky"></i> {{ $pizza->name }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-note-sticky"></i> {{ $pizza->category_name }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-money-bill-1-wave"></i> {{ $pizza->price }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-clock"></i> {{ $pizza->waiting_time }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-eye"></i> {{ $pizza->view_count }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-file-lines"></i> {{ $pizza->description }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-user-clock"></i> {{ $pizza->created_at->format('j-F-Y') }}</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-4 offset-2">
                                <a href="{{ route('products#updatePage',$pizza->id) }}">
                                    <button class="btn btn-dark">
                                        <i class="fa-solid fa-pen-to-square"></i>Edit Product
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
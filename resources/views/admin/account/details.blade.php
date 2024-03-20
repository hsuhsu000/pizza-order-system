@extends('admin.layouts.master')

@section('title','Account Information')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Information</h3>
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
                                @if (Auth::user()->image == null)
                                <img src="{{ asset('image/profile.png') }}" alt="image" class="img-thumbnail">
                                @else
                                <img src="{{ asset('Storage/'.Auth::user()->image) }}" alt="image" class="img-thumbnail">
                                @endif
                            </div>
                            <div class="col-5 offset-1">
                                <p><i class="fa-solid fa-user-pen"></i> {{ Auth::user()->name }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-envelope"></i> {{ Auth::user()->email }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-phone"></i> {{ Auth::user()->phone }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-address-card"></i> {{ Auth::user()->address }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-address-card"></i> {{ Auth::user()->gender }}</p>
                                <hr style="width: 60%;">
                                <p><i class="fa-solid fa-user-clock"></i> {{ Auth::user()->created_at->format('j-F-Y') }}</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-4 offset-2">
                                <a href="{{ route('account#edit') }}">
                                    <button class="btn btn-dark">
                                        <i class="fa-solid fa-pen-to-square"></i>Edit Profile
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
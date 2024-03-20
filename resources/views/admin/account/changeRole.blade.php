@extends('admin.layouts.master')

@section('title','Category Role')

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
                            <h3 class="text-center title-2">Change Role</h3>
                        </div>
                        <hr style="width: 300px; margin: 0 auto;">
                        <br>
                        <form action="{{ route('account#change',$account->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    @if ($account->image == null)
                                    <img src="{{ asset('image/profile.png') }}" alt="" class="border border-gray rounded">
                                    @else
                                    <img src="{{ asset('Storage/'.$account->image) }}" alt="">
                                    @endif

                                    <div class="mt-2">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" disabled>
                                        @error('image')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-dark" type="submit">
                                            <i class="fa-solid fa-circle-chevron-right"></i>Update
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" value="{{ old('name',$account->name) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" disabled>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <select name="role" id="" class="form-control">
                                            <option value="admin" @if($account->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if($account->role == 'user') selected @endif>User</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="text" value="{{ old('email',$account->email) }}" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" disabled>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="text" value="{{ old('phone',$account->phone) }}" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" disabled>
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <input id="cc-pament" name="address" type="text" value="{{ old('address',$account->address) }}" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" disabled>
                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" disabled>
                                            <option value="">Choose Gender</option>
                                            <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if($account->gender == 'female') selected @endif>Female</option>
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror

                                    </div>



                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
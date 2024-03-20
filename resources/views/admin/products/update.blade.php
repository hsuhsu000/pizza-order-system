@extends('admin.layouts.master')

@section('title','Product Update')

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
                        <form action="{{ route('products#update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                    <img src="{{ asset('Storage/'.$pizza->image) }}" alt="">

                                    <div class="mt-2">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
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
                                        <input id="cc-pament" name="pizzaName" type="text" value="{{ old('pizzaName',$pizza->name) }}" class="form-control @error('pizzaName') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                        @error('pizzaName')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <select name="pizzaCategory" id="" class="form-control @error('pizzaCategory') is-invalid @enderror">
                                            <option value="">Choose Category</option>
                                            @foreach ($category as $c)
                                            <option value="{{ $c->id }}" @if($pizza->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('pizzaCategory')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input id="cc-pament" name="pizzaPrice" type="text" value="{{ old('pizzaPrice',$pizza->price) }}" class="form-control @error('pizzaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                        @error('pizzaPrice')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Waiting Time</label>
                                        <input id="cc-pament" name="waitingTime" type="text" value="{{ old('waitingTime',$pizza->waiting_time) }}" class="form-control @error('waitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                        @error('waitingTime')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">View Count</label>
                                        <input id="cc-pament" name="phone" type="text" value="{{ $pizza->view_count }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                        <textarea name="pizzaDescription" id="cc-pament" cols="30" rows="10" value="{{ old('pizzaDescription',$pizza->description) }}" class="form-control @error('pizzaDescription') is-invalid @enderror">{{ $pizza->description }}</textarea>
                                        @error('pizzaDescription')
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
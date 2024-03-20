@extends('admin.layouts.master')

@section('title','Pizza List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Pizza List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('products#createPage') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Pizza
                            </button>
                        </a>
                        <!-- <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button> -->
                    </div>
                </div>

                @if (session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid"></i> {{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-8">
                        <h4>Search Key: <span class="text-danger">{{ request('key') }}</span></h3>
                    </div>
                    <div class="col-4">
                        <form action="{{ route('products#list') }}" method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="key" class="form-control" placeholder="Search Pizza Name" value="{{ request('key') }}">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                @if(count($pizzas) != 0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Waiting Time</th>
                                <th>View Count</th>
                                <th>Category</th>
                                <th><span style="color:gray"><i class="fa-solid fa-database"></i></span> Total Pizza-{{ $pizzas->total() }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pizzas as $p)
                            <tr class="tr-shadow">
                                <td class="col-2"><img src="{{ asset('storage/'.$p->image) }}" alt="" class="img-thumbnail shadow-sm"></td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->price }} Kyats</td>
                                <td>{{ $p->waiting_time }} Mins</td>
                                <td><i class="fa-solid fa-eye"></i>{{ $p->view_count }}</td>
                                <td>{{ $p->category_name }}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <!-- <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button> -->
                                        <a href="{{ route('products#edit',$p->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </a>

                                        <a href="{{ route('products#delete',$p->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $pizzas->links() }}

                    </div>
                </div>

                @else
                <h3 class="text-secondary text-center mt-5">There is no pizza created.</h3>
                @endif
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
@extends('admin.layouts.master')

@section('title','Order List Page')

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
                            <h2 class="title-1 me-2">Order Lists</h2>

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

                <form action="{{ route('admin#changeStatus') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <label class="mt-2 me-2">Order Status</label>
                        <select name="orderStatus" class="form-control col-2">
                            <option value="">All</option>
                            <option value="0" @if(request('orderStatus')==0) selected @endif>Pending</option>
                            <option value="1" @if(request('orderStatus')==1 ) selected @endif>Success</option>
                            <option value="2" @if(request('orderStatus')==2) selected @endif>Reject</option>
                        </select>
                        <button type="submit" class="btn btn-dark">Search</button>
                    </div>
                </form>


                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>UserId</th>
                                <th>UserName</th>
                                <th>Order Date</th>
                                <th>Order Code</th>
                                <th>Amount</th>
                                <th>Status&nbsp;&nbsp;&nbsp;
                                    <i class="fa-solid fa-database"></i>Total Order-{{ count($order) }}
                                </th>

                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($order as $o)
                            <tr class="tr-shadow">
                                <input type="hidden" class="orderId" value="{{ $o->id }}">
                                <td>{{ $o->user_id }}</td>
                                <td>{{ $o->user_name }}</td>
                                <td>{{ $o->created_at->format('M-d-Y') }}</td>
                                <td><a href="{{ route('admin#listInfo',$o->order_code) }}">{{ $o->order_code }}</a></td>
                                <td class="amount">{{ $o->total_price }} Kyats</td>
                                <td>
                                    <select name="status" class="form-control statusChange">
                                        <option value="0" @if ($o->status == 0) selected @endif>Pending</option>
                                        <option value="1" @if($o->status == 1) selected @endif>Success</option>
                                        <option value="2" @if($o->status == 2) selected @endif>Reject</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">


                    </div>
                </div>


                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
<script>
    $(document).ready(function() {
        // $('#orderStatus').change(function() {
        //     $status = $('#orderStatus').val();
        //     console.log($status);

        //     $.ajax({
        //         type: 'get',
        //         url: 'http://127.0.0.1:8000/order/ajax/status',
        //         data: {
        //             'status': $status,
        //         },
        //         dataType: 'json',
        //         success: function(response) {

        //             $list = '';
        //             for ($i = 0; $i < response.length; $i++) {
        //                 $months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July',
        //                     'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        //                 ];
        //                 $dbDate = new Date(response[$i].created_at);
        //                 $finalDate = $months[$dbDate.getMonth()] + '-' + $dbDate.getDate() + '-' + $dbDate.getFullYear();

        //                 if (response[$i].status == 0) {
        //                     $statusMessage = `
        //                     <select name="orderStatus" class="form-control statusChange">
        //                                 <option value="0" selected>Pending</option>
        //                                 <option value="1">Success</option>
        //                                 <option value="2">Reject</option>
        //                             </select>
        //                     `;
        //                 }

        //                 if (response[$i].status == 1) {
        //                     $statusMessage = `
        //                     <select name="orderStatus" class="form-control statusChange">
        //                                 <option value="0">Pending</option>
        //                                 <option value="1" selected>Success</option>
        //                                 <option value="2">Reject</option>
        //                             </select>
        //                     `;
        //                 }

        //                 if (response[$i].status == 2) {
        //                     $statusMessage = `
        //                     <select name="orderStatus" class="form-control statusChange">
        //                                 <option value="0">Pending</option>
        //                                 <option value="1">Success</option>
        //                                 <option value="2" selected>Reject</option>
        //                             </select>
        //                     `;
        //                 }

        //                 $list += `
        //                 <tr class="tr-shadow">
        //                          <input type="hidden" class="orderId" value="${response[$i].id}">
        //                         <td>${response[$i].user_id}</td>
        //                         <td>${response[$i].user_name} || ${response[i].id}</td>
        //                         <td>${$finalDate}</td>
        //                         <td>${response[$i].order_code}</td>
        //                         <td>${response[$i].total_price} Kyats</td>
        //                         <td>${$statusMessage}</td>
        //                     </tr>
        //                 `;
        //             }
        //             $('#dataList').html($list);
        //         }
        //     })
        // })

        $('.statusChange').change(function() {
            $currentStatus = $(this).val();
            $parentNode = $(this).parents('tr');
            $orderId = $parentNode.find('.orderId').val();

            $data = {
                'status': $currentStatus,
                'orderId': $orderId
            }
            console.log($data);

            $.ajax({
                type: 'get',
                url: 'http://127.0.0.1:8000/order/ajax/change/status', //ajaxchangeStatus
                data: $data,
                dataType: 'json',
            })
        })
    })
</script>
@endsection
@extends('layouts.app')
@section('title','Daftar Akun')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/select.bootstrap4.min.css')}}">
@endsection
@section('page_js')
<script src="{{ asset('assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/modules-datatables.js') }}"></script>

@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Akun</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-1">
                        <thead>                                 
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($account as $acc)
                                <tr class="clickable-row" data-href="{{route('admin.profile_account',$acc->id)}}" style="cursor: pointer;">
                                    <td>{{$no++}}</td>
                                    <td><span class="image"><img src="{{asset($acc->photo)}}" class="rounded-circle" width="35" height="35" data-toggle="tooltip" title="{{$acc->name}}"></span>&nbsp;&nbsp; {{$acc->name}} 
                                        @if($acc->role == 3)
                                            (Admin)
                                        @elseif($acc->role ==2)
                                            (Driver)
                                        @else
                                            (User)
                                        @endif</td>
                                    <td>{{$acc->email}}</td>
                                    <td>
                                        @php $available = ''; @endphp
                                        @foreach($addresses as $add)
                                            @if($add->id_users == $acc->id)
                                                @php
                                                    $available = TRUE;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if($available == TRUE)
                                            <div class="badge badge-success">Tersedia</div>
                                        @else
                                            <div class="badge badge-danger">Tidak tersedia</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
@endsection
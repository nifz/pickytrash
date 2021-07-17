@extends('layouts.app')
@section('title','Balas Pesan')
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
<div class="row ">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="text-bold mb-4">Detail Pesan</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-1">
                        <thead>                                 
                            <tr>
                                <th>Pesan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>{{$data->name_contact_us}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$data->email_contact_us}}</td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td>{{$data->subject_contact_us}}</td>
                            </tr>
                            <tr>
                                <td>Isi Pesan</td>
                                <td>{{$data->message_contact_us}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="text-bold mb-4">Pesan Balasan</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-1">
                        <thead>                                 
                            <tr>
                                <th>Pesan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$data->email}}</td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td>{{$data->subject}}</td>
                            </tr>
                            <tr>
                                <td>Isi Pesan</td>
                                <td>{{$data->message}}</td>
                            </tr>
                            <tr>
                                <td>Dibalas Oleh</td>
                                <td>{{$data->user_name}}</td>
                            </tr>
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
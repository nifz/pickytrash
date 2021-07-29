@extends('layouts.app')
@section('title','Balas Pesan')
@section('content')
<div class="row ">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail Pesan Masuk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover">
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
            <div class="card-header">
                <h4 class="card-title">Balas Pesan</h4>
            </div>
            <div class="card-body">
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
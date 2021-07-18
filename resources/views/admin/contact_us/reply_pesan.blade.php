@extends('layouts.app')
@section('title','Detail Pesan')
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
            <div class="card-header">
                <h4 class="card-title">Detail Pesan Masuk</h4>
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
                <form  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="hidden" name="id" id="id" class="form-control" value="{{$data->id}}">
                        <input type="hidden" name="name" id="name" class="form-control" value="{{$data->name}}">
                        <input type="hidden" name="email" id="email" class="form-control" value="{{$data->email}}">
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Masukkan subject" aria-describedby="subject" value="{{"Reply - ".$data->subject}}">
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea name="message" id="message" class="form-control" style="height: 100px;" placeholder="Masukkan pesan" aria-describedby="message"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Kirim Pesan</button>
                </form>
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
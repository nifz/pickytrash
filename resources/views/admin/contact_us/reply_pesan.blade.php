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
            <div class="card-body">
                <h3 class="text-bold mb-4">Balas Pesan</h3>
                <form  method="POST" action="{{ route('admin.contact_us_reply_store', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan nama" aria-describedby="name" value="{{$data->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan email" aria-describedby="email" value="{{$data->email}}">
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan subject" aria-describedby="subject">
                </div>
                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea name="message" id="message" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan pesan" aria-describedby="message" rows="3"></textarea>
                </div>
                <button class="btn btn-primary">Kirim Pesan</button>
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
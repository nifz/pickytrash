@extends('layouts.app')
@section('title','Daftar Pesan Contact Us')
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-1">
                        <thead>                                 
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                @if (!empty($jml))
                    @foreach($data as $d)
                            <tr>
                                <td>{{$d->name}}</td>
                                <td>{{$d->email}}</td>
                                <td>{{ substr($d->subject, 0,  70) }}..</td>
                                <td>
                                    @if($d->is_reply==0)
                                        <span class="badge badge-dark">Menunggu Balasan</span>
                                    @elseif ($d->is_reply==1)
                                        <span class="badge badge-success">Dibalas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.contact_us_reply', $d->id)}}" class="btn btn-primary mr-2 mb-2 text-white">Balas</a>
                                </td>
                            </tr>
                    @endforeach
                @else
                            <tr><th colspan="5" class="text-center">--- Tidak ada pesan ---</th></tr> 
                @endif
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
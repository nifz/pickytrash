@extends('layouts.app')
@section('title','Status Penjualan')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Status Penjualan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @if(count($status)>0 && !empty($status))
                                    @foreach($status as $stat)
                                        <tr>
                                            <td scope="row">{{$stat->id}}</td>
                                            <td>{{$stat->name}}</td>
                                            <td><input type="button" value="Ubah Status" id="lol{{$stat->id}}" class="btn btn-sm btn-warning"></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">Tidak ada status penjualan!</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="status" class="card">
            <div class="card-header">
                <h4 class="card-title">Status Penjualan</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}!
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group row">
                        <label for="type" class="col-md-3 col-form-label">Status</label>
                        <div class="col-md-9">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Status" aria-describedby="name" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group mr-2" role="group">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="btn-group mr-2" role="group">
                                <button type="reset" id="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('.nav-pills a[href="#' + hash + '"]').tab('show');
        } 

        // Change hash for page-reload
        $('.nav-pills a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
            history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
        });
        $('#reset').on('click', function(){
            $('#id').val('');
            $('#name').empty();
        });
        @foreach($status as $stat)
            $('#lol{{$stat->id}}').on('click', function () {
                $('html, body').animate({
                    scrollTop: $("#status").offset().top
                },0);
                $('#id').val("{{$stat->id}}");
                $('#name').val("{{$stat->name}}");
            });
        @endforeach
    });
</script>
@endsection
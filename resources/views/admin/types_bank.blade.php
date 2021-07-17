@extends('layouts.app')
@section('title','Jenis Bank')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ __('Jenis Bank yang tersedia') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @if(count($types)>0 && !empty($types))
                                    @foreach($types as $type)
                                        <tr>
                                            <td scope="row">{{$no++}}</td>
                                            <td>{{$type->name}}</td>
                                            <td><input type="button" value="Ubah Bank" id="lol{{$type->id}}" class="btn btn-sm btn-warning"></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Tidak ada bank!</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="banks" class="card">
            <div class="card-header">
                {{ __('Bank') }}
            </div>
            <div class="card-body">
                @if (session('bank'))
                    <div class="alert alert-success" role="alert">
                        {{ session('bank') }}!
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label">Nama Bank</label>
                        <div class="col-md-9">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Bank" aria-describedby="type" required>
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
                            <div class="btn-group mr-2" id="delete_bank" style="display: none;" role="group">
                                <button type="submit" name="delete_bank" onclick="return deleted()" class="btn btn-danger">Hapus Nama Bank</button>
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
    function deleted()
    {
        if(!confirm("Apakah kamu yakin ingin menghapus nama bank ini?")){
            event.preventDefault();
        }
    }
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
            $('#delete_bank').css('display','none');
        });
        @foreach($types as $type)
            $('#lol{{$type->id}}').on('click', function () {
                $('html, body').animate({
                    scrollTop: $("#banks").offset().top
                },0);
                $('#delete_bank').css('display','block');
                $('#id').val("{{$type->id}}");
                $('#name').val("{{$type->name}}");
            });
        @endforeach
    });
</script>
@endsection
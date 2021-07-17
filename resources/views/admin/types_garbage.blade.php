@extends('layouts.app')
@section('title','Jenis Sampah')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Jenis Sampah</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>No</th>
                                <th>Jenis Sampah</th>
                                <th>Harga/pcs</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @if(count($types)>0 && !empty($types))
                                    @foreach($types as $type)
                                        <tr>
                                            <td scope="row">{{$no++}}</td>
                                            <td>{{$type->type}}</td>
                                            <td>{{$type->price}}</td>
                                            <td><input type="button" value="Ubah Jenis Sampah" id="lol{{$type->id}}" class="btn btn-sm btn-warning"></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Tidak ada jenis sampah!</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="garbages" class="card">
            <div class="card-header">
                <h4 class="card-title">Jenis Sampah</h4>
            </div>
            <div class="card-body">
                @if (session('garbage'))
                    <div class="alert alert-success" role="alert">
                        {{ session('garbage') }}!
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group row">
                        <label for="type" class="col-md-3 col-form-label">Jenis Sampah</label>
                        <div class="col-md-9">
                            <input type="text" name="type" id="type" class="form-control" placeholder="Jenis Sampah" aria-describedby="type" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-md-3 col-form-label">Harga</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="price" id="price" placeholder="Harga Satuan" required>
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
                            <div class="btn-group mr-2" id="delete_garbage" style="display: none;" role="group">
                                <button type="submit" name="delete_garbage" onclick="return deleted()" class="btn btn-danger">Hapus Jenis Sampah</button>
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
        if(!confirm("Apakah kamu yakin ingin menghapus jenis sampah ini?")){
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
            $('#type').empty();
            $('#price').empty();
            $('#delete_garbage').css('display','none');
        });
        @foreach($types as $type)
            $('#lol{{$type->id}}').on('click', function () {
                $('html, body').animate({
                    scrollTop: $("#garbages").offset().top
                },0);
                $('#delete_garbage').css('display','block');
                $('#id').val("{{$type->id}}");
                $('#price').val("{{$type->price}}");
                $('#type').val("{{$type->type}}");
            });
        @endforeach
    });
</script>
@endsection
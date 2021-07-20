@extends('layouts.app')
@section('title','Peraturan')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4>Menu</h4>
                </div>
                <div class="card-body">
                        <ul class="nav nav-pills flex-column" id="menuTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if (!session('password') && !$errors->any() && !session('address') && !session('bank')) active @endif" id="profile-tab" data-toggle="tab" href="#profiles" role="tab" aria-controls="profile" aria-selected="true">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  @if (session('password') OR $errors->any()) active @endif" id="password-tab" data-toggle="tab" href="#passwords" role="tab" aria-controls="password" aria-selected="false">Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (session('address')) active @endif" id="address-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="address" aria-selected="false">Alamat</a>
                            </li>
                            @if(Auth::user()->role != 3)
                                <li class="nav-item">
                                    <a class="nav-link @if (session('bank')) active @endif" id="bank-tab" data-toggle="tab" href="#banks" role="tab" aria-controls="bank" aria-selected="false">Rekening</a>
                                </li>
                            @endif
                        </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content no-padding" id="myTab2Content">
                <div class="tab-pane fade @if (!session('password') && !$errors->any() && !session('address') && !session('bank')) show active @endif" id="profiles" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Profil') }}
                        </div>
                        <div class="card-body">
                            @if (session('profile'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('profile') }}!
                                </div>
                            @endif
                            <form method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-3 form-group">
                                        <label>Foto profil:</label>
                                        <br>
                                        <label class="image__file-upload btn btn-secondary text-white" tabindex="2"> Pilih
                                            <input type="file" name="image" id="pfImage" class="d-none" accept="image/*" >
                                        </label>
                                    </div>
                                    <div class="col-4 image" style="padding: 0 150px 150px 20px;">
                                        <img id='edit_preview_photo' class="img-thumbnail rounded-circle"
                                             src="{{asset(Auth::user()->photo)}}" style="width: 150px; height: 150px; position: absolute;"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label">Nama</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" name="change_profile" class="btn btn-warning">Ubah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if (session('password') OR $errors->any()) show active @endif" id="passwords" role="tabpanel" aria-labelledby="password-tab">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Ubah Password') }}
                        </div>
                        <div class="card-body">
                            @if (session('password'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('password') }}!
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin-bottom: 0 !important;">
                                        @foreach ($errors->all() as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="password_old" class="col-md-3 col-form-label">Password Lama</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password_old" id="password_old" placeholder="Password Lama" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-3 col-form-label">Password Baru</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password Baru" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-md-3 col-form-label">Konfirmasi Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" name="change_password" class="btn btn-warning">Ubah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if (session('address')) show active @endif" id="addresses" role="tabpanel" aria-labelledby="address-tab">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Daftar Alamat') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-inverse">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>No</th>
                                            <th>No. Telp</th>
                                            <th>Nama Alamat</th>
                                            <th>Alamat</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @if(count($address)>0 && !empty($address))
                                                @foreach($address as $add)
                                                    <tr>
                                                        <td scope="row">{{$no++}}</td>
                                                        <td>{{$add->phone}}</td>
                                                        <td>{{$add->name}}</td>
                                                        <td>{{$add->address}}</td>
                                                        <td><input type="button" value="Ubah Alamat" id="lol{{$add->id}}" class="btn btn-sm btn-warning"></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">Tidak ada alamat!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="addreass" class="card">
                        <div class="card-header">
                            {{ __('Alamat') }}
                        </div>
                        <div class="card-body">
                            @if (session('address'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('address') }}!
                                </div>
                            @endif
                            <form method="POST">
                                @csrf
                                <input type="hidden" id="id_address" name="id_address" value="">
                                <div class="form-group row">
                                    <label for="phone" class="col-md-3 col-form-label">No. Telepon</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name_address" class="col-md-3 col-form-label">Nama Alamat</label>
                                    <div class="col-md-9">
                                    <input type="text" name="name_address" id="name_address" class="form-control" placeholder="Nama Alamat" aria-describedby="name_address" required>
                                    <small id="name_address" class="text-muted">Contoh: Rumah, Kantor, dll.</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="province" class="col-md-3 col-form-label">Provinsi</label>
                                    <div class="col-md-9">
                                        <select name="province" id="province" class="form-control" required>
                                            <option value="" disabled selected>== Pilih Provinsi ==</option>
                                            @foreach ($provinces as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city" class="col-md-3 col-form-label">Kab./Kota</label>
                                    <div class="col-md-9">
                                        <select name="city" id="city" class="form-control" required>
                                            <option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="district" class="col-md-3 col-form-label">Kecamatan</label>
                                    <div class="col-md-9">
                                        <select name="district" id="district" class="form-control" required>
                                            <option value="" disabled selected>== Pilih Kecamatan ==</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="village" class="col-md-3 col-form-label">Kelurahan</label>
                                    <div class="col-md-9">
                                        <select name="village" id="village" class="form-control" required>
                                            <option value="" disabled selected>== Pilih Kelurahan ==</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-md-3 col-form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea name="address" id="address" class="form-control" style="height: 64px !important;" placeholder="Alamat Lengkap" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="postalcode" class="col-md-3 col-form-label">Kode Pos</label>
                                    <div class="col-md-9">
                                        <input type="number" name="postalcode" id="postalcode" placeholder="Kode Pos" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="btn-toolbar" role="toolbar">
                                        <div class="btn-group mr-2" role="group">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="btn-group mr-2" role="group">
                                            <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                        <div class="btn-group mr-2" id="delete_address" style="display: none;" role="group">
                                            <button type="submit" name="delete_address" onclick="return deleted()" class="btn btn-danger">Hapus Alamat</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if (session('bank')) show active @endif" id="banks" role="tabpanel" aria-labelledby="bank-tab">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Daftar Rekening') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-inverse">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @if(count($bank)>0 && !empty($bank))
                                                @foreach($bank as $b)
                                                    <tr>
                                                        <td scope="row">{{$no++}}</td>
                                                        @foreach($type_bank as $tb)
                                                            @if($b->id_type_banks == $tb->id)
                                                                <td>{{$tb->name}}</td>
                                                            @endif
                                                        @endforeach
                                                        <td>{{$b->number}}</td>
                                                        <td><input type="button" value="Ubah Rekening" id="bank{{$b->id}}" class="btn btn-sm btn-warning"></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">Tidak ada nomor rekening!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="addreass" class="card">
                        <div class="card-header">
                            {{ __('Rekening') }}
                        </div>
                        <div class="card-body">
                            @if (session('bank'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('bank') }}!
                                </div>
                            @endif
                            <form method="POST">
                                @csrf
                                <input type="hidden" id="id_bank" name="id" value="">
                                <div class="form-group row">
                                    <label for="type_bank" class="col-md-3 col-form-label">Jenis Rekening</label>
                                    <div class="col-md-9" style="overflow-x: auto">
                                        <div class="selectgroup w-100">
                                            @foreach($type_bank as $tb)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="type_bank" value="{{$tb->id}}" class="selectgroup-input">
                                                    <span class="selectgroup-button pb-5 py-3">{{$tb->name}}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="number_bank" class="col-md-3 col-form-label">Nomor Rekening</label>
                                    <div class="col-md-9">
                                    <input type="number" name="number_bank" id="number_bank" class="form-control" placeholder="Nomor Rekening" aria-describedby="number_bank" required>
                                    <small id="number_bank" class="text-muted">Nama Pemilik Rekening harus sesuai dengan Pemilik Akun.</small>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="btn-toolbar" role="toolbar">
                                        <div class="btn-group mr-2" role="group">
                                            <button type="submit" name="submit_bank" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="btn-group mr-2" role="group">
                                            <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                        <div class="btn-group mr-2" id="delete_bank" style="display: none;" role="group">
                                            <button type="submit" name="delete_bank" onclick="return deleted_bank()" class="btn btn-danger">Hapus Rekening</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function deleted()
    {
        if(!confirm("Apakah kamu yakin ingin menghapus alamat ini?")){
            event.preventDefault();
        }
    }
    function deleted_bank()
    {
        if(!confirm("Apakah kamu yakin ingin menghapus nomor rekening ini?")){
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
            $('#id_address').val('');
            axios.post('{{ route('province.store') }}').then(function (response) {
                $('#province').empty();
                $("#province").append('<option value="" disabled selected>== Pilih Provinsi ==</option>');
                $.each(response.data, function (id, name) {
                    $('#province').append(new Option(name, id));
                });
            });
            $('#city').empty();
            $('#district').empty();
            $('#village').empty();
            $("#city").append('<option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>');
            $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
            $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
            $('#delete_address').css('display','none');
        });
        @foreach($address as $add)
            $('#lol{{$add->id}}').on('click', function () {
                $('html, body').animate({
                    scrollTop: $("#addreass").offset().top
                },0);
                $('#delete_address').css('display','block');
                $('#id_address').val("{{$add->id}}");
                $('#phone').val("{{$add->phone}}");
                $('#name_address').val("{{$add->name}}");
                $("#province").append('<option value="" disabled>Tunggu sebentar...</option>');
                $("#city").append('<option value="" disabled>Tunggu sebentar...</option>');
                $("#district").append('<option value="" disabled>Tunggu sebentar...</option>');
                $("#village").append('<option value="" disabled>Tunggu sebentar</option>');
                axios.post('{{ route('province.store') }}', {id: {{$add->id_provinces}}}).then(function (response) {
                    $('#province').empty();
                    $("#province").append('<option value="" disabled>== Pilih Provinsi ==</option>');
                    $.each(response.data, function (id, name) {
                        $('#province').append(new Option(name, id));
                    });
                    $('#province option[value={{$add->id_provinces}}]').attr('selected','selected');
                });
                axios.post('{{ route('city.store') }}', {id: {{$add->id_provinces}}}).then(function (response) {
                    $('#city').empty();
                    $("#city").append('<option value="" disabled>== Pilih Kabupaten/Kota ==</option>');
                    $.each(response.data, function (id, name) {
                        $('#city').append(new Option(name, id));
                    });
                    $('#city option[value={{$add->id_cities}}]').attr('selected','selected');
                });
                axios.post('{{ route('district.store') }}', {id: {{$add->id_cities}}}).then(function (response) {
                    $('#district').empty();
                    $("#district").append('<option value="" disabled>== Pilih Kecamatan ==</option>');
                    $.each(response.data, function (id, name) {
                        $('#district').append(new Option(name, id));
                    });
                    $('#district option[value={{$add->id_districts}}]').attr('selected','selected');
                });
                axios.post('{{ route('village.store') }}', {id: {{$add->id_districts}}}).then(function (response) {
                    $('#village').empty();
                    $("#village").append('<option value="" disabled>== Pilih Kelurahan ==</option>');
                    $.each(response.data, function (id, name) {
                        $('#village').append(new Option(name, id));
                    });
                    $('#village option[value={{$add->id_villages}}]').attr('selected','selected');
                });
                $('#address').val("{{$add->address}}");
                $('#postalcode').val("{{$add->postal_code}}");
            });
        @endforeach
        @foreach($bank as $b)
            $('#bank{{$b->id}}').on('click', function () {
                $('html, body').animate({
                    scrollTop: $("#banks").offset().top
                },0);
                $('#delete_bank').css('display','block');
                $('#id_bank').val("{{$b->id}}");
                var $radios = $('input:radio[name=type_bank]');
                if($radios.is(':checked') === false) {
                    $radios.filter('[value={{$b->id_type_banks}}]').prop('checked', true);
                }
                $('#number_bank').val("{{$b->number}}");
            });
        @endforeach
        $('#province').on('change', function () {
            axios.post('{{ route('city.store') }}', {id: $(this).val()}).then(function (response) {
                $('#city').empty();
                $('#district').empty();
                $('#village').empty();
                $("#city").append('<option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>');
                $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#city').append(new Option(name, id));
                });
            });
        });
        $('#city').on('change', function () {
            axios.post('{{ route('district.store') }}', {id: $(this).val()}).then(function (response) {
                $('#district').empty();
                $('#village').empty();
                $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#district').append(new Option(name, id));
                });
            });
        });
        $('#district').on('change', function () {
            axios.post('{{ route('village.store') }}', {id: $(this).val()}).then(function (response) {
                $('#village').empty();
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#village').append(new Option(name, id));
                });
            });
        });
    });
</script>
@endsection
@extends('layouts.app')
@section('title','Buat Akun')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Akun</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label">Email</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label">Password</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-3 col-form-label">Role</label>
                                <div class="col-md-8">
                                    <select name="role" id="role" class="form-control">
                                        <option value="" disabled selected>== Pilih Role ==</option>
                                        <option value="1">User</option>
                                        <option value="2">Driver</option>
                                        <option value="3">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input mt-3 mb-4" onclick="isAddress()" type="checkbox" name="addressed" id="addressed" value="1"> Tambahkan Alamat
                                </label>
                            </div>
                            <div class="d-sm-none d-md-block">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                        <div id="addres" class="col-md-6 d-sm-none d-md-block">
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label">No. Telepon</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" disabled required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name_address" class="col-md-4 col-form-label">Nama Alamat</label>
                                <div class="col-md-8">
                                <input type="text" name="name_address" id="name_address" class="form-control" placeholder="Nama Alamat" aria-describedby="name_address" disabled required>
                                <small id="name_address" class="text-muted">Contoh: Rumah, Kantor, dll.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province" class="col-md-4 col-form-label">Provinsi</label>
                                <div class="col-md-8">
                                    <select name="province" id="province" class="form-control" disabled required>
                                        <option value="" disabled selected>== Pilih Provinsi ==</option>
                                        @foreach ($provinces as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label">Kab./Kota</label>
                                <div class="col-md-8">
                                    <select name="city" id="city" class="form-control" disabled required>
                                        <option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-md-4 col-form-label">Kecamatan</label>
                                <div class="col-md-8">
                                    <select name="district" id="district" class="form-control" disabled required>
                                        <option value="" disabled selected>== Pilih Kecamatan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-md-4 col-form-label">Kelurahan</label>
                                <div class="col-md-8">
                                    <select name="village" id="village" class="form-control" disabled required>
                                        <option value="" disabled selected>== Pilih Kelurahan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label">Alamat</label>
                                <div class="col-md-8">
                                    <textarea name="address" id="address" class="form-control" rows="2" placeholder="Alamat Lengkap" disabled required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postalcode" class="col-md-4 col-form-label">Kode Pos</label>
                                <div class="col-md-8">
                                    <input type="number" name="postalcode" id="postalcode" placeholder="Kode Pos" class="form-control" disabled required>
                                </div>
                            </div>
                        </div>
                        <div class="col d-none d-sm-block d-md-none">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function isAddress() 
    {
        var checked = document.getElementById("addressed");
        if(checked.checked == true)
        {
            document.getElementById('phone').disabled = false;
            document.getElementById('name_address').disabled = false;
            document.getElementById('province').disabled = false;
            document.getElementById('city').disabled = false;
            document.getElementById('district').disabled = false;
            document.getElementById('village').disabled = false;
            document.getElementById('address').disabled = false;
            document.getElementById('postalcode').disabled = false;
            
            const ad = document.querySelector('#addres');
            if (ad.classList.contains("d-sm-none")) {
                ad.classList.remove("d-sm-none");
            }
        }
        else
        {
            document.getElementById('phone').disabled = true;
            document.getElementById('name_address').disabled = true;
            document.getElementById('province').disabled = true;
            document.getElementById('city').disabled = true;
            document.getElementById('district').disabled = true;
            document.getElementById('village').disabled = true;
            document.getElementById('address').disabled = true;
            document.getElementById('postalcode').disabled = true;

            const ad = document.querySelector('#addres');
            if (ad.classList.contains("d-md-block")) {
                ad.classList.add("d-sm-none");
            }
        }
    }
    $(function () {
        $('#province').on('change', function () {
            axios.post('{{ route('city.store') }}', {id: $(this).val()}).then(function (response) {
                $('#city').empty();
                $("#city").append('<option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>');
                $.each(response.data, function (id, name) {
                    $('#city').append(new Option(name, id));
                });
            });
        });
        $('#city').on('change', function () {
            axios.post('{{ route('district.store') }}', {id: $(this).val()}).then(function (response) {
                $('#district').empty();
                $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
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
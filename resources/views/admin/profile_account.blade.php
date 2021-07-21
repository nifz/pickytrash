@extends('layouts.app')
@section('title','Profil: '.$user->name)
@section('content')

@if($user->role == 2)
    @php $pickup = []; $no = 0; @endphp
    @foreach($history_sell as $hs)
        @if($hs->id_users == $user->id && $hs->status == 1)
            @php array_push($pickup,$no++); @endphp
        @endif
    @endforeach
@endif
@if($user->role == 1)
    @php $sum = 0; @endphp
    @foreach($sell_user as $s)
        @php $yaya = FALSE; @endphp
        @foreach($history_sell as $hss)
            @if($hss->id_sells == $s->id && $hss->status == 7)
                @php $yaya = TRUE; @endphp
            @endif
        @endforeach
            @if($yaya == FALSE)
                @php $qty = explode(',',$s->qty); $sum += array_sum($qty); @endphp
            @endif
    @endforeach
@endif
<div class="section-body">
    <div class="row mt-sm-4">
        <div class="col-12 col-md-7">
            <div class="card profile-widget">
                <div class="profile-widget-header">                     
                    <span class="image">
                        <img alt="image" style="width: 100px; height: 100px;" src="{{asset($user->photo)}}" class="rounded-circle profile-widget-picture">
                    </span>
                    <div class="profile-widget-items">
                        @if($user->role == 1)
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format($sum)}}</div>
                                <div class="profile-widget-item-label">Sampah</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format(Wallet::amount($user->id),0)}}</div>
                                <div class="profile-widget-item-label">Saldo (Rp)</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Pertukaran</div>
                            </div>
                        @elseif($user->role == 2)
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format(count($pickup))}}</div>
                                <div class="profile-widget-item-label">Pickup</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format(Wallet::amount($user->id),0)}}</div>
                                <div class="profile-widget-item-label">Saldo (Rp)</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Pertukaran</div>
                            </div>
                        @else
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">Admin</div>
                            </div>
                        @endif
                    </div>
                </div>
                <form method="POST">
                    <div class="profile-widget-description">
                        @if (session('profile'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile') }}!
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" value="{{ $user->name }}" required @if (!session('edit')) disabled @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}" required  @if (!session('edit')) disabled @endif>
                            </div>
                        </div>
                        @if(session('edit'))
                        <div class="form-group row">
                            <label for="role" class="col-md-3 col-form-label">Role</label>
                            <div class="col-md-9">
                                <select name="role" id="role" class="form-control">
                                    <option value="" disabled selected>== Pilih Role ==</option>
                                    <option value="1" @if($user->role == 1) SELECTED @endif>User</option>
                                    <option value="2" @if($user->role == 2) SELECTED @endif>Driver</option>
                                    <option value="3" @if($user->role == 3) SELECTED @endif>Admin</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="name_address2" class="col-3 col-md-3 col-form-label">Nama Alamat</label>
                            <div class="col-10 col-md-7">
                                <select name="name_address2" id="name_address2" class="form-control">
                                    <option value="" disabled selected>== Nama Alamat ==</option>
                                    @foreach ($addresses as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="form-control" type="button" data-toggle="collapse" data-target="#addres" aria-expanded="false" aria-controls="addres">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="collapse" id="addres">
                            @if(session('edit') && count($addresses)<1)
                            <div class="form-check form-check-inline mb-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="add_address" id="add_address" value="1"> Tambah Alamat
                                </label>
                            </div>
                            @endif
                            @csrf
                            <input type="hidden" id="id_address" name="id_address" value="">
                            <div class="form-group row">
                                <label for="phone" class="col-md-3 col-form-label">No. Telepon</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" required disabled>
                                </div>
                            </div>
                            @if(session('edit'))
                                <div class="form-group row">
                                    <label for="name_address" class="col-md-3 col-form-label">Nama Alamat</label>
                                    <div class="col-md-9">
                                    <input type="text" name="name_address" id="name_address" class="form-control" placeholder="Nama Alamat" aria-describedby="name_address" required disabled>
                                    <small id="name_address" class="text-muted">Contoh: Rumah, Kantor, dll.</small>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="province" class="col-md-3 col-form-label">Provinsi</label>
                                <div class="col-md-9">
                                    <select name="province" id="province" class="form-control" required disabled>
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
                                    <select name="city" id="city" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-md-3 col-form-label">Kecamatan</label>
                                <div class="col-md-9">
                                    <select name="district" id="district" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kecamatan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-md-3 col-form-label">Kelurahan</label>
                                <div class="col-md-9">
                                    <select name="village" id="village" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kelurahan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-3 col-form-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="address" id="address" class="form-control" style="height: 64px !important;" placeholder="Alamat Lengkap" required disabled></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postalcode" class="col-md-3 col-form-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="number" name="postalcode" id="postalcode" placeholder="Kode Pos" class="form-control" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group mr-2" role="group">
                                    <button type="submit" @if(session('edit')) name="edited" @else name="edit" @endif class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($user->role != 3)
            <div class="col-12 col-md-5">
                <div class="card card-hero">
                    <div class="card-header">
                        @if($user->role == 1)
                            <h4 class="text-white">{{number_format($sum)}}</h4>
                            <div class="card-description text-white">Sampah</div>
                            @else
                            <h4 class="text-white">{{number_format(count($pickup))}}</h4>
                            <div class="card-description text-white">Pickup</div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @if($user->role == 1)
                                @php $no = count($sell_user); @endphp
                                @foreach($sell_user as $se)
                                    @php 
                                        $garbage = explode(',',$se->id_types);
                                        $qty = explode(',',$se->qty);
                                        $uang = 0;
                                    @endphp
                                    <a href="#" class="ticket-item" data-toggle="modal" data-target="#ticket{{$se->id}}">
                                        <div class="ticket-title">
                                        <h4>Penjualan ke #{{$no--}}
                                        </h4>
                                        
                                        </div>
                                        <div class="ticket-info">
                                            <div>{{$user->name}}</div>
                                            <div class="bullet"></div>
                                            <div class="text-primary">{{\Carbon\Carbon::parse($se->created_at)->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                @php $id_sell = 0; $id_user = 0; @endphp
                                @foreach($sell as $se)
                                    @foreach($history_sell as $hs)
                                        @if($hs->id_sells == $se->id && $hs->id_users != NULL)
                                            @php $id_sell = $hs->id_sells; $id_user = $hs->id_users @endphp
                                        @endif
                                    @endforeach
                                    @if($se->id == $id_sell && $id_user == $user->id)
                                        @php 
                                            $penjual = count($sell);
                                            $garbage = explode(',',$se->id_types);
                                            $qty = explode(',',$se->qty);
                                            $uang = 0;
                                        @endphp
                                        <a href="#" class="ticket-item" data-toggle="modal" data-target="#ticket{{$se->id}}">
                                            <div class="ticket-title">
                                                <h4>IDS#{{$se->id}} 
                                                </h4>
                                            </div>
                                            <div class="ticket-info">
                                                @foreach($users as $u)
                                                    @if($u->id == $se->id_users)
                                                        <div>{{$u->name}}</div>
                                                        @endif
                                                    @endforeach
                                                    <div class="bullet"></div>
                                                    <div class="text-primary">{{\Carbon\Carbon::parse($se->created_at)->diffForHumans()}}</div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('modal')
    @foreach($history_sell as $hss)
        @php $qwew = 0; @endphp
        @foreach($sell as $se)
            @if($hss->id_sells == $se->id)
                @php 
                    $garbage = explode(',',$se->id_types);
                    $qty = explode(',',$se->qty);
                    $uang = 0;
                @endphp
                <div class="modal fade" id="ticket{{$se->id}}" tabindex="-1" aria-labelledby="ticketLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Rincian Sampah: IDS#{{$se->id}} 
                                                    @php 
                                                        for($i=0;$i<count($garbage);$i++)
                                                        {
                                                            foreach($types as $ty)
                                                            {
                                                                if($ty->id == $garbage[$i])
                                                                {
                                                                    $uang += $qty[$i] * $ty->price;
                                                                }
                                                            }
                                                        }
                                                    @endphp    
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div>
                                                    @php 
                                                        $price = '';
                                                        $count = [];
                                                        for($i=0;$i<count($garbage);$i++)
                                                        {
                                                            foreach($types as $ty)
                                                            {
                                                                if($ty->id == $garbage[$i])
                                                                {
                                                                    $price = $ty->price*$qty[$i];
                                                                    // echo $qty[$i]. " Sampah " . $ty->type." Rp.".number_format($price)."<br> ";
                                                                    echo number_format($qty[$i]). " Sampah " . $ty->type."<br> ";
                                                                }
                                                            }
                                                            array_push($count, $price);
                                                        }
                                                        if($hss->id_sells == $se->id && $hss->status != 7)
                                                        {
                                                            $qwew = array_sum($count);
                                                        }
                                                        echo "Total: Rp.".number_format($qwew)."<br>Komisi Driver: Rp.".number_format($qwew/2);
                                                    @endphp   
                                                </div>
                                                <div>
                                                    @if($hss->id_sells == $se->id && $hss->status != 7)
                                                        Sampah akan diambil oleh: @php $driver = '-'; @endphp
                                                        @foreach($history_sell as $hs)
                                                            @if($hs->id_sells == $se->id)
                                                                    @foreach($users as $u)
                                                                        @if($hs->id_users == $u->id)
                                                                            @php $driver = $u->name @endphp
                                                                        @endif
                                                                    @endforeach
                                                            @endif
                                                        @endforeach
                                                        {{$driver}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Alamat Pengambilan Sampah</h4>
                                            </div>
                                            <div class="card-body">
                                                @foreach($addressing as $adresing)
                                                    @if($se->id_addresses == $adresing->id_address)
                                                        {{$adresing->name." (".$adresing->phone.")"}}<br>
                                                        {{$adresing->address.", ".$adresing->villages_name.", ".$adresing->districts_name.", ".$adresing->cities_name.", ".$adresing->province_name.", ".$adresing->postal_code}}
                                                        @php $meta = json_decode($adresing->villages_meta); @endphp
                                                        <iframe frameborder="0" style="border:0; width: 100%;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCkgBvgpMl5UnG7Gqi4hQhJ3NMROtgdySI&language=id&q={{$adresing->villages_name}}&center={{$meta->lat}},{{$meta->long}}" height="200" allowfullscreen></iframe>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Status Penjualan</h4>
                                            </div>
                                            <div class="card-body activities">
                                                @php $no = 1; @endphp
                                                @php $now = []; @endphp
                                                @foreach($history_sell as $hs)
                                                    @if($hs->id_sells == $se->id)
                                                        @php 
                                                            $no = array_push($now,$hs); 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @php $nox = count($now); $noxx = count($now); @endphp
                                                @foreach($history_sell as $hs)
                                                    @if($hs->id_sells == $se->id)
                                                        <div class="activity">
                                                            <div class="activity-icon bg-primary text-white shadow-primary">
                                                                {{$nox--}}
                                                            </div>
                                                            <div class="activity-detail">
                                                                <div class="mb-2">
                                                                    <span class="text-job @if($nox == ($noxx-1)) text-black @endif">{{\Carbon\Carbon::parse($hs->created_at)->diffForHumans()}}</span>
                                                                    <span class="bullet"></span>
                                                                </div>
                                                                @foreach($status_sell as $ss)
                                                                    @if($ss->id == $hs->status)
                                                                        @php $nama = ''; @endphp
                                                                        <p>
                                                                            @if($hs->status == 1)
                                                                                @foreach($users as $u)
                                                                                    @if($hs->id_sells == $se->id && $se->id_users == $u->id)
                                                                                        @php $nama = $u->name; @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                            @elseif($hs->status != 1 && $hs->status != 6 && $hs->status != 7)
                                                                                @foreach($users as $u)
                                                                                    @if($u->id == $hs->id_users)
                                                                                        @php $nama = $u->name; @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            {{$nama." ".$ss->name}}
                                                                        </p>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @php 
                                                            $no = array_push($now,$hs); 
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php 
                                $confirm2 = FALSE;
                                $completed2 = FALSE;
                                $cancel2 = FALSE;
                                $proses = FALSE;
                                $status = '';
                                foreach($history_sell as $hsel)
                                {
                                    if($hsel->status == 5 && $hsel->status != 6 && $hsel->status != 7 && $hsel->id_sells == $se->id)
                                    {
                                        $confirm2 = TRUE;
                                    }
                                    if($hsel->status == 6 && $hsel->id_sells == $se->id)
                                    {
                                        $completed2 = TRUE;
                                    }
                                    if($hsel->status == 7 && $hsel->id_sells == $se->id)
                                    {
                                        $cancel2 = TRUE;
                                    }
                                    if($hsel->id_sells == $se->id && $hsel->status == 1 OR $hsel->status == 2 OR $hsel->status == 3 OR $hsel->status == 4)
                                    {
                                        $proses = TRUE;
                                    }
                                }
                                if($confirm2 == TRUE && $completed2 == FALSE && $cancel2 == FALSE)
                                {
                                    for($i=0;$i<count($status_sell);$i++)
                                    {
                                        if($status_sell[$i] == $status_sell[5])
                                        {
                                            $status = '
                                                <form method="POST">
                                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                                    <input type="hidden" name="id" value="'.$hss->id_sells.'">
                                                    <input type="hidden" name="id_users" value="'.$hss->id_users.'">
                                                    <input type="hidden" name="status" value="'.$status_sell[$i]->id.'">
                                                    <button type="submit" class="btn btn-success" name="submit">'.str_replace(".","",$status_sell[$i]->name).'</button>
                                                    <button type="submit" class="btn btn-danger" name="cancel" onclick="return deleted()">'.str_replace(".","",$status_sell[6]->name).'</button>
                                                </form>
                                            '; 
                                        }
                                    }
                                }
                            @endphp
                            <div class="modal-footer">
                                {!! $status !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    
    $(function () {
        $('#name_address2').on('change', function () {
            $('#addres').addClass('show');
            axios.post('{{ route('admin.profile_account.address.store',$user->id) }}', {id: $(this).val()}).then(function (response) {
                $('#id_address').val(response.data.id);
                $('#phone').val(response.data.phone);
                $('#name_address').val(response.data.name);
                
                axios.post('{{ route('province.store') }}', {id: response.data.id_provinces}).then(function (response2) {
                    $('#province').empty();
                    $("#province").append('<option value="" disabled>== Pilih Provinsi ==</option>');
                    $.each(response2.data, function (id, name) {
                        $('#province').append(new Option(name, id));
                    });
                    $('#province option[value='+response.data.id_provinces+']').attr('selected','selected');
                });
                
                axios.post('{{ route('city.store') }}', {id: response.data.id_provinces}).then(function (response3) {
                    $('#city').empty();
                    $("#city").append('<option value="" disabled>== Pilih Kabupaten/Kota ==</option>');
                    $.each(response3.data, function (id, name) {
                        $('#city').append(new Option(name, id));
                    });
                    $('#city option[value='+response.data.id_cities+']').attr('selected','selected');
                });
                axios.post('{{ route('district.store') }}', {id: response.data.id_cities}).then(function (response4) {
                    $('#district').empty();
                    $("#district").append('<option value="" disabled>== Pilih Kecamatan ==</option>');
                    $.each(response4.data, function (id, name) {
                        $('#district').append(new Option(name, id));
                    });
                    $('#district option[value='+response.data.id_districts+']').attr('selected','selected');
                });
                axios.post('{{ route('village.store') }}', {id: response.data.id_districts}).then(function (response5) {
                    $('#village').empty();
                    $("#village").append('<option value="" disabled>== Pilih Kelurahan ==</option>');
                    $.each(response5.data, function (id, name) {
                        $('#village').append(new Option(name, id));
                    });
                    $('#village option[value='+response.data.id_villages+']').attr('selected','selected');
                });
                @if(session('edit'))
                $('#phone').prop("disabled", false);
                $('#name_address').prop("disabled", false);
                $('#province').prop("disabled", false);
                $('#city').prop("disabled", false);
                $('#district').prop("disabled", false);
                $('#village').prop("disabled", false);
                $('#address').prop("disabled", false);
                $('#postalcode').prop("disabled", false);
                @endif
                $('#address').val(response.data.address);
                $('#postalcode').val(response.data.postal_code);
            });
        });
        $('input[id="add_address"]').click(function(){
            if($(this).is(":checked")){
                $('#phone').prop("disabled", false);
                $('#name_address').prop("disabled", false);
                $('#province').prop("disabled", false);
                $('#city').prop("disabled", false);
                $('#district').prop("disabled", false);
                $('#village').prop("disabled", false);
                $('#address').prop("disabled", false);
                $('#postalcode').prop("disabled", false);
            }
            else if($(this).is(":not(:checked)")){
                $('#phone').prop("disabled", true);
                $('#name_address').prop("disabled", true);
                $('#province').prop("disabled", true);
                $('#city').prop("disabled", true);
                $('#district').prop("disabled", true);
                $('#village').prop("disabled", true);
                $('#address').prop("disabled", true);
                $('#postalcode').prop("disabled", true);
            }
        });
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
@extends('layouts.app')

@section('content')
@php $sum = 0; @endphp
@foreach($sell as $s)
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
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card profile-widget">
                <div class="profile-widget-header">                                
                    <span class="image">
                        <img alt="image" style="width: 100px; height: 100px;" src="{{asset(Auth::user()->photo)}}" class="rounded-circle profile-widget-picture">
                    </span>
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">{{number_format($sum)}}</div>
                            <div class="profile-widget-item-label">Sampah</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">{{number_format(Wallet::amount(Auth::user()->id),0)}}</div>
                            <div class="profile-widget-item-label">Saldo (Rp)</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">0</div>
                            <div class="profile-widget-item-label">Pertukaran</div>
                        </div>
                    </div>
                </div>
                <form method="POST">
                    @csrf
                    <div class="pl-4">
                        <h2 class="section-title">Jual Sampah</h2>
                        <p class="section-lead">
                          Jual sampahmu dapatkan uangmu.
                        </p>
                    </div>
                    <div class="profile-widget-description">
                        @if (session('sell'))
                            <div class="alert alert-success" role="alert">
                                {{ session('sell') }}!
                                <div>Status: <span class="text-danger">Pending</span></div>
                            </div>
                        @endif
                        <div class="input-wrapper">
                            <div class="form-group row">
                                <label for="garbage" class="col-md-3 col-form-label">Jenis Sampah</label>
                                <div class="col-10 col-md-8">
                                    <select name="garbage[]" id="0" class="form-control garbage">
                                        <option value="" selected disabled>== Jenis Sampah ==</option>
                                        @foreach($types as $type)
                                            @if($type->status == 1)
                                                <option value="{{$type->id}}">{{$type->type}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" id="add" class="btn btn-success"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group row">
                                <label for="qty" class="col-md-3 col-form-label">Qty</label>
                                <div class="col-4 col-md-3">
                                    <input type="number" class="form-control qty" name="qty[]" id="0" placeholder="Qty" min="1" value="1" required disabled>
                                </div>
                                <div class="col-8 col-md-6">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="hidden" class="realprice" id="realprice0" name="realprice">
                                        <input type="text" class="form-control price" id="price0" name="price" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-md-3 col-form-label">Total</label>
                            <div class="col-12 col-md-9">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="hidden" class="realtotal">
                                    <input type="text" class="form-control total" id="total" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-12 col-md-3 col-form-label">Pilih Alamat</label>
                            <div class="col-12 col-md-9 col-md-9">
                                <select name="address" id="address" class="form-control" required>
                                    <option value="" disabled selected>== Nama Alamat ==</option>
                                    @foreach ($addresses as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }} - ({{$ad->phone}})</option>
                                    @endforeach
                                </select>
                                @if(count($addresses)<1)
                                    <span>Anda tidak memiliki alamat, <a href="{{ route(Role::is().'.settings') }}#addresses" class="text-danger">Klik disini</a>. Untuk menambahkan alamat.</span>
                                @endif
                                <div id="txtaddress"></div>
                            </div>
                        </div>
                        <iframe id="map_canvas" frameborder="0" style="border:0; width: 100%; display: none;" height="250" allowfullscreen></iframe>
                        <div class="mt-4">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group mr-2" role="group">
                                    <button type="submit" name="submit" class="btn btn-primary">Jual Sampah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card card-hero">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h4>{{number_format($sum)}}</h4>
                    <div class="card-description">Sampah</div>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        {{-- @foreach($sell as $se)
                            @php 
                                $garbage = explode(',',$se->id_types);
                                $qty = explode(',',$se->qty);
                            @endphp
                            <a href="#" class="ticket-item" data-toggle="modal" data-target="#ticket{{$se->id}}">
                                <div class="ticket-title">
                                <h4>
                                    @php 
                                        for($i=0;$i<count($garbage);$i++)
                                        {
                                            foreach($types as $ty)
                                            {
                                                if($ty->id == $garbage[$i])
                                                {
                                                    echo $qty[$i]. " Sampah " . $ty->type."<br> ";
                                                }
                                            }
                                        }
                                    @endphp    
                                </h4> --}}
                                
                        @php $no = count($sell); @endphp
                        @foreach($sell as $se)
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
                                    <div>{{Auth::user()->name}}</div>
                                    <div class="bullet"></div>
                                    <div class="text-primary">{{\Carbon\Carbon::parse($se->created_at)->diffForHumans()}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('modal')
@foreach($sell as $se)
@php 
    $no = count($sell);
    $garbage = explode(',',$se->id_types);
    $qty = explode(',',$se->qty);
    $qwew = 0;
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
                                <div class="mb-3">
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
                                                    echo number_format($qty[$i]). " Sampah " . $ty->type." Rp.".number_format($price)."<br> ";
                                                }
                                            }
                                            array_push($count, $price);
                                        }
                                        $ya = FALSE;
                                        foreach($history_sell as $hss)
                                        {
                                            if($hss->id_sells == $se->id && $hss->status == 7)
                                            {
                                                $ya = TRUE;
                                            }
                                        }
                                        if($ya == FALSE)
                                        {
                                            $qwew = array_sum($count);
                                        }
                                        echo "Total: Rp.".number_format($qwew);
                                    @endphp   
                                </div>
                                <div>
                                    @if($ya == FALSE)
                                        Sampah akan diambil oleh: @php $driver = '-'; @endphp
                                        @foreach($history_sell as $hs)
                                            @if($hs->id_sells == $se->id)
                                                    @foreach($user as $u)
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
                                                    <span class="text-job @if($nox == ($noxx-1)) text-primary @endif">{{\Carbon\Carbon::parse($hs->created_at)->diffForHumans()}}</span>
                                                    <span class="bullet"></span>
                                                </div>
                                                @foreach($status_sell as $ss)
                                                    @if($ss->id == $hs->status)
                                                        @php $nama = ''; @endphp
                                                        <p>
                                                            @if($hs->status == 1)
                                                                @php $nama = Auth::user()->name; @endphp
                                                            @elseif($hs->status != 1 && $hs->status != 6 && $hs->status != 7)
                                                                @foreach($user as $u)
                                                                    @if($u->id == $hs->id_users)
                                                                        @php $nama = $u->name; @endphp
                                                                    @endif
                                                                @endforeach
                                                                
                                                            @endif
                                                            {{$nama." ".$ss->name}}
                                                            @if($hs->status == 6)
                                                                Anda mendapatkan saldo sebesar Rp.{{number_format($qwew)}}
                                                            @endif
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
            <div class="modal-footer">
                @php $deleted = TRUE; @endphp
                @foreach($history_sell as $hs)
                    @if($hs->id_sells == $se->id)
                            @foreach($user as $u)
                                @if($hs->id_users == $u->id)
                                    @php $deleted = FALSE; @endphp
                                @endif
                            @endforeach
                    @endif
                @endforeach
                @if($deleted == TRUE)
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$se->id}}">
                        <button type="submit" name="cancel" onclick="return deleted()" class="btn btn-danger">Batalkan</button>
                    </form>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function deleted()
    {
        if(!confirm("Apakah kamu yakin ingin membatalkan penjualan sampah ini?")){
            event.preventDefault();
        }
    }
    function getprice() {
        let gprice = document.getElementsByName("price");
        let totalprice = 0;
        for(var i = 0; i < gprice.length; i++){
            totalprice += parseInt(gprice[i].value);
        }
        $('#total').val(totalprice);
    }
    $(document).ready(function(){
        var no = 1;
        var total = 0;
        $('#add').click(function(){
            no++;
            $('.input-wrapper').append(`
                <div id="temp`+no+`">
                    <div class="form-group row">
                        <label for="garbage" class="col-md-3 col-form-label">Jenis Sampah</label>
                        <div class="col-10 col-md-8">
                            <select name="garbage[]" id="`+no+`" class="form-control garbage">
                                <option value="" selected disabled>== Jenis Sampah ==</option>
                                @foreach($types as $type)
                                    @if($type->status == 1)
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="button" id="`+no+`" class="btn btn-danger btn_remove"><i class="fas fa-minus"></i></button>
                    </div>
                    <div class="form-group row">
                        <label for="qty" class="col-md-3 col-form-label">Qty</label>
                        <div class="col-4 col-md-3">
                            <input type="number" class="form-control qty" name="qty[]" id="`+no+`" placeholder="Qty" min="1" value="1" required disabled>
                        </div>
                        <div class="col-8 col-md-6">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="hidden" class="realprice" id="realprice`+no+`" name="realprice">
                                <input type="text" class="form-control price" name="price" id="price`+no+`" value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id"); 
            $('#temp'+button_id).remove();
        });
        $(document).on('change', '.garbage', function(){
            var button_id = $(this).attr("id"); 
            axios.post('{{ route('user.types.store') }}', {id: $(this).val()}).then(function (response) {
                $('#price'+button_id).val(response.data.price);
                $('#realprice'+button_id).val(response.data.price);
                $('[name="qty[]"]').prop("disabled", false)
                getprice();
            });
        });
        $(document).on('change', '.qty', function(){
            var button_id = $(this).attr("id"); 
            var price = $('#realprice'+button_id).val();
            var qty = $(this).val();
            var count = price * qty;
            $('#price'+button_id).val(count);            
        });
        $(document).on('click', function(){
            getprice();
        });
    });
    $('#address').on('change', function() {
        axios.post('{{ route('user.profile_account.address.store') }}', {id: $(this).val()}).then(function (response) {
            var address = response.data.address + ', ' + response.data.villages_name + ', ' + response.data.districts_name + ', ' + response.data.cities_name + ', ' + response.data.province_name + ', ' + response.data.postal_code;
            $('#txtaddress').html(address);
            var meta = JSON.parse(response.data.villages_meta);
            var link = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCkgBvgpMl5UnG7Gqi4hQhJ3NMROtgdySI&language=id&q="+response.data.villages_name+"&center="+meta.lat+","+meta.long+"";
            $('#map_canvas').attr('src', link);
            $('#map_canvas').css('display','block');
        });
    });
</script>
@endsection
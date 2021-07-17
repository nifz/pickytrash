@extends('layouts.app')

@section('content')
@php $pickup = []; $no = 0; @endphp
@foreach($history_sell as $hs)
    @if($hs->id_users == Auth::user()->id && $hs->status == 1)
        @php array_push($pickup,$no++); @endphp
    @endif
@endforeach
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card profile-widget">
                <div class="profile-widget-header">                     
                    <img alt="image" src="{{asset('assets/images/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">{{number_format(count($pickup))}}</div>
                            <div class="profile-widget-item-label">Pickup</div>
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
                    <div class="pl-4">
                        <h2 class="section-title">Ambil Sampah</h2>
                        <p class="section-lead">
                          Ambil sampah dapatkan komisi.
                        </p>
                    </div>
                    <div class="profile-widget-description">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>No</th>
                                        <th>IDS</th>
                                        <th>Komisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $nomor = 1; 
                                        $emoty = FALSE; 
                                    @endphp
                                    @foreach($history_sell as $hs)
                                        @if($hs->id_users == NULL)
                                            @if(!empty($history_sell))
                                                @php $emoty = TRUE; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($emoty == TRUE)
                                        @foreach($history_sell as $hs)
                                            @if($hs->id_users == NULL)
                                                @foreach($sell as $se)
                                                    @if($hs->id_sells == $se->id)
                                                        @php 
                                                            $penjual = count($sell);
                                                            $garbage = explode(',',$se->id_types);
                                                            $qty = explode(',',$se->qty);
                                                            $uang = 0;
                                                        @endphp
                                                        @foreach($user as $u)
                                                            @if($u->id == $se->id_users)
                                                                <tr data-toggle="modal" data-target="#ticket{{$se->id}}" style="cursor: pointer;">
                                                                    <td scope="row">{{$nomor++}}</td>
                                                                    <td> 
                                                                        IDS#{{$se->id}} oleh {{$u->name}}
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
                                                                    </td>
                                                                    <td>Rp.{{number_format($uang/2)}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Kosong</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card card-hero">
                <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h4>{{number_format(count($pickup))}}</h4>
                        <div class="card-description">Pickup</div>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        @php $id_sell = 0; $id_user = 0; @endphp
                        @foreach($sell as $se)
                            @foreach($history_sell as $hs)
                                @if($hs->id_sells == $se->id && $hs->id_users != NULL)
                                    @php $id_sell = $hs->id_sells; $id_user = $hs->id_users @endphp
                                @endif
                            @endforeach
                            @if($se->id == $id_sell && $id_user == Auth::user()->id)
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
                                        @foreach($user as $u)
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
                    </div>
                </div>
            </div>
        </div>
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
                                                            $qwew = array_sum($count)/2;
                                                        }
                                                        echo "Komisi: Rp.".number_format($qwew);
                                                    @endphp   
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
                                                                                @foreach($user as $u)
                                                                                    @if($hs->id_sells == $se->id && $se->id_users == $u->id)
                                                                                        @php $nama = $u->name; @endphp
                                                                                    @endif
                                                                                @endforeach
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
                            @php $status = ''; $removed = ''; $cancel = ''; @endphp
                            @foreach($history_sell as $hs)
                                @for($i=0;$i<count($status_sell);$i++)
                                    @if($hs->id_sells == $se->id && $hs->status == $status_sell[$i]->id && $hs->id == $hss->id && $hs->status<5)
                                        @php 
                                            if($status_sell[$i]->id > 1 && $status_sell[$i]->id < 4)
                                            {
                                                $removed = '
                                                    <button type="submit" class="btn btn-danger" name="removed" onclick="return deleted()">Batalkan Pengambilan Sampah</button>
                                                ';
                                            }
                                            if($status_sell[$i]->id == 4)
                                            {
                                                $cancel = '
                                                    <button type="submit" class="btn btn-danger" name="cancel" onclick="return deleted()">'.str_replace(".","",$status_sell[6]->name).'</button>
                                                ';
                                            }
                                            $i++;
                                            $status = '
                                                <form method="POST">
                                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                                    <input type="hidden" name="id" value="'.$hs->id_sells.'">
                                                    <input type="hidden" name="status" value="'.$status_sell[$i]->id.'">
                                                    <button type="submit" class="btn btn-warning" name="submit">'.str_replace(".","",$status_sell[$i]->name).'</button>
                                                    '.$removed.'
                                                    '.$cancel.'
                                                </form>
                                            '; 
                                        @endphp
                                    @endif
                                @endfor
                            @endforeach
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
    function deleted()
    {
        if(!confirm("Apakah kamu yakin ingin membatalkan pengambilan sampah ini?")){
            event.preventDefault();
        }
    }
    $('#garbage').on('change', function() {
        axios.post('{{ route('user.types.store') }}', {id: $(this).val()}).then(function (response) {
            var price = $('#price').val(response.data.price);
            var price = $('#realprice').val(response.data.price);
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
    $('#qty').on('change', function() {
        var price = $('#realprice').val();
        var qty = $('#qty').val();
        var count = price * qty;
        $('#price').val(count);
    });
</script>
@endsection
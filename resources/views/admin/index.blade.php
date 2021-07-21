@extends('layouts.app')
@section('title','Dashboard')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/select.bootstrap4.min.css')}}">
@endsection
@section('content')
@php 
    $pickup = [];
    $confirm = [];
    $completed = [];
    $cancel = [];
    $process = [];
    $sum = 0; 
    foreach($sell as $se)
    {
        $yaya = FALSE;
        array_push($pickup,"1");

        $confirm2 = FALSE;
        $completed2 = FALSE;
        $cancel2 = FALSE;
        $proses = FALSE;
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
            array_push($confirm,1);
        }
        if($completed2 == TRUE)
        {
            array_push($completed,1);
            $qty = explode(',',$se->qty);
            $sum += array_sum($qty);
        }
        if($cancel2 == TRUE)
        {
            array_push($cancel,1);
        }
        if($proses == TRUE && $confirm2 == FALSE && $completed2 == FALSE && $cancel2 == FALSE)
        {
            array_push($process,1);
        }
    }
    
@endphp

<div class="row mt-4">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">Pengajuan Sampah</div>
                <div class="card-stats-items">
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{count($cancel)}}</div>
                        <div class="card-stats-item-label">Batal</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{count($process)}}</div>
                        <div class="card-stats-item-label">Proses</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{count($confirm)}}</div>
                        <div class="card-stats-item-label">Pending</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{count($completed)}}</div>
                        <div class="card-stats-item-label">Selesai</div>
                    </div>
                </div>
                </div>
                <div class="card-icon bg-secondary">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pengajuan Sampah</h4>
                    </div>
                <div class="card-body">
                    {{number_format(count($pickup))}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-chart">
                <canvas id="garbage-chart" height="80"></canvas>
            </div>
            <div class="card-icon bg-secondary">
                <i class="fas fa-recycle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Sampah</h4>
                </div>
                <div class="card-body">
                    {{$sum}}kg
                    <br>
                    @php
                        $output = array();
                        $output2 = array();
                        $output3 = [];
                        for($i=0;$i<count($sell_asc);$i++)
                        {
                            $yha = FALSE;
                            foreach($history_sell as $hs)
                            {
                                if($hs->status == 6 && $hs->id_sells == $sell_asc[$i]->id)
                                {
                                    $yha = TRUE;
                                }
                            }
                            if($yha == TRUE)
                            {
                                $day = date('Y-m-d',strtotime($sell_asc[$i]->created_at));
                                array_push($output,array('date'=>$day,'value'=>array_sum(explode(',',$sell_asc[$i]->qty))));
                            }
                        }
                        foreach($output as $o)
                        {
                            $output2[$o['date']]['value'] = (isset($output2[$o['date']]['value']) ? $output2[$o['date']]['value'] + $o['value'] : $o['value']);
                            $output2[$o['date']]['date'] = $o['date'];
                        }
                        $output2 = array_values($output2);
                        // echo json_encode($output2);

                    @endphp
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">Penarikan Saldo</div>
                <div class="card-stats-items justify-content-center">
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{number_format(count($history_payment_pending))}}</div>
                        <div class="card-stats-item-label">Pending</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count">{{number_format(count($history_payment_success))}}</div>
                        <div class="card-stats-item-label">Berhasil</div>
                    </div>
                </div>
                </div>
                <div class="card-icon bg-secondary">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pertukaran Saldo</h4>
                    </div>
                <div class="card-body">
                    {{number_format(count($history_payment))}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pengajuan Sampah</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-1">
                        <thead>                                 
                            <tr>
                                <th>No.</th>
                                <th>Pengajuan Sampah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; 
                            @endphp
                            @foreach($sell as $sel)
                                <tr class="clickable-row" data-toggle="modal" data-target="#ticket{{$sel->id}}" style="cursor: pointer;">
                                    <td class="pt-3">{{$no++}}</td>
                                    <td>
                                        @foreach($user as $acc)
                                            @if($acc->id == $sel->id_users)
                                                <span class="image"><img src="{{asset($acc->photo)}}" class="rounded-circle" width="35" height="35" data-toggle="tooltip" title="{{$acc->name}}"></span>&nbsp;&nbsp; 
                                                {{$acc->name}} - 
                                                IDS#{{$sel->id}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="pt-3">
                                        @php
                                            $confirm2 = FALSE;
                                            $completed2 = FALSE;
                                            $cancel2 = FALSE;
                                            $proses = FALSE;
                                            foreach($history_sell as $hsel)
                                            {
                                                if($hsel->status == 5 && $hsel->status != 6 && $hsel->status != 7 && $hsel->id_sells == $sel->id)
                                                {
                                                    $confirm2 = TRUE;
                                                }
                                                if($hsel->status == 6 && $hsel->id_sells == $sel->id)
                                                {
                                                    $completed2 = TRUE;
                                                }
                                                if($hsel->status == 7 && $hsel->id_sells == $sel->id)
                                                {
                                                    $cancel2 = TRUE;
                                                }
                                                if($hsel->id_sells == $sel->id && $hsel->status == 1 OR $hsel->status == 2 OR $hsel->status == 3 OR $hsel->status == 4)
                                                {
                                                    $proses = TRUE;
                                                }
                                            }
                                            if($confirm2 == TRUE && $completed2 == FALSE && $cancel2 == FALSE)
                                            {
                                                echo '<div class="badge badge-warning">Pending</div>';
                                            }
                                            if($completed2 == TRUE)
                                            {
                                                echo '<div class="badge badge-success">Selesai</div>';
                                            }
                                            if($cancel2 == TRUE)
                                            {
                                                echo '<div class="badge badge-danger">Batal</div>';
                                            }
                                            if($proses == TRUE && $confirm2 == FALSE && $completed2 == FALSE && $cancel2 == FALSE)
                                            {
                                                echo '<div class="badge badge-primary">Proses</div>';
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Penarikan Saldo</h4>
            </div>
            <div class="card-body">
                @if (session('withdrawal'))
                    <div class="alert alert-success" role="alert">
                        {{ session('withdrawal') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-inverse table-hover" id="table-2">
                        <thead>                                 
                            <tr>
                                <th>No.</th>
                                <th>Rekening</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; 
                            @endphp
                            @foreach($history_payment as $hp)
                                <tr>
                                    <td class="pt-3">{{$no++}}</td>
                                    <td class="pt-3">
                                        @foreach($bank as $b)
                                            @if($b->id == $hp->id_banks)
                                                @foreach($type_banks as $tb)
                                                    @if($tb->id == $b->id_type_banks)
                                                        @foreach($user as $u)
                                                            @if($u->id == $b->id_users)
                                                                {{$tb->name." ".$b->number." (".$u->name.") - "}}
                                                                @if($u->role == 1)
                                                                User
                                                                @else
                                                                Driver
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="pt-3">
                                        Rp.{{number_format($hp->amount)}}
                                    </td>
                                    <td>
                                        @if($hp->status == 0)
                                            <div class="badge badge-pill badge-danger">Pending</div>
                                        @else
                                            <div class="badge badge-pill badge-success">Berhasil</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($hp->status == 0)
                                            <form method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$hp->id}}">
                                                <button class="btn btn-success btn-sm" type="submit" name="withdrawal"><i class="fas fa-check"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                                                    echo $qty[$i]. "kg Sampah " . $ty->type."<br> ";
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
                                                                    <span class="text-job @if($nox == ($noxx-1)) text-black @endif">{{\Carbon\Carbon::parse($hs->created_at)->diffForHumans()}}</span>
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
@section('page_js')
<script src="{{ asset('assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/modules-datatables.js') }}"></script>

    <script src="{{asset('js/chart.min.js')}}"></script>
    <script>
        function deleted()
        {
            if(!confirm("Apakah kamu yakin ingin membatalkan pengambilan sampah ini?")){
                event.preventDefault();
            }
        }
        var garbage_chart = document.getElementById("garbage-chart").getContext('2d');
        var garbage_chart_bg_color = garbage_chart.createLinearGradient(0, 0, 0, 70);
        garbage_chart_bg_color.addColorStop(0, 'rgba(249,248,113,.2)');
        garbage_chart_bg_color.addColorStop(1, 'rgba(249,248,113,0)');

        var myChart = new Chart(garbage_chart, {
            type: 'line',
            data: {
                labels: [
                    @php
                        if(count($output2) > 0)
                        {
                            for($i=0;$i<count($output2);$i++)
                            {
                                if($i == 0)
                                {
                                    echo json_encode(date('d F Y',strtotime($output2[$i]['date'].'-1 day'))).",";
                                }
                                if($i < count($output2)-1)
                                {
                                    echo json_encode(date('d F Y',strtotime($output2[$i]['date']))).",";
                                }
                                else {
                                    echo json_encode(date('d F Y',strtotime($output2[$i]['date'])));
                                }
                            }
                        }
                        else
                        {
                            echo "'".date('d F Y',strtotime('-1 day'))."',";
                            echo "'".date('d F Y')."'";
                        }
                    @endphp
                ],
                datasets: [{
                label: 'Sampah',
                data: [
                    @php
                        if(count($output2) > 0)
                        {
                            for($i=0;$i<count($output2);$i++)
                            {
                                if($i == 0)
                                {
                                    echo "0,";
                                }
                                if($i < count($output2)-1)
                                {
                                    echo json_encode($output2[$i]['value']).",";
                                }
                                else 
                                {
                                    echo json_encode($output2[$i]['value']);
                                }
                            }
                        }
                        else
                        {
                            echo "0, 0";
                        }
                    @endphp
                ],
                backgroundColor: garbage_chart_bg_color,
                borderWidth: 3,
                borderColor: 'rgba(249,248,113,1)',
                pointBorderWidth: 0,
                pointBorderColor: 'transparent',
                pointRadius: 3,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: 'rgba(249,248,113,1)',
                }]
            },
            options: {
                layout: {
                padding: {
                    bottom: -1,
                    left: -1
                }
                },
                legend: {
                display: false
                },
                scales: {
                yAxes: [{
                    gridLines: {
                    display: false,
                    drawBorder: false,
                    },
                    ticks: {
                    beginAtZero: true,
                    display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                    drawBorder: false,
                    display: false,
                    },
                    ticks: {
                    display: false
                    }
                }]
                },
            }
        });        
    </script>
@endsection
@extends('layouts.app')
@section('title','Penarikan Saldo')
@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}!
                        </div>
                    @endif
                    @if (session('fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('fail') }}!
                        </div>
                    @endif
                    <div class="text-center">
                        <small>Saldo anda</small>
                        <h4 class="card-title">Rp.{{number_format(Wallet::amount(Auth::user()->id))}}</h4>
                        <hr>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="mb-4">
                                    <label class="col-form-label">Penarikan Dari</label>
                                    <h4 class="card-title">Saldo</h4>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="w-100 mb-4">
                                    <label for="bank" class="col-form-label">Ke</label>
                                    <select name="bank" id="bank" class="form-control garbage" required>
                                        <option value="" selected disabled>== Pilih Rekening ==</option>
                                        @foreach($bank as $b)
                                            @foreach($type_bank as $tb)
                                                @if($tb->id == $b->id_type_banks)
                                                    <option value="{{$b->id}}">{{$tb->name." ".$b->number." (".Auth::user()->name.")"}}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @if(count($bank)<1)
                                        <span>Anda tidak memiliki rekening, <a href="{{ route(Role::is().'.settings') }}#banks" class="text-danger">Klik disini</a>. Untuk menambahkan rekening.</span>
                                    @endif
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    Rp
                                </div>
                                <div class="w-100 mb-4">
                                    <label for="amount" class="col-form-label">Nominal</label>
                                    <input type="number" id="amount" name="amount" class="form-control" style="font-weight: bold;" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Penarikan</h4>
                </div>
                <div class="card-body">             
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach($history_payment as $hp)
                            @foreach($bank as $b)
                                @if($b->id == $hp->id_banks)
                                    <li class="media">
                                        <a href="#" class="media-body" style="text-decoration: none;">
                                            @if($hp->status == 0)
                                                <div class="badge badge-pill badge-danger mb-1 float-right">Pending</div>
                                            @else
                                                <div class="badge badge-pill badge-success mb-1 float-right">Berhasil</div>
                                            @endif
                                            @foreach($type_banks as $tb)
                                                @if($tb->id == $b->id_type_banks)
                                                    <div class="media-title">{{$tb->name}} {{$b->number}} <span class="text-success">(+Rp.{{number_format($hp->amount)}})</span></div>
                                                @endif
                                            @endforeach
                                            <div class="text-primary">{{\Carbon\Carbon::parse($hp->created_at)->diffForHumans()}}</div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    
    $('#amount').keyup(function() {
        if ($('#amount').val().trim() > {{Wallet::amount(Auth::user()->id)}}) 
        {
            $('#amount').val({{Wallet::amount(Auth::user()->id)}});
        }
        
        if ($('#amount').val().trim() < 0) 
        {
            $('#amount').val(0);
        }
    });
</script>
@endsection
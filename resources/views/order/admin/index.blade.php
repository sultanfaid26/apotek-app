@extends('layouts.template')

@section('content')
<div class="mt-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.order.download-excel') }}" class="btn btn-primary"><i class="bi bi-upload"></i> Export Excel</a>
    </div>
    <form action="{{ route('admin.order.search-data') }}" method="get" >
        <div style="width: 500px" class="d-flex">
            <label for="searchByDate">Search By Date: </label>
            <input type="date" class="form-control" name="search" id="search" style="margin-left: 5px">
            <Button type="submit" class="btn btn-success" style="margin-left: 5px">Cari</Button>
            <a href="{{route('admin.order.data')}}" class="btn btn-danger" style="margin-left: 5px">Reset</a>
        </div>
    </form>
    <table class="table mt-5 table-striped table-bordered table-hovered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Pesanan</th>
                <th>Total Bayar</th>
                <th>Kasir</th>
                <th>tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                {{-- currentpage: ambil posisi ada di page keberapa - 1 (misal udah klik next lagi ada di page 2 berarti jadi 2-1 = 1), perpage: mengambil jumlah data yang ditemukan per pagenya berapa (ada di controller bagian paginate/simplepaginate, misal 5), loop->index: mengambil index dr array (mulai dari 0)+1 --}}
                {{-- jadi : (2-1) x 5 + 1 = 6 --}}
                <td>{{ ($orders->currentpage()-1) * $orders->perpage() + $loop->index + 1 }}</td>
                <td>{{$order['name_costumer']}}</td>
                <td>
                    <ol>
                        @foreach ($order['medicines'] as $medicine)
                            <li>{{ $medicine['name_medicine'] }} <small>Rp. {{ number_format($medicine['price'],0,'.',',',) }} <b>(qty : {{number_format($medicine['qty'])}})</b></small> = Rp. {{ number_format($medicine['price_after_qty'], 0, '.', ',',) }}</li>
                        @endforeach
                    </ol>
                </td>
                @php
                    $ppn = $order['total_price']*0.1;
                @endphp
                <td>Rp. {{ number_format($order['total_price'], 0, '.', ',') }}</td>
                <td>{{ $order['user']['name'] }} ( <a href="mailto: {{ $order['user']['email'] }}">{{ $order['user']['email'] }}</a> )</td>
                @php
                    setLocale(LC_ALL, 'IND')
                @endphp
                <td>{{ Carbon\Carbon::parse($order['created_at'])->formatLocalized('%d %B %Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        @if ($orders->count())
            {{ $orders->links() }}            
        @endif
    </div>

</div>
@endsection
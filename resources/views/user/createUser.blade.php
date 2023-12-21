@extends('layouts.template')

@section('content')
<form action="{{ route('user.store') }}" method="post" class="card p-5 mt-5 bg-light">
    {{--sebagai token akses database--}}
    @csrf
    {{--jika terjadi error validasi, akan ditampilkan bagian errornya : --}}
    @if ($errors->any())
        <ul class="alert alert-danger p-5">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="mb-3 row">
      <label for="name" class="col-sm-2 col-form-label">Nama :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name">
      </div>
    </div>
    <div class="mb-3 row">
      <label for="name" class="col-sm-2 col-form-label">Email :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="email" name="email">
      </div>
    </div>
    <div class="mb-3 row">
      <label for="type" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
      <div class="col-sm-10">
        <select id="role" class="form-control" name="role">
            <option disabled hidden selected> Pilih </option>
            <option value="cashier"> Cashier </option>
            <option value="admin"> Admin </option>
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>
@endsection
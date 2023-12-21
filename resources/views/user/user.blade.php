@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success')}}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted')}}</div>
    @endif

    <a href="{{ route('user.create') }}" class="btn btn-primary mt-5 ">Tambah User</a>
    <table class="table mt-4 table-striped table-bordered table-hovered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($user as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['role'] }}</td>
                    <td class="d-flex justify-content-center">
                      <a href="{{route('user.edit', $item->id)}}" class="btn btn-primary me-3"><i class="ri-edit-line">Edit</i></a>
                           <form action="{{ route('user.delete', $item['id'])}}" method="POST">
                           @method('DELETE')
                           @csrf
                           <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item['id'] }}">
                                <i class="ri-delete-bin-line">Hapus</i>
                           </button>
                                <div class="modal fade" id="exampleModal{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog">
                                       <div class="modal-content">
                                        <div class="modal-header">
                                           <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                              <div class="modal-body">
                                                 <p>Yakin ingin menghapus data ini ?</p>
                                                      </div>
                                                 <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                     <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                         </div>
                                  </div>
                            </div>
                      </form>
                 </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        @if ($user->count())
            {{ $user->links() }}
        @endif
    </div>

@endsection


@extends('layouts.template')

@section('content')
<div id="msg-success"></div>

    <table class="table mt-5 table-striped table-bordered table-hovered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Stock</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1 @endphp
            @foreach ($medicines as $item)
             <tr>
                <td>{{ $no++}}</td>
                <td>{{$item['name']}}</td>
                <td style="background: {{ $item['stock']<= 3 ? 'red' : 'none' }}">{{ $item['stock'] }}</td>
                <td>
                    <div class="btn btn-primary" onclick="edit({{ $item['id'] }})">Tambah Stock</div>
                </td>

            </tr>   
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        @if ($medicines->count())
            {{ $medicines->links() }}            
        @endif
    </div>

    <div class="modal fade" id="tambah-stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ubah Data Stock</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" id="form-stock">
            <div class="modal-body">
              <div id="msg"></div>
              <input type="hidden" name="id" id="id">
              <div>
                <label for="name">Nama Obat</label>
                <input type="text" name="name" id="name" class="form-control" disabled>
              </div>
              <div>
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>
@endsection

@push('script')
    <script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr("content"),
        }
      })


        function edit(id) {
            let url ="{{ route('medicine.show', 'id' ) }}";

            url= url.replace('id', id);

            $.ajax({
                type: 'GET',
                url: url,
                contentType: 'json',
                success: function (res) {
                    $("#tambah-stock").modal("show");
                    $("#name").val(res.name);
                    $("#stock").val(res.stock)
                    $("#id").val(res.id)
                }
            })
        }

        $("#form-stock").submit(function (e){
          e.preventDefault();
          let id = $("#id").val();
          let url = "{{ route('medicine.stock.update', 'id' ) }}";
          url = url.replace('id', id);

          let data ={
            stock: $("#stock").val(),
          }
          $.ajax({
            type:'PATCH',
            url: url,
            data: data,
            cache: false,
            success: function (res) {
                $('#tambah-stock').modal("hide");
                sessionStorage.successUpdateStock = true;
                window.location.reload();
            },
            error: function (err){
              $("#msg").attr("class", "alert alert-danger");
              $("#msg").text(err.responseJSON.message);
            }
          });
        });
          $(function () {
            if (sessionStorage.successUpdateStock) {
              $("#msg-success").attr("class", "alert alert-success");
              $("#msg-success").text("Berhasil mengubah data stock!");
              sessionStorage.clear()
            }
          });
    </script>
@endpush
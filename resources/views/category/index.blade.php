@extends('app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xl-6">
                <form method="GET" autocomplete="off">
                    <div class="input-group mb-3">
                      <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search..." >
                      <button class="btn btn-success" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-right">Daftar Category</h4>
                        <div class="float-right">
                            <a href="{{ route('category.create') }}"  class="btn btn-primary">Tambah Data</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Is Publish</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $key => $item)
                                    <tr>
                                        <td>{{ ($lists->currentpage()-1) * $lists->perpage() + $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->is_publish == 1)
                                                <span class="badge text-bg-success">Publish</span>
                                            @else
                                                <span class="badge text-bg-danger">Not Publish</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                            <button class="btn btn-danger" onclick="Delete(this.id)"  id="{{ $item->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $lists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function Delete(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (isConfirm) {
                console.log(isConfirm.isConfirmed);
                if (isConfirm.isConfirmed == true) {
                    //ajax delete
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ route('category.index') }}/"+id,
                        data: {
                            id : id
                        },
                        type: 'DELETE',
                        success: function (response) {
                            console.log(response);
                            if (response.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus'
                                }).then(function() {
                                    window.location = "{{ url("category") }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal dihapus',
                                    text: 'Something went wrong!',
                                    footer: '<a href="">Why do I have this issue?</a>'
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else if(isConfirm.isConfirmed == false) {
                    console.log('cancel')
                }
            });
        }
    </script>
@endpush

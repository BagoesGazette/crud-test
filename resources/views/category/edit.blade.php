@extends('app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-right">Edit Category</h4>
                </div>
                <form action="{{ route('category.update', $detail->id) }}" method="post" autocomplete="off">@csrf @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $detail->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="is_publish" class="form-label">Is Publish</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('is_publish') is-invalid @enderror" 
                                {{ $detail->is_publish == 1 ? ' checked="checked"' : '' }}
                                type="radio" name="is_publish" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Publish</label>
                                @error('is_publish')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('is_publish') is-invalid @enderror" 
                                {{ $detail->is_publish == 0 ? ' checked="checked"' : '' }}
                                type="radio" name="is_publish" id="inlineRadio2" value="0">
                                <label class="form-check-label" for="inlineRadio2">Not Publish</label>
                                @error('is_publish')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('category.index') }}"  class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('title')
{{ env('APP_NAME') }} - Dashboard
@endsection

@section('content')

<div class="container-fluid">
    <div class="card-group"style="column-gap:1rem;">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">20
                        </h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Users</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">20</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Documents</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="globe"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 col-md-9 col-lg-9">
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">
                            <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <input type="file" id="csv_file" class="form-control" required name="document" accept=".csv" style="display:none;"  onchange="handleFileChange()">
    
                                <button type="button" class="btn btn-info"style="float: right;width: 100%;" onclick="triggerFileInput()">Import CSV</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable_product" class="table table-striped table-bordered display no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Uploaded By</th>
                                    <th>Uploaded At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->index + 1 }} </td>
                                        <td>{{ $product->name }} </td>
                                        <td><img src="{{ url($product->image) }}" class="rounded-circle" width="50"
                                                height="50" /> </td>
                                        <td>{{ $product->quantity }} </td>
                                        <td>{{ $product->cost }} </td>
                                        <td>
                                            @if ($product->active == '1')
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td>
                                            <a href="products/{{ $product->id }}/edit" class="btn btn-dark btn-sm">Edit
                                            </a>
                                            <a href="products/delete/{{ $product->id }}" class="btn btn-dark btn-sm">Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        function triggerFileInput() {
            document.getElementById('csv_file').click();
        }

        function handleFileChange() {
            document.getElementById('uploadForm').submit();
        }
    </script>
@endpush

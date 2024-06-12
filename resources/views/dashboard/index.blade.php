@extends('layouts.master')

@section('title')
{{ env('APP_NAME') }} - Dashboard
@endsection

@section('content')

<div class="container-fluid">
    <div class="card-group"style="column-gap:1rem;">
                <div class="card border-right">
            <a href="{{route('dashboard.index')}}">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">{{$document_count}}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Uploaded Documents</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="globe"></i></span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        @if(Auth::user()->role == "admin")
        <div class="card border-right">
            <a href="{{route('admin.users')}}">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{DB::table('users')->where('status',1)->count();}}
                            </h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Users</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @else
        <div class="card border-right">
            <a href="{{route('dashboard.index',['document_type'=>'public'])}}">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{DB::table('documents')->where('user_id','!=',Auth::user()->id)->where('document_type','public')->count();}}
                            </h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Public Documents</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
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
                            <button type="button" class="btn btn-info" style="float: right;width: 100%;"  data-toggle="modal"  data-target="#uploadModal">Upload Document</button>
                        </div>
                    </div>
                    @if($documents->count()<1)
                    <div>
                        <h3 class="text-muted font-weight-bold mb-0 w-100 text-truncate">No Documents</h3>
                    </div>                
                    @else
                    <div class="table-responsive">
                        <table id="datatable_product" class="table table-striped table-bordered display no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    @if(Auth::user()->role == "admin" || Request::get('document_type')=='public')
                                    <th>Uploaded By</th>
                                    @elseif(Auth::user()->role == "admin")
                                    <th>User Status</th>
                                    @endif
                                    <th>Uploaded At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    <tr>
                                        <td>{{ $loop->index + 1 }} </td>
                                        <td>{{ $document->document_name }} </td>
                                        <td style="display:none;" id="document_guid">{{ $document->document_guid }} </td>
                                        <td>{{ $document->document_type }} </td>
                                        <td>{{ $document->document_size }} </td>
                                        @if(Auth::user()->role == "admin" || Request::get('document_type')=='public')
                                        <td>{{ $document->uploaded_by }} </td>
                                        @elseif(Auth::user()->role == "admin")
                                        <td>
                                        @if($document->user_status == 1)<span class="badge badge-success">Active</span>
                                        @else 
                                        <span class="badge badge-danger">Inactive</span>
                                        @endif
                                        </td>
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($document->created_at)->format('Y-m-d')}} </td>
                                        <td>
                                            @if(Auth::user()->role == "admin" || $document->uploaded_by == Auth::user()->name)
                                            <button type="button" class="btn btn-danger btn-sm" id="delete" data-toggle="modal"  value="{{$document->id}}" data-target="#myModal">Delete</button>
                                            @endif
                                            <a href="{{route('document.download', ['file_name' => $document->document_file])}}" class="btn btn-success btn-sm">Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $documents->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ARE YOU SURE?</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this document?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('document.delete') }}" method="post">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                    <button type="submit" class="btn btn-primary">YES</button>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="uploadModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload a Document</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="file" id="csv_file" class="form-control mb-2" required name="document" accept=".csv" >
                <select class="form-control select mb-2" name="document_type" required>
                    <option value="">Select Type</option>
                    <option value="private">Private</option>
                    <option value="public"> Public</option>
                </select>
                <button type="submit" class="form-control btn btn-success submit-button"style="float: right;width: 50%;">Save</button>
                </form>
            </div>
            <div class="modal-footer"style="border-top:0;">
            </div>
        </div>

    </div>
</div>
@endsection
@push('js')
    <script>
        $('body').on('click', '#delete', function() {
            var id = $(this).parents('tr').find('#document_guid').text();
            $('#id').val(id);
        })
    </script>
@endpush

@extends('layouts.master')

@section('title')
{{ env('APP_NAME') }} - Users
@endsection

@section('content')

<div class="container-fluid">
    <div class="card-group"style="column-gap:1rem;">
        <div class="card border-right">
            <div class="card-body">
                <a href="{{route('dashboard.index')}}">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{$document_count}}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Documents</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="globe"></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <a href="{{route('admin.users')}}">
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
                </a>
            </div>
        </div>
    </div>
        <div class="row container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    @if($users->count()<1)
                    <div>
                        <h3 class="text-muted font-weight-bold mb-0 w-100 text-truncate">No Users</h3>
                    </div>                
                    @else
                    <div class="table-responsive">
                        <table id="datatable_product" class="table table-striped table-bordered display no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>User Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }} </td>
                                        <td style="display:none;" id="id">{{ $user->id }} </td>
                                        <td>{{ $user->name }} </td>
                                        <td>{{ $user->email }} </td>
                                        <td>{{ $user->role }} </td>
                                            <td>
                                            @if($user->status == 1)<span class="badge badge-success">Active</span>
                                            @else 
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                            </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" id="delete" data-toggle="modal" data-target="#myModal">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $users->links('pagination::bootstrap-4')}}
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
                <p>Do you really want to delete this user?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.users.delete') }}" method="post">
                    @csrf
                    <input type="hidden" id="user_id" name="id">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                    <button type="submit" class="btn btn-primary">YES</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@push('js')
    <script>
        $('body').on('click', '#delete', function() {
            var id = $(this).parents('tr').find('#id').text();
            $('#user_id').val(id);
        })
    </script>
    

@endpush

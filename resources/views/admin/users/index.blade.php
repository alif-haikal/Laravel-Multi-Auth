@extends('layouts.app')
@section('content')
<div class="container pt-2">
    <div class="card">
        <div class="card-header">
            <h2>Users Detail</h2>
        </div>
        <div class="card-body">
            <table id="userDatatable" class="display" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#userDatatable').DataTable({
                ajax: "{{ route('admin.users') }}",
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},

                ]
            });

    });
</script>
@endsection

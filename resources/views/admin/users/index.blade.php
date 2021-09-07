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
                        <th>Status</th>
                        <th>Action</th>
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
            ajax: "{{ route('users.index') }}",
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
            ],
            columnDefs: [
                {
                    "targets": 3,
                    "sortable": true,
                    "data": 'status',
                    "render": function(data, type, full, meta) {
                        return data == 1 ? "Active" : "InActive";
                    }
                },
                {
                    "targets": 4,
                    "data": 'id',
                    "render": function(data, type, full, meta) {
                        let showUrl = "{{ route('users.show', 'data-id') }}";
                        let editUrl = "{{ route('users.edit', 'data-id') }}";

                        showUrl = showUrl.replace('data-id', data);
                        editUrl = editUrl.replace('data-id', data);


                        return '<div class="form-group">' +
                        '<div class="btn-group" role="group">' +
                        '<button type="button" data-action="' + showUrl + '" class="btn btn-icon btn-outline-info" onClick="getModalContent(this)"><i class="fa fa-search">Show</i></button>' +
                        '<button type="button" data-action="' + editUrl + '" class="btn btn-icon btn-outline-warning" onClick="getModalContent(this)"><i class="fa fa-search">Edit</i></button>' +
                        '</div>' +
                        '</div>'
                    }
                }
            ]
        });

    });

</script>
@endsection

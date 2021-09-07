<div class="modal fade" id="baseAjaxModalContent" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Show User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Id</label>
                        <input type="text" class="form-control" value="{{ $user->id ?? '' }}" placeholder="Id" disabled>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $user->name ?? '' }}" placeholder="Name"
                            name="name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $user->email ?? '' }}" placeholder="Email"
                            name="email">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Statu</label>
                        <select class="form-control" name="status">
                            <option value="0" selected="{{($user->status == '0') ? true : false}}">InActive</option>
                            <option value="1" selected="{{($user->status == '1') ? true : false}}">Active</option>
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                            data-action="{{ route('users.update', $user->id) }}" onClick="btnUpdate(this)">Update
                            Changes</button>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
<script type="text/javascript">
    btnUpdate = (elem) => {
        confirmAction(elem).then((result) => {
            let data = $('form').serialize();
            if (result.value) {
                let datatable = $('#userDatatable')
                processInit(elem, datatable, data)
            } else {
                Swal.fire(
                    'Canceled',
                    'Process has been canceled',
                    'info'
                )
            }
        })
    }
</script>

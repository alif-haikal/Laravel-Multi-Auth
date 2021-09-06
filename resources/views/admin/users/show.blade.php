<div class="modal fade" id="baseAjaxModalContent" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel">Show User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Id</label>
                    <input disabled type="text" class="form-control" value="{{ $user->id ?? '' }}" placeholder="Id" name="id">
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input disabled type="text" class="form-control" value="{{ $user->name ?? '' }}" placeholder="Name"
                        name="name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input disabled type="text" class="form-control" value="{{ $user->email ?? '' }}" placeholder="Email"
                        name="email">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select disabled class="form-control" name="status">
                        <option value="0" selected="{{($user->status == '0') ? true : false}}" >InActive</option>
                        <option value="1" selected="{{($user->status == '1') ? true : false}}">Active</option>
                    </select>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

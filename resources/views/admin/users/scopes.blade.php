<div class="modal fade" id="baseAjaxModalContent" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="editModalLabel">Role & Scopes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <h5 class="modal-title text-center" id="editModalLabel">Role</h5>
                        <hr></hr>
                        <div class="form-group">
                            <select class="form-control" id="roles" name="roles">
                                @foreach($roles as $role)
                                    <option value="{{$role}}"  {{ $role == $userRole[0] ? 'selected' : ''}}>{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <h5 class="modal-title text-center" id="editModalLabel">Scopes</h5>
                        <hr></hr>
                        @foreach($scopes as $scope)
                            <div>
                                <input type="checkbox" id="{{$scope}}" name="{{$scope}}" {{in_array($scope , $userScopes) ? 'checked' : ''}}>
                                <label for="{{$scope}}">{{$scope}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                        data-action="{{ route('users.scopes.update', $id) }}" onClick="btnUpdate(this)">Update
                        Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    btnUpdate = (elem) => {
        confirmAction(elem).then((result) => {
            let data = $('form').serialize();
            $.ajax({
                url: elem.dataset.action,
                type: 'POST',
                data: data,
                success: function(response) {
                    if(response.message){
                        $(baseAjaxModalContent).modal("hide");
                    }
                },
                fail: (response) => {
                    Swal.fire(
                        'Opps!',
                        'An error occurred, we are sorry for inconvenience.',
                        'danger'
                    )
                }
            })
        })
    }
    
    $('select').on('change', function(e) {
        
        $("Form :input").prop("disabled", true);
        $.ajax({
            url: "{{ route('users.scopes.by.role') }}",
            type: 'GET',
            data: {
                "role":e.currentTarget.selectedOptions[0].value
            },
            success: function(response) {
                $('input:checkbox').prop('checked', false);
                $.each(response.permissions, function(key,value) {
                    $('#'+value).prop('checked',true);
                }); 
            },
            fail: (response) => {
                Swal.fire(
                    'Opps!',
                    'An error occurred, we are sorry for inconvenience.',
                    'danger'
                )
            }
        })
        $("Form :input").prop("disabled", false);
    });
</script>

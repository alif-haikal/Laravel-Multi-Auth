<div class="modal fade" id="baseAjaxModalContent" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Permissions / Scopes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($scopes as $scope)
                        <div>
                            <input type="checkbox" id="{{$scope}}" name="{{$scope}}" {{in_array($scope , $userScopes) ? 'checked' : ''}}>
                            <label for="{{$scope}}">{{$scope}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>
    </form>
</div>
<!-- <script type="text/javascript">
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
</script> -->

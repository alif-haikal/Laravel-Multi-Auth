<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.jqueryui.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            padding-top: 2.5rem;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }


        .navbar {
            -webkit-box-shadow: 0 8px 6px -6px #EEE;
            -moz-box-shadow: 0 8px 6px -6px #EEE;
            box-shadow: 0 8px 6px -6px #EEE;
            border-bottom: 1px solid #EEE;
            margin: 0 !important;
            padding: 0px !important;

        }
    </style>
</head>

<body>
    <div id="baseAjaxModal"></div>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-white fixed-top bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="/images/navbar-logo.png" width="95" height="70" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name ?: Auth::user()->username }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                                @if(Auth::user()->is_admin == 1)
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"">
                                    {{ __('Logout') }}
                                </a></li>
                            <form id=" logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                        </form>
                </div>
                </li>
                </ul>
            </div>
        </nav>
        @yield('content')
    </div>

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        getModalContent = (elem) => {
            $.get(elem.dataset.action, function(response) {
                $("#baseAjaxModal").html(response);
                $(baseAjaxModalContent).modal("show");
            });
        }

        confirmAction = (elem) => {
            return Swal.fire({
                title: 'Are you sure?',
                text: 'Data will be updated!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc0330',
                cancelButtonColor: '#999',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            })
        }

        processInit = (elem, datatable, data) => {

            Swal.fire({
                title: 'Data is being processed. Please wait...',
                didOpen: function() {
                    Swal.showLoading();
                    $.ajax({
                        url: elem.dataset.action,
                        data: data,
                        type: 'PUT',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: true,
                                }).then(() => {

                                    $(baseAjaxModalContent).modal("hide");
                                    datatable.DataTable().ajax.reload()
                                });
                            }
                        },
                        fail: (response) => {
                            Swal.fire(
                                'Opps!',
                                'An error occurred, we are sorry for inconvenience.',
                                'danger'
                            )
                            failCallback()
                        }
                    })
                    Swal.hideLoading();
                }
            })
        }
    </script>
</body>

</html>

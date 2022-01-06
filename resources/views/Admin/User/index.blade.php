<x-app-layout title="Manajemen User">
    <div class="main-panel">
        <div class="content-wrapper">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="page-header">
                <h3 class="page-title"> Daftar User </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Merchant</a></li> --}}
                        {{-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> --}}
                    </ol>
                </nav>
            </div>
            <div>
                <a data-toggle="modal" data-target="#modal-tambah-user" class="btn btn-primary mb-2">Add User</a>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title">Bordered table</h4> --}}
                            </p>
                            <div class="row">
                                <table tab class="table nowrap table-bordered" id="tableMerchant"
                                    style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> FullName </th>
                                            <th> Name </th>
                                            <th> Email </th>
                                            <th> Merchant Name </th>
                                            <th> Phone Number </th>
                                            <th> Address </th>
                                            <th> Birth Date </th>
                                            <th> Role </th>
                                            <th> Profile Image </th>
                                            <th> Created At </th>
                                            <th> Updated At </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <!-- partial -->
    </div>

    <div id="modal-tambah-user" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Add User</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form action="{{ route('user.store') }}" method="POST" id="form-tambah-user"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <input id="username" type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Email<sup class="text-danger">*</sup></label>
                            <input id="email" type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Password<sup class="text-danger">*</sup></label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Confirm Password<sup
                                    class="text-danger">*</sup></label>
                            <input id="password" type="password" class="form-control" name="password_confirmation"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-edit-user" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Edit User</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form method="POST" id="form-edit-user" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputUsername1">Full Name<sup class="text-danger">*</sup></label>
                            <input id="fullname-edit" type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <input id="username-edit" type="text" class="form-control" name="username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Email<sup class="text-danger">*</sup></label>
                            <input id="email-edit" type="email" class="form-control" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Phone Number<sup class="text-danger">*</sup></label>
                            <input id="phonenumber-edit" type="number" class="form-control" name="phone_number"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Picture</label>
                            <div class="custom-file">
                                <input accept="image/*" class="form-control-file" name="picture" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Birthdate<sup class="text-danger">*</sup></label>
                            <input id="birthdate-edit" type="date" class="form-control" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Address<sup class="text-danger">*</sup></label>
                            <input id="address-edit" type="text" class="form-control" name="address" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-show-picture" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="" id="username-picture"></h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <img style="width: 100%; overflow: hidden !important" id="img-modal" alt="">
                </div>
            </div>
        </div>
    </div>
    <script>
        let table = $('#tableMerchant').DataTable({
            order: [
                [11, "desc"]
            ],
            scrollX: "100%",
            processing: true,
            serverSide: true,
            width: "100%",
            ajax: {
                url: "{{ route('user.get-user') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'fullname',
            }, {
                data: 'username',
            }, {
                data: 'email',
            }, {
                data: 'merchant_name',
                searchable: false
            }, {
                data: 'phone_number',
            }, {
                data: 'address',
            }, {
                data: 'birthdate',
            }, {
                data: 'role',
            }, {
                data: 'picture',
            }, {
                data: 'created_at',
                searchable: false
            }, {
                data: 'updated_at',
                searchable: false
            }, {
                data: 'action',
                searchable: false
            }],
        });


        $(document).on('click', '.btn-edit-user', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var fullname = $(this).data('fullname');
            var username = $(this).data('username');
            var email = $(this).data('email');
            var phonenumber = $(this).data('phonenumber');
            var birthdate = $(this).data('birthdate');
            var address = $(this).data('address');
            var link = $(this).data('link');

            $('#fullname-edit').val(fullname);
            $('#username-edit').val(username);
            $('#email-edit').val(email);
            $('#phonenumber-edit').val(phonenumber);
            $('#birthdate-edit').val(birthdate);
            $('#address-edit').val(address);
            $('#form-edit-user').attr('action', link);
            console.log(username, name, $('#form-edit-user'))
        });

        $(document).on('click', '.btn-show-picture', function(event) {
            
            var username = $(this).data('username');
            var link = $(this).data('link');

            $('#username-picture').html(username);
            $('#img-modal').attr('src', link);
            console.log(username, name, $('#form-edit-user'))
        });
    </script>
</x-app-layout>

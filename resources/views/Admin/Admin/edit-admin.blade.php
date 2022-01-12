<x-app-layout title="Edit Profile">
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
                <h3 class="page-title"> Edit Admin </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Merchant</a></li> --}}
                        {{-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> --}}
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="text-center">
                                    <img src="{{ asset('storage/gambar-user/' . $admin->picture) }}"
                                        alt="admin-picture" class="mb-5" id="profile-image">
                                </div>
                                <form method="POST" action="{{ route('admin.update', $admin->id) }}" id="form-edit-user"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Full Name<sup
                                                class="text-danger">*</sup></label>
                                        <input id="fullname-edit" value="{{ $admin->fullname }}" type="text"
                                            class="form-control" name="fullname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Username<sup
                                                class="text-danger">*</sup></label>
                                        <input id="username-edit" value="{{ $admin->username }}" type="text"
                                            class="form-control" name="username" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Email<sup
                                                class="text-danger">*</sup></label>
                                        <input id="email-edit" value="{{ $admin->email }}" type="email"
                                            class="form-control" name="email" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Phone Number<sup
                                                class="text-danger">*</sup></label>
                                        <input id="phonenumber-edit" value="{{ $admin->phone_number }}" type="number"
                                            class="form-control" name="phone_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Picture</label>
                                        <div class="custom-file">
                                            <input accept="image/*" value="{{ $admin->picture }}"
                                                class="form-control-file" name="picture" type="file">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Birthdate<sup
                                                class="text-danger">*</sup></label>
                                        <input id="birthdate-edit" value="{{ $admin->birthdate }}" type="date"
                                            class="form-control" name="birthdate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Address<sup
                                                class="text-danger">*</sup></label>
                                        <input id="address-edit" value="{{ $admin->address }}" type="text"
                                            class="form-control" name="address" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                </form>
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
    <script>
        let table = $('#tableAdmin').DataTable({
            order: [
                [11, "desc"]
            ],
            scrollX: "100%",
            processing: true,
            serverSide: true,
            width: "100%",
            ajax: {
                url: "{{ route('admin.get-admin') }}",
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


        $(document).on('click', '.btn-edit-admin', function(event) {
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

<x-app-layout title="Pet Activity">
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
            <div>
                <h4 class="fw-bold">Filter</h4>
            </div>
            <div class="d-flex row-filter">
                <div class="form-group col">
                    <label for="exampleInputUsername1">Username</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" onchange="filter_username()" id="filter-username"
                            name="username" required style="width:100%">
                            <option value="">--Pilih--</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->id }}">{{ $item->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col">
                    <label for="exampleInputUsername1">Pet Group</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" onchange="filter_group()" id="filter-group" name="pet_group" required
                            style="width:100%">
                            <option value="">--Pilih--</option>

                        </select>
                    </div>
                </div>
                <div class="col form-group">
                    <label for="exampleInputUsername1">Pet Habitats</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" id="filter-habitats" name="pet_habitats" required
                            style="width:100%">
                            <option value="">--Pilih--</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="page-header">
                <h3 class="page-title"> List Activity Pet </h3>
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
                            {{-- <h4 class="card-title">Bordered table</h4> --}}
                            </p>
                            <div class="row">
                                <table tab class="table nowrap table-bordered" id="tableMerchant"
                                    style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Owner </th>
                                            <th> Pet Name </th>
                                            <th> Pet Group </th>
                                            <th> Pet Activity </th>
                                            <th> Activity Date </th>
                                            <th> Created At </th>
                                            <th> Updated At </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let username = $('#filter-username').val();
        let group = $('#filter-group').val();
        let habitats = $('#filter-habitats').val();

        let table = $('#tableMerchant').DataTable({
            order: [
                [7, "desc"]
            ],
            scrollX: "100%",
            processing: true,
            serverSide: true,
            width: "100%",
            ajax: {
                url: "{{ route('pet-activity.get-pet') }}",
                data: function(d) {
                    d.username = username;
                    d.group = group;
                    d.habitats = habitats;
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'username',
                searchable: false
            }, {
                data: 'pet_name',
            }, {
                data: 'pet_group_name',
                searchable: false
            }, {
                data: 'pet_activity_detail',
                searchable: false
            }, {
                data: 'pet_activity_date',
                searchable: false
            }, {
                data: 'created_at',
                searchable: false
            }, {
                data: 'updated_at',
                searchable: false
            }],
        });

        function filter_username(params) {
            $("#filter-group").find('option').not(':first').remove();
            username = $('#filter-username').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('pet-profile.get-group') }}",
                data: {
                    username: username
                },
                success: function(response) {
                    if (response) {
                        console.log(response.data);
                        response.data.forEach(function(item, index) {
                            $('#filter-group').append($('<option>', {

                                value: item['id'],
                                text: item['pet_group_name']
                            }));
                        });
                    }
                },
            });
            table.ajax.reload(null, false);
        }

        function filter_group(params) {
            group = $('#filter-group').val();
            table.ajax.reload(null, false);
        }

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

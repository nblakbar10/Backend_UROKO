<x-app-layout title="Merchant">
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
                <h3 class="page-title"> Daftar Pet Hotel Provider </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Merchant</a></li> --}}
                        {{-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> --}}
                    </ol>
                </nav>
            </div>
            <div>
                <a data-toggle="modal" data-target="#modal-tambah-provider" class="btn btn-primary mb-2">Tambah
                    Pet Hotel Provider</a>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title">Bordered table</h4> --}}
                            </p>
                            <div class="row">
                                <table class="table nowrap table-bordered" id="tableMerchant"
                                    style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Username </th>
                                            <th> Merchant Name </th>
                                            <th> Hotel Name </th>
                                            <th> Hotel Address </th>
                                            <th> Hotel Phone </th>
                                            <th> Hotel Photo </th>
                                            <th> Hotel Description </th>
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

    <div id="modal-edit-pet-hotel-provider" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Edit Pet Hotel Provider</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form  method="POST" id="form-edit-pet-hotel-provider"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <div class="form-group">
                                <input id="username-edit" type="text" class="form-control" name="username_edit"
                                readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Merchant Name<sup class="text-danger">*</sup></label>
                            <input id="merchant-name-edit" type="text" class="form-control" name="merchant_name"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Name<sup
                                    class="text-danger">*</sup></label>
                            <input id="pet-hotel-provider-name-edit" type="text" class="form-control" name="pet_hotel_provider_name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Address<sup
                                    class="text-danger">*</sup></label>
                            <input id="pet-hotel-provider-address-edit" type="text" class="form-control" name="pet_hotel_provider_address" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Phone<sup
                                    class="text-danger">*</sup></label>
                            <input id="pet-hotel-provider-phone-edit" type="number" class="form-control" name="pet_hotel_provider_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Description<sup
                                    class="text-danger">*</sup></label>
                            <input id="pet-hotel-provider-description-edit" type="text" class="form-control" name="pet_hotel_provider_description"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Pet Hotel Provider Photo<sup
                                    class="text-danger">*</sup></label>
                            <div class="custom-file">
                                <input accept="image/*" class="form-control-file"
                                    name="pet_hotel_provider_image" type="file">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-tambah-provider" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Tambah Pet Hotel Provider</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form action="{{ route('pet-hotel-provider.store') }}" method="POST" id=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <div class="form-group">
                                <select required class="js-example-basic-single" onchange="select_username();"
                                    id="filter-username" name="username" style="width:100%">
                                    <option value="">--Pilih--</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Merchant Name<sup class="text-danger">*</sup></label>
                            <input id="merchant-name-tambah" type="text" class="form-control" name="merchant_name"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Name<sup
                                    class="text-danger">*</sup></label>
                            <input id="" type="text" class="form-control" name="pet_hotel_provider_name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Address<sup
                                    class="text-danger">*</sup></label>
                            <input id="" type="text" class="form-control" name="pet_hotel_provider_address" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Phone<sup
                                    class="text-danger">*</sup></label>
                            <input id="" type="number" class="form-control" name="pet_hotel_provider_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pet Hotel Provider Description<sup
                                    class="text-danger">*</sup></label>
                            <input id="" type="text" class="form-control" name="pet_hotel_provider_description"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Pet Hotel Provider Photo<sup
                                    class="text-danger">*</sup></label>
                            <div class="custom-file">
                                <input required accept="image/*" class="form-control-file"
                                    name="pet_hotel_provider_image" type="file">
                            </div>
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
        $(document).on('click', '.btn-show-picture', function(event) {

            var username = $(this).data('username');
            var link = $(this).data('link');

            $('#username-picture').html(username);
            $('#img-modal').attr('src', link);
            console.log(username, $('#img-modal'))
        });
        let table = $('#tableMerchant').DataTable({
            order: [
                [9, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pet-hotel-provider.get-pet-hotel-provider') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'username',
            }, {
                data: 'merchant_name',
                searchable: false
            }, {
                data: 'name',
            }, {
                data: 'address',
                searchable: false
            }, {
                data: 'phone',
                searchable: false
            }, {
                data: 'photo',
                searchable: false
            }, {
                data: 'description',
                searchable: false
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

        table.columns.adjust().draw();

        $(document).on('click', '.btn-edit-pet-hotel-provider', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var username = $(this).data('username');
            var merchantname = $(this).data('merchantname');
            var hoteltname = $(this).data('hotelname');
            var address = $(this).data('address');
            var phone = $(this).data('phone');
            var description = $(this).data('description');
            var link = $(this).data('link');

            console.log(username, hoteltname, link)
            $('#username-edit').val(username);
            $('#form-edit-pet-hotel-provider').attr('action', link);
            $('#merchant-name-edit').val(merchantname);
            $('#pet-hotel-provider-name-edit').val(hoteltname);
            $('#pet-hotel-provider-phone-edit').val(phone);
            $('#pet-hotel-provider-address-edit').val(address);
            $('#pet-hotel-provider-description-edit').val(description);
        });

        function select_username(params) {
            let user_id = $('#filter-username').val();
            console.log(user_id)
            $.ajax({
                url: "{{ route('pet-hotel-provider.get-merchant-for-hotel-provider') }}",
                type: "GET",
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    if (response) {
                        $('#merchant-name-tambah').val(response.data);
                    }
                },
            });
        }
    </script>
</x-app-layout>

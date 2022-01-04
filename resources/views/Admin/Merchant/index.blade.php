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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="page-header">
                <h3 class="page-title"> Daftar Merchant </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="#">Merchant</a></li> --}}
                        {{-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> --}}
                    </ol>
                </nav>
            </div>
            <div>
                <a data-toggle="modal" data-target="#modal-tambah-merchant" class="btn btn-primary mb-2">Tambah
                    Merchant</a>
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

    <div id="modal-edit-merchant" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Edit merchant</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form method="POST" id="form-edit-merchant" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="username-edit" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Merchant<sup class="text-danger">*</sup></label>
                            <input id="merchant-name-edit" type="text" class="form-control" name="merchant_name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Foto Merchant</label>
                            <div class="custom-file">
                                <input accept="image/*" class="form-control-file" name="merchant_image" type="file">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-tambah-merchant" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Tambah merchant</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form action="{{ route('merchant.store') }}" method="POST" id="form-edit-merchant"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username<sup class="text-danger">*</sup></label>
                            <div class="form-group">
                                <select class="js-example-basic-single" name="username" required style="width:100%">
                                    <option value="">--Pilih--</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Merchant<sup class="text-danger">*</sup></label>
                            <input id="merchant-name-edit" type="text" class="form-control" name="merchant_name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Foto Merchant</label>
                            <div class="custom-file">
                                <input required accept="image/*" class="form-control-file" name="merchant_image" type="file">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let table = $('#tableMerchant').DataTable({
            order: [
                [4, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('merchant.get-merchant') }}",
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

        $(document).on('click', '.btn-edit-merchant', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var username = $(this).data('username');
            var name = $(this).data('name');
            var link = $(this).data('link');

            console.log(username, name, link)
            $('#username-edit').val(username);
            $('#form-edit-merchant').attr('action', link);
            $('#merchant-name-edit').val(name);
        });
    </script>
</x-app-layout>

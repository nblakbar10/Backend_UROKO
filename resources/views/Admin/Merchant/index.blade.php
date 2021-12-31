<x-app-layout title="Merchant">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Daftar Merchant </h3>
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
                            <div class="table">
                                <table class="table nowrap table-bordered" id="tableMerchant" style="width: 100%">
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
                className: 'dt-body-nowrap',
                data: 'name',
            }, {
                data: 'merchant_name',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                data: 'created_at',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                data: 'updated_at',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                data: 'action',
                searchable: false
            }],
        });

        table.columns.adjust().draw();
    </script>
</x-app-layout>

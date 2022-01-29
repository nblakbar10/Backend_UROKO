<x-app-layout title="Pet Profile">
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
                    <label for="exampleInputUsername1">Pet Hotel Provider</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" onchange="filter_pet_hotel_provider()"
                            id="filter-pet-hotel-provider" name="pet_group" required style="width:100%">
                            <option value="">--Pilih--</option>
                            @foreach ($petHotelProvider as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="col form-group">
                    <label for="exampleInputUsername1">Pet Habitats</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" id="filter-habitats" name="pet_habitats" required
                            style="width:100%">
                            <option value="">--Pilih--</option>

                        </select>
                    </div>
                </div> --}}
            </div>
            <div class="page-header">
                <h3 class="page-title"> List Pet </h3>
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
                                            <th> Buyer </th>
                                            <th> Pet Hotel Provider Description </th>
                                            <th> Pet Description </th>
                                            <th> Cage </th>
                                            <th> Pet Caring Note </th>
                                            <th> Check In Date </th>
                                            <th> Check Out Date </th>
                                            <th> Total Days </th>
                                            <th> Fee Description </th>
                                            <th> Shipping Type </th>
                                            <th> Shipping Fee </th>
                                            <th> Booking Slots Status </th>
                                            <th> Amminities Description</th>
                                            <th> Amminities Extra Description</th>
                                            <th> Payment Option </th>
                                            <th> Total Price</th>
                                            <th> Order Status </th>
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
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <!-- partial -->
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
    <div id="modal-detail-pet" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Detail Pet</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form class="forms-sample">
                        <div class="text-center">
                            <img id="detail-pet-picture" alt="" class="img-thumbnail">
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Name</label>
                            <div class="col-sm-9">
                                <p id="pet-name">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Species</label>
                            <div class="col-sm-9">
                                <p id="pet-species">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Group</label>
                            <div class="col-sm-9">
                                <p id="pet-group">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Breed</label>
                            <div class="col-sm-9">
                                <p id="pet-breed">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Morph</label>
                            <div class="col-sm-9">
                                <p id="pet-morph">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Birthdate</label>
                            <div class="col-sm-9">
                                <p id="pet-birthdate">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Gender</label>
                            <div class="col-sm-9">
                                <p id="pet-gender">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Age</label>
                            <div class="col-sm-9">
                                <p id="pet-age">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Description</label>
                            <div class="col-sm-9">
                                <p id="pet-description">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Status</label>
                            <div class="col-sm-9">
                                <p id="pet-status">Kucing</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-detail-fee" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Detail Fee</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form class="forms-sample">

                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet Type</label>
                            <div class="col-sm-9">
                                <p id="fee-pettype">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Pet
                                Size</label>
                            <div class="col-sm-9">
                                <p id="fee-petsize">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Slot
                                Available</label>
                            <div class="col-sm-9">
                                <p id="fee-slotavailable">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Price Per
                                Day</label>
                            <div class="col-sm-9">
                                <p id="fee-priceperday">Kucing</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-detail-amminities" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Detail Amminities</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form class="forms-sample">

                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Food</label>
                            <div class="col-sm-9">
                                <p id="amminities-food">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Basking</label>
                            <div class="col-sm-9">
                                <p id="amminities-basking">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Cleaning</label>
                            <div class="col-sm-9">
                                <p id="amminities-cleaning">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Bedding</label>
                            <div class="col-sm-9">
                                <p id="amminities-bedding">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Grooming</label>
                            <div class="col-sm-9">
                                <p id="amminities-grooming">Kucing</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-detail-amminities-extra" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Detail Amminities Extra</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form class="forms-sample">

                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Name</label>
                            <div class="col-sm-9">
                                <p id="amminities-extra-extraamminitiesname">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Amminities
                                Price Per Day</label>
                            <div class="col-sm-9">
                                <p id="amminities-extra-extraamminitiespriceperday">Kucing</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-detail-hotel" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Detail Hotel</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form class="forms-sample">
                        <div class="text-center">
                            <img id="detail-hotel-picture" alt="" class="img-thumbnail">
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Hotel
                                Name</label>
                            <div class="col-sm-9">
                                <p id="hotel-name">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Hotel
                                Address</label>
                            <div class="col-sm-9">
                                <p id="hotel-address">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Hotel
                                Phone</label>
                            <div class="col-sm-9">
                                <p id="hotel-phone">Kucing</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label fw-bold">Hotel
                                Description</label>
                            <div class="col-sm-9">
                                <p id="hotel-description">Kucing</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let username = $('#filter-username').val();
        let AmminitiesHotelProvider = $('#filter-pet-hotel-provider').val();
        let habitats = $('#filter-habitats').val();

        let table = $('#tableMerchant').DataTable({
            order: [
                [13, "desc"]
            ],
            scrollX: "100%",
            processing: true,
            serverSide: true,
            width: "100%",
            ajax: {
                url: "{{ route('pet-hotel-order.get-pet-hotel-order') }}",
                data: function(d) {
                    d.username = username;
                    d.petHotelProvider = petHotelProvider;
                    // d.habitats = habitats;
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
                data: 'hotel_provider_desc',
            }, {
                data: 'cage',
                searchable: false
            }, {
                data: 'pet_caring_note',
                searchable: false
            }, {
                data: 'check_in_date',
                searchable: false
            }, {
                data: 'check_out_date',
                searchable: false
            }, {
                data: 'pet_birthdate',
                searchable: false
            }, {
                data: 'total_days',
                searchable: false
            }, {
                data: 'fee_desc',
                searchable: false
            }, {
                data: 'shipping_type',
                searchable: false
            }, {
                data: 'shipping_fee',
                searchable: false
            }, {
                data: 'status',
                searchable: false
            }, {
                data: 'aminities_desc',
                searchable: false
            }, {
                data: 'aminities_extra_desc',
                searchable: false
            }, {
                data: 'payments_type',
                searchable: false
            }, {
                data: 'pethotel_total_price',
                searchable: false
            }, {
                data: 'pethotel_order_status',
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
            table.ajax.reload(null, false);
        }

        function filter_pet_hotel_provider(params) {
            group = $('#filter-pet-hotel-provider').val();
            table.ajax.reload(null, false);
        }


        $(document).on('click', '.btn-detail-pet', function(event) {
            var petpicture = $(this).data('petpicture');
            var petname = $(this).data('petname');
            var petgender = $(this).data('petgender');
            var petbreed = $(this).data('petbreed');
            var petmorph = $(this).data('petmorph');
            var petbirthdate = $(this).data('petbirthdate');
            var petdescription = $(this).data('petdescription');
            var petage = $(this).data('petage');
            var petstatus = $(this).data('petstatus');
            var petspecies = $(this).data('petspecies');

            $('#pet-name').html(petname);
            $('#pet-species').html(petspecies);
            $('#pet-breed').html(petbreed);
            $('#pet-morph').html(petmorph);
            $('#pet-gender').html(petgender);
            $('#pet-birthdate').html(petbirthdate);
            $('#pet-description').html(petdescription);
            $('#pet-age').html(petage);
            $('#pet-status').html(petstatus);
            $('#detail-pet-picture').attr('src', petpicture);
        });

        $(document).on('click', '.btn-detail-hotel', function(event) {
            var hotelphoto = $(this).data('hotelphoto');
            var name = $(this).data('name');
            var address = $(this).data('address');
            var phone = $(this).data('phone');
            var description = $(this).data('description');

            $('#hotel-name').html(name);
            $('#hotel-address').html(address);
            $('#hotel-phone').html(phone);
            $('#hotel-description').html(description);
            $('#detail-hotel-picture').attr('src', hotelphoto);
        });

        $(document).on('click', '.btn-detail-fee', function(event) {

            var pettype = $(this).data('pettype');
            var petsize = $(this).data('petsize');
            var slotavailable = $(this).data('slotavailable');
            var priceperday = $(this).data('priceperday');

            $('#fee-pettype').html(pettype);
            $('#fee-petsize').html(petsize);
            $('#fee-slotavailable').html(slotavailable);
            $('#fee-priceperday').html(priceperday);
        });

        $(document).on('click', '.btn-detail-amminities', function(event) {

            var food = $(this).data('food');
            var basking = $(this).data('basking');
            var cleaning = $(this).data('cleaning');
            var bedding = $(this).data('bedding');
            var grooming = $(this).data('grooming');

            $('#amminities-food').html(food);
            $('#amminities-basking').html(basking);
            $('#amminities-cleaning').html(cleaning);
            $('#amminities-bedding').html(bedding);
            $('#amminities-grooming').html(grooming);
        });

        $(document).on('click', '.btn-detail-amminities-extra', function(event) {

            var extraamminitiesname = $(this).data('extraamminitiesname');
            var extraamminitiespriceperday = $(this).data('extraamminitiespriceperday');

            $('#amminities-extra-extraamminitiesname').html(extraamminitiesname);
            $('#amminities-extra-extraamminitiespriceperday').html(extraamminitiespriceperday);
        });
    </script>
</x-app-layout>

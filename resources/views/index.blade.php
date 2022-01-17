<x-app-layout title="Dashboard">
    <div id="modal-tambah-user" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="card-title" style="">Add Admin</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form action="{{ route('admin.store') }}" method="POST" id="form-tambah-user"
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
            <div class="row">
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $user }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success ">
                                        <span class="mdi mdi-nature-people icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Users</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $merchant }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-warning">
                                        <span class="mdi mdi-home-variant icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Merchants</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $pet_profile }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-danger">
                                        <span class="mdi mdi-cat icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Pets</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $transaksi }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success ">
                                        <span class="mdi mdi-history icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">All Transactions</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Transaction History</h4>
                            <canvas id="transaction-history" class="transaction-chart"></canvas>
                            <div
                                class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h6 class="mb-1">Transfer to Paypal</h6>
                                    <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                </div>
                                <div
                                    class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                    <h6 class="font-weight-bold mb-0">$236</h6>
                                </div>
                            </div>
                            <div
                                class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h6 class="mb-1">Tranfer to Stripe</h6>
                                    <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                </div>
                                <div
                                    class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                    <h6 class="font-weight-bold mb-0">$593</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title mb-1">Open Projects</h4>
                                <p class="text-muted mb-1">Your data status</p>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-primary">
                                                    <i class="mdi mdi-file-document"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Admin dashboard design</h6>
                                                    <p class="text-muted mb-0">Broadcast web app mockup</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <p class="text-muted">15 minutes ago</p>
                                                    <p class="text-muted mb-0">30 tasks, 5 issues </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-success">
                                                    <i class="mdi mdi-cloud-download"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Wordpress Development</h6>
                                                    <p class="text-muted mb-0">Upload new design</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <p class="text-muted">1 hour ago</p>
                                                    <p class="text-muted mb-0">23 tasks, 5 issues </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-info">
                                                    <i class="mdi mdi-clock"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Project meeting</h6>
                                                    <p class="text-muted mb-0">New project discussion</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <p class="text-muted">35 minutes ago</p>
                                                    <p class="text-muted mb-0">15 tasks, 2 issues</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-danger">
                                                    <i class="mdi mdi-email-open"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">Broadcast Mail</h6>
                                                    <p class="text-muted mb-0">Sent release details to team</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <p class="text-muted">55 minutes ago</p>
                                                    <p class="text-muted mb-0">35 tasks, 7 issues </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-item">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-warning">
                                                    <i class="mdi mdi-chart-pie"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                                <div class="flex-grow">
                                                    <h6 class="preview-subject">UI Design</h6>
                                                    <p class="text-muted mb-0">New application planning</p>
                                                </div>
                                                <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                    <p class="text-muted">50 minutes ago</p>
                                                    <p class="text-muted mb-0">27 tasks, 4 issues </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5>Adoption Order</h5>
                            <div class="row">
                                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                    <div class="d-flex d-sm-block d-md-flex align-items-center mt-3">
                                        <h3 class="mb-0">Rp. {{ $nominalAdoptionOrder }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5>Auction Order</h5>
                            <div class="row">
                                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                    <div class="d-flex d-sm-block d-md-flex align-items-center mt-3">
                                        <h3 class="mb-0">Rp. {{ $nominalAuctionOrder }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5>Purchase</h5>
                            <div class="row">
                                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                    <div class="d-flex d-sm-block d-md-flex align-items-center mt-3">
                                        <h3 class="mb-0">Rp. {{ $nominalRentOrder }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Last Order Status</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> User </th>
                                            <th> Pet </th>
                                            <th> Order Type </th>
                                            <th> Total Order </th>
                                            <th> Payment Option </th>
                                            <th> Order Date </th>
                                            <th> Payment Status </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allTransaction as $item)
                                            <tr>
                                                <td>

                                                    <img src="{{ asset('storage/gambar-user/' . $item->picture) }}"
                                                        alt="image" class="rounded-circle" />
                                                    <span class="pl-2">{{ $item->username }}</span>
                                                </td>
                                                <td> {{ $item->pet_name }} </td>
                                                <td>
                                                    @if ($item->adoption_item_id)
                                                        Adoption Order
                                                    @endif
                                                    @if ($item->auction_item_id)
                                                        Auction Order
                                                    @endif
                                                    @if ($item->rent_item_id)
                                                        Rent Order
                                                    @endif
                                                </td>
                                                <td> {{ $item->grand_total_order }} </td>
                                                <td> {{ $item->payments_option }} </td>
                                                <td> {{ $item->created_at }} </td>
                                                <td>
                                                    @if ($item->adoption_item_id)
                                                        @if ($item->adoption_order_status == 'Approved')
                                                            <div class="badge badge-outline-success">Approved</div>
                                                        @endif
                                                        @if ($item->adoption_order_status == 'Waiting')
                                                            <div class="badge badge-outline-warning">Waiting</div>
                                                        @endif
                                                        @if ($item->adoption_order_status == 'Rejected')
                                                            <div class="badge badge-outline-danger">Rejected</div>
                                                        @endif
                                                    @endif
                                                    @if ($item->auction_item_id)
                                                        @if ($item->auction_order_status == 'Approved')
                                                            <div class="badge badge-outline-success">Approved</div>
                                                        @endif
                                                        @if ($item->auction_order_status == 'Waiting')
                                                            <div class="badge badge-outline-warning">Waiting</div>
                                                        @endif
                                                        @if ($item->auction_order_status == 'Rejected')
                                                            <div class="badge badge-outline-danger">Rejected</div>
                                                        @endif
                                                    @endif
                                                    @if ($item->rent_item_id)
                                                        @if ($item->rent_order_status == 'Approved')
                                                            <div class="badge badge-outline-success">Approved</div>
                                                        @endif
                                                        @if ($item->rent_order_status == 'Waiting')
                                                            <div class="badge badge-outline-warning">Waiting</div>
                                                        @endif
                                                        @if ($item->rent_order_status == 'Rejected')
                                                            <div class="badge badge-outline-danger">Rejected</div>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title">Activity User With Pet</h4>
                                <a href="/all-activity" class="text-muted mb-1 small">View all</a>
                            </div>
                            <div class="preview-list">
                                @foreach ($smallActivity as $item)
                                    <div class="preview-item border-bottom">
                                        <div class="preview-thumbnail">
                                            <img src="{{ asset('storage/gambar-user/' . $item->picture) }}"
                                                alt="image" class="rounded-circle" />
                                        </div>
                                        <div class="preview-item-content d-flex flex-grow">
                                            <div class="flex-grow">
                                                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                    <h6 class="preview-subject">{{ $item->username }}</h6>
                                                </div>
                                                <p class="text-muted">{{ $item->pet_name }}
                                                    {{ $item->pet_activity_detail }} pada tanggal
                                                    {{ $item->pet_activity_date }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Portfolio Slide</h4>
                            <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel"
                                id="owl-carousel-basic">
                                <div class="item">
                                    <img src="{{ asset('template') }}/assets/images/dashboard/Rectangle.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset('template') }}/assets/images/dashboard/Img_5.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img src="{{ asset('template') }}/assets/images/dashboard/img_6.jpg" alt="">
                                </div>
                            </div>
                            <div class="d-flex py-4">
                                <div class="preview-list w-100">
                                    <div class="preview-item p-0">
                                        <div class="preview-thumbnail">
                                            <img src="{{ asset('template') }}/assets/images/faces/face12.jpg"
                                                class="rounded-circle" alt="">
                                        </div>
                                        <div class="preview-item-content d-flex flex-grow">
                                            <div class="flex-grow">
                                                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                    <h6 class="preview-subject">CeeCee Bass</h6>
                                                    <p class="text-muted text-small">4 Hours Ago</p>
                                                </div>
                                                <p class="text-muted">Well, it seems to be working now.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">Well, it seems to be working now. </p>
                            <div class="progress progress-md portfolio-progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">To do list</h4>
                            <div class="add-items d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="enter task..">
                                <button class="add btn btn-primary todo-list-add-btn">Add</button>
                            </div>
                            <div class="list-wrapper">
                                <ul class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Create invoice </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Meeting with Alita
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked> Prepare for
                                                presentation </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Plan weekend outing
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                    <li>
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Pick up kids from school
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-box"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Visitors by Countries</h4>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-us"></i>
                                                    </td>
                                                    <td>USA</td>
                                                    <td class="text-right"> 1500 </td>
                                                    <td class="text-right font-weight-medium"> 56.35% </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-de"></i>
                                                    </td>
                                                    <td>Germany</td>
                                                    <td class="text-right"> 800 </td>
                                                    <td class="text-right font-weight-medium"> 33.25% </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-au"></i>
                                                    </td>
                                                    <td>Australia</td>
                                                    <td class="text-right"> 760 </td>
                                                    <td class="text-right font-weight-medium"> 15.45% </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-gb"></i>
                                                    </td>
                                                    <td>United Kingdom</td>
                                                    <td class="text-right"> 450 </td>
                                                    <td class="text-right font-weight-medium"> 25.00% </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-ro"></i>
                                                    </td>
                                                    <td>Romania</td>
                                                    <td class="text-right"> 620 </td>
                                                    <td class="text-right font-weight-medium"> 10.25% </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="flag-icon flag-icon-br"></i>
                                                    </td>
                                                    <td>Brasil</td>
                                                    <td class="text-right"> 230 </td>
                                                    <td class="text-right font-weight-medium"> 75.00% </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div id="audience-map" class="vector-map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->

</x-app-layout>

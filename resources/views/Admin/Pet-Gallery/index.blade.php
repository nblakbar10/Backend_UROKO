<x-app-layout title="Pet Gallery">
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
                                @if ($item->id == $user_id)
                                    <option selected value="{{ $item->id }}">{{ $item->username }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col">
                    <label for="exampleInputUsername1">Album</label>
                    <div class="form-group">
                        <select class="js-example-basic-single" onchange="filter_album()" id="filter-album"
                            name="pet_album" required style="width:100%">
                            <option value="">--Pilih--</option>
                            @if ($all_album)
                                @foreach ($all_album as $item)
                                    @if ($item->id == $album_id)
                                        <option selected value="{{ $item->id }}">{{ $item->album_name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->album_name }}</option>
                                    @endif
                                @endforeach
                            @endif
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
                <h3 class="page-title"> Gallery </h3>
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
                                @foreach ($petActivity as $item)
                                    <a href="{{ asset('storage/gambar-activity/' . $item->pet_activity_image) }}"
                                        class="mt-4 mybox" title="{{ $item->pet_name }}"
                                        data-lcl-txt="{{ $item->pet_activity_detail }}">
                                        <img class="img-design rounded shadow"
                                            src="{{ asset('storage/gambar-activity/' . $item->pet_activity_image) }}"
                                            width="300" alt="">
                                    </a>
                                @endforeach
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
        let username = $('#filter-username').val();
        let album = $('#filter-album').val();



        function filter_username(params) {
            $("#filter-album").find('option').not(':first').remove();
            username = $('#filter-username').val();
            window.location.search = '?user=' + username;
        }

        function filter_album(params) {
            album = $('#filter-album').val();
            window.location.search = '?user=' + username + '&album=' + album;
        }
    </script>
</x-app-layout>

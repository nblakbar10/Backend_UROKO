<x-app-layout title="All Activity">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title">Activity User With Pet</h4>
                            </div>
                            <div class="preview-list">
                                @foreach ($allActivity as $item)
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
                            {{ $allActivity->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->

</x-app-layout>

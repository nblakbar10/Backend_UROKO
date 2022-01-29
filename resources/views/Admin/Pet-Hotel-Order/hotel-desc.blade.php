<div class="text-center">
    <a
    data-hotelphoto="{{asset('storage/gambar-hotel/' . $model->photo)}}"
    data-name="{{$model->name}}"
    data-address="{{$model->address}}"
    data-phone="{{$model->phone}}"
    data-description="{{$model->description}}"
    data-toggle="modal" 
    data-target="#modal-detail-hotel"
    class="btn btn-detail-hotel mdi mdi-dots-horizontal text-primary fs-4"></a>
</div>
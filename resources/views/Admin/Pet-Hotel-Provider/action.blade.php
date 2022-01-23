<div class="d-flex justify-content-center">
    <div class="">
        <a
        data-link="{{route('pet-hotel-provider.update', $model->id)}}" 
        data-username="{{$model->username}}"
        data-merchantname="{{$model->merchant_name}}"
        data-hotelname="{{$model->name}}"
        data-address="{{$model->address}}"
        data-phone="{{$model->phone}}"
        data-description="{{$model->description}}"
        data-toggle="modal" 
        data-target="#modal-edit-pet-hotel-provider"
        class="btn btn-edit-pet-hotel-provider mdi mdi-pencil-box-outline text-warning fs-4"></a>
    </div>
    <div class="">
        <form action="{{ route('pet-hotel-provider.destroy', $model->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="border-radius: 2rem" type="submit" class="btn mdi mdi-delete-forever text-danger fs-4"
                onclick="return confirm('Apakah anda yakin untuk menghapus pet hotel provider ini ?');"></button>
        </form>
    </div>
</div>
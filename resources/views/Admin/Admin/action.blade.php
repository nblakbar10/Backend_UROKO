<div class="d-flex justify-content-center">
    <div class="">
        <a
        data-link="{{route('user.update', $model->id)}}" 
        data-fullname="{{$model->fullname}}"
        data-username="{{$model->username}}"
        data-email="{{$model->email}}"
        data-phonenumber="{{$model->phone_number}}"
        data-birthdate="{{$model->birthdate}}"
        data-address="{{$model->address}}"
        data-toggle="modal" 
        data-target="#modal-edit-user"
        class="btn btn-edit-admin mdi mdi-pencil-box-outline text-warning fs-4"></a>
    </div>
    <div class="">
        <form action="{{ route('user.destroy', $model->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="border-radius: 2rem" type="submit" class="btn mdi mdi-delete-forever text-danger fs-4"
                onclick="return confirm('Apakah anda yakin untuk menghapus admin ini ?');"></button>
        </form>
    </div>
</div>
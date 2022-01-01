<div class="d-flex justify-content-center">
    <div class="">
        <a
        data-link="{{route('merchant.update', $model->id)}}" 
        data-username="{{$model->name}}"
        data-name="{{$model->merchant_name}}"
        data-toggle="modal" 
        data-target="#modal-edit-merchant"
        class="btn btn-edit-merchant mdi mdi-pencil-box-outline text-warning fs-4"></a>
    </div>
    <div class="">
        <form action="{{ route('merchant.destroy', $model->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="border-radius: 2rem" type="submit" class="btn mdi mdi-delete-forever text-danger fs-4"
                onclick="return confirm('Apakah anda yakin untuk menghapus merchant ini ?');"></button>
        </form>
    </div>
</div>
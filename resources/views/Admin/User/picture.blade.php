<div class="text-center">
    <a
    data-username="{{$model->username}}"
    data-link="{{ asset('storage/gambar-user/' . $model->picture) }}"
    data-toggle="modal" 
    data-target="#modal-show-picture"
    class="btn btn-show-picture mdi mdi-eye text-warning fs-4"></a>
</div>
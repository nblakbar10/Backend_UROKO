<div class="text-center">
    <a
    data-petpicture="{{asset('storage/gambar-pet/' . $model->pet_picture)}}"
    data-petname="{{$model->pet_name}}"
    data-petage="{{$model->pet_age}}"
    data-petspecies="{{$model->pet_species}}"
    data-petbreed="{{$model->pet_breed}}"
    data-petgender="{{$model->pet_gender}}"
    data-petdescription="{{$model->pet_description}}"
    data-petbirthdate="{{$model->pet_birthdate}}"
    data-petstatus="{{$model->pet_status}}"
    data-toggle="modal" 
    data-target="#modal-detail-pet"
    class="btn btn-detail-pet mdi mdi-dots-horizontal text-primary fs-4"></a>
</div>
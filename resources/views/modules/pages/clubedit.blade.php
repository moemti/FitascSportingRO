@extends('frame.masterdetail')

@section('masterdetail')


    <script type="text/javascript" src="{{asset('js/pages/clubedit.js')}}"> </script>           

@endsection




@push('detail')
    <input id="TeamId" name= "TeamId" hidden>
    <div class="form-row">
        <div class="col-md-10">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" required></div>
        </div>

        <div class="col-md-2">
             <label for="IsActive">Activ</label><input name="IsActive" id="IsActive"  type="checkbox"  class="form-check-input" >
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="Description">Description</label><input name="Description" id="Description" class="form-control" ></div>
        </div>
    </div>
@endpush


@push('afterdetailform')
    @if (session("IsSuperUser") == 1)

    <div class="form-row">
        <div class="col-12 col-md-6">
            <form id="echivalareclub" action=""  class="position-relative form-group  ">
                @csrf
                <label class= "" for="OldPersonId">Alege clubul care va fi sters si echivalat cu clubul curent</label>
                
                <select name="OldTeamId" id="OldTeamId"  type="text" class="form-control" required >
                <option value=""></option>
                    @foreach($masterlist as $r)
                        <option value="{{$r->TeamId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
            
                <div class="text-left ">
                    <button type="submit" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-danger btn-lg">{{transex('Echivaleaza')}}</button>
            
                </div>
            </form>
        </div>
    </div>
    @endif

@endpush
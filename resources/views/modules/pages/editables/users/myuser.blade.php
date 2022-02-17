@extends('frame.master')

@push('title')
    {{$data[0]->Name}}
@endpush

@push('subtitle')

    Modificare utilizator
    
@endpush


@push('masterscripts')
    <script type="text/javascript" src={{asset('js/pages/myuser.js')}}></script>
@endpush


@push('formcontent')


    @if(session("IsSuperUser") == 1)
        <div class="  text-right u-margin-top-small">
            <a href="{{Route('registeries')}}" class=" btn-sm">Registeries</a>
        </div>
    @endif

<div class="row">
    
    <input name="PersonId" id="PersonId" hidden>


    <div class="position-relative form-group">
         <label class= "form-label">Email</label>
        <input name="Email" id="Email" placeholder="Email here..." type="email" class="form-control real_input" required>
    </div>


    <div class="position-relative form-group">
    <label class= "form-label">Nume intreg</label>
        <input name="Name" id="Name" placeholder="Name here..." type="text" class="form-control real_input" required>
    </div>

    

    <div class="position-relative form-group">
        <label class= "form-label">Nume</label>
        <input name="NickName" id="NickName" class="form-control real_input" >
    </div>



    <div class="position-relative form-group">
        <label class= "form-label">Roluri</label>
        <input name="Role" id="Role" class="form-control real_input" disabled>
    </div>


</div>
     
@endpush

@push('content_after')

    <form id="changemypassword" action="" class="passwordchange">
    <div class="row">
       
        <div class="col-md-12">
            <div class="position-relative form-group"><input name="password" id="Password" placeholder="Password here..." type="password" class="form-control real_input" required></div>
        </div>
        <div class="col-md-12">
            <div class="position-relative form-group"><input name="password2" id="Password2" placeholder="Repeat Password here..." type="password" class="form-control real_input" required></div>
        </div>

    </div>
        <div class="  text-right u-margin-top-medium">
            <button type="submit" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Modifica parola</button>
    
        </div>

    </form>

@endpush
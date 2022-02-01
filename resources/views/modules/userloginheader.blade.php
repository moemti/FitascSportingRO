


@if (session("PersonId") > 0)
    <a href="{{Route('logout')}}" class="">
        <span title="Logout" class='loginheader_container__icon fi fi-rr-user-delete' ></span>
    </a>

@else
    <a href="{{Route('login')}}" class="">
        <span title="Login" class='loginheader_container__icon fi fi-rr-user' ></span>
    </a>



@endif  
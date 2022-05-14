

@extends('layouts.admin')



@push('include_content')
	


    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">

                <div class="page-title-heading">
                    <span>C{{transex('hange my password')}}</span></h4>
                </div>


  
            </div>
        </div>
    

        <div class="card-body">

            <div class="main-card mb-2 card" id = "maincard">

                <div class="mb-3 card p-3" >
                    <form class="" action="changemypassword" method="POST">
                        @csrf

                        <div class="form-row">
                            
                            <div class="col-md-4">
                                <div class="position-relative form-group"><input name="password" id="password" placeholder="Password here..." type="password" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="form-row">    
                            <div class="col-md-4">
                                <div class="position-relative form-group"><input name="password2" id="password2" placeholder="Repeat Password here..." type="password" class="form-control" required></div>
                            </div>
                        </div>

                        @if (isset($mesaj) && array_key_exists('mesaj',$mesaj))
                        <div class="col-md-12">
                            <span class="text-danger">
                                <strong>{{ $mesaj['mesaj'] }}</strong>
                            </span>
                            </div>
                        @endif



                        <div class="divider row"></div>

                        <div class="d-flex align-items-center">
                            <div class="ml-left"><!--a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a-->
                                <button class="btn btn-primary btn-lg">{{transex('Change the password')}}</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        

        </div>

    </div>


    @endpush('include_content')
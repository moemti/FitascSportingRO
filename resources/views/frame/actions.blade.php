

            @stack('beforeactions')

            @foreach($actions as $a) 
            

                <li id = "action_{{$a->Code}}" class="nav-item">
                    <a class="nav-link" onclick="DoAction('{{$a->Code}}', {{isset($a->NextDocumentTypeId)?$a->NextDocumentTypeId:'null'}}, {{$a->FinalDocumentStateId}})">
                        <i class="fa fa-angle-right"></i>&nbsp
                        <span>
                             {{trans($a->Name)}}
                        </span>
                    </a>
                </li>

                
	  		@endforeach   
	  		
            @stack('afteractions')  
	  		
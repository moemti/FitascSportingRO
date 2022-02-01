
@if (isset($CustomFilters) && count($CustomFilters) > 0)

<div class="d-inline-block dropdown justlist" >
    <button id="basicfilter" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
            class="btn-shadow dropdown-toggle btn btn-info">
        <span class="btn-icon-wrapper pr-2 opacity-7">
            <i class="fa fa-filter fa-w-20"></i>
        </span>
        {{trans('general.filters')}}
    </button>   


    <div id="filtermenu" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
        <ul class="nav flex-column">
        
            @foreach($CustomFilters as $index => $f)
            
                @php $input = '' @endphp

                <li class="nav-item">
                        @if (isset($f['HTML']))
                            @if ($f['HTML'] == 'input')
                            @php $input = 'cfilter_'.$index @endphp
                            <div class='ml-2'>
                                <input id="cfilter_{{$index}}" onkeyup=" if(event.keyCode == 13)  RefreshMasterWarning('{{$f['Filter']}}', '{{$f['Warning']}}', '{{$input}}', '{{$f['Caption']}}')"/>
                            </div>
                           
                            @endif
                            @if ($f['HTML'] == 'select')
                            @php $input = 'cfilter_'.$index @endphp
                            <div class='ml-2'>
                                <select id="cfilter_{{$index}}" onkeyup=" if(event.keyCode == 13)  RefreshMasterWarning('{{$f['Filter']}}', '{{$f['Warning']}}', '{{$input}}, '{{$f['Caption']}}')"/>
                                @if (isset($f['options']))

                                    @php 
                                        $val = $f['optionfields'][0];
                                        $caption = $f['optionfields'][1];

                                    @endphp

                                   
                                    @foreach($f['options'] as $o)
 
                                        <option value='{{$o->$val}}'> {{$o->$caption}}</option>
                                    @endforeach
                                @endif
                                
                                </select>
                            </div>
                           
                            @endif
                        @endif

                        <a class="nav-link" onclick="RefreshMasterWarning('{{$f['Filter']}}', '{{$f['Warning']}}', '{{$input}}', '{{$f['Caption']}}')">
                        <i class="nav-link-icon lnr-pencil"></i>

                        <span>
                                {{trans($f['Caption'])}}
                        </span>
                        


                        <div class="ml-auto badge badge-pill badge-info" id="filter-draft">{{$f['Label']}}</div>
                    </a>
                </li>

            @endforeach
            
            
        </ul>
    </div>
</div>

@endif

		<!-- Body footer -->
    	<div id="message">
                    @include('frame.errors')
                    @include('frame.success')
            
        </div>
        
        @include('frame.message')
        @include('frame.confirm')
        @include('frame.popupedit')

        @if (!isset($DeniedPermissions) || !in_array("Delete", $DeniedPermissions))
                   
        @include('frame.confirmsave')

        @endif
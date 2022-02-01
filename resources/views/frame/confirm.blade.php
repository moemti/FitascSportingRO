<div id="confirmdialog" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog"   >
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading" >
                Mesaj
            </div>
    
            <div class="modal-body" id='confirmdialog_body' >
            <span id="confirmdialog_message"></span>
            
            </div>
            
            <div class="modal-footer">
            
            <div id="confirminputdiv">
            		<label for="confirminput">Comment</label>
            		<input id="confirminput" val="">
            </div>
                
            <input id="btnConfirmCloseModal" type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{trans("general.No")}}>
            <input id="btnConfirmOKModal" type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{trans("general.Yes")}}>
            </div>
            
        </div>
    </div>
</div>


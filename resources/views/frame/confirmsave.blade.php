<div id="confirmsavedialog" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog"   >
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading" >
                Mesaj
            </div>
    
            <div class="modal-body" id='confirmdialog_body' >
            <span id="confirmsavedialog_message"></span>
            
            </div>
            
            <div class="modal-footer">
            
            <div id="confirmsaveinputdiv">
            		<label for="confirmsaveinput">Comment</label>
            		<input id="confirmsaveinput" val="">
            </div>
                
            <input id="btnConfirmSaveStayModal" type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{trans("general.Stay")}}>
            <input id="btnConfirmSaveCancelModal" type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{trans("general.Cancel")}}>
            <input id="btnConfirmSaveSaveModal" type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{trans("general.Save")}}>    
        </div>
            
        </div>
    </div>
</div>


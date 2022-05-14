<div id="confirmsavedialog" class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                
            <input id="btnConfirmSaveStayModal" type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{transex("Stay")}}>
            <input id="btnConfirmSaveCancelModal" type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{transex("Cancel")}}>
            <input id="btnConfirmSaveSaveModal" type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn btn-primary" value={{transex("Save")}}>    
        </div>
            
        </div>
    </div>
</div>


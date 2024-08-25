<div id="editserii" class="page_content page_content_master ">
        <h2>Editare serii</h2>

        <form class="" action="changeserii" method="POST">
            @csrf
           
                <style>
                 table, th, td  {
                    border: 1px solid black; /* Add a border to all table rows */
                }
                </style>
            <div id='jqserii'></div>
             <div class="modal-footer" id="popup_footer">    
                <input id="btnRegenereazaBIB" type="button" aria-hidden="true" class="btn btn-primary btn-sm" value="Regenereaza BIB">
            </div>
          
           
        </form>
</div>
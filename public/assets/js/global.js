function showConfirmationModal(headingText, contentText, onClick) {
    if(document.getElementById('confirmationModal') !== null) {
        $('#confirmationModal').remove();
    }
    $('#modalsContainer').html('\
            <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">\
              <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <i class="fa fa-info-circle"></i>'+headingText+'\
                    </div>\
                    <div class="modal-body">\
                        '+contentText+'\
                    </div>\
                    <div class="modal-footer">\
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                        <button type="button" class="btn btn-danger" onClick="'+onClick+'">Confirm</button>\
                    </div>\
                <div>\
              </div>\
            </div>\
        ');
    return $('#confirmationModal').modal('show');
}
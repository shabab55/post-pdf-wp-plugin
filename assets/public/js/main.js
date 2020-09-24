; (function ($) {
    $(document).ready(function () {
        $(".action-button").on('click', function () {
            let task = $(this).data('task');
            window[task]();
        });
});

})(jQuery);

function ppdf_ajax_call() {
    let $ = jQuery;
    $.post(ppdfdata.ajax_url, { 'action': 'ppdf_post_details', 'data': ppdfdata.pid }, function (data) {
        //console.log(data);
        $.ajax({
            url : ppdfdata.root_utl+"generate-pdf.php" ,
            type : 'POST',
            contentType:'application/json',
            dataType:'json',
            data : JSON.stringify(data),
            success : function(res) {
                    // Successfully sent data
                  console.log(res);
            },
            error: function(err) {
                // Unable to send data
                  console.log(err);
            }
        });
    });
}
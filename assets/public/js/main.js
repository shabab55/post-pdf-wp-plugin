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
    $.post(ppdfdata.ajax_url, { 'action': 'ppdf_post_details', 'data': ppdfdata.pid }, function (response) {
        //console.log(response.data.title,response.data.content);
        
		//var targetUrl = ppdfdata.site_url+'/generate-pdf/'+'?title='+response.data.title+'&content='+response.data.content; //generate-pdf is a wp page.
        //console.log(targetUrl);
		//using for get method via url parameter 
		//window.open(targetUrl, "_blank");
        
		var targetUrl = ppdfdata.site_url+'/generate-pdf';

        $.ajax({
            url : targetUrl,
            type : 'post',
            //contentType:"application/json; charset=utf-8",
           // dataType:'json',
            //data: JSON.stringify(response),
            //async: false,
			data: {title:response.data.title,content:response.data.content},
			success : function(data) {
				window.open(targetUrl, "_blank");
              	console.log("Successfully sent data");
            },
            error: function(err) {
                // Unable to send data
                  console.log("operation failed");
            }
        });
        

    });
}
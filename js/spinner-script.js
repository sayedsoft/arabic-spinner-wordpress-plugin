jQuery(function($) {
    $(document).ready(function(){
            $('#insert-my-media').click(open_media_window);
        });

    function open_media_window() {
       if ($(".loadingspinn").length) { $(".loadingspinn").remove(); }
       $("body").append('<div class="loadingspinn"> <div class="loading-data"><div class="image-gif"><img src="'+spinnerurl+'loading.jpg"></div> <div class="loading-mode"><p>Spinner is running</p></div> <div class="loading-close"></div>  </div></div>');
       $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
            'action' :'arabic_spinner_ajax',
            'conent' : tinymce.editors.content.getContent(),
        },
        success:function(data) {
            var info    = data;
            var mode    = jQuery( data ).find( 'response_data' ).text();
            var message = jQuery( data ).find( 'supplemental message' ).text();
            if (mode == "error") {
               $(".loadingspinn").css("background","rgba(31, 1, 1, 0.77)"); 
               $(".image-gif").html("");
               $(".loading-mode").html("<p>"+message+"</p>");
               $(".loading-close").html('<a href="#">Close</a>');
               $(".loading-close a").click(function () {
                  $(".loadingspinn").hide("600");
               });
            } else {
              $(".loadingspinn").css("background","rgba(1, 45, 9, 0.77)");   
              $(".image-gif").html("");
              $(".loading-mode").html("<p>"+message+"</p>");
              $(".loading-close").html('<a href="#">Close And Join!</a>');
              var spinnedText = jQuery( data ).find( 'supplemental spinnedText' ).html();
              spinnedText = spinnedText.replace('<![CDATA[','');
              spinnedText = spinnedText.replace(']]>','');
              tinyMCE.activeEditor.setContent(spinnedText);
              $(".loading-close a").click(function () {
                  $(".loadingspinn").hide("600");
               });
            }
            //$(".loadingspinn").hide(500);
        },
        error: function(errorThrown){
            $(".loadingspinn").css("background","rgba(31, 1, 1, 0.77)");
            
        }
      });  
       
    }
});
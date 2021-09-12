(function( $ ) {
 
    "use strict";
     
    $(document).ready(function() {
        $('#deployBtn').on('click', function(){
            
            $.ajax({
                url: XBOX_JS.ajax_url,
                data: {
                    action: 'wptdp_deploy'
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('.deploy_loader').addClass('active');
                },
                success: function(response) {
                    alert(response.msg);
                    if(response.success == true){
                        $('#tabela_deploy tbody tr').remove();
                    }
                }
            }).done(function(){
                    $('.deploy_loader').removeClass('active');
            });

        });
    });
 
})(jQuery);
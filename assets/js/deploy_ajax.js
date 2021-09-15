(function( $ ) {
 
    "use strict";
     
    $(document).ready(function() {

        $('#wp-admin-bar-deployBtn a').on('click', function(){ deployList(); });
        $('#deployBtn').on('click', function(){ deployList(); });

        var deployList = function(){
            
            $.ajax({
                url: ajaxurl,
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
                        $('#wp-admin-bar-deployBtn a').text('Deploy List (0)');
                    }
                }
            }).done(function(){
                    $('.deploy_loader').removeClass('active');
            });

            return false;

        };

        $(document).on('click', '#removeTD', function() {
            var id = $(this).data('id');

            var r = confirm("Tem certeza que deseja remover?");
            if (r == true) {

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'wptdp_removePage',
                        id: id
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                    },
                    success: function(response) {
                        if(response.success == true){
                            $('#tabela_deploy tbody tr#'+id).remove();
                        } else {
                            alert(response.msg);
                        }
                    }
                }).done(function(){
                });
            }
            
        });

        $('#addCustomPage').on('click', function(){
            $('.custom_page_deploy').addClass('active');
        });

        $('.closeDep').on('click', function(){
            $('.custom_page_deploy').removeClass('active');
        });

        $(document).on('submit', '#createCustomPage', function() {

            var url = $(this).find('#url').val();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'wptdp_custompage',
                    url: url
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('.custom_page_deploy').addClass('submit');
                },
                success: function(response) {
                    if(response.success == true){
                        alert(response.msg);
                    } else {
                        $('.custom_page_deploy').removeClass('submit');
                        alert(response.msg);
                    }
                }
            }).done(function(){
                    $('.custom_page_deploy').removeClass('active');
                    location.reload();
            });

            return false;
        });

    });
 
})(jQuery);
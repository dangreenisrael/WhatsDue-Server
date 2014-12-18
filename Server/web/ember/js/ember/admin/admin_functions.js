/**
 * Created by Dan on 9/23/14.
 */

/* Extend jQuery */
(function($){
    $.expr[':'].text = function(obj, index, meta, stack){
        return ($(obj).text() === meta[3])
    };
})(jQuery);

/* End Extend jQuery */

function loadView(){
    if ($(window).height()-50 > $('.main-content').height()) {
        $('#mainFooter').css({'position': 'fixed', 'bottom':0});
    }
    $('#Picker').on('shown.bs.modal', function (e) {
        $('.modal-backdrop').html("<i class='fa fa-spin fa-cog big-middle'></i>")

        $.ajax( "/api/teacher/user" )
            .fail(function() {
                alert( "You've been logged out due to inactivity" );
                window.location = '/logout';
            });
    });
    resizePage();
}
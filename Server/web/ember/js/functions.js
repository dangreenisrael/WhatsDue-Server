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
    if ($(window).height() > $('.main-content').height()) {
        $('#mainFooter').css({'position': 'fixed', 'bottom':0});
    }
    $('#Picker').on('shown.bs.modal', function (e) {
        console.log('shown')
        $('.modal-backdrop').html("<i class='fa fa-spin fa-cog big-middle'></i>")
    });
}


/*
 jQuery Manipulation
 */
function initChooser() {

    setTimeout(function(){

        var date = $('#date');
        var time = $('#time');
        var datetimeValue = $('#datetime').val();
        if (datetimeValue == ""){
            date.val('Enter Date');
            time.val('Enter Time');
        } else{
            date.val(moment(datetimeValue).format('dddd MMM Do'));
            time.val(moment(datetimeValue).format('h:mm A'));
        }

        function getISODateString(days)
        {
            var date = new Date();
            date.setUTCHours(0,0,0,0);
            date.setUTCDate(date.getDate() + days + 1);
            return date.toISOString();
        }
        var now = moment(getISODateString(-2))._d;



        /* Today's Date*/
        var nowTemp = new Date();
        var today = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        /* Select Date in Picker:
        $('.day').removeClass('active')
        var dayMonth = moment($('#datetime').val()).format('D');
        $(".day:not('.new, .old'):text("+dayMonth+")").addClass('active')
        */
        date.datepicker({
            onRender: function(date) {
                return date.valueOf() < today.valueOf() ? 'disabled' : '';
            }
            }).on('changeDate', function(ev){

                if (moment(ev.date).isAfter(now)){
                    date.datepicker('hide');
                }else{
                    date.val('Date has passed');
                }
            }).on('hide', function(ev){
                if (moment(ev.date).isAfter(now)){
                    var pretty = moment(ev.date).format('dddd MMM Do');
                    date.val(pretty);
                    time.click();
                }else{
                    date.val('Date has passed');
                    date.datepicker('show');
                }
        });

        time.timepicker({
            minuteStep: 15,
            showMeridian: true,
            defaultTime: '8:30 AM'
        });

        if (date.val() != 'Enter Date'){
            $('.day').removeClass('active');
            var dateTime = moment($('#datetime').val());
            var dayMonth = dateTime.format('D');
            var hour = dateTime.format('hh');
            var minute = dateTime.format('mm');
            var meridian = dateTime.format('A');
            time.val(dateTime.format('hh:mm A'));
            $(".day:not('.new, .old'):text("+dayMonth+")").addClass('active')
            $('.bootstrap-timepicker-hour').val(hour);
            $('.bootstrap-timepicker-minute').val(minute);
            $('.bootstrap-timepicker-meridian').val(meridian);

        }

        time.on('change',  function() {
            var datetime = $(date).val()+" "+$(time).val();
            datetime = moment(datetime, "dddd MMM Do h:mm A");
            $('#datetime').val(datetime.format('YYYY-MM-DD HH:mm')).focus();
        });


    }, 500);

}

function validateAssignment (){
    var date = $('#date').val();
    var name = $('#assignment-name').val();
    console.log(date);
    if (
        (date != 'Date has passed') &&
        (date != 'Invalid date') &&
        (date != 'Enter Date') &&
        (name != '')
        ){
        return true;
    }
}


function showModal(){
    setTimeout( function(){
        $('#Picker').modal('show');
    },700)
}
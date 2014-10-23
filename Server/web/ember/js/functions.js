/**
 * Created by Dan on 9/23/14.
 */


function loadView(){
    if (localStorage.getItem('firstCourseAdded') != "true"){
        $('#add-first-course').show();
    }
    if (localStorage.getItem('firstAssignmentAdded') != "true"){
        $('#add-first-assignment').show();
    }
    var contentHeight = $('.header-section').height()+$('.page-heading').height()+$('.wrapper').height()+$('#main-footer').height();
    var topPadding = $('html').height()-contentHeight+10;
    $('#mainFooter').css('margin-top',topPadding);


}


/*
 jQuery Manipulation
 */
function initChooser() {

    setTimeout(function(){

        var date = $('#date');
        var time = $('#time');
        var datetimeValue = $('#datetime').val();
        date.val(moment(datetimeValue).format('dddd MMM Do'));
        time.val(moment(datetimeValue).format('h:mm A'));
        function getISODateString(days)
        {
            var date = new Date();
            date.setUTCHours(0,0,0,0);
            date.setUTCDate(date.getDate() + days + 1);
            return date.toISOString();
        }
        var now = moment(getISODateString(-2))._d;

        date.datepicker({
            startDate: now
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
        }).on('show.timepicker', function(e) {
            time.val('8:30 AM');
        });

        time.on('change',  function() {
            var datetime = $(date).val()+" "+$(time).val();
            datetime = moment(datetime, "dddd MMM Do h:mm A");
            $('#datetime').val(datetime.format('YYYY-MM-DD HH:mm')).focus();
        });


    }, 500);





}

/**
 * Created by Dan on 9/23/14.
 */


/*
 jQuery Manipulation
 */
console.log('hi')
function initChooser() {
    setTimeout(function(){

        var now = moment()._d;

        var date = $('#date');
        var time = $('#time');
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
        time.off('change');
        time.on('change',  function() {
            console.log('change');
            var datetime = $(date).val()+" "+$(time).val();
            datetime = moment(datetime, "dddd MMM Do h:mm A");
            $('#datetime').val(datetime.format('YYYY-MM-DD HH:mm')).focus();
        });






        var pickerButton = $('[href="#Picker"]');
        pickerButton.off();
        pickerButton.on('click', function(){
            console.log('click');
        });


    }, 500);
}

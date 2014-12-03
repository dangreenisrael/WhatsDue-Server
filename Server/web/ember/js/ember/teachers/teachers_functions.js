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

        $.ajax( "http://teachers.whatsdueapp.com/api/teacher/username" )
            .fail(function() {
                alert( "You've been logged out due to inactivity" );
                window.location = '/logout';
            });
        initChooser();
    });
    courseUpdate();
    resizePage();
}


/*
 jQuery Manipulation
 */
function initChooser() {

        var date = $('#date');
        var time = $('#time');
        var newEntry = false;

        var datetimeValue = $('#datetime').val();
        if (datetimeValue == ""){
            date.val('Click to choose date');
            newEntry = true;
        } else{
            date.val(moment(datetimeValue).format('dddd MMM Do YYYY'));
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
                    var pretty = moment(ev.date).format('dddd MMM Do YYYY');
                    date.val(pretty);
                    time.click();
                }else{
                    date.val('Date has passed');
                    date.datepicker('show');
                }
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
            datetime = moment(datetime, "dddd MMM Do YYYY h:mm A");
            $('#datetime').val(datetime.format('YYYY-MM-DD HH:mm')).focus();
        });

        time.timepicker('showWidget');
        time.timepicker().on('hide.timepicker', function(e) {
            setTimeout(function () {
                $('.bootstrap-timepicker-widget').addClass('open')
            }, 1)

        });
        if(newEntry == true){
            $('#time').timepicker('setTime', '9:30 AM');
        }
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


function courseUpdate(){
    var panelList = $('.draggable');
    panelList.disableSelection();
    panelList.sortable({
        // Only make the .panel-heading child elements support dragging.
        // Omit this to make the entire <li>...</li> draggable.
        handle: '.fa-sort',
        items: "li",
        update: function(e,ui) {
            var order = panelList.sortable("toArray").join();
            $.ajax({
                url: "http://teachers.whatsdueapp.com/api/teacher/settings/order-" + order,
                type: 'PUT',
                success: function (order) {
                    console.log(order)
                }
            });
            var mainPanels = $('ul.courses');
            var panelOrder = order.replace(/Panel/g, '');
            $.each(panelOrder.split(','), function (i, id) {
                $("#" + id).appendTo(mainPanels);

            });
        }
    });

    $.get('http://teachers.whatsdueapp.com/api/teacher/settings/order', function(order){
        if (order.length > 1) {
            console.log(order.length);
            $.each(order.split(','), function (i, id) {
                var item = "#"+id;
                console.log(item);
                $(item).appendTo(panelList);
            });

            var mainPanels = $('ul.courses');
            var panelOrder = order.replace(/Panel/g, '');
            $.each(panelOrder.split(','), function (i, id) {
                $("#" + id).appendTo(mainPanels);

            });
        }
    });

}


function resizePage(){
    var sidebar = $('.sidebar.panel');
    sidebar.width(sidebar.parent('div').width())
}
$( window ).resize(function(){
    var sidebar = $('.sidebar.panel');
    sidebar.width(sidebar.parent('div').width())
});


function scrollToId(id){
    var target = ($('#'+id).offset().top)-105;
    $('html,body').animate({
        scrollTop: target
    }, 500);
}

function trackEvent(event, firstOption, firstValue, secondOption, secondValue){
    firstOption = firstOption || null;
    firstValue = firstValue || null;
    secondOption = secondOption || null;
    secondValue = secondValue || null;

    var options = {};
    options['username'] = username;
    if (firstOption != null) {
        options[firstOption] = firstValue;
        if (secondOption != null) {
            options[secondOption] = secondValue;
        }
    }

    ll('tagEvent', event, options);
}



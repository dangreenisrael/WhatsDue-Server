/**
 * Created by Dan on 9/20/14.
 */

App.ApplicationAdapter = DS.RESTAdapter.extend({
    host: 'http://teachers.whatsdueapp.com',
    namespace: 'api/admin'
});


App.User = DS.Model.extend({
    username:           DS.attr('string'),
    email:              DS.attr('string'),
    course_count:       DS.attr('number'),
    assignment_count:   DS.attr('number'),
    last_login:         DS.attr('string'),
    last_login_t:       function(){
        var login = this.get('last_login');
        if (typeof login !== 'undefined') {
            return moment(this.get('last_login')).format('X');
        } else{
            return "";
        }

    }.property('last_login'),
    last_login_since:    function(){
        var login = this.get('last_login');
        if (typeof login !== 'undefined') {
            return moment(this.get('last_login')).from();
        } else{
            return "";
        }
    }.property('last_login')
});

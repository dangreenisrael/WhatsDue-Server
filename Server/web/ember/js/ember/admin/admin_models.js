/**
 * Created by Dan on 9/20/14.
 */

App.ApplicationAdapter = DS.RESTAdapter.extend({
    host: 'http://teachers.whatsdueapp.com',
    namespace: 'api/admin'
});


App.User = DS.Model.extend({
    username:         DS.attr('string'),
    email:         DS.attr('string'),
    last_login:         DS.attr('string'),
    last_login_h:       function(){
        var login = this.get('last_login');
        if (typeof login !== 'undefined') {
            return moment(this.get('last_login')).format('dddd MMM D, h:mm A');
        } else{
            return "";
        }

    }.property('last_login')
});

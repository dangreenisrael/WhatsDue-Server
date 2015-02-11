/**
 * Created by Dan on 9/20/14.
 */


App.ApplicationAdapter = DS.RESTAdapter.extend({
    namespace: 'api/admin'
});



App.User = DS.Model.extend({
    username:           DS.attr('string'),
    email:              DS.attr('string'),
    course_count:       DS.attr('number'),
    assignment_count:   DS.attr('number'),
    unique_users:       DS.attr('number'),
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

App.School = DS.Model.extend({
    school_name:      DS.attr('string'),
    total_courses:     DS.attr('number'),
    total_users:     DS.attr('number')
});

App.Message = DS.Model.extend({
    title:  DS.attr('string'),
    body:   DS.attr('string')
});

/*
App.User.reopenClass({
    FIXTURES: [
        { id: 34, username: "dangreen", email: "dan@tlvwebdevelopment.com", last_login: "2014-12-01T16:33:53+0200", assignment_count: "2", course_count: "4"},
        { id: 35, username: "angreen", email: "dan@tlvwebdevelopment.com", last_login: "2014-12-01T16:33:53+0200", assignment_count: "2", course_count: "4"}
    ]
});
    */
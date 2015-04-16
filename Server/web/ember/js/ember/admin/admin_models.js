/**
 * Created by Dan on 9/20/14.
 */


App.ApplicationAdapter = DS.RESTAdapter.extend({
    namespace: 'app_dev.php/api/admin'
});



App.User = DS.Model.extend({
    username:           DS.attr('string'),
    email:              DS.attr('string'),
    course_count:       DS.attr('number'),
    assignment_count:   DS.attr('number'),
    unique_users:       DS.attr('number'),
    last_login:         DS.attr('string'),
    institution_name:   DS.attr('string'),
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

App.Usage = DS.Model.extend({
    school_name:      DS.attr('string'),
    total_courses:     DS.attr('number'),
    total_users:     DS.attr('number')
});


App.School = DS.Model.extend({
    name:               DS.attr('string'),
    city:               DS.attr('string'),
    region:             DS.attr('string'),
    address:            DS.attr('string'),
    country:            DS.attr('string'),
    contact_name:       DS.attr('string'),
    contact_email:      DS.attr('string'),
    contact_phone:      DS.attr('string'),
    total_courses:      DS.attr('number'),
    total_users:        DS.attr('number')
});

App.Message = DS.Model.extend({
    title:      DS.attr('string'),
    body:       DS.attr('string')
});

App.Email = DS.Model.extend({
    user:       DS.belongsTo('user', {async:true}),
    subject:    DS.attr('string'),
    body:       DS.attr('string'),
    tag:        DS.attr('string'),
    date:       DS.attr('date'),
    recipients: DS.attr(),
    sent_count:    function(){
        var recipients = this.get('recipients');
        recipients = JSON.parse(recipients);
        return recipients.length;
    }.property('recipients')

});


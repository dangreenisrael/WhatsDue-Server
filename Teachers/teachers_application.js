var App = Ember.Application.create();

Ember.LinkView.reopen({
    attributeBindings: ['data-toggle']
});

var user;

$.get('/api/teacher/user', function(data){

    user        = data.user;
    var lastName    = user.last_name;
    var firstName   = user.first_name;
    var salutation  = user.salutation;
    var email       = user.email;

    trackEvent('Opened Site');

    Ember.Handlebars.helper('lastName', function() {
        return new Ember.Handlebars.SafeString(lastName)
    });

    Ember.Handlebars.helper('firstName', function() {
        return new Ember.Handlebars.SafeString(firstName)
    });

    Ember.Handlebars.helper('salutation', function() {
        return new Ember.Handlebars.SafeString(salutation)
    });

    Ember.Handlebars.helper('email', function() {
        return new Ember.Handlebars.SafeString(email)
    });

});

Ember.Handlebars.helper('liScrollToId', function(course) {
    var id = course.id;
    var name = course.get('course_name');
    return new Ember.Handlebars.SafeString("<li id='" +id+ "Panel'><i class='fa fa-sort'></i><span onclick='scrollToId("+id+")'>"+name+"</span></li>");
});

Ember.Handlebars.helper('linkify', function(text) {
    if (typeof text === "undefined") {
        return Ember.String.htmlSafe("");
    } else{
        return Ember.String.htmlSafe(linkify(text));
    }
});

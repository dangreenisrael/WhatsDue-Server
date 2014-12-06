var App = Ember.Application.create();

Ember.LinkView.reopen({
    attributeBindings: ['data-toggle']
});

var username;

$.get('http://teachers.whatsdueapp.com/api/teacher/user', function(user){
    username = user.user.username_canonical;
    Ember.Handlebars.helper('userName', function() {
        return new Ember.Handlebars.SafeString(username)
    });

});

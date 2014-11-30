var App = Ember.Application.create();

Ember.LinkView.reopen({
    attributeBindings: ['data-toggle']
});

var username;

$.get('http://teachers.whatsdueapp.com/teacher/username', function(userid){
    username = userid.username_canonical;
    trackEvent('Opened Site');
    Ember.Handlebars.helper('userName', function() {
        return new Ember.Handlebars.SafeString(username)
    });

});

Ember.Handlebars.helper('liScrollToId', function(name, id) {
    return new Ember.Handlebars.SafeString("<li id='"+id+"Panel'><i class='fa fa-sort'></i><span onclick='scrollToId("+id+")'>"+name+"</span></li>");
});
var App = Ember.Application.create();

Ember.LinkView.reopen({
    attributeBindings: ['data-toggle']
});

var username;

$.get('/api/teacher/user', function(data){
    user = data.user;
    var username  = user.username_canonical;
    var first_name = user.first_name;
    trackEvent('Opened Site');
    Ember.Handlebars.helper('userName', function() {
        return new Ember.Handlebars.SafeString(username)
    });

    Ember.Handlebars.helper('firstName', function() {
        return new Ember.Handlebars.SafeString(first_name)
    });


});

Ember.Handlebars.helper('liScrollToId', function(name, id) {
    return new Ember.Handlebars.SafeString("<li id='"+id+"Panel'><i class='fa fa-sort'></i><span onclick='scrollToId("+id+")'>"+name+"</span></li>");
});

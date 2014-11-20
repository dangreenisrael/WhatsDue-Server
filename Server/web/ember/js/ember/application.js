
var loaderObj = {

    templates : [
        'application.hbs',
        'main.hbs'
    ]
};


loadTemplates(loaderObj.templates);
//This function loads all templates into the view
function loadTemplates(templates) {
    $(templates).each(function() {
        var tempObj = $('<script>');
        tempObj.attr('type', 'text/x-handlebars');
        var dataTemplateName = this.substring(0, this.indexOf('.'));
        tempObj.attr('data-template-name', dataTemplateName);
        $.ajax({
            async: false,
            type: 'GET',
            url: '/ember/templates/' + this,
            success: function(resp) {
                tempObj.html(resp);
                $('body').append(tempObj);
            }
        });
    })
}

var helperObj = {

    templates : [
        'main_editAssignment.hbs',
        'main_editCourse.hbs',
        'course_newAssignment.hbs',
        'main_newCourse.hbs',
        'message_new.hbs',
        'message_history.hbs',
        'main_trash.hbs',
        'main_welcome.hbs'
    ]
};


loadHelpers(helperObj.templates);
//This function loads all templates into the view
function loadHelpers(templates) {
    $(templates).each(function() {
        var tempObj = $('<script>');
        tempObj.attr('type', 'text/x-handlebars');
        var name = this.substring(0, this.indexOf('.'));
        var firstHalf = name.substring(0, name.indexOf('_'));
        var secondHalf = name.substr(name.indexOf("_") + 1);
        var dataTemplateName = firstHalf+"/"+secondHalf;

        tempObj.attr('data-template-name', dataTemplateName);
        $.ajax({
            async: false,
            type: 'GET',
            url: '/ember/templates/' + this,
            success: function(resp) {
                tempObj.html(resp);
                $('body').append(tempObj);
            }
        });
    })
}

var App = Ember.Application.create();

Ember.LinkView.reopen({
    attributeBindings: ['data-toggle']
});

var username;


$.get('http://teachers.whatsdueapp.com/teacher/username', function(userid){
    username = userid;
    trackEvent('Opened Site');
    Ember.Handlebars.helper('userName', function() {
        return new Ember.Handlebars.SafeString(username)
    });
});

Ember.Handlebars.helper('liScrollToId', function(name, id) {
   return new Ember.Handlebars.SafeString("<li id='"+id+"Panel'><i class='fa fa-sort'></i><span onclick='scrollToId("+id+")'>"+name+"</span></li>");
});

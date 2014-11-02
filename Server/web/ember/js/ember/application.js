
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
        'main_assignment.hbs',
        'main_course.hbs',
        'main_newAssignment.hbs',
        'main_newCourse.hbs',
        'main_trash.hbs'
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


/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('assignments', {path: '/'}, function(){
        this.route('info', {path: 'assignment/:id'});
        this.route('course', {path: 'course/:id'});
        this.route('newAssignment', {path: 'course/:id/new'});
        this.route('newCourse', {path: 'new-course'});
    });
});


App.ApplicationRoute = Ember.Route.extend({
    actions:{
        close : function(){
            this.transitionTo('assignments');
        }
    }
});
App.AssignmentsRoute = Ember.Route.extend({
    model: function() {
        this.store.find('assignment');
        return this.store.find('course');
    },
    afterModel: function(){
        initChooser();
    }
});

App.AssignmentsInfoRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('assignment', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});

App.AssignmentsCourseRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('course', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});

App.AssignmentsNewAssignmentRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('course', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});
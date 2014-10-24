/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
        this.route('info', {path: 'assignment/:id'});
        this.route('course', {path: 'course/:id'});
        this.route('newAssignment', {path: 'course/:id/new'});
        this.route('newCourse', {path: 'new-course'});
    });
});


App.ApplicationRoute = Ember.Route.extend({
    actions:{
        close : function(){
            this.transitionTo('main');
        }
    }
});
App.MainRoute = Ember.Route.extend({
    model: function() {
        this.store.find('assignment');
        return this.store.find('course');
    },
    afterModel: function(){
        initChooser();
    }
});

App.MainInfoRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('assignment', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});

App.MainCourseRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('course', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});

App.MainNewAssignmentRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('course', params.id);
    },
    afterModel: function(){
        initChooser();
    }
});
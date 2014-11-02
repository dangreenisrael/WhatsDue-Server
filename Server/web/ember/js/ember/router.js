/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
        this.route('assignment', {path: 'assignment/:id'});
        this.route('course', {path: 'course/:id'});
        this.route('newAssignment', {path: 'course/:id/new'});
        this.route('newCourse', {path: 'new-course'});
        this.route('welcome', {path: 'welcome'});
    });
});



App.MainRoute = Ember.Route.extend({
    model: function() {
        this.store.find('assignment');
        return this.store.find('course');
    },
    afterModel: function(){
        initChooser();
        var count = this.modelFor('main').get('length');
        if (count == 0){
            this.transitionTo('main.welcome');
        }

    }
});

App.MainAssignmentRoute = Ember.Route.extend({
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

App.MainWelcomeRoute = Ember.Route.extend({
    model: function(){
        return "";
    },
    afterModel: function(){
        showModal()
    },
    actions: {
        addCourse: function () {
            showModal();
            this.transitionTo('main.newCourse');
        }
    }
});
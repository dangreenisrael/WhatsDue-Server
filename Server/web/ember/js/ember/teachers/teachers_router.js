/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
        this.route('editAssignment', {path: 'edit-assignment/assignment/:id'});
        this.resource('course',{path: 'course/:id'}, function(){
            this.route('newAssignment');
            this.route('bulkChange');
            this.resource('message', {path:'messages'}, function(){
                this.route('new');
                this.route('history');
            });
            this.resource('email', {path:'email'}, function(){
                this.route('invite');
            })
        });
        this.route('editCourse', {path: 'edit-course/:id'});
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
    },
    actions: {
        change: function() {
            // deal with the change
            console.log('change');
            this.refresh();
        }
    }
});


App.MainEditAssignmentRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('assignment', params.id);
    },
    afterModel: function(){
        initChooser();
    },
    actions: {
        dataChanged: function() {
            this.refresh();
        }
    }
});



App.MainEditCourseRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('course', params.id);
    },
    afterModel: function(){
        initChooser();

    },
    actions: {
    invalidateModel: function() {
        Ember.Logger.log('Route is now refreshing...');
        this.refresh();
    }
}
});

App.CourseBulkChangeRoute = Ember.Route.extend({
    model: function() {
        var course = this.modelFor('course');
        return course.get('assignments');
    },
    afterModel: function(){
        initChooser();
    }
});

App.CourseNewAssignmentRoute = Ember.Route.extend({
    model: function() {
        return this.modelFor('course');
    },
    afterModel: function(){
        initChooser();
    }
});

App.MessageNewRoute = Ember.Route.extend({
    model: function() {
        var id = this.modelFor('course').id;
        return this.store.find('course', id);
    }
});

App.MessageNewRoute = Ember.Route.extend({
    model: function() {
        var id = this.modelFor('course').id;
        return this.store.find('course', id);
    }
});

App.MessageHistoryRoute = Ember.Route.extend({
    model: function() {
        var id = this.modelFor('course').id;
        return this.store.find('message', {course_id:id});
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

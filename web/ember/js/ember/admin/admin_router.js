/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
        this.resource('message', {path:'messages'}, function(){
            this.route('new');
        });
    });
    this.resource('schools', function() {
        this.route('new');
        this.resource('school', {path: ':id'}, function () {
            this.route('edit');
        })
    });
    this.resource('logs', function() {
        this.route('emails')
    });
});


App.MainRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('user');
    },
    afterModel: function(){
        setTimeout(
            function(){
                initTable();
            },
            1
        )
    }
});

App.SchoolsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('school');
    },
    afterModel: function(){
        setTimeout(
            function(){
                initTable();
            },
            1
        )
    }
});

App.LogsEmailsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('email');
    },
    afterModel: function(){
        setTimeout(
            function(){
                initTable();
            },
            1
        )
    }
});


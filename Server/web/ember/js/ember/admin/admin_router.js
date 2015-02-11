/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
        this.resource('message', {path:'messages'}, function(){
            this.route('new');
        });
    });
    this.resource('schools');
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


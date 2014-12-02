/**
 * Created by Dan on 9/20/14.
 */

App.Router.map(function(){
    this.resource('main', {path: '/'}, function(){
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


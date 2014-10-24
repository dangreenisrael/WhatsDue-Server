/**
 * Created by Dan on 10/14/14.
 */

App.MainView = Ember.View.extend({
    contentDidChange: function() {
        setTimeout(function(){loadView() }, 1);
    }.observes('controller.mainData')
});

App.MainNewAssignmentView = Ember.View.extend({
    didInsertElement: function() {
        console.log('loaded');
        $('input').val('');
    }
});
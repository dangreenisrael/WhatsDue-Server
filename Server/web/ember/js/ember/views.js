/**
 * Created by Dan on 10/14/14.
 */

App.AssignmentsView = Ember.View.extend({
    contentDidChange: function() {
        setTimeout(function(){loadView() }, 1);
    }.observes('controller.mainData')
});
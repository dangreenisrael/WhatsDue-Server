/**
 * Created by Dan on 9/22/14.
 */

App.MessageNewController = Ember.ObjectController.extend({
    actions: {
        send: function() {
            var data = this.get('model');
            var message = this.store.createRecord('message', {
                title:  data.title,
                body:   data.body
            });
            message.save();
            this.transitionToRoute('main');
        },
        close: function(){
            this.transitionToRoute('main');
        }
    }
});

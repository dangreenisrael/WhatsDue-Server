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



App.SchoolsNewController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            var data = this.get('model');
            var school = this.store.createRecord('school', {
                name:           data.name,
                city:           data.city,
                region:         data.region,
                country:        data.country,
                address:        data.address,
                contact_name:    data.contact_name,
                contact_email:   data.contact_email,
                contact_phone:   data.contact_phone
            });
            school.save();
            this.transitionToRoute('schools');
        },
        close: function(){
            this.transitionToRoute('schools');
        }
    }
});



App.SchoolEditController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            var school = this.get('model');
            school.save();
            this.transitionToRoute('schools');
        },
        close: function(){
            this.transitionToRoute('schools');
        }
    }
});
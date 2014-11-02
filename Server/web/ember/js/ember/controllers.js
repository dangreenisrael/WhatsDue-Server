/**
 * Created by Dan on 9/22/14.
 */
function save(model, context){
    model.save().then(function (e) {
        $('#Picker').modal('hide');
        $('.modal-body input').val('');
        context.transitionToRoute('main');

    }).catch(function(reason){
        if (reason.status == 500){
            alert('OOPS sorry about that, try reloading the page')
        }
    });
}

App.MainCourseController = Ember.ArrayController.extend({
    content:[],
    mainData: (function() {
        return this.get('model')
    }).property('content.@each.enrolled')
});

App.MainAssignmentController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            if (validateAssignment() == true) {
                save(this.get('model'));
                this.transitionToRoute('main');
            }else{
                alert("Woops, Did you select a valid date?")
            }
        },
        remove: function(){
            var model = this.get('model');
            model.deleteRecord();
            save(model, this);
            this.transitionToRoute('main');
        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});

App.MainCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            save(this.get('model'), this);
            this.transitionToRoute('main');
        },
        remove: function(){
            var model = this.get('model');
            model.deleteRecord();
            save(model, this);
            this.transitionToRoute('main');
        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});

App.MainNewAssignmentController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            if (validateAssignment() == true) {
                var data = this.get('model');
                var assignment = this.store.createRecord('assignment', {
                    course_id: data,
                    due_date: data.due_date,
                    assignment_name: data.assignment_name,
                    admin_id: data._data.admin_id
                });
                save(assignment, this);
                localStorage.setItem('firstAssignmentAdded', 'true');
                $('#add-first-assignment').hide();
                save(this.get('model'));
                this.transitionToRoute('main');
            } else{
                alert ('Please fill everything out');
            }
        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});

App.MainNewCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            var data = this.get('model');
            var course = this.store.createRecord('course', {
                course_name: data.course_name,
                instructor_name: data.instructor_name
            });
            save(course, this);
            localStorage.setItem('firstCourseAdded', 'true');
            $('#add-first-course').hide();
        },
        close: function(){
            this.transitionToRoute('main');
        }
    }
});
/**
 * Created by Dan on 9/22/14.
 */
function save(model){
    model.save().then(function (post) {
        $('#Picker').modal('hide');
        $('.modal-body input').val('');
    }).catch(function(reason){
        if (reason.status == 500){
            alert('Please fill everything out')
        }
    });
}

App.AssignmentsCourseController = Ember.ArrayController.extend({
    content:[],
    mainData: (function() {
        return this.get('model')
    }).property('content.@each.enrolled')
});

App.AssignmentsInfoController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            save(this.get('model'));
        },
        remove: function(){
            var model = this.get('model');
            model.deleteRecord();
            save(model);
        }
    }
});

App.AssignmentsCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            save(this.get('model'));
        }
    }
});

App.AssignmentsNewAssignmentController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            var data = this.get('model');
            var assignment = this.store.createRecord('assignment', {
                course_id: data,
                due_date: data.due_date,
                assignment_name: data.assignment_name,
                admin_id: data._data.admin_id
            });
            save(assignment);
            localStorage.setItem('firstAssignmentAdded', 'true');
            $('#add-first-assignment').hide();
        }
    }
});

App.AssignmentsNewCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            var data = this.get('model');
            var course = this.store.createRecord('course', {
                course_name: data.course_name,
                instructor_name: data.instructor_name
            });
            save(course);
            localStorage.setItem('firstCourseAdded', 'true');
            $('#add-first-course').hide();
        }
    }
});
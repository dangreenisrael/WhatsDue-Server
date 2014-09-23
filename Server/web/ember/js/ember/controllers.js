/**
 * Created by Dan on 9/22/14.
 */
App.AssignmentsInfoController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            this.get('model').save();
        }
    }
});

App.AssignmentsCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            this.get('model').save();
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
            assignment.save();
            $('.modal-body input').val('');
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
            course.save();
            $('.modal-body input').val('');
        }
    }
});



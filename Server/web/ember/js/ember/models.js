/**
 * Created by Dan on 9/20/14.
 */

App.ApplicationAdapter = DS.RESTAdapter.extend({
    host: 'http://admin.whatsdueapp.com/app_dev.php',
    namespace: 'teacher'
});

App.Course = DS.Model.extend({
    course_name:         DS.attr('string'),
    instructor_name:     DS.attr('string'),
    admin_id:            DS.attr('string'),
    last_modified:       DS.attr('number'),
    created_at:          DS.attr('number'),
    assignments:         DS.hasMany('Assignment')
});


App.Assignment = DS.Model.extend({
    admin_id:            DS.attr('string'),
    assignment_name:     DS.attr('string'),
    due_date:            DS.attr('string'),
    course_id:           DS.belongsTo('course'),
    dueDate: function(){
        return moment(this.get('due_date')).format('MMM D h:mm A');
    }.property('due_date'),
    hidden: function(){
        if (moment().isAfter(this.get('due_date')) == true){
            return "hidden";
        }else{
            return " ";
        }
    }.property('due_date')

});

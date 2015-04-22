/**
 * Created by Dan on 9/20/14.
 */

var path = window.location.pathname;
var baseUrl;
if (path.indexOf("app_dev.php") > -1){
    baseUrl = "app_dev.php/";
} else{
    baseUrl = "";
}

App.ApplicationAdapter = DS.RESTAdapter.extend({
    namespace: baseUrl+'api/teacher'
});


App.Course = DS.Model.extend({
    course_name:         DS.attr('string'),
    instructor_name:     DS.attr('string'),
    admin_id:            DS.attr('string'),
    course_code:         DS.attr('string'),
    archived:            DS.attr('boolean'),
    device_ids:          DS.attr('string',  {defaultValue: "{}"}),
    assignments:         DS.hasMany('Assignment'),
    panelId: function(){
        return this.get('id')+"Panel";
    }.property('id'),
    totalSubscribers: function(){
        var users = JSON.parse(this.get('device_ids'));
        return Object.keys(users).length;
    }.property('device_ids')

});

App.Assignment = DS.Model.extend({
    admin_id:            DS.attr('string'),
    assignment_name:     DS.attr('string'),
    description:         DS.attr('string'),
    due_date:            DS.attr('string'),
    archived:            DS.attr('boolean'),
    course_id:           DS.belongsTo('course'),
    dueDate: function(){
        return moment(this.get('due_date')).format('ddd M/D h:mm A');
    }.property('due_date'),
    timestamp: function(){
        return moment(this.get('due_date')).format('X');
    }.property('due_date'),
    hidden: function(){
        if (moment().isAfter(this.get('due_date')) == true){
            return "hidden";
        }else{
            return " ";
        }
    }.property('due_date'),
    changed: function(){
        // Changed
    }.observes('description').on('init'),
    checked:            DS.attr('boolean', {defaultValue: false})
});

App.Message = DS.Model.extend({
    body:               DS.attr('string'),
    title:              DS.attr('string'),
    updated_at:         DS.attr('number'),
    course_id:          DS.belongsTo('course', {async:true}),
    date: function(){
        return moment(this.get('updated_at'),"X").format('MMM Do, hh:mm A');
    }.property('updated_at')
});

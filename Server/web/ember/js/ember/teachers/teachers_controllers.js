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

App.MainController = Ember.ArrayController.extend({
    model:[],
    actions:{
        duplicate: function(oldCourse){
            var newCourse = this.store.createRecord('course', {
                course_name: oldCourse.get('course_name')+" COPY",
                instructor_name: oldCourse.get('instructor_name')
            });
            var context = this;
            newCourse.save().then(function(record){
                oldCourse.get('assignments').forEach(function(oldAssignment) {
                    if (oldAssignment.get('archived')==false){
                        var assignment = context.store.createRecord('assignment', {
                            course_id:          record,
                            due_date:           oldAssignment.get('due_date'),
                            assignment_name:    oldAssignment.get('assignment_name'),
                            description:        oldAssignment.get('description'),
                            admin_id:           username
                        });
                        assignment.save();
                    }
                });
            })

        }
    }
});


App.MainEditAssignmentController = Ember.ObjectController.extend({
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
            save(model);
            this.transitionToRoute('main');
        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});

App.MainEditCourseController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            save(this.get('model'), this);
            this.transitionToRoute('main');
        },
        remove: function(){
            var model = this.get('model');
            //model.set('archived',true);
            model.deleteRecord();
            save(model);
            this.transitionToRoute('main');
        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});

App.CourseNewAssignmentController = Ember.ObjectController.extend({
    actions: {
        save: function() {

            console.log(this.get('model'));
            if (validateAssignment() == true) {
                var data = this.get('model');
                var assignment = this.store.createRecord('assignment', {
                    course_id:          data,
                    due_date:           data.due_date,
                    assignment_name:    data.assignment_name,
                    description:        data.description,
                    admin_id:           data._data.admin_id
                });
                assignment.save();
                localStorage.setItem('firstAssignmentAdded', 'true');
                $('#add-first-assignment').hide();
                save(this.get('model'));
                trackEvent("Added Assignment");
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

App.CourseBulkChangeController = Ember.ObjectController.extend({
    time: "10:00 AM",
    actions: {
        save: function () {
            var data = this.get('model');
            var time = this.time;
            var day = $("input[name=day]:checked").val();
            console.log(day);
            var date;
            var dueDate;
            var week;
            data.forEach(function(item) {
                if(item.get('checked')==true){
                    dueDate = item.get('due_date');
                    if (day == "no-change"){
                        date = moment(dueDate).format('dddd MMM Do YYYY');
                    } else{
                        week = moment(dueDate).startOf('week');
                        date = moment(week).add(day, 'days').format('dddd MMM Do YYYY');
                    }

                    dueDate = date+" "+time;
                    dueDate = moment(dueDate, "dddd MMM Do YYYY h:mm A");
                    dueDate = moment(dueDate).format('YYYY-MM-DD HH:mm');
                    item.set('due_date', dueDate);
                    item.set('checked', false);
                    save(item, this);
                }
            });
            this.transitionToRoute('main');
        }
    }
});

App.MainNewCourseController = Ember.ObjectController.extend({
    needs:['main'],
    actions: {
        save: function() {
            var userName = user.salutation + " " + user.first_name + " " + user.last_name;
            var data = this.get('model');
            var course = this.store.createRecord('course', {
                course_name: data.course_name,
                instructor_name: userName
            });
            save(course, this);
            $('#add-first-course').hide();
            trackEvent("Added Course");
            //this.modelFor('main').reload()
            this.get('controllers.main').send('change');
            this.transitionToRoute('main');
            //location.reload(false);
        },
        close: function(){
            this.transitionToRoute('main');
        }
    }
});


App.MessageNewController = Ember.ObjectController.extend({
    actions: {
        save: function() {
            if (validateAssignment() == true) {
                var data = this.get('model');
                var message = this.store.createRecord('message', {
                    course_id:          data,
                    body:               data.body,
                    title:              data.title
                });
                save(message, this);
                save(this.get('model'));
                trackEvent("Sent Message");
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

App.MessageHistoryController = Ember.ArrayController.extend({
    needs: ['course']
});

App.EmailInviteController = Ember.ObjectController.extend({

    emailMessage: function(){
        var message =
        "Hi Class, \nI am now putting all of your assignments on the WhatsDue app.\n" +
        "All the information you need to get started can be found in this email\n" +
        "Cheers, ";
        return message + " " + user.first_name + " " + user.last_name;
    }.property(),
    actions: {
        send: function() {
            var data = this.get('model');
            var payload =
            {email:
                {
                    course_code: 	data.get('course_code'),
                    course_name:	data.get('course_name'),
                    email_list:     this.get('emailAddresses'),
                    message:	    this.get('emailMessage')
                }
            };

            var context = this;
            $.ajax({
                type: "POST",
                url: "/app_dev.php/api/teacher/emails/invites",
                data: JSON.stringify(payload),
                dataType: "json",
                contentType: 'application/json; charset=UTF-8',
                success: function(response){
                    /*
                     * Display bad emails
                     */
                    var invalidEmails = response.emails_invalid;
                    console.log(invalidEmails);
                    if (invalidEmails.length > 0 ){
                        alert("The following email addresses aren't valid:\n" + invalidEmails.join(","))
                    }
                    else{
                        trackEvent("Invitation Email Sent");
                        context.transitionToRoute('main');
                        $('#Picker').modal('hide')
                    }
                }
            });

        },
        close: function(){
            this.get('model').rollback();
            this.transitionToRoute('main');
        }
    }
});
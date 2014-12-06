Ember.TEMPLATES["application"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1;


  data.buffer.push("<section>\n\n    <!-- main content start-->\n    <div class=\"main-content\" >\n\n    <!-- header section start-->\n    <div class=\"header-section\">\n\n        <!--notification menu start -->\n        <div class=\"pull-left\">\n            <img id=\"logo\" src=\"/ember/images/whatsdue-logo.png\"/>\n        </div>\n        <div class=\"menu-right\">\n            <ul class=\"notification-menu\">\n                <li>\n                    <a href=\"#\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">\n                        <i class=\"fa fa-info-circle\"></i> <strong>");
  stack1 = helpers._triageMustache.call(depth0, "userName", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</strong>\n                        <span class=\"caret\"></span>\n                    </a>\n                    <ul class=\"dropdown-menu dropdown-menu-usermenu pull-right\">\n                        <li><a href=\"mailto:aaron@whatsdueapp.com\"><i class=\"fa fa-envelope\"></i>Email Aaron</a></li>\n                        <li><a href=\"skype:aarontaylor613?call\"><i class=\"fa fa-phone\"></i>Skype Aaron</a></li>\n                        <li><a href=\"/logout\"><i class=\"fa fa-sign-out\"></i> Log Out</a></li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n        <!--notification menu end -->\n    </div>\n    <!-- header section end-->\n\n\n\n    <!--body wrapper start-->\n    <div class=\"wrapper\">\n        ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n    </div>\n    <!--body wrapper end-->\n\n\n\n    </div>\n    <!-- main content end-->\n</section>\n<!--footer section start-->\n<footer id=\"mainFooter\">\n    2014 &copy; WhatsDue\n</footer>\n<!--footer section end-->\n\n\n<div class=\"overlay\" style=\"display: none\">\n    \n</div>");
  return buffer;
  });

Ember.TEMPLATES["course/newAssignment"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" - New Assignment</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-5\">\n\n                <div class=\"form-group\">\n                    ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("due_date"),
    'id': ("datetime")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                    <input type=\"text\" id=\"date\" class=\"form-control\" required=\"required\"  size=\"16\" placeholder=\"Please close and try again\"/>\n                </div>\n\n                <div class=\"form-group input-append bootstrap-timepicker\">\n                    <input id=\"time\" type=\"hidden\" class=\"input-small\">\n                    <span class=\"add-on\"><i class=\"icon-time\"></i></span>\n                </div>\n            </div>\n            <div class=\"col-md-7\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("assignment_name"),
    'id': ("assignment-name"),
    'maxlength': ("40"),
    'class': ("pull-left form-control"),
    'placeholder': ("Assignment Name")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'id': ("description"),
    'value': ("description"),
    'maxlength': ("250"),
    'class': ("pull-left form-control"),
    'placeholder': ("Description")
  },hashTypes:{'id': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'id': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n        </div>\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>\n");
  return buffer;
  });

Ember.TEMPLATES["main"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  
  data.buffer.push("\n                        Add Courses\n                    ");
  }

function program3(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                        ");
  stack1 = helpers.unless.call(depth0, "course.archived", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(4, program4, data),contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                    ");
  return buffer;
  }
function program4(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                        <li ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'id': ("course.panelId")
  },hashTypes:{'id': "ID"},hashContexts:{'id': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">\n                        <i class='fa fa-sort'></i>\n                            <span>\n                                ");
  stack1 = helpers._triageMustache.call(depth0, "course.course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            </span>\n                        </li>\n                        ");
  return buffer;
  }

function program6(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n            ");
  stack1 = helpers.unless.call(depth0, "course.archived", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(7, program7, data),contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        ");
  return buffer;
  }
function program7(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n                <li class=\"col-md-12 panel ui-state-default\" ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'id': ("course.id")
  },hashTypes:{'id': "ID"},hashContexts:{'id': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">\n                    <header class=\"panel-heading row\">\n                        <div class=\"col-md-6\">\n                            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'data-toggle': "STRING",'href': "STRING"},hashContexts:{'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(8, program8, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editCourse", "course", options) : helperMissing.call(depth0, "link-to", "main.editCourse", "course", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            <br/>\n                            <span class=\"student-count\">");
  stack1 = helpers._triageMustache.call(depth0, "course.totalSubscribers", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" students</span>\n                        </div>\n                        <div class=\"col-md-6 row\">\n                            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("button"),
    'class': ("btn btn-primary col-md-12"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(10, program10, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "course.newAssignment", "course", options) : helperMissing.call(depth0, "link-to", "course.newAssignment", "course", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            <!--\n                            <div class=\"padded\">\n                                {#link-to 'message.new' course tag=\"button\"  class=\"col-md-7 btn btn-primary\" data-toggle=\"modal\" href=\"#Picker\"}}\n                                    <i class=\"fa fa-envelope\"></i> Send Message\n                                {/link-to}}\n\n                                {#link-to 'message.history' course tag=\"button\"  class=\"col-md-4 btn btn-primary pull-right\" data-toggle=\"modal\" href=\"#Picker\"}}\n                                    <i class=\"fa fa-archive\"></i>\n                                {/link-to}}\n                            </div>\n                            -->\n                        </div>\n\n                    </header>\n                    <div class=\"panel-body\">\n                        <table class=\"table table-hover\">\n                            <thead>\n                            <tr>\n                                <th>Due Date</th>\n                                <th>Name</th>\n                                <th>Description </th>\n                            </tr>\n                            </thead>\n                            <tbody>\n\n                            ");
  stack1 = helpers.each.call(depth0, "assignment", "in", "course.assignments", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(12, program12, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            </tbody>\n                        </table>\n                    </div>\n                </li>\n            ");
  return buffer;
  }
function program8(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n\n                                ");
  stack1 = helpers._triageMustache.call(depth0, "course.course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" <small><i>");
  stack1 = helpers._triageMustache.call(depth0, "course.instructor_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</i></small>\n                            ");
  return buffer;
  }

function program10(depth0,data) {
  
  
  data.buffer.push("\n                                <i class=\"fa fa-plus\"></i> Add Assignment\n                            ");
  }

function program12(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                                ");
  stack1 = helpers.unless.call(depth0, "assignment.archived", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(13, program13, data),contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            ");
  return buffer;
  }
function program13(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n                                    ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tagName': ("tr"),
    'class': ("assignment"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tagName': "STRING",'class': "ID",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tagName': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(14, program14, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editAssignment", "assignment", options) : helperMissing.call(depth0, "link-to", "main.editAssignment", "assignment", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                ");
  return buffer;
  }
function program14(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                                        <td> ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.dueDate", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td> ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.assignment_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td> ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.description", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" </td>\n                                    ");
  return buffer;
  }

  data.buffer.push("<div class=\"row\">\n    <div class=\"col-sm-4 col-md-3\">\n        <!-- page heading start-->\n        <div class=\"sidebar panel panel-default\">\n\n            <div class=\"panel-heading\">\n                <h3 class=\"panel-title\">\n                    ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("i"),
    'class': ("fa fa-plus-square-o pointer"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "main.newCourse", options) : helperMissing.call(depth0, "link-to", "main.newCourse", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                </h3>\n            </div>\n            <div class=\"panel-body\">\n               <ul class=\"draggable\">\n                    ");
  stack1 = helpers.each.call(depth0, "course", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n               </ul>\n            </div>\n        </div>\n        <!-- page heading end-->\n\n    </div>\n    <div class=\"col-sm-8 col-md-9\">\n        <ul class=\"courses\">\n\n        ");
  stack1 = helpers.each.call(depth0, "course", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(6, program6, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </ul>\n    </div>\n</div>\n<div class=\"modal fade\" id=\"Picker\" data-backdrop=\"static\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">\n    <div class=\"modal-dialog\">\n        <div class=\"modal-content\">\n            ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </div>\n    </div>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/editAssignment"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_id.course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(": ");
  stack1 = helpers._triageMustache.call(depth0, "assignment_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</h4>\n</div>\n\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-5\">\n\n                <div class=\"form-group\">\n                    ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("due_date"),
    'id': ("datetime")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                    <input type=\"text\" id=\"date\" class=\"form-control\" required=\"required\"  size=\"16\" placeholder=\"Due Date\"/>\n                </div>\n\n                <div class=\"form-group input-append bootstrap-timepicker\">\n                    <input id=\"time\" type=\"hidden\" class=\"input-small\">\n                    <span class=\"add-on\"><i class=\"icon-time\"></i></span>\n                </div>\n            </div>\n            <div class=\"col-md-7\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("assignment_name"),
    'id': ("assignment-name"),
    'maxlength': ("40"),
    'class': ("pull-left form-control"),
    'placeholder': ("Assignment Name")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'id': ("description"),
    'value': ("description"),
    'maxlength': ("250"),
    'class': ("pull-left form-control"),
    'placeholder': ("Description")
  },hashTypes:{'id': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'id': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n        </div>\n    </form>\n</div>\n\n<div class=\"modal-footer\">\n    <button  class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n    <button  class=\"btn btn-danger pull-left\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "remove", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Delete</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/editCourse"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("course_name"),
    'maxlength': ("20"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Course Name")
  },hashTypes:{'type': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("instructor_name"),
    'maxlength': ("20"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Instructor Name")
  },hashTypes:{'type': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n    <button  class=\"btn btn-danger pull-left\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "remove", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Delete</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/main_trash"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"modal-header\">\n    <button ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  stack1 = helpers._triageMustache.call(depth0, "instructor_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "undelete", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >undelete</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/newCourse"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">New Course</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("course_name"),
    'maxlength': ("20"),
    'class': ("pull-left form-control"),
    'placeholder': ("Course Name")
  },hashTypes:{'type': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("instructor_name"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Instructor Name")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/welcome"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">Welcome to WhatsDue</h4>\n</div>\n\n<div class=\"modal-body\">\n\n    <p>Hey ");
  stack1 = helpers._triageMustache.call(depth0, "firstName", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(", </p>\n    <p>\n        Here's how to use WhatsDue. (Do the same thing for each course)\n    </p>\n    <ol>\n        <li>\n            Click <strong>\"Add a Course\"</strong> and fill in the details\n        </li>\n        <li>\n            Click <strong>\"Add an Assignment\"</strong> and do the same\n        </li>\n        <li>\n            Tell your students to search for <strong>");
  stack1 = helpers._triageMustache.call(depth0, "userName", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</strong> in the app.\n        </li>\n    </ol>\n   <p>\n       If you have any questions, you can get a hold of us by email or Skype 24/7\n   </p>\n    <p>\n        Thanks for using WhatsDue\n    </p>\n    <p>\n        Dan & Aaron\n    </p>\n</div>\n\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "addCourse", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Add a Course</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["message/history"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                                <tr>\n                                    <td>");
  stack1 = helpers._triageMustache.call(depth0, "message.date", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                    <td>");
  stack1 = helpers._triageMustache.call(depth0, "message.body", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                </tr>\n                            ");
  return buffer;
  }

  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\"class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "controllers.course.course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(": Message History</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-12\">\n                <div class=\"panel-body\">\n                    <table class=\"table table-striped\">\n                        <thead>\n                        <tr>\n                            <th>Date</th>\n                            <th>Message</th>\n                        </tr>\n                        </thead>\n                        <tbody>\n                            ");
  stack1 = helpers.each.call(depth0, "message", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                        </tbody>\n                    </table>\n                </div>\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" >Close</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["message/new"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(": New Message</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-12\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'value': ("body"),
    'class': ("pull-left form-control"),
    'placeholder': ("Type message to class")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });
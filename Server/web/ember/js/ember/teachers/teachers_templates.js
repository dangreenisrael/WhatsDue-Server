Ember.TEMPLATES["application"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  
  data.buffer.push("\n                Add Course\n            ");
  }

  data.buffer.push("<section>\n\n    <!-- main content start-->\n    <div class=\"main-content\" >\n\n    <!-- header section start-->\n    <div class=\"header-section\">\n\n        <!--notification menu start -->\n        <div class=\"pull-left\">\n            <img id=\"logo\" src=\"/ember/images/whatsdue-logo.png\"/>\n\n\n        </div>\n        <div class=\"menu-right\">\n            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("i"),
    'class': ("fa fa-plus-square-o pointer add-course btn btn-primary"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "main.newCourse", options) : helperMissing.call(depth0, "link-to", "main.newCourse", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            <ul class=\"notification-menu\">\n                <li>\n                    <a href=\"#\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">\n                        ");
  stack1 = helpers._triageMustache.call(depth0, "email", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                        <i class=\"fa fa-info-circle\"></i>\n                        <span class=\"caret\"></span>\n                    </a>\n                    <ul class=\"dropdown-menu dropdown-menu-usermenu pull-right\">\n                        <li><a href=\"mailto:aaron@whatsdueapp.com\"><i class=\"fa fa-envelope\"></i>Email Aaron</a></li>\n                        <li><a href=\"skype:aarontaylor613?call\"><i class=\"fa fa-phone\"></i>Skype Aaron</a></li>\n                        <li><a href=\"/logout\"><i class=\"fa fa-sign-out\"></i> Log Out</a></li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n        <!--notification menu end -->\n    </div>\n    <!-- header section end-->\n\n\n\n    <!--body wrapper start-->\n    <div class=\"wrapper\">\n        ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n    </div>\n    <!--body wrapper end-->\n\n\n\n    </div>\n    <!-- main content end-->\n</section>\n<!--footer section start-->\n<footer id=\"mainFooter\">\n    2014 &copy; WhatsDue\n</footer>\n<!--footer section end-->\n\n\n<div class=\"overlay\" style=\"display: none\">\n    \n</div>");
  return buffer;
  });

Ember.TEMPLATES["components/assignment-list"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var stack1, helper, options, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n    <table class=\"table table-hover\">\n        <thead>\n        <tr>\n            <!--<th></th>-->\n            <th ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "sortBy", "timestamp", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0,depth0],types:["STRING","STRING"],data:data})));
  data.buffer.push(" ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'class': (":due-date :noselect :pointer time sort")
  },hashTypes:{'class': "STRING"},hashContexts:{'class': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">Due Date</th>\n            <th ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "sortBy", "assignment_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0,depth0],types:["STRING","STRING"],data:data})));
  data.buffer.push(" ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'class': (":due-date :noselect :pointer name sort")
  },hashTypes:{'class': "STRING"},hashContexts:{'class': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">Name</th>\n            <th class=\"description noselect pointer\">Description </th>\n        </tr>\n        </thead>\n        <tbody>\n\n            ");
  stack1 = helpers.each.call(depth0, "assignment", "in", "controller", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(2, program2, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </tbody>\n    </table>\n");
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                ");
  stack1 = helpers.unless.call(depth0, "assignment.archived", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            ");
  return buffer;
  }
function program3(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n                    <tr ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'class': ("assignment.id")
  },hashTypes:{'class': "ID"},hashContexts:{'class': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">\n                        <!--<td>-->\n                        <!--{input type=\"checkbox\" checked=assignment.checked}}-->\n                        <!--</td>-->\n                        ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tagName': ("td"),
    'class': ("due"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tagName': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tagName': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(4, program4, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editAssignment", "assignment", options) : helperMissing.call(depth0, "link-to", "main.editAssignment", "assignment", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n                        ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tagName': ("td"),
    'class': ("name"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tagName': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tagName': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(6, program6, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editAssignment", "assignment", options) : helperMissing.call(depth0, "link-to", "main.editAssignment", "assignment", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n                        ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tagName': ("td"),
    'class': ("description"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tagName': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tagName': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(8, program8, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editAssignment", "assignment", options) : helperMissing.call(depth0, "link-to", "main.editAssignment", "assignment", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                    </tr>\n                ");
  return buffer;
  }
function program4(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                            <span class=\"hidden\"> ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.timestamp", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" </span>\n                            ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.dueDate", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                        ");
  return buffer;
  }

function program6(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                            ");
  stack1 = helpers._triageMustache.call(depth0, "assignment.assignment_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                        ");
  return buffer;
  }

function program8(depth0,data) {
  
  var buffer = '', helper, options;
  data.buffer.push("\n\n                            ");
  data.buffer.push(escapeExpression((helper = helpers.linkify || (depth0 && depth0.linkify),options={hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data},helper ? helper.call(depth0, "assignment.description", options) : helperMissing.call(depth0, "linkify", "assignment.description", options))));
  data.buffer.push("\n                        ");
  return buffer;
  }

  stack1 = (helper = helpers.render || (depth0 && depth0.render),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "assignments", "assignments", options) : helperMissing.call(depth0, "render", "assignments", "assignments", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  else { data.buffer.push(''); }
  });

Ember.TEMPLATES["components/course-panes"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                ");
  stack1 = helpers._triageMustache.call(depth0, "course.course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            ");
  return buffer;
  }

function program3(depth0,data) {
  
  
  data.buffer.push("\n                <!--<i class=\"fa fa-plus\"></i>--> Add Assignment\n            ");
  }

function program5(depth0,data) {
  
  
  data.buffer.push("\n                <!--<i class=\"fa fa-users\"></i> -->Invite Parents & Students\n            ");
  }

  data.buffer.push("<li class=\"col-md-12 panel ui-state-default\" ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'id': ("course.id")
  },hashTypes:{'id': "ID"},hashContexts:{'id': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">\n    <header class=\"panel-heading row\">\n        <div class=\"col-sm-4\">\n            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'data-toggle': "STRING",'href': "STRING"},hashContexts:{'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "main.editCourse", "course", options) : helperMissing.call(depth0, "link-to", "main.editCourse", "course", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n            <br/>\n            <i data-original-title=\"This is the unique course code. Your students and parents need this code in order to join the course\" class=\"fa fa-question-circle tooltips\" data-toggle=\"tooltip\" data-placement=\"bottom\" ></i>\n            ");
  stack1 = helpers._triageMustache.call(depth0, "course.course_code", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" -\n            <span class=\"student-count\">");
  stack1 = helpers._triageMustache.call(depth0, "course.totalSubscribers", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" students</span>\n        </div>\n        <div class=\"col-sm-8 row\">\n            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("button"),
    'class': ("btn btn-primary col-md-4"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "course.newAssignment", "course", options) : helperMissing.call(depth0, "link-to", "course.newAssignment", "course", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n            <!--<div class=\"padded\">-->\n            <!--{#link-to 'message.new' course tag=\"button\"  class=\"col-md-7 btn btn-primary\" data-toggle=\"modal\" href=\"#Picker\"}}-->\n            <!--<i class=\"fa fa-envelope\"></i> Send Message-->\n            <!--{/link-to}}-->\n\n            <!--{#link-to 'message.history' course tag=\"button\"  class=\"col-md-4 btn btn-primary pull-right\" data-toggle=\"modal\" href=\"#Picker\"}}-->\n            <!--<i class=\"fa fa-archive\"></i>-->\n            <!--{/link-to}}-->\n            <!--</div>-->\n\n            ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("button"),
    'class': ("btn btn-primary col-md-7 pull-right"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'class': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'class': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(5, program5, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "email.invite", "course", options) : helperMissing.call(depth0, "link-to", "email.invite", "course", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n        </div>\n\n    </header>\n    <div class=\"panel-body\">\n\n        <!--{#link-to 'course.bulkChange' course tag=\"button\" class=\"btn btn-primary col-xs-5 col-sm-3\" data-toggle=\"modal\" href=\"#Picker\"}}-->\n        <!--Bulk-->\n        <!--{/link-to}}-->\n\n        <div class=\"col-xs-1\"></div>\n        <!--<button class=\"btn btn-warning col-xs-5 col-sm-3\" {action 'duplicate' course}}>-->\n        <!--Duplicate-->\n        <!--</button>-->\n        ");
  data.buffer.push(escapeExpression((helper = helpers['assignment-list'] || (depth0 && depth0['assignment-list']),options={hash:{
    'assignments': ("course.assignments")
  },hashTypes:{'assignments': "ID"},hashContexts:{'assignments': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "assignment-list", options))));
  data.buffer.push("\n\n    </div>\n</li>\n");
  return buffer;
  });

Ember.TEMPLATES["course/bulkChange"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, self=this, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;

function program1(depth0,data) {
  
  
  data.buffer.push("\n        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    ");
  }

  data.buffer.push("<div class=\"modal-header\">\n    ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "main", options) : helperMissing.call(depth0, "link-to", "main", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n    <h4 class=\"modal-title\"> Bulk change</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-5\">\n                <div class=\"form-group input-append bootstrap-timepicker\">\n                    ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'value': ("time"),
    'type': ("hidden"),
    'class': (":input-small"),
    'id': ("time")
  },hashTypes:{'value': "ID",'type': "STRING",'class': "STRING",'id': "STRING"},hashContexts:{'value': depth0,'type': depth0,'class': depth0,'id': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                    <span class=\"add-on\"><i class=\"icon-time\"></i></span>\n                </div>\n            </div>\n            <div class=\"col-md-7 radio\">\n                <div class=\"col-md-6\">\n                    <div class=\"input-group \">\n                        <span class=\"input-group-addon primary\">\n                            <input type=\"radio\" name=\"day\" checked=\"checked\" value=\"no-change\">\n                        </span>\n                        <span class=\"form-control\">\n                            <i>Keep&nbsp;Day</i>\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group \">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"0\">\n                        </span>\n                        <span class=\"form-control\">\n                            Sunday\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group\">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"1\">\n                        </span>\n                        <span class=\"form-control\">\n                            Monday\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group\">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"2\">\n                        </span>\n                        <span class=\"form-control\">\n                            Tuesday\n                        </span>\n                    </div><!-- /input-group -->\n                </div>\n\n                <div class=\"col-md-6\">\n                    <div class=\"input-group \">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"3\">\n                        </span>\n                        <span class=\"form-control\">\n                            Wednesday\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group\">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"4\">\n                        </span>\n                        <span class=\"form-control\">\n                            Thursday\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group\">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"5\">\n                        </span>\n                        <span class=\"form-control\">\n                            Friday\n                        </span>\n                    </div><!-- /input-group -->\n                    <div class=\"input-group\">\n                        <span class=\"input-group-addon\">\n                            <input type=\"radio\" name=\"day\" value=\"6\">\n                        </span>\n                        <span class=\"form-control\">\n                            Saturday\n                        </span>\n                    </div><!-- /input-group -->\n                </div>\n\n            </div>\n        </div>\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>\n");
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
  data.buffer.push(" - New Assignment</h4>\n</div>\n\n<div class=\"modal-body\">\n        <div class=\"form-group\">\n            <div class=\"col-md-5\">\n\n                <div class=\"form-group\">\n                    ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("due_date"),
    'id': ("datetime")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                    <input type=\"text\" id=\"date\" class=\"form-control\" readonly=\"true\" required=\"required\"  size=\"16\" placeholder=\"Please close and try again\"/>\n                </div>\n\n                <div class=\"form-group input-append bootstrap-timepicker\">\n                    <input id=\"time\" type=\"hidden\" data-disable-focus=\"true\" readonly=\"true\" class=\"input-small\">\n                    <span class=\"add-on\"><i class=\"icon-time\"></i></span>\n                </div>\n            </div>\n            <div class=\"col-md-7\">\n                ");
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
  data.buffer.push("\n            </div>\n        </div>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary col-xs-12\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>\n");
  return buffer;
  });

Ember.TEMPLATES["email/invite"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(": Invite Students and Parents</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n\n            <div class=\"col-md-12\">\n\n                <h5>\n                    In order for a parent or student to add <i>");
  stack1 = helpers._triageMustache.call(depth0, "course_name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</i> to WhatsDue, all they have to\n                    do is enter this course code into the app: <strong>");
  stack1 = helpers._triageMustache.call(depth0, "course_code", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</strong>\n                </h5>\n                <h5>\n                    If you would like, we will send an email to whomever you wish, instructing them how to set up\n                    WhatsDue and add this course.\n                </h5>\n                <h5>\n                    The email will be sent from us, and <strong>your email address will be hidden</strong>\n                </h5>\n                <h5>\n                    <strong><i>Note: The course code is automatically sent in the email.</i></strong>\n                </h5>\n\n                <h5>\n                    Please feel free to change this text:\n                </h5>\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'value': ("emailMessage"),
    'class': ("form-control padded"),
    'placeholder': ("Message to your students")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n\n            <div class=\"col-md-12\">\n                <h5>\n                    Please enter a list of email addresses. <i><strong>Recipients cannot see other email addresses</strong></i>\n                </h5>\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'value': ("emailAddresses"),
    'class': ("form-control padded"),
    'placeholder': ("List of emails seperated by commas, spaces, or new lines")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "send", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Send Email</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  
  data.buffer.push("\n                        Add Course\n                    ");
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
  
  var buffer = '', helper, options;
  data.buffer.push("\n                            ");
  data.buffer.push(escapeExpression((helper = helpers.liScrollToId || (depth0 && depth0.liScrollToId),options={hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data},helper ? helper.call(depth0, "course", options) : helperMissing.call(depth0, "liScrollToId", "course", options))));
  data.buffer.push("\n                        ");
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
  
  var buffer = '', helper, options;
  data.buffer.push("\n                ");
  data.buffer.push(escapeExpression((helper = helpers['course-panes'] || (depth0 && depth0['course-panes']),options={hash:{
    'course': ("course")
  },hashTypes:{'course': "ID"},hashContexts:{'course': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "course-panes", options))));
  data.buffer.push("\n            ");
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
  data.buffer.push("</h4>\n</div>\n\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-5\">\n                <div class=\"form-group\">\n                    ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("due_date"),
    'id': ("datetime")
  },hashTypes:{'type': "STRING",'value': "ID",'id': "STRING"},hashContexts:{'type': depth0,'value': depth0,'id': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n                    <input type=\"text\" id=\"date\" class=\"form-control\" readonly=\"true\" required=\"required\"  size=\"16\" placeholder=\"Due Date\"/>\n                </div>\n\n                <div class=\"form-group input-append bootstrap-timepicker\">\n                    <input id=\"time\" type=\"hidden\" data-disable-focus=\"true\" readonly=\"true\" class=\"input-small\">\n                    <span class=\"add-on\"><i class=\"icon-time\"></i></span>\n                </div>\n            </div>\n            <div class=\"col-md-7\">\n                ");
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
  data.buffer.push("</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n            <div class=\"col-md-12\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("course_name"),
    'maxlength': ("20"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Course Name")
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
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">New Course</h4>\n</div>\n<div class=\"modal-body\">\n        <div class=\"form-group\">\n            <div class=\"col-md-12\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("course_name"),
    'maxlength': ("20"),
    'class': ("pull-left form-control"),
    'placeholder': ("Course Name")
  },hashTypes:{'type': "STRING",'value': "ID",'maxlength': "STRING",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'maxlength': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["main/welcome"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', escapeExpression=this.escapeExpression;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">Welcome to WhatsDue</h4>\n</div>\n\n<div class=\"modal-body\">\n\n    <p>Welcome to WhatsDue!</p>\n    <p>\n        We know you want to see your students succeed so we built WhatsDue to help you do that.\n    </p>\n    <p>\n        Here’s how you can make the most of the app:\n    </p>\n    <ol>\n        <li>\n            Add the courses you teach\n        </li>\n        <li>\n            Add as many upcoming assignments as you can. The more you add, the more your students and/or parents will know in advance.\n        </li>\n        <li>\n            Invite students and/or parents to use WhatsDue. Just hit the “Invite” button and enter the email addresses of everyone you think should know what assignments are coming up. The email will contain the course code that the students and/or parents will need in order to join the class.\n        </li>\n    </ol>\n   <p>\n       Also, every time you add, update, or delete an assignment, everyone who joined your class will get a push notification. Keep this in mind before you make changes.   </p>\n    <p>\n        If you need any help at any time, just head to the top right or bottom right corner to get in touch with Aaron.\n    </p>\n    <p>\n        Thanks again for using WhatsDue!\n    </p>\n</div>\n\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
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
  stack1 = helpers.each.call(depth0, "message", "in", "controller", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
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
  data.buffer.push(": New Message</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n\n            <div class=\"col-md-12 row\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'value': ("title"),
    'class': (" form-control"),
    'placeholder': ("Title")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-12\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.textarea || (depth0 && depth0.textarea),options={hash:{
    'value': ("body"),
    'class': ("form-control"),
    'placeholder': ("Type message to class")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "textarea", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });
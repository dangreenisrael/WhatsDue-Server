Ember.TEMPLATES["application"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1;


  data.buffer.push("<section>\n\n    <!-- main content start-->\n    <div class=\"main-content\" >\n\n    <!-- header section start-->\n    <div class=\"header-section\">\n\n        <!--notification menu start -->\n        <div class=\"pull-left\">\n            <img id=\"logo\" src=\"/ember/images/whatsdue-logo.png\"/> Super Admin Panel\n        </div>\n        <div class=\"menu-right\">\n            <ul class=\"notification-menu\">\n                <li>\n                    <a href=\"#\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">\n                        <i class=\"fa fa-info-circle\"></i> <strong>");
  stack1 = helpers._triageMustache.call(depth0, "userName", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</strong>\n                        <span class=\"caret\"></span>\n                    </a>\n                    <ul class=\"dropdown-menu dropdown-menu-usermenu pull-right\">\n                        <li><a href=\"mailto:aaron@whatsdueapp.com\"><i class=\"fa fa-envelope\"></i>Email Aaron</a></li>\n                        <li><a href=\"skype:aarontaylor613?call\"><i class=\"fa fa-phone\"></i>Skype Aaron</a></li>\n                        <li><a href=\"/logout\"><i class=\"fa fa-sign-out\"></i> Log Out</a></li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n        <!--notification menu end -->\n    </div>\n    <!-- header section end-->\n\n\n\n    <!--body wrapper start-->\n    <div class=\"wrapper admin\">\n        ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n    </div>\n    <!--body wrapper end-->\n\n\n\n    </div>\n    <!-- main content end-->\n</section>\n<!--footer section start-->\n<footer id=\"mainFooter\">\n    2014 &copy; WhatsDue\n</footer>\n<!--footer section end-->\n\n\n<div class=\"overlay\" style=\"display: none\">\n    \n</div>");
  return buffer;
  });

Ember.TEMPLATES["main"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                                    <tr class=\"gradeX odd\">\n                                        <td class=\" \">");
  stack1 = helpers._triageMustache.call(depth0, "user.id", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td class=\" \">");
  stack1 = helpers._triageMustache.call(depth0, "user.username", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td class=\" \">");
  stack1 = helpers._triageMustache.call(depth0, "user.email", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td class=\" \">\n                                            <span class=\"hidden\">\n                                                ");
  stack1 = helpers._triageMustache.call(depth0, "user.last_login_t", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                            </span>\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "user.last_login_since", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                        <td>\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "user.unique_users", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                        <td >\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "user.course_count", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                        <td>\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "user.assignment_count", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                    </tr>\n                                ");
  return buffer;
  }

  data.buffer.push("\n\n<div class=\"row\">\n    <div class=\"col-sm-12\">\n        <section class=\"panel\">\n            <header class=\"panel-heading\">\n                Users\n                <!--\n                {#link-to 'message.new' data-toggle=\"modal\" href=\"#Picker\" class=\"btn btn-info pull-right\"}}\n                    Bulk Message\n                {/link-to}}\n                -->\n\n            </header>\n            <div class=\"panel-body\">\n                <div class=\"adv-table\">\n                    <div id=\"dynamic-table_wrapper\" class=\"dataTables_wrapper form-inline\" role=\"grid\">\n                        <table class=\"display table table-bordered table-striped dataTable\" id=\"dynamic-table\" aria-describedby=\"dynamic-table_info\">\n                            <thead>\n                            <tr role=\"row\">\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" aria-sort=\"descending\">\n                                    ID\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Username\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Email\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Last Login\n                                </th>\n                                <th>\n                                    Users\n                                </th>\n                                <th >\n                                    Courses\n                                </th>\n                                <th>\n                                    Assignments\n                                </th>\n\n                            </tr>\n                            </thead>\n                            <tbody role=\"alert\" aria-live=\"polite\" aria-relevant=\"all\">\n                                ");
  stack1 = helpers.each.call(depth0, "user", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            </tbody>\n                        </table>\n                    </div>\n                </div>\n            </div>\n        </section>\n    </div>\n</div>\n<div class=\"modal fade\" id=\"Picker\" data-backdrop=\"static\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">\n    <div class=\"modal-dialog\">\n        <div class=\"modal-content\">\n            ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </div>\n    </div>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["message/new"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">Bulk Message</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal \">\n        <div class=\"form-group\">\n\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'value': ("title"),
    'class': ("pull-left form-control"),
    'placeholder': ("Message title")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-12\">\n                <br/>\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'value': ("body"),
    'class': ("pull-left form-control"),
    'placeholder': ("Type message to all users"),
    'maxlength': ("40")
  },hashTypes:{'value': "ID",'class': "STRING",'placeholder': "STRING",'maxlength': "STRING"},hashContexts:{'value': depth0,'class': depth0,'placeholder': depth0,'maxlength': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button  data-dismiss=\"modal\" class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "send", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Send to ALL users</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["school/edit"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">New Course</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal school\">\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("name"),
    'class': ("pull-left form-control required"),
    'placeholder': ("School Name"),
    'disabled': ("Disabled")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING",'disabled': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0,'disabled': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("city"),
    'class': ("form-control required"),
    'size': ("16"),
    'placeholder': ("City")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("region"),
    'class': ("pull-left form-control required"),
    'placeholder': ("Region")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("country"),
    'class': ("form-control required"),
    'size': ("16"),
    'placeholder': ("Country")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("address"),
    'class': ("pull-left form-control required"),
    'placeholder': ("Address")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_name"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Contact Name")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_email"),
    'class': ("pull-left form-control"),
    'placeholder': ("Contact Email")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_phone"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Contact Phone")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["schools"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  
  data.buffer.push("\n                    New School\n                ");
  }

function program3(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n                                    <tr class=\"gradeX odd\">\n                                        ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'tag': ("td"),
    'data-toggle': ("modal"),
    'href': ("#Picker")
  },hashTypes:{'tag': "STRING",'data-toggle': "STRING",'href': "STRING"},hashContexts:{'tag': depth0,'data-toggle': depth0,'href': depth0},inverse:self.noop,fn:self.program(4, program4, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "school.edit", "school", options) : helperMissing.call(depth0, "link-to", "school.edit", "school", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        <td class=\" \">");
  stack1 = helpers._triageMustache.call(depth0, "school.total_users", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</td>\n                                        <td class=\" \"> ");
  stack1 = helpers._triageMustache.call(depth0, "school.total_courses", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" </td>\n                                    </tr>\n                                ");
  return buffer;
  }
function program4(depth0,data) {
  
  var buffer = '', stack1;
  data.buffer.push("\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "school.name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        ");
  return buffer;
  }

  data.buffer.push("\n<div class=\"row\">\n    <div class=\"col-sm-12\">\n        <section class=\"panel\">\n            <header class=\"panel-heading\">\n                Schools\n                ");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{
    'data-toggle': ("modal"),
    'href': ("#Picker"),
    'class': ("btn btn-info pull-right")
  },hashTypes:{'data-toggle': "STRING",'href': "STRING",'class': "STRING"},hashContexts:{'data-toggle': depth0,'href': depth0,'class': depth0},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "schools.new", options) : helperMissing.call(depth0, "link-to", "schools.new", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n            </header>\n            <div class=\"panel-body\">\n                <div class=\"adv-table\">\n                    <div id=\"dynamic-table_wrapper\" class=\"dataTables_wrapper form-inline\" role=\"grid\">\n                        <table class=\"display table table-bordered table-striped dataTable\" id=\"dynamic-table\" aria-describedby=\"dynamic-table_info\">\n                            <thead>\n                            <tr role=\"row\">\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    School\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Total Users\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Total Courses\n                                </th>\n                            </tr>\n                            </thead>\n                            <tbody role=\"alert\" aria-live=\"polite\" aria-relevant=\"all\">\n                                ");
  stack1 = helpers.each.call(depth0, "school", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            </tbody>\n                        </table>\n                    </div>\n                </div>\n            </div>\n        </section>\n    </div>\n</div>\n<div class=\"modal fade\" id=\"Picker\" data-backdrop=\"static\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">\n    <div class=\"modal-dialog\">\n        <div class=\"modal-content\">\n            ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </div>\n    </div>\n</div>");
  return buffer;
  });

Ember.TEMPLATES["schools/new"] = Ember.Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing;


  data.buffer.push("<div class=\"modal-header\">\n    <button type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "close", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n    <h4 class=\"modal-title\">New Course</h4>\n</div>\n<div class=\"modal-body\">\n    <form action=\"#\" class=\"form-horizontal school\">\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("name"),
    'class': ("pull-left form-control required"),
    'placeholder': ("School Name*")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("city"),
    'class': ("form-control required"),
    'size': ("16"),
    'placeholder': ("City*")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("region"),
    'class': ("pull-left form-control required"),
    'placeholder': ("Region*")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("country"),
    'class': ("form-control required"),
    'size': ("16"),
    'placeholder': ("Country*")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("address"),
    'class': ("pull-left form-control required"),
    'placeholder': ("Address*")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_name"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Contact Name")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n        <div class=\"form-group\">\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_email"),
    'class': ("pull-left form-control"),
    'placeholder': ("Contact Email")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n            <div class=\"col-md-6\">\n                ");
  data.buffer.push(escapeExpression((helper = helpers.input || (depth0 && depth0.input),options={hash:{
    'type': ("text"),
    'value': ("contact_phone"),
    'class': ("form-control"),
    'size': ("16"),
    'placeholder': ("Contact Phone")
  },hashTypes:{'type': "STRING",'value': "ID",'class': "STRING",'size': "STRING",'placeholder': "STRING"},hashContexts:{'type': depth0,'value': depth0,'class': depth0,'size': depth0,'placeholder': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "input", options))));
  data.buffer.push("\n            </div>\n        </div>\n\n    </form>\n</div>\n<div class=\"modal-footer\">\n    <button class=\"btn btn-primary\" type=\"button\" ");
  data.buffer.push(escapeExpression(helpers.action.call(depth0, "save", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["STRING"],data:data})));
  data.buffer.push(" >Save</button>\n</div>");
  return buffer;
  });
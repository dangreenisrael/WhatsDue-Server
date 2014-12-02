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
  stack1 = helpers._triageMustache.call(depth0, "user.course_count", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                        <td>\n                                            ");
  stack1 = helpers._triageMustache.call(depth0, "user.assignment_count", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                                        </td>\n                                    </tr>\n                                ");
  return buffer;
  }

  data.buffer.push("\n\n<div class=\"row\">\n\n    <div class=\"col-sm-12\">\n        <section class=\"panel\">\n            <header class=\"panel-heading\">\n                Users\n            </header>\n            <div class=\"panel-body\">\n                <div class=\"adv-table\">\n                    <div id=\"dynamic-table_wrapper\" class=\"dataTables_wrapper form-inline\" role=\"grid\">\n                        <table class=\"display table table-bordered table-striped dataTable\" id=\"dynamic-table\" aria-describedby=\"dynamic-table_info\">\n                            <thead>\n                            <tr role=\"row\">\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" aria-sort=\"descending\">\n                                    ID\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Username\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Email\n                                </th>\n                                <th class=\"sorting\" role=\"columnheader\" aria-controls=\"dynamic-table\" >\n                                    Last Login\n                                </th>\n                                <th>\n                                    Courses\n                                </th>\n                                <th>\n                                    Assignments\n                                </th>\n                            </tr>\n                            </thead>\n                            <tbody role=\"alert\" aria-live=\"polite\" aria-relevant=\"all\">\n                                ");
  stack1 = helpers.each.call(depth0, "user", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n                            </tbody>\n                        </table>\n                    </div>\n                </div>\n            </div>\n        </section>\n    </div>\n</div>\n<div class=\"modal fade\" id=\"Picker\" data-backdrop=\"static\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">\n    <div class=\"modal-dialog\">\n        <div class=\"modal-content\">\n            ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </div>\n    </div>\n</div>");
  return buffer;
  });
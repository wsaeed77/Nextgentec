  $.typeahead({
            input: '.js-typeahead-input',
            minLength: 1,
            order: "asc",
            dynamic: true,
            delay: 500,
            backdrop: {
                "background-color": "#fff"
            },
             group: true,
             /*template: "@{{display}}, <small><em>@{{group}}</em></small>",*/
            dropdownFilter: "All",
            template: function (query, item) {
         
                var color = "#777";
               /*if (item.status === "owner") {
                    color = "#ff1493";
                }*/

            if(item.group=='location')
            {
            //console.log(item);
                return '<span class="row">' +           
                    '<span class="username">@{{loc_name}} <small style="color: ' + color + ';">(@{{group}})</small></span>' +
                "</span>";
              }

              if(item.group=='customer')
            {
            //console.log(item);
                return '<span class="row">' +           
                    '<span class="username">@{{cust_name}} <small style="color: ' + color + ';">(@{{group}})</small></span>' +
                "</span>";
              }
              if(item.group=='ticket')
            {
            //console.log(item);
                return '<span class="row">' +           
                    '<span class="username">@{{ticket_title}} <small style="color: ' + color + ';">(@{{group}})</small></span>' +
                "</span>";
              }
            },
            emptyTemplate: "no result for @{{query}}",
            source: {
                customer: {
                    display: "cust_name",
                    href: "{{URL::route('admin.crm.index')}}/show/@{{id}}",
                    ajax: function (query) {
                        return {
                            type: "GET",
                            url: "{{URL::route('admin.crm.search.customers')}}",
                            path: "data.customers",
                            data: {
                                cust: "@{{query}}"
                            },
                            callback: {
                                done: function (data) {
                                  //console.log(data);
                                    /*for (var i = 0; i < data.customers.length; i++) {
                                       
                                            data.customers[i].status = 'contributor';
                                       
                                    }*/
                                    return data;
                                }
                            }
                        }
                    }
         
                },
                location:{
                  display: "loc_name",
                    href: "{{URL::route('admin.crm.index')}}/show/@{{id}}",
                    ajax: function (query) {
                        return {
                            type: "GET",
                            url: "{{URL::route('admin.crm.search.locations')}}",
                            path: "data.locations",
                            data: {
                                loc: "@{{query}}"
                            },
                            callback: {
                                done: function (data) {
                                  //console.log(data);
                                    /*for (var i = 0; i < data.customers.length; i++) {
                                       
                                            data.customers[i].status = 'contributor';
                                       
                                    }*/
                                    return data;
                                }
                            }
                        }
                    }

                },
                ticket:{
                  display: "ticket_title",
                    href: "{{URL::route('admin.ticket.index')}}/show/@{{id}}",
                    ajax: function (query) {
                        return {
                            type: "GET",
                            url: "{{URL::route('admin.crm.ajax.search.tickets')}}",
                            path: "data.tickets",
                           {{--  dataType: 'json', --}}
                            data: {
                                ticket: "@{{query}}"
                            },
                            callback: {
                                done: function (data) {
                                 console.log(data);
                                    /*for (var i = 0; i < data.customers.length; i++) {
                                       
                                            data.customers[i].status = 'contributor';
                                       
                                    }*/
                                    return data;
                                }
                            }
                        }
                    }

                }
                
            },
            callback: {
                onClick: function (node, a, item, event) {
         
                    // You can do a simple window.location of the item.href
                    //alert(JSON.stringify(item));
         
                },
                onSendRequest: function (node, query) {
                    //console.log('request is sent')
                },
                onReceiveRequest: function (node, query) {
                    //console.log('request is received')
                },
                 onResult: function (node, query, obj, objCount) {

                        //console.log(objCount)

                        var text = "";
                        if (query !== "") {
                            text = objCount + ' elements matching "' + query + '"';
                        }
                        $('.js-result-container').text(text);

                    }
            },
            debug: true
        });
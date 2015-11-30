var CustomDashboardPage = (function() {
    
    var message = "Please be patient, We are processing your request...";
    
    function scriptStarter() {
        getUserPosts();
        getUserPages();
        getUsersRegistered();
        addDatePicker();
    }
    
    function makeAjaxCall(data, cbFunction, message) {
        jQuery.blockUI({ message: '<h5>'+message+'</h5>',
                         css: {
                             'padding-bottom': '10px',
                             height: '40px',
                             width: '500px'
                         }
        });
        jQuery.ajax({
            type: 'POST',
            url: MyAjax.ajaxurl,
            timeout: 10000,
            data: data,
            success: function(data){
                if (cbFunction) {
                    cbFunction(data);
                }
            },
            complete: function() {
                jQuery.unblockUI();
            },
            error: function(xhr) {
                new PNotify({
                    title: 'Unable to process your request, Please try again.'
                });
                jQuery('.ui-pnotify').css({
                    'width':'480px'
                });
            }
        });
    }
    
    function addDatePicker() {
        jQuery('#datetimepickerone').datetimepicker({
            format: 'YYYY-MM-DD',
            maxDate: moment()
        });
        jQuery('#datetimepickertwo').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date(),
            maxDate: moment()
        });
        jQuery("#datetimepickerone").on("dp.change", function (e) {
            jQuery('#datetimepickertwo').data("DateTimePicker").minDate(e.date);
        });
        jQuery("#datetimepickertwo").on("dp.change", function (e) {
            jQuery('#datetimepickerone').data("DateTimePicker").maxDate(e.date);
        });
        jQuery('#txtFromDate').datetimepicker({
            format: 'YYYY-MM-DD',
            maxDate: moment()
        });
        jQuery('#txtToDate').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date(),
            maxDate: moment()
        });
        jQuery("#txtFromDate").on("dp.change", function (e) {
            jQuery('#txtToDate').data("DateTimePicker").minDate(e.date);
        });
        jQuery("#txtToDate").on("dp.change", function (e) {
            jQuery('#txtFromDate').data("DateTimePicker").maxDate(e.date);
        });
    }
    
    function getUserPosts() {
        jQuery('#getPostButtonId').click(function() {
            var from = jQuery('#txtFromDate').val();
            var to = jQuery('#txtToDate').val();
            if(from == '' || from == null) {
                jQuery('#dateError').show().html("Please select the from date...");
            }
            else if(to == '' || to == null) {
                jQuery('#dateError').show().html("Please select the to date...");
            }
            else {
                jQuery('#dateError').hide();
                var data = {
                    'action': 'show_user_posts',
                    'from': from,
                    'to': to
                };
            
                makeAjaxCall(data, showPostsofusers, message);
            }
        });
    }
    
    function showPostsofusers(data) {
        jQuery('#user-pages').hide();
        jQuery('#user-registered').hide();
        jQuery('#user-posts').show().html(data);
        jQuery('#userPosts').DataTable().destroy();
        jQuery('#userPosts').DataTable({
            "dom": '<"top">rt<"bottom" pl>',
            "language": {
                emptyTable: "There are no posts published during entered date periods."
            },
            "columnDefs": [ {
                "targets": [0,1,2,3],
                "orderable": false
            } ],
            "order": [[ 0, "asc" ]],
            "autoWidth": false,
            "scrollY": "400px",
            "scrollCollapse": true
        });
    }
    
    function getUserPages() {
        jQuery('#getPageButtonId').click(function() {
            var from = jQuery('#txtFromDate').val();
            var to = jQuery('#txtToDate').val();
            if(from == '' || from == null) {
                jQuery('#dateError').show().html("Please select the from date...");
            }
            else if(to == '' || to == null) {
                jQuery('#dateError').show().html("Please select the to date...");
            }
            else {
                jQuery('#dateError').hide();
                var data = {
                    'action': 'show_user_pages',
                    'from': from,
                    'to': to
                };
            
                makeAjaxCall(data, showPagesofusers, message);
            }
        });
    }
    
    function showPagesofusers(data) {
        jQuery('#user-posts').hide();
        jQuery('#user-registered').hide();
        jQuery('#user-pages').show().html(data);
        jQuery('#userPages').DataTable().destroy();
        jQuery('#userPages').DataTable({
            "dom": '<"top">rt<"bottom" pl>',
            "language": {
                emptyTable: "There are no pages published during entered date periods."
            },
            "columnDefs": [ {
                "targets": [0,1,2,3],
                "orderable": false
            } ],
            "order": [[ 0, "asc" ]],
            "autoWidth": false,
            "scrollY": "400px",
            "scrollCollapse": true
        });
    }
    
    function getUsersRegistered() {
        jQuery('#getUserButtonId').click(function() {
            var from = jQuery('#txtFromDate').val();
            var to = jQuery('#txtToDate').val();
            if(from == '' || from == null) {
                jQuery('#dateError').show().html("Please select the from date...");
            }
            else if(to == '' || to == null) {
                jQuery('#dateError').show().html("Please select the to date...");
            }
            else {
                jQuery('#dateError').hide();
                var data = {
                    'action': 'show_user_registered',
                    'from': from,
                    'to': to
                };
            
                makeAjaxCall(data, showRegisteredusers, message);
            }
        });
    }
    
    function showRegisteredusers(data) {
        jQuery('#user-posts').hide();
        jQuery('#user-pages').hide();
        jQuery('#user-registered').show().html(data);
        jQuery('#userRegistered').DataTable().destroy();
        jQuery('#userRegistered').DataTable({
            "dom": '<"top">rt<"bottom" pl>',
            "columnDefs": [ {
                "targets": [1,2,3,5,6],
                "orderable": false
            } ],
            "language": {
                'emptyTable': "There are no users registered during entered date periods."
            },
            "order": [[ 0, "asc" ]],
            "autoWidth": false,
            "scrollY": "400px",
            "scrollCollapse": true
        });
    }
    
    return {
       scriptStarter  : scriptStarter 
    };
    
})();

jQuery(CustomDashboardPage.scriptStarter);



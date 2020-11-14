<!DOCTYPE HTML>
<html>
    <head>
        <title>Job Portal</title>
<link rel="shortcut icon" type="image/x-icon" href="https://static.squarespace.com/universal/default-favicon.ico"/>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="keywords" content="Seeking Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

        <link href="/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="/css/jquery.tablesorter.pager.css">
        <link href="/css/style.css" rel='stylesheet' type='text/css' />
        <!--link rel="stylesheet" href="/fontawesome/css/all.css" /-->  
        <link rel="stylesheet" href="/css/theme.bootstrap.css">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

        <link href='//fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
        <!----font-Awesome----->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel='stylesheet' type='text/css' />
        <link href="/css/font-awesome.css" rel="stylesheet">     
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

        <!--link rel="icon" href="/images/core-img/favicon.ico">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"-->
        
        <script src="/js/jquery.min.js"></script>
        
        <script src="/js/bootstrap.min.js"></script>
        
        <!-- Custom Theme files -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
         
        <!----font-Awesome----->
        <!-- Tablesorter: required for bootstrap -->

        <script src="/js/jquery.tablesorter.js"></script>
        <script src="/js/jquery.tablesorter.widgets.js"></script>

        <!-- Tablesorter: optional -->

        <script src="/js/jquery.tablesorter.pager.js"></script>
        <script src="/js/all_js_function.js"></script>
        <style>


            .image {
                width:20px;
                display: block;
            }

            .hide_show:hover .text_email {
                visibility: visible;
                opacity: 1;
            }


            .text_email {
                position: absolute;  
                background: rgba(29, 106, 154, 0.72);
                color: #fff;
                visibility: hidden;
                opacity: 0;
                text-align: center;
                transition: opacity .2s, visibility .2s;

            }
            .visible {
                display:block;
            }

            .hidden {
                display:none;
            }
            .table td.fit, 
            .table th.fit {
                white-space: nowrap;
                width: 1%;
            }
        </style>
        <script id="js">$(function () {

                // NOTE: $.tablesorter.themes.bootstrap is ALREADY INCLUDED in the jquery.tablesorter.widgets.js
                // file; it is included here to show how you can modify the default classes
                $.tablesorter.themes.bootstrap = {
                    // these classes are added to the table. To see other table classes available,
                    // look here: http://getbootstrap.com/css/#tables
                    table: 'table table-bordered table-striped',
                    caption: 'caption',
                    // header class names
                    header: 'bootstrap-header', // give the header a gradient background (theme.bootstrap_2.css)
                    sortNone: '',
                    sortAsc: '',
                    sortDesc: '',
                    active: '', // applied when column is sorted
                    hover: '', // custom css required - a defined bootstrap style may not override other classes
                    // icon class names
                    icons: '', // add "bootstrap-icon-white" to make them white; this icon class is added to the <i> in the header
                    iconSortNone: 'bootstrap-icon-unsorted', // class name added to icon when column is not sorted
                    iconSortAsc: 'glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
                    iconSortDesc: 'glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
                    filterRow: '', // filter row class; use widgetOptions.filter_cssFilter for the input/select element
                    footerRow: '',
                    footerCells: '',
                    even: '', // even row zebra striping
                    odd: ''  // odd row zebra striping
                };


                // call the tablesorter plugin and apply the uitheme widget
                $("table").tablesorter({
                    // this will apply the bootstrap theme if "uitheme" widget is included
                    // the widgetOptions.uitheme is no longer required to be set
                    theme: "bootstrap",

                    widthFixed: true,

                    headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

                    // widget code contained in the jquery.tablesorter.widgets.js file
                    // use the zebra stripe widget if you plan on hiding any rows (filter widget)
                    widgets: ["uitheme", "filter", "columns", "zebra"],

                    widgetOptions: {
                        // using the default zebra striping class name, so it actually isn't included in the theme variable above
                        // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                        zebra: ["even", "odd"],

                        // class names added to columns when sorted
                        columns: ["primary", "secondary", "tertiary"],

                        // reset filters button
                        filter_reset: ".reset",

                        // extra css class name (string or array) added to the filter element (input or select)
                        filter_cssFilter: "form-control",

                        //resizable: true,
                        //resizable_widths : [ '10%', '10%', '40px', '10%', '100px' ]
                        // set the uitheme widget to use the bootstrap theme class names
                        // this is no longer required, if theme is set
                        // ,uitheme : "bootstrap"

                    }
                })
                        .tablesorterPager({

                            pageReset: 1,

                            // target the pager markup - see the HTML block below
                            container: $(".ts-pager"),

                            // target the pager page select dropdown - choose a page
                            cssGoto: ".pagenum",

                            // remove rows from the table to speed up the sort of large tables.
                            // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                            removeRows: false,

                            // output string - default is '{page}/{totalPages}';
                            // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                            //output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
                            // output: '{startRow:input} &ndash; {endRow} / {totalRows} total rows'
                            output: '{page}/{totalPages}'

                        });


            });</script>

        <script>
            $(function () {

                // filter button demo code
                $('button.filter').click(function () {
                    var col = $(this).data('column'),
                            txt = $(this).data('filter');
                    $('table').find('.tablesorter-filter').val('').eq(col).val(txt);
                    $('table').trigger('search', false);
                    return false;
                });

                // toggle zebra widget
                $('button.zebra').click(function () {
                    var t = $(this).hasClass('btn-success');
//			if (t) {
                    // removing classes applied by the zebra widget
                    // you shouldn't ever need to use this code, it is only for this demo
//				$('table').find('tr').removeClass('odd even');
//			}
                    $('table')
                            .toggleClass('table-striped')[0]
                            .config.widgets = (t) ? ["uitheme", "filter"] : ["uitheme", "filter", "zebra"];
                    $(this)
                            .toggleClass('btn-danger btn-success')
                            .find('i')
                            .toggleClass('glyphicon-ok glyphicon-remove').end()
                            .find('span')
                            .text(t ? 'disabled' : 'enabled');
                    $('table').trigger('refreshWidgets', [false]);
                    return false;
                });
            });
            $(document).ready(function () {
                $('table').trigger('pageAndSize', [1, 10]);
                

            });

        </script>


    </head>
 <?php if($_SESSION['user_type'] == 'User'){
	     if (isset($_SESSION['user_id'])) {
    $userdetails = $u->getUserDetails($_SESSION['user_id']);//print_r($userdetails);
    
    if(empty($userdetails[0]['resume_file_data'])){
    
  ?>  <body onload="alert('<?php echo 'Please Upload Resume First!' ?>')" onClose="sessionClose()">
  <?php  }else { ?>
	  
	 <body onClose="sessionClose()"> 
	  <?php }
  }}else { ?>
	  
	 <body onClose="sessionClose()"> 
	  <?php }
	  ?>
  <?php include_once ('menu.php'); ?>
 <?php if($_SESSION['user_type'] == 'User'){?>
   <form method="POST" action="jobs.php" id="configform">
        <div class="banner_1">
            <div class="container">
                <div id="search_wrapper1">
                    <div id="search_form" class="clearfix">
                        <h1>Start your job search</h1>
                        <p><input type="text" class="text" style="color:#fff;" name="keyword" placeholder=" " value="" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Enter Keyword(s)';}">
                            <input type="text" class="text" style="color:#fff;"  name="location" placeholder=" " value="" onfocus="this.value = '';" onblur="if (this.value == '') {
                                        this.value = 'Location';}">
                            <label class="btn2 btn-2 btn2-1b"><input type="submit" value="Find Jobs"></label>
                        </p>
                    </div>
                </div>
            </div> 
        </div>
</form>
<?php }?>

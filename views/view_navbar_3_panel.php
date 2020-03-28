<?php
/*
 * This view uses the following  PHP variables as content
 * 
 * First - get the content from the $data array which is provided by the controller:
 */
 $pageTitle =   $data['pageTitle'];  //title of the page
 $pageHeading = $data['pageHeading'];//page heading
 $menuNav   =   $data['menuNav'];    // an array of menu items and associated URLS
 $stringLHS =   $data['stringLHS'];  // A string intended of the Left Hand Side of the page
 $stringMID =    $data['stringMID'];  // A string intended of the Left Hand Side of the page
 $stringRHS =    $data['stringRHS']; // A string intended of the Right Hand Side of the page
 $panelHeadLHS=$data['panelHeadLHS'];// A string containing the LHS panel heading/title
 $panelHeadMID=$data['panelHeadMID'];// A string containing the MIDDLE panel heading/title
 $panelHeadRHS=$data['panelHeadRHS'];// A string containing the RHS panel heading/title
 /*
  * Then use these values to fill in the 'blank' content of the view
  * 
  */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pageTitle;?></title>

<!--
<!--
--Load the bootstrap scripts by reference
--Note the use of the 'integrity' property
--More info on that property here: https://blog.compass-security.com/2015/12/subresource-integrity-html-attribute/
-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>



<!--apply any local styles if required -->
<style type="text/css">
    body{
        padding-top: 70px;
    }
</style>
</head> 

<body>
<!--Main SECTION--> 
<section>
<!--Top of page Navigation menus-->    
<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><?php echo $pageHeading?></a>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
		<?php //foreach($menuNav as $menuItem){echo "<li>$menuItem</li>";} //populate the navbar menu items?>
                <?php echo $menuNav; ?>
            </ul>
        </div>
    </div>
</nav>


<!--Main container for page content-->  
<div class="container" >

     
<div class="row">
    <!--Left Hand Side (LHS) content panel--> 
    <div class="col-md-3" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHeadLHS; ?></div>
              <div class="panel-body">
                    <?php echo $stringLHS; ?>
              </div>
            </div>
    </div>
    <!--Middle section (MID)  content panel--> 
    <div class="col-md-6" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHeadMID; ?></div>
              <div class="panel-body">
                    <?php echo $stringMID; ?>
              </div>
            </div>
    </div>
    <!--Right Hand Side (RHS) content panel--> 
    <div class="col-md-3" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHeadRHS; ?></div>
              <div class="panel-body">
                    <?php echo $stringRHS; ?>
              </div>
            </div>
    </div>
</div>



</div>  <!--end of main container-->


</section>    


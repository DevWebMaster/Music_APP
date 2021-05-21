<!DOCTYPE html>
<html lang="en">
<head>
  <title>CIAS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
 <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
 
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>

<div class="container">

<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
    <li><a href="#">Link</a></li>
    <li><a href="#">Link</a></li>
  </ul>
  <p class="navbar-text">Some text</p>
</nav>


 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="<?php echo base_url(); ?>assets/images/slider/slider1.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="<?php echo base_url(); ?>assets/images/slider/slider2.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="<?php echo base_url(); ?>assets/images/slider/slider3.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>


<div id="portfolio" class="container-fluid text-center bg-grey">
  <h2>CHART ROOMS</h2><br>
  <h4>What we have created</h4>
  <div class="row text-center slideanim">
    <a data-toggle="modal" data-target="#loginmodal" href="#loginmodal">
      <div class="col-sm-4">
        <div class="thumbnail">
          <img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="Paris" width="400" height="300">
          <p><strong>ROOM1 Online(2/100)</strong></p>
          <p>welcome to home room enjoy your stay</p>
        </div>
      </div>
    </a>

    <a data-toggle="modal" data-target="#loginmodal" href="#loginmodal">
      <div class="col-sm-4">
        <div class="thumbnail">
          <img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="New York" width="400" height="300">
          <p><strong>ROOM2 Online(2/100)</strong></p>
          <p>welcome to home room enjoy your stay</p>
        </div>
      </div>
    </a>

    <a data-toggle="modal" data-target="#loginmodal" href="#loginmodal">
      <div class="col-sm-4">
        <div class="thumbnail">
          <img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="San Francisco" width="400" height="300">
          <p><strong>ROOM3 Online(2/100)</strong></p>
          <p>welcome to home room enjoy your stay</p>
        </div>
      </div>
    </a>
  </div><br>
       


   <!-- Modal Login-->
  <div class="modal fade" id="loginmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body">
          <a href="#registermodal" data-toggle="modal" data-target="#registermodal" data-dismiss="modal">CLICK HERE TO REGISTER</a>
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">USERNAME</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">PASSWORD</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
              </div>
            </div>
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label><input type="checkbox" name="remember"> GUEST LOGIN</label>
                  <label><input type="checkbox" name="remember"> REMEMBER ME</label>
                  <label><input type="checkbox" name="remember"> AUTO LOGIN ON NEXT VISIT</label>
                </div>
              </div>
            </div>
            
            <a href="#forgetmodal" data-toggle="modal" data-target="#forgetmodal" data-dismiss="modal">FORGOT PASSWORD</a><br>
            <p>TERMS AND CONDITIONS</p>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">LOGIN</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal-->

  <!-- Modal ForgetPassword-->
  <div class="modal fade" id="forgetmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">EMAIL OR USERNAME</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
              </div>
            </div>
         
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loginmodal" data-dismiss="modal">GO TO LOGIN</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">RETRIEVE PASSWORD</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal-->

  <!-- Modal Register-->
  <div class="modal fade" id="registermodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-2" for="username">USERNAME</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
              </div>
            </div>
           <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">PASSWORD</label>
                <div class="col-sm-10">          
                  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                </div>
              </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">EMAIL</label>
                <div class="col-sm-10">          
                  <input type="email" class="form-control" id="email" placeholder="Enter E-mail" name="email">
                </div>
              </div>
              
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loginmodal" data-dismiss="modal">GO TO LOGIN</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">REGISTER</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal-->


</div>

</body>
</html>
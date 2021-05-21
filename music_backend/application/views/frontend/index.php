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
<body >
<div class="container">

<div class="row" style="background-color: #f9fafa; height: 80px;padding-left: 5px; ">
	<b style="position: relative;top: 40%;">logo updatable form admin</b>
	<b style="float: right; position: relative;top: 40%;">ACTIVE ROOMS(1) - ALL ROOMS(10)-TOTAL USERS ONLINE:1</b>
</div>

<div class="row" style="margin-top: 2px;">

	<div class="col-md-6" style="padding:0;margin-top: 15px;cursor: pointer;" data-toggle="modal" data-target="#loginmodal">
		<div style="width: 98%;height: 98%">
			<img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="San Francisco" style="width: 100%;height: 100%; position: relative;">
			<div style="background: #000;color: #fff;padding: 15px; top: 0px;right:  2%; position: absolute;opacity: 0.5;">JOIN ROOM</div>
			<div style="background: #000;color: #fff;padding: 15px; bottom: 0px;width: 98%; position: absolute; opacity: 0.5; height: 30%;">
				<b style="font-size: 20px;">ROOM-HOME</b>
				<b style="font-size: 20px; float: right;">Online(2/100)</b>
				<p style="padding-top: 10px;"><b>welcome to home room enjoy your stay</b></p>
			</div>
		</div>
	</div>

	<div class="col-md-6" style="padding:0;margin-top: 15px;cursor: pointer;" data-toggle="modal" data-target="#loginmodal">
		<div style="width: 98%;height: 98%;margin-left: 2%;">
			<img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="San Francisco" style="width: 100%;height: 100%; position: relative;">
			<div style="background: #000;color: #fff;padding: 15px; top: 0px;right:  2%; position: absolute;opacity: 0.5;">JOIN ROOM</div>
			<div style="background: #000;color: #fff;padding: 15px; bottom: 0px;width: 98%; position: absolute; opacity: 0.5; height: 30%;">
				<b style="font-size: 20px;">ROOM-HOME</b>
				<b style="font-size: 20px; float: right;">Online(2/100)</b>
				<p style="padding-top: 10px;"><b>welcome to home room enjoy your stay</b></p>
			</div>
		</div>
	</div>

</div>

<div class="row" style="margin-top: 2px;">

	<div class="col-md-6" style="padding:0;margin-top: 15px;cursor: pointer;" data-toggle="modal" data-target="#loginmodal">
		<div style="width: 98%;height: 98%">
			<img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="San Francisco" style="width: 100%;height: 100%; position: relative;">
			<div style="background: #000;color: #fff;padding: 15px; top: 0px;right:  2%; position: absolute;opacity: 0.5;">JOIN ROOM</div>
			<div style="background: #000;color: #fff;padding: 15px; bottom: 0px;width: 98%; position: absolute; opacity: 0.5; height: 30%;">
				<b style="font-size: 20px;">ROOM-HOME</b>
				<b style="font-size: 20px; float: right;">Online(2/100)</b>
				<p style="padding-top: 10px;"><b>welcome to home room enjoy your stay</b></p>
			</div>
		</div>
	</div>

	<div class="col-md-6" style="padding:0;margin-top: 15px;cursor: pointer;" data-toggle="modal" data-target="#loginmodal">
		<div style="width: 98%;height: 98%;margin-left: 2%;">
			<img src="<?php echo base_url(); ?>assets/images/room.jpg" alt="San Francisco" style="width: 100%;height: 100%; position: relative;">
			<div style="background: #000;color: #fff;padding: 15px; top: 0px;right:  2%; position: absolute;opacity: 0.5;">JOIN ROOM</div>
			<div style="background: #000;color: #fff;padding: 15px; bottom: 0px;width: 98%; position: absolute; opacity: 0.5; height: 30%;">
				<b style="font-size: 20px;">ROOM-HOME</b>
				<b style="font-size: 20px; float: right;">Online(2/100)</b>
				<p style="padding-top: 10px;"><b>welcome to home room enjoy your stay</b></p>
			</div>
		</div>
	</div>

</div>
	

	  <!-- Modal Login-->
  <div class="modal fade" id="loginmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #4a4a4a;color: #fff;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body">
          <p  data-toggle="modal" data-target="#registermodal" data-dismiss="modal" style="text-align: center;cursor: pointer;font-size: 20px;margin-bottom: 20px;"><b style="width: 60%;background-color: #fff568;padding: 15px;">CLICK HERE TO REGISTER</b></p>
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-5" for="email" style="font-size: 20px;">USERNAME</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" style="border-color: #000;border-radius: 0px;height: 40px;">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-5" for="pwd" style="font-size: 20px;">PASSWORD</label>
              <div class="col-sm-5">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" style="border-color: #000;border-radius: 0px;height: 40px;">
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
            <p style="text-align: center;"><button type="button" class="btn btn-default" data-dismiss="modal" style="width: 50%;background-color: #dfdfdf;font-size: 20px;">LOGIN</button></p>
            <p data-toggle="modal" data-target="#forgetmodal" data-dismiss="modal" style="text-align: center;cursor: pointer;font-size: 20px;"><b>FORGOT PASSWORD</b></p>
            <p style="text-align: center;">TERMS AND CONDITIONS</p>
          </form>
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
        <div class="modal-header" style="background-color: #4a4a4a;color: #fff;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body" style="padding-top: 10%;">
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-5" for="emailandusername" style="font-size: 20px;">EMAIL OR USERNAME</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" style="border-color: #000;border-radius: 0px;height: 40px;">
              </div>
            </div>
         	<p style="text-align: center;margin-top:10%;margin-bottom: 10%;">
         		<button type="button" class="btn btn-default" data-dismiss="modal" style="width: 50%;background-color: #dfdfdf;font-size: 20px;">RETRIEVE PASSWORD</button>
         	</p>
          </form>
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
        <div class="modal-header" style="background-color: #4a4a4a;color: #fff;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">LOGIN OR REGISTER</h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal" action="/action_page.php">
            <div class="form-group">
              <label class="control-label col-sm-5" for="username" style="font-size: 20px;">USERNAME</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" style="border-color: #000;border-radius: 0px;height: 40px;">
              </div>
            </div>
           <div class="form-group">
                <label class="control-label col-sm-5" for="pwd" style="font-size: 20px;">PASSWORD</label>
                <div class="col-sm-5">          
                  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" style="border-color: #000;border-radius: 0px;height: 40px;">
                </div>
              </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="email" style="font-size: 20px;">EMAIL</label>
                <div class="col-sm-5">          
                  <input type="email" class="form-control" id="email" placeholder="Enter E-mail" name="email" style="border-color: #000;border-radius: 0px;height: 40px;">
                </div>
              </div>

              <p style="text-align: center;margin-top:10%;margin-bottom: 10%;">
               <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 50%;background-color: #dfdfdf;font-size: 20px;">REGISTER</button>
              </p>
              <p style="text-align: center;">TERMS AND CONDITIONS</p>
          </form>
        </div>
        
      </div>
      
    </div>
  </div>
  <!--Modal-->

</div>

</body>
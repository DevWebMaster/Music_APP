<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i>Add New Sync4
      </h1>
    </section>

    <section class="content">
        <div class="row">
           <div class="col-md-8">
           		<div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Sync4 Details</h3>
                    </div><!-- /.box-header -->

                     <form role="form" id="addSampleSet" action="<?php echo base_url() ?>index.php/addnewsync4_b" method="post" role="form" enctype='multipart/form-data'>

                     	 <div class="box-body">
                     	  <div class="row">
                     	 	
								<div class="col-md-12">
	                                <div class="form-group">
	                                    <label for="fname">Name</label>
	                                    <input type="text" class="form-control required" id="sname" name="sname" maxlength="256">
	                                </div>
	                            </div>

	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="fname">Description</label>
	                                    <textarea class="form-control required" id="sdescription" name="sdescription"></textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="sfree" style="float: left;"><span>Free</span></label>
                                        <div style="float: left;padding-left: 10px;padding-top: 0px;">
	                                       <input type="checkbox" class="" id="sfree" name="sfree">
                                        </div>
	                                </div>
	                            </div>
                                <br>
	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="fname">Price</label>
	                                    <input type="Number" class="form-control" id="sprice" name="sprice" value="0">
	                                </div>
	                            </div>

                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">BPM</label>
                                        <input type="Number" class="form-control" id="bpm" name="bpm" value="0" min="0">
                                    </div>
                                </div>

                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        
                                        <input type="file" class="" id="thumb" name="thumbimg" style="display: inline;" accept="image/*">
                                        <img src="<?=base_url()?>assets/thumbimages/no_img.png" id="thubpreview" style="width: 100px;">
                                    </div>
                                </div>
                     	 </div>
                     	 <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Add" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                     </form>

                </div>
           </div> 
        </div>
	</section>
</div>

<script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>

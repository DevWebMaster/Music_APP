<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i>Edit Sync8
      </h1>
    </section>

    <section class="content">
        <div class="row">
           <div class="col-md-8">
           		<div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Sync8 Details</h3>
                    </div><!-- /.box-header -->

                     <form id="addSampleSet" action="<?php echo base_url() ?>index.php/updatesync8_b" method="post" role="form" enctype='multipart/form-data'>
                     <input type="hidden" name="sid" value="<?=$sample[0]['id']?>" id="sid">
                     	 <div class="box-body">
                     	  <div class="row">
                     	 	
								          <div class="col-md-12">
	                                <div class="form-group">
	                                    <label for="fname">Name</label>
	                                    <input type="text" class="form-control required" id="sname" name="sname" maxlength="256" value="<?=$sample[0]['name']?>">
	                                </div>
	                            </div>

	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="fname">Description</label>
	                                    <textarea class="form-control required" id="sdescription" name="sdescription"><?=$sample[0]['description']?></textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="fname">Free</label>
	                                    <input type="checkbox" class="" id="sfree" name="sfree" <?php echo $sample[0]['is_free']=='yes'?'checked':'';?>>
	                                </div>
	                            </div>

	                            <div class="col-md-12">                                
	                                <div class="form-group">
	                                    <label for="fname">Price</label>
	                                    <input type="Number" class="form-control required" id="sprice" name="sprice" value="<?=$sample[0]['price']?>" <?php echo $sample[0]['is_free']=='yes'?'disabled':'';?>>
	                                </div>
	                            </div>

                              <div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="fname">BPM</label>
                                    <input type="Number" class="form-control" id="bpm" name="bpm" value="<?=$sample[0]['bpm']?>" min="0">
                                </div>
                              </div>
                              <?php 
                               $thumimage_url = $sample[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$sample[0]['thumb'];
                              ?>
                              <div class="col-md-12">                                
                                    <div class="form-group">
                                        <input type="file" class="" id="thumb" name="thumbimg" style="display: inline;"  accept="image/*">
                                        <img src="<?=$thumimage_url?>" id="thubpreview" style="width: 100px;">
                                        <p>*Image size must be 2048x768 pixel.</p>
                                    </div>
                                </div>
                     	 </div>
                     	 <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                     </form>

                </div>

           </div> 


        </div>


         


    <script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>
  </section>
</div>


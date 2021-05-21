<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i>Add New Sample Set
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Sample Details</h3>
                    </div><!-- /.box-header -->

                    <form role="form" id="addSampleSet" action="<?php echo base_url() ?>index.php/addnewsampleset_b" method="post" role="form" enctype='multipart/form-data'>

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

                                <div class="col-md-12 options-box">
                                    <label>Options</label><br/>
                                    <div class="form-group">
                                        <input type="radio" id="construction-mode" name="option" value="construction" checked>
                                        <label for="construction-mode">Construction State</label>

                                        <div class="construction-mode-setting option-setting">
                                            <label for="master-code">Master Code</label>
                                            <input type="text" id="master-code" name="master_code" value="" disabled>
                                            <i class="fa fa-refresh hidden" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="demo-state" name="option" value="demo">
                                        <label for="gotit">Demo State</label>

                                        <div class="demo-mode-setting option-setting">
                                            <label for="demo-link">Demo Link</label>
                                            <input type="text" id="demo-link" name="demo_link" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="buy-state" name="option" value="buy">
                                        <label for="not-right-now">Buy State</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Next" />
                                <input type="reset" class="btn btn-default" value="Reset" />
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>

<script type="text/javascript">
    $(".options-box input[type = 'radio']").click(function () {
        $.each($(".options-box .option-setting"), function (index, ele) {
            $(this).hide();
            $(this).find('input').prop('disabled');
        });

        $(this).siblings(".option-setting").show();
        $(this).siblings(".option-setting").find('input').prop('disabled', false);
    });
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i>Edit Sample Set
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Sample Details</h3>
                    </div><!-- /.box-header -->

                    <form role="form" id="addSampleSet" action="<?php echo base_url() ?>index.php/updatesampleset_b" method="post" role="form" enctype='multipart/form-data'>
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
                                        <label for="fname">Shift Pitch</label>
                                        <input type="Number" class="form-control required" id="sprice" name="sprice" value="<?=$sample[0]['price']?>" <?php echo $sample[0]['is_free']=='yes'?'disabled':'';?>>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fname">BPM</label>
                                        <input type="Number" class="form-control" id="bpm" name="bpm" value="<?=$sample[0]['bpm']?>" min="0">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fname">Left Sync4</label>
                                        <select class="form-control" name='sync4'>
                                            <option value="0" <?php echo $sample[0]['sync4'] == "0"?  "selected" : ""?>>No Selected Sync4</option>
                                            <?php
                                            foreach ($sync4s as $sync4)
                                            {
                                                $checked_str = $sample[0]['sync4'] == $sync4['id']?  "selected" : "";
                                                $thum_url = $sync4['thumb'] == "" ? base_url()."assets/thumbimages/no_img.png" : base_url()."assets/thumbimages/". $sync4['thumb'];
                                                echo "<option ".$checked_str." value='".$sync4['id']."'>".$sync4['name']."</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fname">Right Sync4</label>
                                        <select class="form-control" name='sync4_2'>
                                            <option value="0" <?php echo $sample[0]['sync4_2'] == "0"?  "selected" : ""?>>No Selected Sync4</option>
                                            <?php
                                            foreach ($sync4s as $sync4_2)
                                            {
                                                $checked_str = $sample[0]['sync4_2'] == $sync4_2['id']?  "selected" : "";
                                                $thum_url = $sync4_2['thumb'] == "" ? base_url()."assets/thumbimages/no_img.png" : base_url()."assets/thumbimages/". $sync4_2['thumb'];
                                                echo "<option ".$checked_str." value='".$sync4_2['id']."'>".$sync4_2['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                $thumimage_url = $sample[0]['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$sample[0]['thumb'];
                                ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="thumb">Collection Image (2048 x 768)</label>
                                        <input type="file" class="" id="thumb" name="thumbimg" style="display: inline;"  accept="image/*">
                                        <img src="<?=$thumimage_url?>" id="thubpreview" style="width: 100px;">
                                    </div>
                                </div>

                                <div class="col-md-12 options-box">
                                    <label>Options</label><br/>
                                    <div class="form-group">
                                        <input type="radio" id="construction-mode" name="option" value="construction"
                                            <?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "construction")) ? "checked":''; ?> >
                                        <label for="construction-mode">Construction State</label>

                                        <div class="construction-mode-setting option-setting">
                                            <label for="master-code">Master Code</label>
                                            <input type="text" id="master-code" name="master_code" value="<?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "construction")) ? $sample[0]['option_value']:''; ?>" <?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "construction")) ? '':'disabled'; ?>>
                                            <i class="fa fa-refresh hidden" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="demo-state" name="option" value="demo"
                                            <?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "demo")) ? "checked":''; ?> >
                                        <label for="gotit">Demo State</label>

                                        <div class="demo-mode-setting option-setting">
                                            <label for="demo-link">Demo Link</label>
                                            <input type="text" id="demo-link" name="demo_link" value="<?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "demo")) ? $sample[0]['option_value']:''; ?>" <?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "demo")) ? '':'disabled'; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="buy-state" name="option" value="buy"
                                            <?php echo (!isset($sample[0]) || (isset($sample[0]) && $sample[0]['option'] == "buy")) ? "checked":''; ?> >
                                        <label for="not-right-now">Buy State</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Update" />
                                <input type="reset" class="btn btn-default" value="Reset" />
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <?php
            $order_short = $sample[0]['order_short'];
            $order_short = explode(",", $order_short);
            $order_long = $sample[0]['order_long'];
            $order_long = explode(",", $order_long);
            ?>
            <div class="col-md-8">
                <div class="change-short-long" style="padding-left: 50px;">
                    <button class="btn btn-success switch-short-btn">Short</button>
                    <button class="btn btn-default switch-long-btn">Long</button>
                </div>
                <div class="short-panel row">

                    <div class="col-md-6">
                        <ul class="ul-drag">
                            <li class="ui-state-highlight draggable-short" predmet-id="1">Item 1<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="2">Item 2<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="3">Item 3<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="4">Item 4<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="5">Item 5<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="6">Item 6<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="7">Item 7<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="8">Item 8<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-short" predmet-id="9">Item 9<span class="drag-del">Delete</span></li>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Update Sample Sequence(Short)</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <ul id="short-seq" class="sortable">
                                    <?php foreach($order_short as $key_no):?>
                                        <li class="ui-state-default" predmet-id="<?=$key_no?>">Item <?=$key_no?><span class="drag-del">Delete</span></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div class="box-footer">
                                <input type="button" class="btn btn-primary short-change-btn" value="Change" />
                                <input type="button" class="btn btn-default sort-seq-undo" value="Reset" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hide long-panel row">
                    <div class="col-md-6">
                        <ul class="ul-drag">
                            <li class="ui-state-highlight draggable-long" predmet-id="10">Item 10<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="11">Item 11<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="12">Item 12<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="13">Item 13<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="14">Item 14<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="15">Item 15<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="16">Item 16<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="17">Item 17<span class="drag-del">Delete</span></li>
                            <li class="ui-state-highlight draggable-long" predmet-id="18">Item 18<span class="drag-del">Delete</span><span class="drag-del">Delete</span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Update Sample Sequence(Long)</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <ul id="long-seq" class="sortable">
                                    <?php foreach($order_long as $key_no):?>
                                        <li class="ui-state-default" predmet-id="<?=$key_no?>">Item <?=$key_no?><span class="drag-del">Delete</span></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary long-change-btn" value="Change" />
                                <input type="reset" class="btn btn-default sort-seq-undo" value="Reset" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>
<style type="text/css">
    .sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }
    .sortable li,.draggable-short, .draggable-long {
        margin: 0 3px 3px 3px;
        padding: 0.4em;
        padding-left: 1.5em;
        font-size: 1.4em;
        cursor: pointer;
        border: 1px solid #c5c5c5;
        background: #f6f6f6;
        font-weight: normal;
        color: #454545;
        list-style: none;
    }

    #long-seq .drag-del, #short-seq .drag-del{
        float: right;
        font-size: 15px;
        color: #3c8dbc;
        text-transform: uppercase;
        visibility: visible;
    }

    .ul-drag .drag-del{
        visibility: hidden;
    }

</style>

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

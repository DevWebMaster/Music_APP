<?php
/**
 * Created by PhpStorm.
 * User: CStar
 * Date: 1/20/2018
 * Time: 7:01 AM
 */

$rows = array();
$i = 0;
foreach ($images as $image) {
    $rows[$image['index_num']] = $image;
    $i++;
}

$j = 0;
$new_array = array();
$next = 0;
while ($j < count($rows)) {
    if ($j == 0) {
        $new_array[] = $rows[$j];
        $next = $rows[$j]['id'];
        $j++;
        continue;
    }

    $new_array[] = $rows[$next];
    $next = $rows[$next]['id'];
    $j++;
}

$count = count($new_array);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i> Image List
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">

                <div class="form-group">
                    <a href="<?=base_url()?>index.php/sample-sets-list" class="tab-kind-triggers">Triggerz Multi</a>
                    <a href="<?=base_url()?>index.php/sync4-lists" class="tab-kind-triggers">Triggerz Sync4</a>
                    <a href="<?=base_url()?>index.php/sync8-lists" class="tab-kind-triggers">Triggerz Sync8</a>
                    <a href="<?=base_url()?>index.php/images" class="tab-kind-triggers tab-kind-triggers-active">Images</a>
                    <a class="btn btn-primary add-image" href="javascript:;"><i class="fa fa-plus"></i> Add New
                        Image</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 row">
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Image List</h3>
                            <div class="box-tools">
                                <form action="<?php echo base_url() ?>index.php/searchsample" method="POST" id="searchList">
                                    <div class="input-group">
                                        <input type="text" name="searchText" value="<?=$search?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="image-list" class="image-list">
                                <?php if ($count > 0): ?>
                                    <ul id="sortable">
                                        <?php $i = 0; ?>
                                        <?php foreach($new_array as $row): ?>
                                            <li class="element ui-state-default" data-image-id="<?php echo $row['id'] ?>" data-index="<?php echo $i+1; ?>">
                                                <img src="<?php echo base_url('assets') ?>/upload_images/<?php echo $row['path'] ?>">
                                                <div class="right-box">
                                                    <label>Link : </label><br/>
                                                    <input type="text" name="link_<?php echo $row['id'] ?>" value="<?php echo $row['link'] ?> ">
                                                    <button class="btn save" data-link-id="<?php echo $row['id'] ?>">Save</button>
                                                    <button class="btn remove" data-image-id="<?php echo $row['id'] ?>">Remove</button>
                                                </div>

                                                <?php $i++ ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Response Options</h3>
                        </div>
                        <div class="box-body">
                            <form class="form" action="<?php echo base_url("index.php/saveResponse") ?>" method="post">
                                <div class="">
                                    <label>Title : </label>
                                    <input type="text" name="response_title" value="<?php echo (isset($response[0])) ?
                                    $response[0]['title']:''; ?>">
                                    <br>
                                </div>

                                <div class="response_type">
                                    <label>Response Type</label><br/>
                                    <select name="response_type" class="response-type-selector">
                                        <option value="single" <?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['response_type'] == "single")) ? "selected":''; ?>>Single Response</option>
                                        <option value="dual" <?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['response_type'] == "dual")) ? "selected":''; ?>>Dual Response</option>
                                    </select>
                                </div>

                                <div class="">
                                    <label>Message : </label>
                                    <textarea name="response_message"><?php echo (isset($response[0])) ? $response[0]['message']:''; ?></textarea>
                                    <br>
                                </div>

                                <div class="single-response-option <?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['response_type'] == "single")) ? "":'hidden'; ?>">
                                    <div class="form-group">
                                        <label>Button Label</label><input type="text" name="single_button_label" value="<?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['single_button_label'])) ? $response[0]['single_button_label']:''; ?>">
                                    </div>
                                </div>

                                <div class="dual-response-options <?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['response_type'] == "dual")) ? "":'hidden'; ?>">
                                    <div class="form-group">
                                        <label>Yes Button Label</label><input type="text" name="yes_button_label" value="<?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['yes_button_label'])) ? $response[0]['yes_button_label']:'Yes'; ?>">
                                        <label>Button Link</label><input type="text" name="dual_link" value="<?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['dual_link'])) ? $response[0]['dual_link']:''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>No Button Label</label><input type="text" name="no_button_label" value="<?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['no_button_label'])) ? $response[0]['no_button_label']:'No'; ?>">
                                    </div>
                                </div>

                                <div class="options-box hidden">
                                    <label>Options</label><br/>
                                    <div class="">
                                        <input type="radio" id="dopeness" name="response_option" value="dopeness"
                                            <?php echo (!isset($response[0]) || (isset($response[0]) && $response[0]['option'] == "dopeness")) ? "checked":''; ?> >
                                        <label for="dopeness">Dopeness!</label>
                                    </div>
                                    <div class="">
                                        <input type="radio" id="gotit" name="response_option" value="gotit" <?php echo (isset($response[0]) && $response[0]['option'] == "gotit") ? "checked":''; ?> >
                                        <label for="gotit">Got it</label>
                                    </div>
                                    <div class="">
                                        <input type="radio" id="not-right-now" name="response_option" value="seeit" <?php echo (isset($response[0]) && $response[0]['option'] == "seeit") ? "checked":''; ?> >
                                        <label for="not-right-now">Not right now,  Let’s see it!</label>
                                    </div>
                                </div>
                                <div class="hidden">
                                    <label>Link : </label>
                                    <input type="text" name="response_link" value="<?php echo (isset($response[0])) ?
                                        $response[0]['link']:''; ?>">
                                </div>

                                <div class="actions">
                                    <button  class="btn btn-primary save-response-option">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="deletemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/delete-image" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Sync4</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sync4-no" id="sample-id-hidden">
                    <h2>Confirm Delete</h2>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="addmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url('index.php/saveImage')?>" method="post" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Image</h4>
                </div>
                <div class="modal-body">
                    <label>Image Size Should Be Less Than 100KB.</label>
                    <label>The dimension of image must be 2048x768</label>

                    <div id="filediv">
                        <input type="file" name="file" id="file"/><br/>
                        <lable>Link : </lable><input type="text" name="links" id="link" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    #image-list {
        width: 60%;
        float: left;
    }
    #formdiv{
        width:35%;
        float:left;
        text-align:center;
        margin: auto;
    }
    .abcd img{
        height:100px;
        max-width: 300px;
        padding:5px;
        border:1px solid #e8debd
    }
    .upload{
        background-color:red;
        border:1px solid red;
        color:#fff;
        border-radius:5px;
        padding:10px;
        text-shadow:1px 1px 0 green;
        box-shadow:2px 2px 15px rgba(0,0,0,.75)
    }
    .upload:hover{
        cursor:pointer;
        background:#c20b0b;
        border:1px solid #c20b0b;
        box-shadow:0 0 5px rgba(0,0,0,.75)
    }
    #file{
        color:green;
        padding:5px;
        border:1px dashed #123456;
        background-color:#f9ffe5
    }
    #upload{
        margin-left:45px
    }
    #noerror{
        color:green;
        text-align:left
    }
    #error{
        color:red;
        text-align:left
    }
    #img{
        width:17px;
        border:none;
        height:17px;
        margin-left:-20px;
        margin-bottom:91px
    }

    #sortable { list-style-type: none; margin: 0; padding: 0;}
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; font-size: 1.4em; }
    #sortable li img { max-width: 300px; }
    #sortable li .right-box { max-width: 240px; display: inline-block;}
    #sortable li .right-box input { width: 100%; line-height: 1.5em; display: inline-block;}
    #sortable li .right-box .save {background: green; padding: 10px 20px; margin-right: 30px; border: 0; color: #ffffff;}
    #sortable li .right-box .remove {background: red; padding: 10px 20px; border: 0; color: #ffffff;}
    .options-box {display: inline-block; margin: 20px 0;}
    .options-box div {padding-left: 20px;}
    .save-response-option {float: right;}
</style>

<script type="text/javascript">
    var abc = 0;      // Declaring and defining global increment variable.
    $(document).ready(function () {
        $( "#sortable" ).sortable({
            update: function (ev, ui) {
                var id = $(ui.item).data('image-id');
                var left_sibling_id = $(ui.item).prev().data('image-id');
                var right_sibling_id = $(ui.item).next().data('image-id');

                // if left_sibling_id is undefined, must be next to home page
                if (!left_sibling_id) {
                    left_sibling_id = 'parent';
                }

                if (left_sibling_id) {
                    $.post('<?php echo base_url('index.php/update-index') ?>', {
                            id: id,
                            left_sibling_id: left_sibling_id,
                            right_sibling_id: right_sibling_id
                        },
                        function (data) {
                            console.log('drag');
                        }
                    );
                }
            }
        });

        $('.remove').on('click', function (ele) {
            var imageId = $(this).attr('data-image-id');
            $.post('<?php echo base_url("index.php/delete-image") ?>', {image: imageId, type: 'delete'}, function (data) {
                if (JSON.parse(data).status == 'success') {
                    $('#sortable li').each(function (i, ele) {
                        if ($(this).attr('data-image-id') == JSON.parse(data).image) {
                            $(this).hide();
                        }
                    });
                }
            });
        });

        $('.save').on('click', function (ele) {
            var linkId = $(this).attr('data-link-id');
            $.post('<?php echo base_url("index.php/update-title") ?>', {'link-id': linkId, 'link-text': $(this).parent().find
            ('input').val(), type:
            'save'},
                function (data) {
                if (JSON.parse(data).status == 'success') {
                    console.log(JSON.parse(data).link);
                }
            });
        });

        $( "#sortable" ).disableSelection();

        //  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
        $('#add_more').click(function() {
            $(this).before($("<div/>", {
                id: 'filediv'
            }).fadeIn('slow').append($("<input/>", {
                name: 'file[]',
                type: 'file',
                id: 'file'
            }), $('<br/><label>Link : </label>'),  $("<input/>", {
                name: 'links[]',
                type: 'text',
                id: 'link'
            }), $("<br/><br/>")));
        });

        $('#upload').click(function(e) {
            var name = $(":file").val();
            if (!name) {
                alert("First Image Must Be Selected");
                e.preventDefault();
            }
        });

        // Following function will executes on change event of file input to select different file.
        $('body').on('change', '#file', function() {
            if (this.files && this.files[0]) {
                abc += 1; // Incrementing global variable by 1.
                var z = abc - 1;
                var x = $(this).parent().find('#previewimg' + z).remove();
                $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $(this).hide();
                $("#abcd" + abc).append($("<img/>", {
                    id: 'img',
                    src: 'x.png',
                    alt: 'delete'
                }).click(function() {
                    $(this).parent().parent().remove();
                }));
            }
        });
        // To Preview Image
        function imageIsLoaded(e) {
            $('#previewimg' + abc).attr('src', e.target.result);
        };

        $(".add-image").click(function(){
            $("#addmodal").modal('show');
        });

        $('.response-type-selector').change(function () {
            if ($(this).val() == 'single') {
                $('.single-response-option').removeClass('hidden');
                $('.dual-response-options').addClass('hidden');
                $('.dual-response-options input').prop('disabled');
            }
            if ($(this).val() == 'dual') {
                $('.single-response-option').addClass('hidden');
                $('.dual-response-options').removeClass('hidden');
                $('.dual-response-options input').prop('disabled', false);
            }
        });
    });
</script>

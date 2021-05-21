<?php
function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i>Edit Sync4
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Sync4 Details</h3>
                    </div><!-- /.box-header -->

                    <form id="addSampleSet" action="<?php echo base_url() ?>index.php/updatesync4_b" method="post" role="form" enctype='multipart/form-data'>
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


        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Update Sync4 Music Files</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-hover sync4-item-files">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Listen</th>
                            <th>Actions</th>

                        </tr>
                        <?php
                        for($i=1;$i<=5;$i++)
                        {
                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td class="sync4-cell-name" style="cursor: pointer;text-decoration: underline;"
                                    data-music-no="<?=$i?>"><?php echo $sample[0]['music_title_'.$i]?$sample[0]['music_title_'.$i]:"No Title" ?></td>
                                <td>
                                    <div class="music-file">
                                        <label><span>Music : </span></label>
                                        <?php
                                        if($sample[0]['music_'.$i] == null || $sample[0]['music_'.$i] == "" || !file_exists(FCPATH.'assets/sync4-musicfiles/'.$sample[0]['music_'.$i]))
                                        {
                                            echo "No Music File";
                                        }
                                        else{
                                            ?>
                                            <audio controls="">
                                                <source src="<?=base_url()?>assets/sync4-musicfiles/<?=$sample[0]['music_'.$i]?>?<?=generateRandomString()?>" type="audio/ogg">
                                            </audio>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="drum-file">
                                        <label><span>Drum : </span></label>
                                        <?php
                                        if($sample[0]['drum_'.$i] == null || $sample[0]['drum_'.$i] == "" || !file_exists(FCPATH.'assets/sync4-drumfiles/'.$sample[0]['drum_'.$i]))
                                        {
                                            echo "No Drum File";
                                        }
                                        else{
                                            ?>
                                            <audio controls="">
                                                <source src="<?=base_url()?>assets/sync4-drumfiles/<?=$sample[0]['drum_'.$i]?>?<?=generateRandomString()?>" type="audio/ogg">
                                            </audio>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="music-edit">
                                        <span class="btn btn-sm btn-success edit-music-file" alt="edit sample" data-music-no="<?=$i?>"><i class="fa fa-pencil"></i></span>
                                        <?php
                                        if($sample[0]['music_'.$i] == null || $sample[0]['music_'.$i] == "" || !file_exists(FCPATH.'assets/sync4-musicfiles/'.$sample[0]['music_'.$i]))
                                        {
                                            echo '<span class="btn btn-sm btn-danger remove-sample-btn" alt="delete sample" disabled><i class="fa fa-trash"></i></span>';
                                        }
                                        else{
                                            echo '<span class="btn btn-sm btn-danger remove-sample-btn" alt="delete sample" data-music-no="'.$i.'"><i class="fa fa-trash"></i></span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="drum-edit">
                                        <span class="btn btn-sm btn-success edit-drum-file" alt="edit sample"
                                              data-drum-no="<?=$i?>"><i class="fa fa-pencil"></i></span>
                                        <?php
                                        if($sample[0]['drum_'.$i] == null || $sample[0]['drum_'.$i] == "" || !file_exists(FCPATH.'assets/sync4-drumfiles/'.$sample[0]['drum_'.$i]))
                                        {
                                            echo '<span class="btn btn-sm btn-danger remove-drum-btn" alt="delete sample" disabled><i class="fa fa-trash"></i></span>';
                                        }
                                        else{
                                            echo '<span class="btn btn-sm btn-danger remove-drum-btn" alt="delete sample" data-drum-no="'.$i.'"><i class="fa fa-trash"></i></span>';
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                    <form action="<?=base_url()?>index.php/sync4-upload-music" role="form" enctype='multipart/form-data' id='sync4-upload-form' method="post" style="display: none;">
                        <input type="hidden" name="sync4-id" id="sync4-id" value="<?=$sample[0]['id']?>">
                        <input type="hidden" name="sync4-music-no" id="sync4-music-no">
                        <input type="file" name="sync4-music-file" id="sync4-music-file" accept="audio/*">

                        <input type="hidden" name="sync4-drum-no" id="sync4-drum-no">
                        <input type="file" name="sync4-drum-file" id="sync4-drum-file" accept="audio/*">
                    </form>
                </div>
            </div>
        </div>


        <script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>
    </section>
</div>


<div id="deletemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/deletesync4musicfile" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Sync4 Music File</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sync4-music-no" id="sample-id-hidden">
                    <input type="hidden" name="sync4-id" value="<?=$sample[0]['id']?>">
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

<div id="deleteDrumModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/deletesync4musicfile" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Sync4 Drum File</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sync4-drum-no" id="drum-id-hidden">
                    <input type="hidden" name="sync4-id" value="<?=$sample[0]['id']?>">
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

<div id="editmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/editsync4musicname" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Sync4 Music Name</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sync4-music-no" id="sync4-music-edit-no">
                    <input class="form-control" type="text" name="sync4-music-name" id="sync4-music-edit-val"
                           required="" placeholder="Please Input Sync4 Music Name">
                    <input type="hidden" name="sync4-id" value="<?=$sample[0]['id']?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Change</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(".edit-music-file").click(function(){
        //alert($(this).data("music-no"));
        $("#sync4-upload-form").closest('form').get(0).reset();
        $("#sync4-music-no").val($(this).data("music-no"));
        $("#sync4-music-file").trigger('click');
    });

    $(".edit-drum-file").click(function(){
        //alert($(this).data("music-no"));
        $("#sync4-upload-form").closest('form').get(0).reset();
        $("#sync4-drum-no").val($(this).data("drum-no"));
        $("#sync4-drum-file").trigger('click');
    });

    $("#sync4-music-file").change(function(){
        if(!this.files[0]){
            //alert("file no selected");
            return;
        }
        //alert("file selected");
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = musicFileLoaded;
        reader.readAsDataURL(this.files[0]);
    });

    $("#sync4-drum-file").change(function(){
        if(!this.files[0]){
            //alert("file no selected");
            return;
        }
        //alert("file selected");
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = drumFileLoaded;
        reader.readAsDataURL(this.files[0]);
    });

    function musicFileLoaded(e)
    {
        $("#sync4-upload-form").submit();
    }

    function drumFileLoaded(e)
    {
        $("#sync4-upload-form").submit();
    }

    $(".remove-sample-btn").click(function(){
        var music_no = $(this).data('music-no');
        //alert(music_no);
        $("#sample-id-hidden").val(music_no);
        $("#deletemodal").modal('show');
    });

    $(".remove-drum-btn").click(function(){
        var drum_no = $(this).data('drum-no');
        //alert(music_no);
        $("#drum-id-hidden").val(drum_no);
        $("#deleteDrumModal").modal('show');
    });

    $(".sync4-cell-name").click(function(){
        var me = $(this);

        var pp_tr = me.parent();
        var cell_id = $(this).data('music-no');
        // alert(cell_id);
        $("#sync4-music-edit-no").val(cell_id);
        $("#sync4-music-edit-val").val(me.html());
        $("#editmodal").modal('show');
    });
</script>

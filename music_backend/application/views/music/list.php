<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i> Music List
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/addNewMusic"><i class="fa fa-plus"></i> Add New Music</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Music List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>index.php/searchmusic" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $search ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Id</th>
                                <th>Thumb</th>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>DJ</th>
                                <th class="text-center">Actions</th>
                            </tr>

                            <?php for($i = 1; $i<=count($musics); $i++)
                            {
                                $music = $musics[$i-1];
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <?php
                                    $thumimage_url = $music->thumb == ""? base_url()."assets/thumbimages/no_img.png":base_url().$music->thumb;
                                    ?>
                                    <td><img src="<?php echo $thumimage_url ?>" style="width: 100px;"></td>
                                    <td><?php echo $music->name ?></td>
                                    <td><?php echo $music->genre ?></td>
                                    <td><?php echo $music->DJ ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-success" href="<?=base_url()?>index.php/editMusic/<?php echo $music->id ?>" alt="edit music"><i class="fa fa-pencil"></i></a>
                                        <span class="btn btn-sm btn-danger remove-music-btn" data-music-id="<?php echo $music->id ?>" alt="delete music"><i class="fa fa-trash"></i></span>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="deletemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/deleteMusic" method="post">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Sync4</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="musicId" id="music-id-hidden">
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

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/musicset.js"></script> -->
<script type="text/javascript">
    $('.remove-music-btn').click(function(){
        var music_no = $(this).data('music-id');
        $('#music-id-hidden').val(music_no);
        $('#deletemodal').modal('show');
        //alert(music_no);
    });

    $('.noti-music-btn').click(function(){
        var noti_name = $(this).data('music-name');
        var music_id = $(this).data('music-id');
        var noti_data = {
            name : noti_name,
            msg : noti_name+" is updated.",
            music_id: music_id
        };
        $.ajax({
            url : baseURL+"noti.php",
            type : 'post',
            data :noti_data
        });
    });
</script>
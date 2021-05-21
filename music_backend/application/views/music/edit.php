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
            <i class="fa fa-tachometer" aria-hidden="true"></i>Edit Music
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Music Details</h3>
                    </div><!-- /.box-header -->

                    <form id="addmusicSet" action="<?php echo base_url() ?>index.php/saveEditMusic" method="post" role="form" enctype='multipart/form-data'>
                        <input type="hidden" name="musicId" value="<?php echo $music->id ?>" id="musicId">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $music->name ?>" maxlength="255" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genre">Genre</label>
                                        <select id="genre" class="form-control required" name="genre" value="<?php echo $music->genre ?>" required>
                                            <?php if (count($genres) > 0): ?>
                                                <?php foreach ($genres as $genre): ?>
                                                    <option value="<?php echo $genre->id ?>"><?php echo $genre->name ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dj">DJ</label>
                                        <select id="dj" class="form-control required" name="dj" value="<?php echo $music->dj ?>" required>
                                            <?php if (count($djs) > 0): ?>
                                                <?php foreach ($djs as $dj): ?>
                                                    <option value="<?php echo $dj->id ?>"><?php echo $dj->name ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="artist">Artist</label>
                                        <select id="artist" class="form-control required" name="artist" value="<?php echo $music->artist ?>" required>
                                            <?php if (count($artists) > 0): ?>
                                                <?php foreach ($artists as $artist): ?>
                                                    <option value="<?php echo $artist->id ?>"><?php echo $artist->name ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description"><?php echo $music->description ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="file" class="" id="thumb" name="thumbimg" style="display: inline;" accept="image/*">
                                        <img src="<?php echo $music->thumb ? base_url() . $music->thumb : base_url() . 'assets/thumbimages/no_img.png' ?>" id="thubpreview" style="width: 100px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="music_file_input">Music File:</label>
                                        <?php
                                        if(!$music->music || !file_exists(FCPATH . $music->music))
                                        {
                                            echo "No Music File";
                                        }
                                        else{
                                            ?>
                                            <audio controls="">
                                                <source src="<?php echo base_url() ?><?php echo $music->music ?>?<?php echo generateRandomString() ?>" type="audio/ogg">
                                            </audio>
                                            <?php
                                        }
                                        ?>

                                        <span class="btn btn-sm btn-success edit-music-file" alt="edit music"><i class="fa fa-pencil"></i></span>

                                        <input type="file" class="" id="music_file_input" name="music" style="display: none;" accept="audio/*">
                                    </div>
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

        <script src="<?php echo base_url(); ?>assets/js/addmusic.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".edit-music-file").click(function(){
                    $("#music_file_input").trigger('click');
                });
            });
        </script>
    </section>
</div>


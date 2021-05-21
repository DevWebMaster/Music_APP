<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i>Add New Music
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Music Details</h3>
                    </div><!-- /.box-header -->

                    <form role="form" id="addSampleSet" action="<?php echo base_url() ?>index.php/saveNewMusic" method="post" role="form" enctype='multipart/form-data'>

                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" maxlength="255" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genre">Genre</label>
                                        <select class="form-control required" name="genre" id="genre" required>
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
                                        <select class="form-control required" name="dj" id="dj" required>
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
                                        <select class="form-control required" name="artist" id="artist" required>
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
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="file" class="" id="thumb" name="thumbimg" style="display: inline;" accept="image/*">
                                        <img src="<?php echo base_url() ?>assets/thumbimages/no_img.png" id="thubpreview" style="width: 100px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="music_file_input">Music File:</label>
                                        <input type="file" class="" id="music_file_input" name="music" style="display: inline;" accept="audio/*">
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
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/addSample.js" type="text/javascript"></script>

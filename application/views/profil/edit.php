<!-- Page -->
<div class="page">
    
    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel col-lg-8">
        <div class="panel-heading">
          <h2 class="panel-title">Edit Profile</h2>
        </div>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
          <div class="row">
              <div class="col-lg-10">

                <?=form_open_multipart('Profil/edit');?>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" id="email" value="<?= $getUser['email']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="<?= $getUser['name']; ?>" >
                            <?= form_error('name', '<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">Picture</div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-center">Current Pic</h5>
                                    <img src="<?= base_url('assets/img/profile/').$getUser['image']; ?>" width="85" height="85">
                                </div>
                                <div class="col-sm-8">
                                    <h5 class="text-center">New Pic</h5>
                                    <input type="file" name="image" id="image" data-plugin="dropify" data-height="75">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 text-left">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?=base_url('profil')?>" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </form>

              </div>
          </div>
        </div>
      </div>
      <!-- End Panel Tabs -->
      
    </div>
  </div>


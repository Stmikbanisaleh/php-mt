<!-- Page -->
  <div class="page">
    
    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel col-lg-8">
        <div class="panel-heading">
          <h2 class="panel-title">My Profile</h2>
        </div>
        <div class="panel-body container-fluid">
          
            <div class="card mb-6" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-6">
                    <img src="<?= base_url('assets/img/profile/').$getUser['image']; ?>" height="220px" width="220px" class="card-img">
                    </div>
                    <div class="col-md-6">
                    <div class="card-body">
                      <table class="table">
                        <tr>
                          <td><p class="font-weight-bold">Name</p></td>
                          <td><?= $getUser['name']; ?></td>
                        </tr>
                        <tr>
                          <td><p class="font-weight-bold">Email</p></td>
                          <td><?= $getUser['email']; ?></td>
                        </tr>
                        <tr>
                          <td><p class="font-weight-bold">Role</p></td>
                          <td><?= $getUser['NAMA_REV']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><a href="<?= base_url('profil/edit') ?>" class="btn btn-primary">Edit</a></td>
                        </tr>
                      </table>
                    </div>
                    </div>
                </div>
                </div>
           
        </div>
      </div>
      <!-- End Panel Tabs -->
      
    </div>
  </div>


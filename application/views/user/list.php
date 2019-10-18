  <!-- Page -->
  <div class="page">

    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">User Management</h3>
        </div>
        <div class="panel-body container-fluid">
          <div class="row row-lg">
            <div class="col-xl">
              <div class="panel">
                <a href="" class="btn btn-primary my-3" data-toggle="modal" data-target="#newUserModal"><i class="fa fa-plus"></i> New User</a>
                <div class="table-responsive">
                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                    <thead>
                      <tr class="table-info">
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>
                      <?php foreach ($getRoleStatus as $gu) : ?>
                        <tr>
                          <td><?= $i ?></td>
                          <td><?= $gu['name']; ?></td>
                          <td><?= $gu['email']; ?></td>
                          <td><?= $gu['role']; ?></td>
                          <td><?= $gu['status']; ?></td>
                        </tr>
                    </tbody>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- End Panel Tabs -->

  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- End Page -->


  <!-- Modal -->
  <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMenuModalLabel">Add New User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <form action="<?= base_url('user/adduser'); ?>" method="post">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= set_value('name'); ?>">
              <?= form_error(
                'name',
                '<small class="text-danger pl-3">',
                '</small>'
              ); ?>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" placeholder="Name" value="<?= set_value('email'); ?>">
              <?= form_error(
                'email',
                '<small class="text-danger pl-3">',
                '</small>'
              ); ?>
            </div>
            <div class="form-group row">
              <div class="col-sm-6">
                <input type="password" class="form-control" id="pasword1" name="password1" placeholder="Password">
                <?= form_error(
                  'password1',
                  '<small class="text-danger pl-3">',
                  '</small>'
                ); ?>
              </div>
              <div class="col-sm-6">
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password">
              </div>
            </div>
            <div class="form-group">
              <select name="role_id" id="role_id" class="form-control" placeholder="Unit Kerja">
                <option value="">Select Role</option>
                <?php foreach ($getRole as $gr) : ?>
                  <option value="<?= $gr['ID']; ?>"><?= $gr['NAMA_REV'] ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error(
                'role_id',
                '<small class="text-danger pl-3">',
                '</small>'
              ); ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
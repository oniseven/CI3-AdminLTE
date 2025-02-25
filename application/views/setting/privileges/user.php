<div class="table-responsive">
  <table class="table table-bordered table-hover table-sm" id="user-grid" style="width: 100%;">
    <thead>
      <tr class="bg-light">
        <th class="text-center" style="width: 50px;" data-id="id">No</th>
        <th class="text-center" style="width: 200px;" data-id="fullname">Nama</th>
        <th class="text-center" style="width: 150px;" data-id="username">Username</th>
        <th class="text-center" style="width: 200px;" data-id="email">Email</th>
        <th class="text-center" style="width: 200px;" data-id="privilege">Privilege</th>
        <th class="text-center" style="width: 100px;" data-id="is_active">Status</th>
        <th class="text-center" style="width: 100px;" data-id="actions">Action</th>
      </tr>
    </thead>
  </table>
</div>
<div class="modal fade" aria-model="true" role="dialog" tabindex="-1" id="user-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Form Pengguna</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <form id="user-form">
        <div class="modal-body">
          <input type="hidden" name="id" id="user-id" value="">
          <div class="form-group required">
            <label class="control-label">Hak Akses</label>
            <select class="form-control" id="hakakses" name="privilege"></select>
          </div>
          <div class="form-group required">
            <label class="control-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" >
          </div>
          <div class="form-group required">
            <label class="control-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" >
          </div>
          <div class="form-group required">
            <label class="control-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" >
          </div>
          <div class="form-group required">
            <label class="control-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" >
          </div>
          <div class="form-group">
            <label class="control-label">Status</label>
            <div class="custom-control custom-switch">
              <input type="checkbox" name="is_active" id="status_user" value="1" class="custom-control-input" checked >
              <label class="custom-control-label" for="status">Aktif</label>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-light btn-icon" data-dismiss="modal">Close</button>
          <button type="submit" id="save-user" class="btn btn-success"><i class="fa fa-save fs-3x"></i>&nbsp;Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
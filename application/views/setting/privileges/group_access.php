<div class="row">
  <div class="col-md-4">
    <form id="group-form">
    <div class="card">
      <div class="card-body">
        <input type="hidden" name="id" id="priv-id" value="">
        <div class="form-group required">
          <label class="control-label">Nama Group</label>
          <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="form-group">
          <label class="control-label">Status</label>
          <div class="custom-control custom-switch">
            <input type="checkbox" name="is_active" id="status" value="1" class="custom-control-input" checked >
            <label class="custom-control-label" for="status">Aktif</label>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" id="btn-simpan" class="btn btn-primary float-right">Simpan</button>
        <button type="reset" id="btn-reset" class="btn btn-default float-right mr-2">Reset</button>
      </div>
    </div>
    </form>
  </div>
  <div class="col-md-8 table-responsive">
    <table class="table table-bordered table-hover table-sm" id="group-grid" style="width: 100%;">
      <thead>
        <tr class="bg-light">
          <th class="text-center" data-id="id">No</th>
          <th class="text-center" data-id="name">Group Akses</th>
          <th class="text-center" data-id="id">Menu Akses</th>
          <th class="text-center" data-id="is_active">Status</th>
          <th class="text-center" data-id="actions">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<div class="modal fade" aria-model="true" role="dialog" tabindex="-1" id="group-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Daftar Menu</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="menu-tree"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-light btn-icon" data-dismiss="modal">Close</button>
        <button type="button" id="menus-save-button" class="btn btn-icon btn-success"><i class="fa fa-check fs-3x"></i></button>
      </div>
    </div>
  </div>
</div>
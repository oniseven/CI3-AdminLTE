<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" id="group-access-tab" data-toggle="pill" href="#group-access" role="tab" aria-controls="group-access" aria-selected="true">Group Akses</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pengguna-tab" data-toggle="pill" href="#pengguna" role="tab" aria-controls="pengguna" aria-selected="false">Pengguna</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="privileges-tab-content">
      <div id="group-access" class="tab-pane fade active show" role="tabpanel" aria-labelledby="group-access-tab">
        <div class="row">
          <div class="col-md-4">
            <form id="main-form">
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
            <table class="table table-bordered table-hover table-sm" id="main-grid" style="width: 100%;">
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
      </div>
      <div id="pengguna" class="tab-pane fade" role="tabpanel" aria-labelledby="pengguna-tab">
        pengguna
      </div>
    </div>
  </div>
</div>
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
        <?=$group_section?>
      </div>
      <div id="pengguna" class="tab-pane fade" role="tabpanel" aria-labelledby="pengguna-tab">
        pengguna
      </div>
    </div>
  </div>
</div>
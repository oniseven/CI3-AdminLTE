    <!-- Content Header (Page header) -->
    <?php if($show['content-toolbar'] === true) { ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $page_title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <?php if($show['breadcrums'] === true) {?>
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
            </ol>
            <?php } ?>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php } ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php
      $content_top_margin_class = $show["content-toolbar"] === true ? "" : "pt-2";
    ?>
    <div class="content <?php echo $content_top_margin_class; ?>">
      <div class="container-fluid">
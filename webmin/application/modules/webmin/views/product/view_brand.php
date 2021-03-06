<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Brand
      <small>Product</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Brand</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- solid sales graph -->
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-th"></i>
            <h3 class="box-title">All Brand</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-add" onclick="formadd()"><i class="fa fa-plus"></i> Add</button>
            </div>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>Brand Name</th>
                  <th>Sort</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data->result() as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $d->brand_name ?></td>
                    <td><?php echo $d->brand_sort ?></td>
                    <td><?php echo checkStatus($d->brand_status) ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="formedit('<?php echo $d->brand_id ?>', '<?php echo $d->brand_name ?>', '<?php echo $d->brand_sort ?>', '<?php echo $d->brand_image ?>', '<?php echo $d->brand_status ?>');">Edit</a> 
                      <a href="<?php echo webmin_url('product/remove/brand/'.$d->brand_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->brand_name ?>? ');">Remove</a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form" action="<?php echo webmin_url('product/brand?action=save') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Brand</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="f1" name="post[brand_name]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Sort</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="f2" name="post[brand_sort]" value="<?php echo ($data->num_rows()+1) ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Image</label>
            <div class="col-sm-5">
              <div id="image"><img src="" style="max-width:200px;" class="img-responsive"></div>
              <input type="file" class="form-control" id="f3" name="image" onchange="showimage(this);">
              (100px x 100px)
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Status</label>
            <div class="col-sm-9">
              <select class="form-control" name="post[brand_status]" id="f4" required>
                <option value="">-- select --</option>
                <option value="1">Active</option>
                <option value="2">Nonactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('themes/private/view_footer_script'); ?>
<script type="text/javascript">
  function formadd() {
    $("#f1").val('');
    // $("#f2").val('');
    $("#f3").val('');
    $("#f4").val('');
    var split = $("#modal-add #form").attr('action').split('&');
    $("#image img").attr('src', '');
    $("#modal-add #form").attr('action', split[0]);
  }
  function showimage(val) {
    readURL(val, '#image img');
  }
  function formedit(id, f1, f2, f3, f4) {
    $("#f1").val(f1);
    $("#f2").val(f2);
    $("#image img").attr('src', '<?php echo brand_url() ?>' + f3);
    $("#f4").val(f4);
    $("#modal-add #form").attr('action', $("#modal-add #form").attr('action') + '&id=' + id);
    $("#modal-add").modal('toggle');
  }

</script>
<?php $this->load->view('themes/private/view_footer'); ?>

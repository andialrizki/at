<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Category
      <small>Recipes</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Category</li>
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
            <h3 class="box-title">All Category</h3>
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
                  <th>Category Name</th>
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
                    <td><?php echo $d->category_name ?></td>
                    <td><?php echo $d->category_sort ?></td>
                    <td><?php echo checkStatus($d->category_status) ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="formedit('<?php echo $d->category_id ?>', '<?php echo $d->category_name ?>', '<?php echo $d->category_sort ?>', '<?php echo $d->category_status ?>');">Edit</a> 
                      <a href="<?php echo webmin_url('recipes/remove/category/'.$d->category_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->category_name ?>? ');">Remove</a>
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
      <form class="form-horizontal" id="form" action="<?php echo webmin_url('recipes/category?action=save') ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Category</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="f1" name="post[category_name]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Sort</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="f2" name="post[category_sort]" value="<?php echo ($data->num_rows()+1) ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Status</label>
            <div class="col-sm-9">
              <select class="form-control" name="post[category_status]" id="f3" required>
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
    var split = $("#modal-add #form").attr('action').split('&');
    $("#modal-add #form").attr('action', split[0]);
  }
  function formedit(id, f1, f2, f3) {
    $("#f1").val(f1);
    $("#f2").val(f2);
    $("#f3").val(f3);
    $("#modal-add #form").attr('action', $("#modal-add #form").attr('action') + '&id=' + id);
    $("#modal-add").modal('toggle');
  }

</script>
<?php $this->load->view('themes/private/view_footer'); ?>

<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Product
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Product</li>
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
            <h3 class="box-title">All Product</h3>
            <div class="box-tools pull-right">
              <a href="<?php echo webmin_url('product/add') ?>">
                <button class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add</button>
              </a>
            </div>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>Product Name</th>
                  <th>Sort</th>
                  <th>Status</th>
                  <th>Images</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data->result() as $d): ?>
                  <?php $tot_img = $this->db->where('image_product_id', $d->product_id)->get('product_image')->num_rows() ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $d->product_name ?></td>
                    <td><?php echo $d->product_sort ?></td>
                    <td><?php echo checkStatus($d->product_status) ?></td>
                    <td>
                      <label class="label label-warning">(<?php echo $tot_img ?>) image(s)</label>
                      <a href="<?php echo webmin_url('product/image/'.$d->product_id) ?>" class="label label-success">Add</a>
                    </td>
                    <td>
                      <a href="<?php echo webmin_url('product/edit/'.$d->product_id) ?>" class="btn btn-success btn-xs">Edit</a> 
                      <a href="<?php echo webmin_url('product/remove/product/'.$d->product_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->product_name ?>? ');">Remove</a>
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
<?php $this->load->view('themes/private/view_footer_script'); ?>
<?php $this->load->view('themes/private/view_footer'); ?>
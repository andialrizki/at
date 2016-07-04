<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Product
      <small>Add</small>
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
            <h3 class="box-title">Add Product</h3>
            <div class="box-tools pull-right">
              <a href="<?php echo webmin_url('product') ?>">
                <button class="btn btn-danger" type="button"><i class="fa fa-arrow-left"></i> Back</button>
              </a>
            </div>
          </div>
          <div class="box-body border-radius-none">
            <form class="form-horizontal" id="form" action="<?php echo webmin_url('product/add?action=save') ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-sm-3">Product Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[product_name]" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Category</label>
                <div class="col-sm-9">
                  <div style="max-width: 400px; max-height: 400px; overflow: auto;">
                    <?php foreach ($cat as $d): ?>
                      <input type="checkbox" name="prodcat[]" value="<?php echo $d->category_id ?>"> <?php echo $d->category_name ?><br>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Brand</label>
                <div class="col-sm-9">
                  <div style="max-width: 400px; max-height: 400px; overflow: auto;">
                    <?php foreach ($brand as $d): ?>
                      <input type="checkbox" name="prodbrand[]" value="<?php echo $d->brand_id ?>"> <?php echo $d->brand_name ?><br>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Description</label>
                <div class="col-sm-9">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">English</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Indonesia</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <textarea id="ckeditor" name="post[product_description_en]"></textarea>
                      </div>
                      <div class="tab-pane" id="tab_2">
                        <textarea id="ckeditor2" name="post[product_description_id]"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Product Image</label>
                <div class="col-sm-5">
                  <div id="image"><img src="" style="max-width:200px;" class="img-responsive"></div>
                  <input type="file" class="form-control" name="image" onchange="showimage(this);" required>
                  (500px x 500px)
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Product Brochure</label>
                <div class="col-sm-5">
                  <input type="file" class="form-control" name="brochure">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Sort</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="post[product_sort]" value="<?php echo ($data->num_rows()+1) ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Status</label>
                <div class="col-sm-3">
                  <select class="form-control" name="post[product_status]" required>
                    <option value="">-- select --</option>
                    <option value="1">Active</option>
                    <option value="2">Nonactive</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('themes/private/view_footer_script'); ?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo private_url() ?>plugins/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
    selector: '#ckeditor, #ckeditor2',
    height: 500,
    theme: 'modern',
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify ',
    toolbar2: 'print preview media | forecolor backcolor emoticons | | bullist numlist outdent indent | link image',
    image_advtab: true,
    content_css: [
      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
      '//www.tinymce.com/css/codepen.min.css'
    ],
   file_browser_callback: RoxyFileBrowser
   });
  function RoxyFileBrowser(field_name, url, type, win) {
    var roxyFileman = '<?php echo private_url() ?>fileman/index.html';
    if (roxyFileman.indexOf("?") < 0) {     
      roxyFileman += "?type=" + type;   
    }
    else {
      roxyFileman += "&type=" + type;
    }
    roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
    if(tinyMCE.activeEditor.settings.language){
      roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
    }
    tinyMCE.activeEditor.windowManager.open({
       file: roxyFileman,
       title: 'Filemanager',
       width: 750, 
       height: 450,
       resizable: "yes",
       plugins: "media",
       inline: "yes",
       close_previous: "no"  
    }, {     window: win,     input: field_name    });
    return false; 
  }
</script>
<!-- /TinyMCE -->
<script type="text/javascript">
  function showimage(val) {
    readURL(val, '#image img');
  }
</script>
<?php $this->load->view('themes/private/view_footer'); ?>
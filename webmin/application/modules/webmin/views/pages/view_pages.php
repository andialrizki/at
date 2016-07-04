<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pages
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pages</li>
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
            <h3 class="box-title">All Page</h3>
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
                  <th>Page Name</th>
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
                    <td><?php echo $d->pages_title ?></td>
                    <td><?php echo $d->pages_sort ?></td>
                    <td><?php echo checkStatus($d->pages_status) ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="formedit('<?php echo $d->pages_id ?>', '<?php echo $d->pages_title ?>', '<?php echo $d->pages_sort ?>', '<?php echo $d->pages_image ?>', '<?php echo $d->pages_status ?>');">Edit</a> 
                      <?php if($d->pages_id != 1){ ?>
                      <a href="<?php echo webmin_url('pages/remove/'.$d->pages_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->pages_title ?>? ');">Remove</a>
                      <?php } ?>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" id="form" action="<?php echo webmin_url('pages?action=save') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Page</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Page Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="f1" name="post[pages_title]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Sort</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="f2" name="post[pages_sort]" value="<?php echo ($data->num_rows()+1) ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Image</label>
            <div class="col-sm-5">
              <div id="image"><img src="" style="max-width:200px;" class="img-responsive"></div>
              <input type="file" class="form-control" id="f3" name="image" onchange="showimage(this);">
              (939px x 370px)
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
                    <textarea id="ckeditor" name="post[pages_desc_en]"></textarea>
                  </div>
                  <div class="tab-pane" id="tab_2">
                    <textarea id="ckeditor2" name="post[pages_desc_id]"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Status</label>
            <div class="col-sm-9">
              <select class="form-control" name="post[pages_status]" id="f4" required>
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
  function formadd() {
    $("#f1").val('');
    // $("#f2").val('');
    $("#f3").val('');
    $("#f4").val('');
    var split = $("#modal-add #form").attr('action').split('&');
    $("#image img").attr('src', '');
    $("#modal-add #form").attr('action', split[0]);
    tinymce.get('ckeditor').setContent('');
    tinymce.get('ckeditor2').setContent('');
  }
  function showimage(val) {
    readURL(val, '#image img');
  }
  function formedit(id, f1, f2, f3, f4) {
    $("#f1").val(f1);
    $("#f2").val(f2);
    $("#image img").attr('src', '<?php echo pagesimg_url() ?>' + f3);
    $("#f4").val(f4);
    $("#modal-add #form").attr('action', $("#modal-add #form").attr('action') + '&id=' + id);
    $.ajax({
      url: '<?php echo webmin_url('pages/getByAjax') ?>/' + id,
      cache: false,
      dataType: "json",
      success:function(data){
        tinymce.get('ckeditor').setContent(data.pages_desc_en);
        tinymce.get('ckeditor2').setContent(data.pages_desc_id);
      }
    });
    $("#modal-add").modal('toggle');
  }

</script>
<?php $this->load->view('themes/private/view_footer'); ?>

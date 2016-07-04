<?php $this->load->view('themes/private/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
      <small>Website</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile</li>
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
            <h3 class="box-title">Edit Profile</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-danger" type="button" onclick="window.history.back()"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <form class="form-horizontal" id="form" action="<?php echo webmin_url('profile?action=save') ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-sm-3">Website Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_title]" value="<?php echo $data->profile_title ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Phone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_phone]" value="<?php echo $data->profile_phone ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Mobile</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_mobile]" value="<?php echo $data->profile_mobile ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Email</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_email]" value="<?php echo $data->profile_email ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Footer</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_footer]" value="<?php echo $data->profile_footer ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Facebook</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_facebook]" value="<?php echo $data->profile_facebook ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Twitter</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_twitter]" value="<?php echo $data->profile_twitter ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Youtube</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_youtube]" value="<?php echo $data->profile_youtube ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Pinterest</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="post[profile_pinterest]" value="<?php echo $data->profile_pinterest ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Meta Tag Keyword</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="post[profile_meta_key]"><?php echo $data->profile_meta_key ?></textarea>  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Meta Tag Description</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="post[profile_meta_description]"><?php echo $data->profile_meta_description ?></textarea>  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Contact Us</label>
                <div class="col-sm-9">
                  <textarea id="ckeditor" name="post[profile_contactus]"><?php echo $data->profile_contactus ?></textarea>  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Website Logo</label>
                <div class="col-sm-5">
                  <div id="image"><img src="<?php echo logo_url($data->profile_logo) ?>" style="max-width:500px;" class="img-responsive"></div>
                  <input type="file" class="form-control" name="image" onchange="showimage(this);">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Website Logo Footer</label>
                <div class="col-sm-5">
                  <div id="image2"><img src="<?php echo logo_url($data->profile_logo_footer) ?>" style="max-width:500px;" class="img-responsive"></div>
                  <input type="file" class="form-control" name="image2" onchange="showimage2(this);">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Website Favicon</label>
                <div class="col-sm-5">
                  <div id="image3"><img src="<?php echo logo_url($data->profile_favicon) ?>" style="max-width:80px;" class="img-responsive"></div>
                  <input type="file" class="form-control" name="image3" onchange="showimage3(this);">
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
    height: 300,
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
       height: 300,
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
  function showimage2(val) {
    readURL(val, '#image2 img');
  }
  function showimage3(val) {
    readURL(val, '#image3 img');
  }
</script>
<?php $this->load->view('themes/private/view_footer'); ?>
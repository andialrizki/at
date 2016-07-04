    <?php $this->load->view('themes/private/view_header'); ?>
      <?php $prof = $this->mpage->getProfile(); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-sm-4" style="padding-top: 30px; padding-bottom: 60px;">
              <img src="<?php echo logo_url($prof->profile_logo_footer) ?>" class="img-responsive">
            </div>
            <div class="col-sm-4" style="padding-top: 30px; padding-bottom: 60px;">
              Welcome to administration page, please click menu in top page or control panel in bottom for maintenance your page.
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Profile</span>
                  <span class="info-box-number">&nbsp;</span>
                  <a href="<?php echo webmin_url('profile') ?>" class="label bg-green">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-laptop"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Product</span>
                  <span class="info-box-number"><?php echo $prod ?></span>
                  <a href="<?php echo webmin_url('product') ?>" class="label bg-blue">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-building-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Our Company</span>
                  <span class="info-box-number"><?php echo $oc ?></span>
                  <a href="<?php echo webmin_url('ourcompany') ?>" class="label bg-yellow">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-code"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Pages</span>
                  <span class="info-box-number"><?php echo $pages ?></span>
                  <a href="<?php echo webmin_url('pages') ?>" class="label bg-red">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-image"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Banner</span>
                  <span class="info-box-number"><?php echo $banner ?></span>
                  <a href="<?php echo webmin_url('banner') ?>" class="label bg-aqua">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-newspaper-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage News</span>
                  <span class="info-box-number"><?php echo $news ?></span>
                  <a href="<?php echo webmin_url('news') ?>" class="label bg-orange">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="fa fa-navicon"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manage Recipes</span>
                  <span class="info-box-number"><?php echo $prod ?></span>
                  <a href="<?php echo webmin_url('recipes') ?>" class="label bg-navy">
                  <i class="fa fa-arrow-circle-right"></i> More
                  </a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    <?php $this->load->view('themes/private/view_footer_script'); ?>
    <?php $this->load->view('themes/private/view_footer'); ?>
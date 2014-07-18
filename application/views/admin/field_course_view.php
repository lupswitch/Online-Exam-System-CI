<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-plus-circle"></span> <?php echo $pagetitle;?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li><?php echo anchor('admin/subjects', 'จัดการวิชาในระบบ');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small><?php echo $pagesubtitle;?></small>
		</h4>

		<?php
		$attr = array(
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open($formlink, $attr);
		?>
		<div class="row">
			<div class="col-md-5 col-lg-6 col-lg-offset-3">
<?php
if (isset($msg_error)) 
{
	echo <<<EOL
<div class="alert alert-danger hidden-xs alert-dismissable" style="min-width: 343px">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>ผิดพลาด</b> : $msg_error
</div>
<div class="alert alert-danger visible-xs alert-dismissable">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>ผิดพลาด</b> : $msg_error
</div>
EOL;
	}
	else
	{
		echo <<<EOL
<div class="alert alert-info hidden-xs" style="min-width: 343px">
	<i class="fa fa-info"></i>
	<b>คำแนะนำ :</b> <b>เครื่องหมาย</b> <span class="text-danger">*</span>
	จำเป็นต้องกรอกข้อมูล
</div>
<div class="alert alert-info visible-xs">
	<i class="fa fa-info"></i>
	<b>คำแนะนำ :</b> <b>เครื่องหมาย</b> <span class="text-danger">*</span>
	จำเป็นต้องกรอกข้อมูล
</div>
EOL;
	}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				
				<!-- Begin BasicInfo -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							รายละเอียดการเปิดสอบวิชา
						</h3>
					</div>
					<div class="box-body">
						<div class="form-group<?php if(form_error('subject_id')) echo ' has-error';?>">
							<?php 
							echo form_label('วิชา <span class="text-danger">*</span>', 'subject_id');
							$options = $this->courses->buildCourseOptions();
							echo form_dropdown('subjectid', $options, $courseInfo['subject_id'], 'id="subjectid" class="form-control"');
							?>
						</div>
						<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
							<b>คำอธิบายวิชา</b>
							<p id="courseDesc" class="text-justify"><?php echo $courseInfo['description'];?></p>
						</div>
					</div>
				</div>
				<!-- End BasicInfo -->
			</div>
		</div>
		

		<div class="form-group">
			<div class="row row-centered">
				<div class="col-sm-12">
					<?php
					echo form_submit('submit', $this->courses->btnSaveText(), 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->
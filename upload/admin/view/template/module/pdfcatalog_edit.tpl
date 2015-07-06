<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">

  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
  
	<div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>

      <div class="panel-body">
     
		<form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal" enctype="multipart/form-data">
          
		  <div class="form-group">            
			<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="offer_title" value="<?php echo $edit_data[0]['offer_title']; ?>"  id="input-name" class="form-control" required/>
			</div>
          </div>

		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-html"><?php echo $entry_text; ?></label>
			<div class="col-sm-10">
		<input type="text" name="offer_filename" value="<?php echo $edit_data[0]['file_name']; ?>"  id="input-filename" class="form-control" />	
             <input type="file" name="offer_file" id="file_name" >
            </div>
		  </div>

          <div class="form-group">  
			<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control" required="required">
                <?php if ($edit_data[0]['status']==1) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			  
   			</div>
			
			
		  </div>
<input type="hidden" name="catalog_id" value="<?php echo $catalog_id;?>">
		  
		</form>

		
			<!--  
			  <div class="table-responsive">
<table class="table table-bordered table-hover">
<thead>
<tr>
<td class="text-center">OFFER TITLE</td>
<td class="text-left">PDF FILE NAME</td>
<td class="text-left">STATUS</td>
<td class="text-right">ACTION</td>
</tr>
</thead>
<tbody>
<?php

foreach($offer_datas as $offer_data) {

$id=$offer_data['id'];
echo '<tr>
<td class="text-center">'.$offer_data['offer_title'].'</td>
<td class="text-left">'.$offer_data['file_name'].'</td>.'?>
<?php if($offer_data['status']=='1')
{
echo '<td class="text-left">Enable</td>';
}
else
{
echo '<td class="text-left">Disable</td>';
}?>
<?php echo'<td class="text-right"><a href="index.php?route=module/pdfcatalog/edit/'.$id.'&token='.$token.'" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
</tr>';

}

?>

</tbody>
</table>
</div>-->
	  </div>
	</div>
    
  </div>
</div>
<script>
$(document).ready(function(){
$('#file_name').click(function(){
$('#input-filename').hide();

});

});
</script>
<?php echo $footer; ?>

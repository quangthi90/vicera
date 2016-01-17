<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button form="form-category" data-toggle="tooltip" title="<?php echo $button_submit; ?>" class="btn btn-primary" onclick="$('form').submit();"><i class="fa fa-arrow-circle-o-up"></i></button></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (!empty($error_warning)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (!empty($success)) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-staff"><?php echo $entry_file; ?></label>
            <div class="col-sm-5">
              <input type="file" name="file[]" multiple />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.date').datetimepicker({
    pickTime: false
  });
  $('.hour').datetimepicker({
    format: 'HH:mm',
    pickDate: false
  });
</script>
<script type="text/javascript">
  $('#input-staff').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=staff/staff/autocomplete&token=<?php echo $token; ?>&filter_code=' +  encodeURIComponent(request),
        dataType: 'json',     
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['staff_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('#input-staff').val(item['label']);
      $('input[name=\'staff_id\']').val(item['value']);
    } 
  });
</script>
<?php echo $footer; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <div class="tab-content">
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-staff"><?php echo $entry_code; ?></label>
              <div class="col-sm-5">
                <input type="text" value="<?php echo $code; ?>" placeholder="<?php echo $entry_code; ?>" id="input-staff" class="form-control" />
                <input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-date"><?php echo $entry_date; ?></label>
              <div class="col-sm-5">
                <div class="input-group date">
                  <input type="text" name="date" value="<?php echo $date; ?>" placeholder="<?php echo $entry_date; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-checkin"><?php echo $entry_checkin; ?></label>
              <div class="col-sm-5">
                <div class="input-group hour">
                  <input type="text" name="checkin" value="<?php echo $checkin; ?>" placeholder="<?php echo $entry_checkin; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                </span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-checkout"><?php echo $entry_checkout; ?></label>
              <div class="col-sm-5">
                <div class="input-group hour">
                  <input type="text" name="checkout" value="<?php echo $checkout; ?>" placeholder="<?php echo $entry_checkout; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                </span></div>
              </div>
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
              label: item['firstname'] + ' ' + item['lastname'] + ' - ' + item['code'],
              value: item['staff_id'],
              data: item['code']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('#input-staff').val(item['data']);
      $('input[name=\'staff_id\']').val(item['value']);
    } 
  });
</script>
<?php echo $footer; ?>
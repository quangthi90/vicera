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
                <input <?php if ($is_edit) { ?>disabled<?php } ?> type="text" value="<?php echo $code; ?>" placeholder="<?php echo $entry_code; ?>" id="input-staff" name="code" class="form-control" />
                <input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-staff"><?php echo $entry_kind; ?></label>
              <div class="col-sm-5">
                <select name="kind">
                  <option value="1"><?php echo $text_offset; ?></option>
                  <option <?php if($kind == 2) { ?>selected="selected"<?php } ?> value="2"><?php echo $text_absent; ?></option>
                  <option <?php if($kind == 3) { ?>selected="selected"<?php } ?> value="3"><?php echo $text_over; ?></option>
                  <option <?php if($kind == 4) { ?>selected="selected"<?php } ?> value="4"><?php echo $text_ab_year; ?></option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-date"><?php echo $entry_date; ?></label>
              <div class="col-sm-5">
                <div class="input-group date">
                  <input type="text" name="date" value="<?php echo $date; ?>" placeholder="<?php echo $entry_date; ?>" data-date-format="YYYY-MM-DD" class="form-control" <?php if ($is_edit) { ?>disabled<?php } ?> />
                  <?php if ($is_edit) { ?><input type="hidden" name="date" value="<?php echo $date; ?>"/><?php } ?>
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-full-day"><?php echo $entry_full_day; ?></label>
              <div class="col-sm-5">
                <div class="input-group">
                  <input id="input-full-day" type="checkbox" name="is_full_day" value="true" placeholder="<?php echo $entry_full_day; ?>" <?php if (!empty($is_full_day)) { ?>checked="checked"<?php } ?> class="form-control" />
                </span></div>
              </div>
            </div>
            <div class="form-group input-from-hour" <?php if (!empty($is_full_day)) { ?>style="display: none;"<?php } ?>>
              <label class="col-sm-2 control-label" for="input-from-hour"><?php echo $entry_from_hour; ?></label>
              <div class="col-sm-5">
                <div class="input-group hour">
                  <input id="input-from-hour" type="text" name="from_hour" value="<?php echo $from_hour; ?>" placeholder="<?php echo $entry_from_hour; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                </span></div>
              </div>
            </div>
            <div class="form-group input-to-hour" <?php if (!empty($is_full_day)) { ?>style="display: none;"<?php } ?>>
              <label class="col-sm-2 control-label" for="input-to-hour"><?php echo $entry_to_hour; ?></label>
              <div class="col-sm-5">
                <div class="input-group hour">
                  <input id="input-to-hour" type="text" name="to_hour" value="<?php echo $to_hour; ?>" placeholder="<?php echo $entry_to_hour; ?>" class="form-control" />
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
<script type="text/javascript">
  $('#input-full-day').on('click', function(){
    $('.input-from-hour').slideToggle();
    $('.input-to-hour').slideToggle();


  });
</script>
<?php echo $footer; ?>
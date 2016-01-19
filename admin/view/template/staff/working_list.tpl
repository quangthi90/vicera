<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-working').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-working">
          <div class="well">
            <div class="row" id="data-filter">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-date-start"><?php echo $text_code; ?></label>
                  <div class="input-group">
                    <input type="text" name="filter_code" value="<?php echo $filter_code; ?>" placeholder="<?php echo $text_code; ?>" id="input-staff" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-department"><?php echo $column_department; ?></label>
                  <div class="input-group">
                    <select class="form-control" name="filter_department_id" id="input-department">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($departments as $department) { ?>
                      <option <?php if($department['id'] == $filter_department_id) { ?>selected="selected"<?php } ?> value="<?php echo $department['id'] ?>"><?php echo $department['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-part"><?php echo $column_part; ?></label>
                  <div class="input-group">
                    <select class="form-control" name="filter_part_id" id="input-part">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($parts as $part) { ?>
                      <option <?php if ($filter_part_id == $part['id']) { ?>selected = "selected"<?php } ?> value="<?php echo $part['id']; ?>"><?php echo $part['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                  <div class="input-group date">
                    <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span></div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                  <div class="input-group date">
                    <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span></div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-part"><?php echo $column_error; ?></label>
                  <div class="input-group">
                    <select class="form-control" name="filter_error" id="input-error">
                      <option value="0"><?php echo $text_false; ?></option>
                      <option <?php if ($filter_error == 1) { ?>selected = "selected"<?php } ?> value="1"><?php echo $text_true; ?></option>
                    </select>
                  </div>
                </div>
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                <button type="button" style="margin-right: 5px;" id="button-working1" class="btn btn-success pull-right"><i class="fa fa-cloud-download"></i> <?php echo $button_working1; ?></button>
                <button type="button" style="margin-right: 5px;" id="button-working2" class="btn btn-success pull-right"><i class="fa fa-cloud-download"></i> <?php echo $button_working2; ?></button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php echo $column_code; ?></td>
                  <td class="text-left"><?php echo $column_working_code; ?></td>
                  <td class="text-left"><?php echo $column_fullname; ?></td>
                  <td class="text-left"><?php echo $column_part; ?></td>
                  <td class="text-left"><?php echo $column_working_time; ?></td>
                  <td class="text-left"><?php echo $column_date; ?></td>
                  <td class="text-left"><?php echo $column_checkin; ?></td>
                  <td class="text-left"><?php echo $column_checkout; ?></td>
                  <td class="text-left"><?php echo $column_over; ?></td>
                  <td class="text-left"><?php echo $column_under; ?></td>
                  <td class="text-left"><?php echo $column_absent; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($workings) { ?>
                <?php foreach ($workings as $working) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($working['working_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $working['working_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $working['working_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $working['code']; ?></td>
                  <td class="text-left"><?php echo $working['working_code']; ?></td>
                  <td class="text-left"><?php echo $working['fullname']; ?></td>
                  <td class="text-left"><?php echo $working['part']; ?></td>
                  <td class="text-left"><?php echo $working['working_time']; ?> h</td>
                  <td class="text-left"><?php echo $working['date']; ?></td>
                  <td class="text-left"><?php echo $working['checkin']; ?></td>
                  <td class="text-left"><?php echo $working['checkout']; ?></td>
                  <td class="text-left"><?php echo $working['over']; ?></td>
                  <td class="text-left"><?php echo $working['under']; ?></td>
                  <td class="text-left"><?php echo $working['absent']; ?></td>
                  <td class="text-right"><a href="<?php echo $working['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=staff/working&token=<?php echo $token; ?>';

  var filter_code = $('input[name=\'filter_code\']').val();
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }

  var filter_date_start = $('input[name=\'filter_date_start\']').val();
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').val();
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_department_id = $('select[name=\'filter_department_id\']').val();
  
  if (filter_department_id > 0) {
    url += '&filter_department_id=' + encodeURIComponent(filter_department_id);
  }

  var filter_part_id = $('select[name=\'filter_part_id\']').val();
  
  if (filter_part_id > 0) {
    url += '&filter_part_id=' + encodeURIComponent(filter_part_id);
  }

  var filter_error = $('select[name=\'filter_error\']').val();
  
  if (filter_error > 0) {
    url += '&filter_error=' + encodeURIComponent(filter_error);
  }

  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('#button-working1').on('click', function() {
  url = 'index.php?route=staff/working/exportWorking1&token=<?php echo $token; ?>';

  var filter_date_start = $('input[name=\'filter_date_start\']').val();
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').val();
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_department_id = $('select[name=\'filter_department_id\']').val();
  
  if (filter_department_id > 0) {
    url += '&filter_department_id=' + encodeURIComponent(filter_department_id);
  }

  var filter_part_id = $('select[name=\'filter_part_id\']').val();
  
  if (filter_part_id > 0) {
    url += '&filter_part_id=' + encodeURIComponent(filter_part_id);
  }

  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('#button-working2').on('click', function() {
  url = 'index.php?route=staff/working/exportWorking2&token=<?php echo $token; ?>';

  var filter_staff_id = $('input[name=\'filter_staff_id\']').val();
  
  if (filter_staff_id) {
    url += '&filter_staff_id=' + encodeURIComponent(filter_staff_id);
  }

  var filter_date_start = $('input[name=\'filter_date_start\']').val();
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').val();
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  location = url;
});
//--></script>
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
              value: item['code']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('input[name=\'filter_code\']').val(item['value']);
    } 
  });
</script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script>
<script type="text/javascript">
  $('select[name=\'filter_department_id\']').on('change', function(){
    $.ajax({
      url: 'index.php?route=department/part/autocomplete&token=<?php echo $token; ?>&department_id=' + $(this).val(),
      dataType: 'json',
      success: function(json) {
        var html = '<option value="0"><?php echo $text_none; ?></option>';
        $.each(json, function(i, part) {
          html += '<option value="' + part.id + '">' + part.name + '</option>';
        });

        $('select[name=\'filter_part_id\']').html(html);
      }
    });
  });
</script>
<script type="text/javascript">
  $('#data-filter').keyup(function(e) {
    var code = e.keyCode || e.which;
      if(code == 13) {
        $('#button-filter').click();
      }
  });
</script>
<?php echo $footer; ?>
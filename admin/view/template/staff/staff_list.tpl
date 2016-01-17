<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-staff').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-staff">
          <div class="well">
            <div class="row" id="staff-filter">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label" for="input-code"><?php echo $column_code; ?></label>
                  <div class="input-group">
                    <input type="text" name="filter_code" value="<?php echo $filter_code; ?>" placeholder="<?php echo $column_code; ?>" id="input-code" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-name"><?php echo $column_name; ?></label>
                  <div class="input-group">
                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />
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
                  <label class="control-label" for="input-gender"><?php echo $entry_gender; ?></label>
                  <div class="input-group">
                    <select class="form-control" name="filter_gender" id="input-gender">
                      <option><?php echo $text_none; ?></option>
                      <option <?php if($filter_gender === 0) { ?>selected="selected"<?php } ?> value="0"><?php echo $text_female; ?></option>
                      <option <?php if($filter_gender == 1) { ?>selected="selected"<?php } ?> value="1"><?php echo $text_male; ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-gender"><?php echo $entry_break; ?></label>
                  <div class="input-group">
                    <select class="form-control" name="filter_break" id="input-break">
                      <option <?php if($filter_break === 0) { ?>selected="selected"<?php } ?> value="0"><?php echo $text_false; ?></option>
                      <option <?php if($filter_break == 1) { ?>selected="selected"<?php } ?> value="1"><?php echo $text_true; ?></option>
                    </select>
                  </div>
                </div>
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                <button type="button"  id="button-export" style="margin-right: 5px;" class="btn btn-success pull-right"><i class="fa fa-cloud-download"></i> <?php echo $button_export; ?></button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'code') { ?>
                    <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_working_code; ?></td>
                  <td class="text-right"><?php echo $column_department; ?></td>
                  <td class="text-right"><?php echo $column_part; ?></td>
                  <td class="text-right"><?php echo $column_position; ?></td>
                  <td class="text-right"><?php echo $column_status; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($staffs) { ?>
                <?php foreach ($staffs as $staff) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($staff['staff_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $staff['staff_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $staff['staff_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $staff['name']; ?></td>
                  <td class="text-right"><?php echo $staff['code']; ?></td>
                  <td class="text-right"><?php echo $staff['working_code']; ?></td>
                  <td class="text-right"><?php echo $staff['department']; ?></td>
                  <td class="text-right"><?php echo $staff['part']; ?></td>
                  <td class="text-right"><?php echo $staff['position']; ?></td>
                  <td class="text-right"><?php echo $staff['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $staff['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
  url = 'index.php?route=staff/staff&token=<?php echo $token; ?>';

  var filter_code = $('input[name=\'filter_code\']').val();
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }

  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_gender = $('select[name=\'filter_gender\']').val();
  
  if (filter_gender >= 0) {
    url += '&filter_gender=' + encodeURIComponent(filter_gender);
  }

  var filter_department_id = $('select[name=\'filter_department_id\']').val();
  
  if (filter_department_id > 0) {
    url += '&filter_department_id=' + encodeURIComponent(filter_department_id);
  }

  var filter_part_id = $('select[name=\'filter_part_id\']').val();
  
  if (filter_part_id > 0) {
    url += '&filter_part_id=' + encodeURIComponent(filter_part_id);
  }

  var filter_break = $('select[name=\'filter_break\']').val();
  
  if (filter_break > 0) {
    url += '&filter_break=' + encodeURIComponent(filter_break);
  }

  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('#button-export').on('click', function() {
  url = 'index.php?route=staff/staff/export&token=<?php echo $token; ?>';

  var filter_code = $('input[name=\'filter_code\']').val();
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }

  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_gender = $('select[name=\'filter_gender\']').val();
  
  if (filter_gender >= 0) {
    url += '&filter_gender=' + encodeURIComponent(filter_gender);
  }

  var filter_department_id = $('select[name=\'filter_department_id\']').val();
  
  if (filter_department_id > 0) {
    url += '&filter_department_id=' + encodeURIComponent(filter_department_id);
  }

  var filter_part_id = $('select[name=\'filter_part_id\']').val();
  
  if (filter_part_id > 0) {
    url += '&filter_part_id=' + encodeURIComponent(filter_part_id);
  }

  var filter_break = $('select[name=\'filter_break\']').val();
  
  if (filter_break > 0) {
    url += '&filter_break=' + encodeURIComponent(filter_break);
  }

  location = url;
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
  $('#staff-filter').keyup(function(e) {
    var code = e.keyCode || e.which;
      if(code == 13) {
        $('#button-filter').click();
      }
  });
</script>
<?php echo $footer; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-staff" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-staff" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-profile" data-toggle="tab"><?php echo $tab_profile; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane in active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-code"><?php echo $entry_code; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="code" value="<?php echo $code; ?>" placeholder="<?php echo $entry_code; ?>" id="input-code" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-working-code"><?php echo $entry_working_code; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="working_code" value="<?php echo $working_code; ?>" placeholder="<?php echo $entry_working_code; ?>" id="input-working-code" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-insure-code"><?php echo $entry_insure_code; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="insure_code" value="<?php echo $insure_code; ?>" placeholder="<?php echo $entry_insure_code; ?>" id="input-insure_code" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_department; ?></label>
                <div class="col-sm-3">
                  <select name="department_id" id="department1" class="form-control">
                    <?php foreach ($departments as $department) { ?>
                    <option <?php if ($department_id == $department['id']) { ?>selected="selected"<?php } ?> value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_part; ?></label>
                <div class="col-sm-3">
                  <select name="part_id" id="part" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($parts as $part) { ?>
                    <option <?php if ($part_id == $part['id']) { ?>selected="selected"<?php } ?> value="<?php echo $part['id']; ?>"><?php echo $part['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_position; ?></label>
                <div class="col-sm-3">
                  <select name="position_id" id="position" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($positions as $position) { ?>
                    <option <?php if ($position['id'] == $position_id) { ?>selected="selected"<?php } ?> value="<?php echo $position['id'] ?>"><?php echo $position['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-special"><?php echo $entry_special; ?></label>
                <div class="col-sm-3">
                  <select name="special" id="input-special" class="form-control">
                    <?php if ($special) { ?>
                    <option value="1" selected="selected"><?php echo $text_true; ?></option>
                    <option value="0"><?php echo $text_false; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_true; ?></option>
                    <option value="0" selected="selected"><?php echo $text_false; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-working_change"><?php echo $entry_working_change; ?></label>
                <div class="col-sm-3">
                  <select name="working_change" id="input-working_change" class="form-control">
                    <?php if ($working_change) { ?>
                    <option value="1" selected="selected"><?php echo $text_true; ?></option>
                    <option value="0"><?php echo $text_false; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_true; ?></option>
                    <option value="0" selected="selected"><?php echo $text_false; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-3">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane in" id="tab-profile">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-gender"><?php echo $entry_gender; ?></label>
                <div class="col-sm-3">
                  <select name="gender" id="input-gender" class="form-control">
                    <option value="1"><?php echo $text_male; ?></option>
                    <option <?php if ($gender == 0) { ?>selected="selected"<?php } ?> value="0"><?php echo $text_female; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_birthday; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="birthday" value="<?php echo $birthday; ?>" placeholder="<?php echo $entry_birthday; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_birthplace; ?></label>
                <div class="col-sm-3">
                  <select name="birthplace" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php foreach ($places as $place) { ?>
                    <option <?php if ($birthplace == $place['id']) { ?>selected = "selected"<?php } ?> value="<?php echo $place['id']; ?>"><?php echo $place['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-nation"><?php echo $entry_nation; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="nation" value="<?php echo $nation; ?>" placeholder="<?php echo $entry_nation; ?>" id="input-nation" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-religion"><?php echo $entry_religion; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="religion" value="<?php echo $religion; ?>" placeholder="<?php echo $entry_religion; ?>" id="input-religion" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_married; ?></label>
                <div class="col-sm-3">
                  <select name="married" class="form-control">
                    <option value="0"><?php echo $text_single; ?></option>
                    <option <?php if($marred == 1) { ?>selected = "selected"<?php } ?> value="1"><?php echo $text_family; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-id"><?php echo $entry_id; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="id" value="<?php echo $id; ?>" placeholder="<?php echo $entry_id; ?>" id="input-id" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_id_date; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="id_date" value="<?php echo $id_date; ?>" placeholder="<?php echo $entry_id_date; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_id_place; ?></label>
                <div class="col-sm-3">
                  <select name="id_place" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php foreach ($places as $place) { ?>
                    <option <?php if ($id_place == $place['id']) { ?>selected = "selected"<?php } ?> value="<?php echo $place['id']; ?>"><?php echo $place['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-address1"><?php echo $entry_address1; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="address1" value="<?php echo $address1; ?>" placeholder="<?php echo $entry_address1; ?>" id="input-address1" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-address2"><?php echo $entry_address2; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="address2" value="<?php echo $address2; ?>" placeholder="<?php echo $entry_address2; ?>" id="input-address2" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_degree; ?></label>
                <div class="col-sm-3">
                  <select name="degree" class="form-control">
                    <option><?php echo $text_none; ?></option>
                    <?php foreach ($degrees as $degree) { ?>
                    <option <?php if ($degree_id == $degree['id']) { ?>selected = "selected"<?php } ?> value="<?php echo $degree['id']; ?>"><?php echo $degree['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_technique; ?></label>
                <div class="col-sm-3">
                  <select name="technique" class="form-control">
                    <option><?php echo $text_none; ?></option>
                    <?php foreach ($techniques as $technique) { ?>
                    <option <?php if ($technique_id == $technique['id']) { ?>selected="selected"<?php } ?> value="<?php echo $technique['id']; ?>"><?php echo $technique['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_contract_start; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="contract_start" value="<?php echo $contract_start; ?>" placeholder="<?php echo $entry_contract_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_contract_end; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="contract_end" value="<?php echo $contract_end; ?>" placeholder="<?php echo $entry_contract_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_contract_kind; ?></label>
                <div class="col-sm-3">
                  <select name="contract_kind" class="form-control">
                    <option><?php echo $text_none; ?></option>
                    <?php foreach ($contract_kinds as $contract_kind) { ?>
                    <option <?php if ($contract_kind_id == $contract_kind['id']) { ?>selected="selected"<?php } ?> value="<?php echo $contract_kind['id']; ?>"><?php echo $contract_kind['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_work_start; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="work_start" value="<?php echo $work_start; ?>" placeholder="<?php echo $entry_work_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_work_end; ?></label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="work_end" value="<?php echo $work_end; ?>" placeholder="<?php echo $entry_work_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                  </span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_reason_work_end; ?></label>
                <div class="col-sm-5">
                  <textarea type="text" name="reason_work_end" placeholder="<?php echo $entry_reason_work_end; ?>" class="form-control" ><?php echo $reason_work_end; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-atm-account"><?php echo $entry_atm_account; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="atm_account" value="<?php echo $atm_account; ?>" placeholder="<?php echo $entry_atm_account; ?>" id="input-atm-account" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-atm-card"><?php echo $entry_atm_card; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="atm_card" value="<?php echo $atm_card; ?>" placeholder="<?php echo $entry_atm_card; ?>" id="input-atm-card" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tax-code"><?php echo $entry_tax_code; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="tax_code" value="<?php echo $tax_code; ?>" placeholder="<?php echo $entry_tax_code; ?>" id="input-tax-code" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_note; ?></label>
                <div class="col-sm-5">
                  <textarea type="text" name="note" placeholder="<?php echo $entry_note; ?>" class="form-control" ><?php echo $note; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-avatar"><?php echo $entry_avatar; ?></label>
                <div class="col-sm-10"> <a href="" id="thumb-avatar" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_avatar; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="avatar" value="<?php echo $avatar; ?>" id="input-avatar" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-id-image"><?php echo $entry_id_image; ?></label>
                <div class="col-sm-10"> <a href="" id="thumb-id-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_id_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="id_image" value="<?php echo $id_image; ?>" id="input-id-image" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $('#department1').on('change', function(){
    $.ajax({
      url: 'index.php?route=department/part/autocomplete&token=<?php echo $token; ?>&department_id=' + $(this).val(),
      dataType: 'json',
      success: function(json) {
        var html = '<option value="0"><?php echo $text_none; ?></option>';
        $.each(json, function(i, part) {
          html += '<option value="' + part.id + '">' + part.name + '</option>';
        });

        $('#part').html(html);
      }
    });
  });
  $('#part').on('change', function(){
    $.ajax({
      url: 'index.php?route=department/position/autocomplete&token=<?php echo $token; ?>&part_id=' + $(this).val(),
      dataType: 'json',
      success: function(json) {
        var html = '<option value="0"><?php echo $text_none; ?></option>';
        $.each(json, function(i, position) {
          html += '<option value="' + position.id + '">' + position.name + '</option>';
        });

        $('#position').html(html);
      }
    });
  });
</script>
<script type="text/javascript">
  $('.date').datetimepicker({
    pickTime: false
  });
</script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>
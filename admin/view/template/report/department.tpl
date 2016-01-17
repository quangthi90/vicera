<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
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
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
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
                <label class="control-label"><?php echo $entry_department; ?></label>
                <div class="input-group">
                  <select id="department" name="department_id" style="text-align: center;">
                    <?php foreach ($departments as $department) { ?>
                    <option <?php if ($department_id == $department['id']) { ?>selected="selected"<?php } ?> value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo $entry_part; ?></label>
                <div class="input-group">
                  <select id="part" name="part_id" style="text-align: center;">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($parts as $part) { ?>
                    <option <?php if ($part_id == $part['id']) { ?>selected="selected"<?php } ?> value="<?php echo $part['id']; ?>"><?php echo $part['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              <button style="margin-right: 5px;" id="button-export" class="btn btn-success pull-right"><i class="fa fa-cloud-download"></i> <?php echo $button_export; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_campaign; ?></td>
                <td class="text-left"><?php echo $column_code; ?></td>
                <td class="text-right"><?php echo $column_clicks; ?></td>
                <td class="text-right"><?php echo $column_orders; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($inventories) { ?>
              <?php foreach ($inventories as $inventory) { ?>
              <tr>
                <td class="text-left"><?php echo $inventory['campaign']; ?></td>
                <td class="text-left"><?php echo $inventory['code']; ?></td>
                <td class="text-right"><?php echo $inventory['clicks']; ?></td>
                <td class="text-right"><?php echo $inventory['orders']; ?></td>
                <td class="text-right"><?php echo $inventory['total']; ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=report/department&token=<?php echo $token; ?>';

  var department_id = $('select[name=\'department_id\']').val();
  
  if (department_id) {
    url += '&department_id=' + encodeURIComponent(department_id);
  }

  var part_id = $('select[name=\'part_id\']').val();
  
  if (part_id) {
    url += '&part_id=' + encodeURIComponent(part_id);
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
<script type="text/javascript"><!--
$('#button-export').on('click', function() {
  url = 'index.php?route=report/department/export&token=<?php echo $token; ?>';

  var department_id = $('select[name=\'department_id\']').val();
  
  if (department_id) {
    url += '&department_id=' + encodeURIComponent(department_id);
  }

  var part_id = $('select[name=\'part_id\']').val();
  
  if (part_id) {
    url += '&part_id=' + encodeURIComponent(part_id);
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
  $('select[name=\'department_id\']').on('change', function(){
    console.log('hehe');
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
</script>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>
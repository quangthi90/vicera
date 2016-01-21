<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-working-offset').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-working-offset">
          <div class="well">
            <div class="row" id="data-filter">
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
                  <label class="control-label" for="input-date-start"><?php echo $text_code; ?></label>
                  <div class="input-group">
                    <input type="text" name="filter_code" value="<?php echo $filter_code; ?>" placeholder="<?php echo $text_code; ?>" id="input-staff" class="form-control" />
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
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php echo $column_code; ?></td>
                  <td class="text-left"><?php echo $column_name; ?></td>
                  <td class="text-left"><?php echo $column_kind; ?></td>
                  <td class="text-left"><?php echo $column_date; ?></td>
                  <td class="text-left"><?php echo $column_from_hour; ?></td>
                  <td class="text-left"><?php echo $column_to_hour; ?></td>
                  <td class="text-left"><?php echo $column_full_day; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($working_offsets) { ?>
                <?php foreach ($working_offsets as $working_offset) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($working_offset['working_offset_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $working_offset['working_offset_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $working_offset['working_offset_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $working_offset['code']; ?></td>
                  <td class="text-left"><?php echo $working_offset['name']; ?></td>
                  <td class="text-left"><?php echo $working_offset['kind']; ?></td>
                  <td class="text-left"><?php echo $working_offset['date']; ?></td>
                  <td class="text-left"><?php echo $working_offset['from_hour']; ?></td>
                  <td class="text-left"><?php echo $working_offset['to_hour']; ?></td>
                  <td class="text-left"><?php echo $working_offset['full_day']; ?></td>
                  <td class="text-right"><a href="<?php echo $working_offset['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
$('.date').datetimepicker({
  pickTime: false
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
$('#button-filter').on('click', function() {console.log('hehe');
  url = 'index.php?route=staff/working_offset&token=<?php echo $token; ?>';

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

  location = url;
});
//--></script>
<script type="text/javascript">
  $('#data-filter').keyup(function(e) {
    var code = e.keyCode || e.which;
      if(code == 13) {
        $('#button-filter').click();
      }
  });
</script>
<?php echo $footer; ?>
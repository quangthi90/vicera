<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-part" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-part" class="form-horizontal">
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <div class="tab-content">
              </div>
              <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="position_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($position_description[$language['language_id']]) ? $position_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_department; ?></label>
                <div class="col-sm-10">
                  <select name="department_id" id="department1">
                    <?php foreach ($departments as $department) { ?>
                    <option <?php if ($department_id == $department['id']) { ?>selected="selected"<?php } ?> value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-delivery-group"><?php echo $entry_part; ?></label>
                <div class="col-sm-3">
                  <select name="part_id" id="part">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($parts as $part) { ?>
                    <option <?php if ($part_id == $part['id']) { ?>selected="selected"<?php } ?> value="<?php echo $part['id']; ?>"><?php echo $part['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-working"><?php echo $entry_working; ?></label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="text" name="working" value="<?php echo $working; ?>" placeholder="<?php echo $entry_working; ?>" id="input-working" class="form-control" />
                    <span class="input-group-btn"><button class="btn btn-default" type="button">h</button></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/part/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					part_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['part_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#part-filter' + item['value']).remove();

		$('#part-filter').append('<div id="part-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="part_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#part-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
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
</script>
<?php echo $footer; ?>
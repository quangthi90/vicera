<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-delivery" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-delivery" class="form-horizontal">
          <div class="form-group required" id="products">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <input id="product_name" type="text" placeholder="<?php echo $entry_name; ?>" value="<?php echo $name; ?>" <?php if($is_edit){ ?>disabled<?php } ?> class="form-control" />
                <input id="product_id" name="product_id" type="hidden" value="<?php echo $product_id; ?>" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-delivery-group"><?php echo $entry_quantity; ?></label>
            <div class="col-sm-3">
              <input onclick="this.setSelectionRange(0, this.value.length)" type="text" placeholder="<?php echo $entry_quantity; ?>" name="quantity" value="<?php echo $quantity ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-delivery-group"><?php echo $entry_department; ?></label>
            <div class="col-sm-3">
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
            <label class="col-sm-2 control-label" for="input-delivery-group"><?php echo $entry_date; ?></label>
            <div class="col-sm-3">
              <div class="input-group date">
                <input type="text" name="delivery_date" value="<?php echo $delivery_date; ?>" placeholder="<?php echo $entry_date; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" <?php if ($is_edit) { ?>disabled<?php } ?> />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
              </span></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#product_name').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('#product_name').val(item['label']);
    $('#product_id').val(item['value']);
  }
});
$('.date').datetimepicker({
  pickTime: false
});
</script>
<script type="text/javascript">
  $('select[name=\'department_id\']').on('change', function(){
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
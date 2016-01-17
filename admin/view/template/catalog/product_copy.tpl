<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_order; ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-up"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <div class="tab-content" id="list-products">
            <div class="product-item">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name-1"><?php echo $entry_name; ?> 1</label>
                <div class="col-sm-10">
                  <input type="text" placeholder="<?php echo $entry_name; ?> 1" id="input-name-1" class="form-control product-name" />
                  <input type="hidden" id="input-id-1" name="products[1][id]" class="form-control product-id" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="products[1][quantity]" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity-1" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div style="text-align: right;">
            <button class="btn btn-primary" type="button" id="add-product-btn"><i class="fa fa-plus"></i> <span>Thêm sản phẩm</span></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  var count = 1;
  $('#add-product-btn').on('click', function(){
    count++;
    var html = '<div class="product-item"><div class="form-group"><label class="col-sm-2 control-label" for="input-name-' + count + '"><?php echo $entry_name; ?> ' + count + '</label><div class="col-sm-10"><input type="text" placeholder="<?php echo $entry_name; ?> ' + count + '" id="input-name-' + count + '" class="form-control product-name" /><input type="hidden" id="input-id-' + count + '" name="products[' + count + '][id]" class="form-control product-id" /></div></div><div class="form-group"><label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label><div class="col-sm-10"><input type="text" name="products[' + count + '][quantity]" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity-' + count + '" class="form-control" /></div></div></div>';
    $('#list-products').append(html);
  });
  </script>

  <script type="text/javascript"><!--
  var products = {};
  $('#list-products').on('click', 'input.product-name', function(){    
    $(this).autocomplete({
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
        $(this).val(item['label']);
        $(this).parent().find('.product-id').val(item['value']);
      }
    });
  });
//--></script></div>
<?php echo $footer; ?> 
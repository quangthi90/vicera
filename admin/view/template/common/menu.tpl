<ul id="menu">
  <?php if ($user->hasPermission('modify', 'catalog/product')) { ?>
  <li id="dashboard"><a href="<?php echo $product; ?>"><i class="fa fa-list-alt fa-fw"></i> 
  <span><?php echo $text_product; ?></span></a></li>
  <?php } ?>
  <?php if ($user->hasPermission('modify', 'catalog/category')) { ?>
  <li id="catalog"><a href="<?php echo $category; ?>"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_category; ?></span></a></li>
  <?php } ?>
  <li id="staff"><a class="parent"><i class="fa fa-users fa-fw"></i> <span><?php echo $text_staffs; ?></span></a>
    <ul>
      <?php if ($user->hasPermission('modify', 'staff/staff')) { ?>
      <li><a href="<?php echo $staff; ?>"><?php echo $text_staff; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/degree')) { ?>
      <li><a href="<?php echo $degree; ?>"><?php echo $text_degree; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/technique')) { ?>
      <li><a href="<?php echo $technique; ?>"><?php echo $text_technique; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/contract_kind')) { ?>
      <li><a href="<?php echo $contract_kind; ?>"><?php echo $text_contract_kind; ?></a></li
      >
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'localisation/place')) { ?>
      <li><a href="<?php echo $place; ?>"><?php echo $text_place; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/working')) { ?>
      <li><a href="<?php echo $working; ?>"><?php echo $text_working; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/working_offset')) { ?>
      <li><a href="<?php echo $working_offset; ?>"><?php echo $text_working_offset; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/timesheet')) { ?>
      <li><a href="<?php echo $timesheet; ?>"><?php echo $text_timesheet; ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <li id="department"><a class="parent"><i class="fa fa-building fa-fw"></i> <span><?php echo $text_departments; ?></span></a>
    <ul>
      <?php if ($user->hasPermission('modify', 'department/department')) { ?>
      <li><a href="<?php echo $department; ?>"><?php echo $text_department; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'department/part')) { ?>
      <li><a href="<?php echo $part; ?>"><?php echo $text_part; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'department/position')) { ?>
      <li><a href="<?php echo $position; ?>"><?php echo $text_position; ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <li id="import"><a class="parent"><i class="fa fa-arrow-circle-o-down fa-fw"></i> <span><?php echo $text_import; ?></span></a>
    <ul>
      <?php if ($user->hasPermission('modify', 'warehouse/receipt')) { ?>
      <li><a href="<?php echo $receipt; ?>"><?php echo $text_receipt; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/working')) { ?>
      <li><a href="<?php echo $working_import; ?>"><?php echo $text_working_import; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/staff')) { ?>
      <li><a href="<?php echo $staff_import; ?>"><?php echo $text_staff_import; ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <?php if ($user->hasPermission('modify', 'warehouse/delivery')) { ?>
  <li id="extension"><a href="<?php echo $delivery; ?>"><i class="fa fa-arrow-circle-o-up fa-fw"></i> <span><?php echo $text_delivery; ?></span></a></li>
  <?php } ?>
  <li id="tools"><a class="parent"><i class="fa fa-line-chart fa-fw"></i> <span><?php echo $text_report; ?></span></a>
    <ul>
      <?php if ($user->hasPermission('modify', 'report/inventory')) { ?>
      <li><a href="<?php echo $inventory; ?>"><?php echo $text_inventory; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'report/department')) { ?>
      <li><a href="<?php echo $report_department; ?>"><?php echo $text_report_department; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'report/product')) { ?>
      <li><a href="<?php echo $report_product; ?>"><?php echo $text_report_product; ?></a></li>
      <?php } ?>
      <?php if ($user->hasPermission('modify', 'staff/staff')) { ?>
      <li><a href="<?php echo $report_staff; ?>"><?php echo $text_report_staff; ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <?php if ($isAdmin == true) { ?>
  <li><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_setting; ?></span></a>
    <ul>
      <li><a href="<?php echo $user_link; ?>"><?php echo $text_user; ?></a></li>
      <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
    </ul>
  </li>
  <?php } ?>
</ul>

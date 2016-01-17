<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['text_category'] = $this->language->get('text_category');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_departments'] = $this->language->get('text_departments');
		$data['text_department'] = $this->language->get('text_department');
		$data['text_part'] = $this->language->get('text_part');
		$data['text_position'] = $this->language->get('text_position');
		$data['text_import'] = $this->language->get('text_import');
		$data['text_receipt'] = $this->language->get('text_receipt');
		$data['text_staff_import'] = $this->language->get('text_staff_import');
		$data['text_working_import'] = $this->language->get('text_working_import');
		$data['text_delivery'] = $this->language->get('text_delivery');
		$data['text_inventory'] = $this->language->get('text_inventory');
		$data['text_report_department'] = $this->language->get('text_report_department');
		$data['text_report_product'] = $this->language->get('text_report_product');
		$data['text_report_staff'] = $this->language->get('text_report_staff');
		$data['text_report'] = $this->language->get('text_report');
		$data['text_staffs'] = $this->language->get('text_staffs');
		$data['text_staff'] = $this->language->get('text_staff');
		$data['text_degree'] = $this->language->get('text_degree');
		$data['text_technique'] = $this->language->get('text_technique');
		$data['text_contract_kind'] = $this->language->get('text_contract_kind');
		$data['text_place'] = $this->language->get('text_place');
		$data['text_working'] = $this->language->get('text_working');
		$data['text_working_offset'] = $this->language->get('text_working_offset');
		$data['text_timesheet'] = $this->language->get('text_timesheet');
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');

		$data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
		$data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
		$data['department'] = $this->url->link('department/department', 'token=' . $this->session->data['token'], 'SSL');
		$data['part'] = $this->url->link('department/part', 'token=' . $this->session->data['token'], 'SSL');
		$data['position'] = $this->url->link('department/position', 'token=' . $this->session->data['token'], 'SSL');
		$data['receipt'] = $this->url->link('warehouse/receipt', 'token=' . $this->session->data['token'], 'SSL');
		$data['working_import'] = $this->url->link('staff/working/import', 'token=' . $this->session->data['token'], 'SSL');
		$data['staff_import'] = $this->url->link('staff/staff/import', 'token=' . $this->session->data['token'], 'SSL');
		$data['delivery'] = $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'], 'SSL');
		$data['inventory'] = $this->url->link('report/inventory', 'token=' . $this->session->data['token'], 'SSL');
		$data['report_department'] = $this->url->link('report/department', 'token=' . $this->session->data['token'], 'SSL');
		$data['report_product'] = $this->url->link('report/product', 'token=' . $this->session->data['token'], 'SSL');
		$data['report_staff'] = $this->url->link('staff/staff/report', 'token=' . $this->session->data['token'], 'SSL');
		$data['staff'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'], 'SSL');
		$data['degree'] = $this->url->link('staff/degree', 'token=' . $this->session->data['token'], 'SSL');
		$data['technique'] = $this->url->link('staff/technique', 'token=' . $this->session->data['token'], 'SSL');
		$data['contract_kind'] = $this->url->link('staff/contract_kind', 'token=' . $this->session->data['token'], 'SSL');
		$data['place'] = $this->url->link('localisation/place', 'token=' . $this->session->data['token'], 'SSL');
		$data['working'] = $this->url->link('staff/working', 'token=' . $this->session->data['token'], 'SSL');
		$data['working_offset'] = $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'], 'SSL');
		$data['timesheet'] = $this->url->link('staff/timesheet', 'token=' . $this->session->data['token'], 'SSL');
		$data['user_link'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
		
		if ($this->user->getGroupId() == 1) {
			$data['isAdmin'] = true;
		} else {
			$data['isAdmin'] = false;
		}

		$data['user'] = $this->user;

		return $this->load->view('common/menu.tpl', $data);
	}
}
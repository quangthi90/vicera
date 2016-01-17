<?php
class ControllerReportDepartment extends Controller {
	public function index() {
		$this->load->language('report/department');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['department_id'])) {
			$department_id = $this->request->get['department_id'];
		} else {
			$department_id = '';
		}

		if (isset($this->request->get['part_id'])) {
			$part_id = $this->request->get['part_id'];
		} else {
			$part_id = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/department', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/department');

		$data['inventories'] = array();
		$department_total = 0;

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'                  => $this->config->get('config_limit_admin')
			);

			$department_total = $this->model_report_department->getTotalDepartment($department_id, $part_id, $filter_data);

			$results = $this->model_report_department->getDepartment($department_id, $part_id, $filter_data);

			foreach ($results as $result) {
				$action = array();

				$data['inventories'][] = array(
					'campaign' => $result['name'],
					'code'     => $result['tag'],
					'clicks'   => number_format($result['price']),
					'orders'   => $result['delivery_quantity'],
					'total'    => number_format($result['price'] * $result['delivery_quantity'])
				);
			}
		}

		$data['departments'] = array();
		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments(array('limit' => 1000, 'start' => 0), true);
		foreach ($departments as $department) {
			$data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}

		$this->load->model('department/part');
		if (empty($department_id)) {
			$department_id = $departments[0]['department_id'];
		}
		$parts = $this->model_department_part->getParts(array(
			'start' => 0,
			'limit' => 100,
			'filter_department_id' => $department_id,
		));
		$data['parts'] = array();
		foreach ($parts as $part) {
			$data['parts'][] = array(
				'id' => $part['part_id'],
				'name' => $part['name']
			);
		}

		$data['department_id'] = $department_id;
		$data['part_id'] = $part_id;

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');
		$data['text_none'] = $this->language->get('text_none');

		$data['column_campaign'] = $this->language->get('column_campaign');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_clicks'] = $this->language->get('column_clicks');
		$data['column_orders'] = $this->language->get('column_orders');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_part'] = $this->language->get('entry_part');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_export'] = $this->language->get('button_export');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['department_id'])) {
			$url .= '&department_id=' . $this->request->get['department_id'];
		}

		if (isset($this->request->get['part_id'])) {
			$url .= '&part_id=' . $this->request->get['part_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $department_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/department', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($department_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($department_total - $this->config->get('config_limit_admin'))) ? $department_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $department_total, ceil($department_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/department.tpl', $data));
	}

	function export() {
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['department_id'])) {
			$department_id = $this->request->get['department_id'];
		} else {
			$department_id = '';
		}

		if (isset($this->request->get['part_id'])) {
			$part_id = $this->request->get['part_id'];
		} else {
			$part_id = '';
		}

		$this->load->model('report/department');

		$inventories = array();

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'					 => 0,
				'limit'					 => 1000
			);

			$results = $this->model_report_department->getDepartment($department_id, $part_id, $filter_data);

			$this->load->language('report/department');

			$arr_data = array(
				'A1' => 'STT',
				'B1' => $this->language->get('column_campaign'),
				'C1' => $this->language->get('column_code'),
				'D1' => $this->language->get('column_clicks'),
				'E1' => $this->language->get('column_orders'),
				'F1' => $this->language->get('column_total')
			);

			$row = 1;
			foreach ($results as $result) {
				$row++;
				try {
					// STT
					$arr_data['A' . $row] = $row - 1;
					// Tên sản phẩm
					$arr_data['B' . $row] = $result['name'];
					// Đơn vị tính
					$arr_data['C' . $row] = $result['tag'];
					// Đơn giá
					$arr_data['D' . $row] = $result['price'];
					// Số lượng xuất kho
					$arr_data['E' . $row] = $result['delivery_quantity'];
					// Thành tiền
					$arr_data['F' . $row] = $result['price'] * $result['delivery_quantity'];
				} catch (Exception $e) {
					print $result['name'] . '<br>';
				}
			}
			$filename = 'department';
			$file = DIR_DOWNLOAD . $filename . '.xlsx';
			$sheetname = $filter_date_start . '_' . $filter_date_end;

			$this->load->model('tool/excel');
			$this->model_tool_excel->modifyExcelFile($arr_data, $file, $sheetname);

			print "COMPLETED!";
			$this->response->redirect(HTTP_CATALOG . 'system/download/' . $filename . '.xlsx');
		}

		exit;
	}
}
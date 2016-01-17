<?php
class ControllerReportInventory extends Controller {
	public function index() {
		$this->load->language('report/inventory');

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
			'href' => $this->url->link('report/inventory', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/inventory');

		$data['inventories'] = array();
		$inventory_total = 0;

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'                  => $this->config->get('config_limit_admin')
			);

			$inventory_total = $this->model_report_inventory->getTotalInventory($filter_data);

			$results = $this->model_report_inventory->getInventory($filter_data);

			foreach ($results as $result) {
				$action = array();

				/*$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('inventory/inventory/edit', 'token=' . $this->session->data['token'] . '&inventory_id=' . $result['inventory_id'] . $url, 'SSL')
				);*/

				$data['inventories'][] = array(
					'campaign' => $result['name'],
					'code'     => $result['tag'],
					'clicks'   => $result['quantity_input'],
					'orders'   => $result['receipt_quantity_total'],
					'total'    => $result['delivery_quantity_total'],
					'action'   => $result['quantity_inventory']
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_campaign'] = $this->language->get('column_campaign');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_clicks'] = $this->language->get('column_clicks');
		$data['column_orders'] = $this->language->get('column_orders');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_status'] = $this->language->get('entry_status');

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

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $inventory_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/inventory', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($inventory_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($inventory_total - $this->config->get('config_limit_admin'))) ? $inventory_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $inventory_total, ceil($inventory_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/inventory.tpl', $data));
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

		$this->load->model('report/inventory');

		$inventories = array();

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'					 => 0,
				'limit'					 => 1000
			);

			$results = $this->model_report_inventory->getInventory($filter_data);

			$this->load->language('report/inventory');

			$arr_data = array(
				'A1' => 'STT',
				'B1' => $this->language->get('column_campaign'),
				'C1' => $this->language->get('column_code'),
				'D1' => $this->language->get('column_clicks'),
				'E1' => $this->language->get('column_orders'),
				'F1' => $this->language->get('column_total'),
				'G1' => $this->language->get('column_action')
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
					// Tồn đầu kỳ
					$arr_data['D' . $row] = $result['quantity_input'];
					// Tổng nhập
					$arr_data['E' . $row] = $result['receipt_quantity_total'];
					// Tổng xuất
					$arr_data['F' . $row] = $result['delivery_quantity_total'];
					// Tồn cuối kỳ
					$arr_data['G' . $row] = $result['quantity_inventory'];
				} catch (Exception $e) {
					print $result['name'] . '<br>';
				}
			}
			$filename = 'inventory';
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
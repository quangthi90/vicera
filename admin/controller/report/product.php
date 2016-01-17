<?php
class ControllerReportProduct extends Controller {
	public function index() {
		$this->load->language('report/product');

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

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = '';
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
			'href' => $this->url->link('report/product', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/product');

		$data['inventories'] = array();
		$department_total = 0;

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'                  => $this->config->get('config_limit_admin')
			);

			$results = $this->model_report_product->getDepartments($product_id, $filter_data);

			$department_total = count($results);

			$this->load->model('catalog/product');
			$product = $this->model_catalog_product->getProduct($product_id);

			foreach ($results as $result) {
				$action = array();

				$data['inventories'][] = array(
					'campaign' => $result['name'],
					'product'  => $product['name'],
					'code'     => $product['tag'],
					'clicks'   => number_format($product['price']),
					'orders'   => $result['total'],
					'total'    => number_format($product['price'] * $result['total'])
				);
			}
		}

		$data['product_id'] = $product_id;
		$data['product_name'] = '';
		if (!empty($product_id)) {
			$this->load->model('catalog/product');
			$product = $this->model_catalog_product->getProduct($product_id);
			$data['product_name'] = $product['name'];
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_campaign'] = $this->language->get('column_campaign');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_clicks'] = $this->language->get('column_clicks');
		$data['column_orders'] = $this->language->get('column_orders');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_product'] = $this->language->get('entry_product');

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
		$pagination->total = $department_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($department_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($department_total - $this->config->get('config_limit_admin'))) ? $department_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $department_total, ceil($department_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/product.tpl', $data));
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

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = '';
		}

		$this->load->model('report/product');

		$inventories = array();

		if (!empty($filter_date_start) && !empty($filter_date_end)) {
			$filter_data = array(
				'filter_date_start'	     => $filter_date_start,
				'filter_date_end'	     => $filter_date_end,
				'start'					 => 0,
				'limit'					 => 1000
			);

			$results = $this->model_report_product->getDepartments($product_id, $filter_data);

			$this->load->model('catalog/product');
			$product = $this->model_catalog_product->getProduct($product_id);

			$this->load->language('report/product');

			$arr_data = array(
				'A1' => 'STT',
				'B1' => $this->language->get('column_campaign'),
				'C1' => $this->language->get('column_product'),
				'D1' => $this->language->get('column_code'),
				'E1' => $this->language->get('column_clicks'),
				'F1' => $this->language->get('column_orders'),
				'G1' => $this->language->get('column_total')
			);

			$row = 1;
			foreach ($results as $result) {
				$row++;
				try {
					// STT
					$arr_data['A' . $row] = $row - 1;
					// Tên phòng ban
					$arr_data['B' . $row] = $result['name'];
					// Tên sản phẩm
					$arr_data['C' . $row] = $product['name'];
					// Đơn vị tính
					$arr_data['D' . $row] = $product['tag'];
					// Đơn giá
					$arr_data['E' . $row] = $product['price'];
					// Số lượng xuất kho
					$arr_data['F' . $row] = $result['total'];
					// Thành tiền
					$arr_data['G' . $row] = $product['price'] * $result['total'];
				} catch (Exception $e) {
					print $result['name'] . '<br>';
				}
			}
			$filename = 'product';
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
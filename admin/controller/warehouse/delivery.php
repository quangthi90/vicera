<?php
class ControllerWarehouseDelivery extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('warehouse/delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('warehouse/delivery');

		$this->getList();
	}

	public function add() {
		$this->load->language('warehouse/delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('warehouse/delivery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_warehouse_delivery->addDelivery($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('warehouse/delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('warehouse/delivery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_warehouse_delivery->editDelivery($this->request->get['delivery_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('warehouse/delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('warehouse/delivery');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $delivery_id) {
				$this->model_warehouse_delivery->deleteDelivery($delivery_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'rc.Delivery_date';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'dESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
			'href' => $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('warehouse/delivery/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('warehouse/delivery/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['deliveries'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$delivery_total = $this->model_warehouse_delivery->getTotalDeliveries();

		$results = $this->model_warehouse_delivery->getDeliveries($filter_data);

		foreach ($results as $result) {
			$data['deliveries'][] = array(
				'delivery_id'    	  => $result['delivery_id'],
				'product_id' 	  => $result['product_id'],
				'name'            => $result['product_name'],
				'quantity'        => $result['delivery_quantity'],
				'price'           => number_format($result['price']),
				'total'           => number_format($result['price'] * $result['delivery_quantity']),
				'date'        	  => date($this->language->get('date_format_short'), strtotime($result['delivery_date'])),
				'department_name' => $result['department_name'],
				'part_name' 	  => $result['part_name'],
				'edit'            => $this->url->link('warehouse/delivery/edit', 'token=' . $this->session->data['token'] . '&delivery_id=' . $result['delivery_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_department'] = $this->language->get('column_department');
		$data['column_part'] = $this->language->get('column_part');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_date'] = $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . '&sort=rc.Delivery_date' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $delivery_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($delivery_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($delivery_total - $this->config->get('config_limit_admin'))) ? $delivery_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $delivery_total, ceil($delivery_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('warehouse/delivery_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['delivery_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_part'] = $this->language->get('entry_part');
		$data['entry_date'] = $this->language->get('entry_date');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
			'href' => $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['delivery_id'])) {
			$data['action'] = $this->url->link('warehouse/delivery/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('warehouse/delivery/edit', 'token=' . $this->session->data['token'] . '&delivery_id=' . $this->request->get['delivery_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('warehouse/delivery', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['is_edit'] = false;
		if (isset($this->request->get['delivery_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$delivery_info = $this->model_warehouse_delivery->getDelivery($this->request->get['delivery_id']);
			$data['is_edit'] = true;
		}

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($delivery_info)) {
			$data['product_id'] = $delivery_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (!empty($delivery_info)) {
			$data['name'] = $delivery_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($delivery_info)) {
			$data['quantity'] = $delivery_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['department_id'])) {
			$data['department_id'] = $this->request->post['department_id'];
		} elseif (!empty($delivery_info)) {
			$data['department_id'] = $delivery_info['department_id'];
		} else {
			$data['department_id'] = '';
		}

		if (isset($this->request->post['part_id'])) {
			$data['part_id'] = $this->request->post['part_id'];
		} elseif (!empty($delivery_info)) {
			$data['part_id'] = $delivery_info['part_id'];
		} else {
			$data['part_id'] = '';
		}

		if (isset($this->request->post['delivery_date'])) {
			$data['delivery_date'] = $this->request->post['delivery_date'];
		} elseif (!empty($delivery_info)) {
			$data['delivery_date'] = ($delivery_info['delivery_date'] != '0000-00-00') ? $delivery_info['delivery_date'] : '';
		} else {
			$data['delivery_date'] = date('Y-m-d');
		}

		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments();
		$data['departments'] = array();
		foreach ($departments as $department) {
			$data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}

		$this->load->model('department/part');
		if ($data['department_id'] == null) {
			$department_id = $departments[0]['department_id'];
		} else {
			$department_id = $data['department_id'];
		}
		$parts = $this->model_department_part->getParts(array(
			'start' => 0,
			'limit' => 100,
			'filter_department_id' => $department_id
		));
		$data['parts'] = array();
		foreach ($parts as $part) {
			$data['parts'][] = array(
				'id' => $part['part_id'],
				'name' => $part['name']
			);
		}

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('warehouse/delivery_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'warehouse/delivery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/product');
		$product = $this->model_catalog_product->getProduct($this->request->post['product_id']);
		if (!empty($product) && $product['quantity'] < $this->request->post['quantity']) {
			$this->error['warning'] = $this->language->get('error_quantity');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'warehouse/delivery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('warehouse/delivery');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_warehouse_delivery->getDeliveries($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'delivery_id'    => $result['delivery_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'delivery_group' => $result['delivery_group']
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
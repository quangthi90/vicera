<?php
class ControllerStaffWorkingOffset extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('staff/working_offset');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working_offset');

		$this->getList();
	}

	public function add() {
		$this->load->language('staff/working_offset');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working_offset');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_working_offset->addWorkingOffset($this->request->post);

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

			$this->response->redirect($this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('staff/working_offset');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working_offset');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_working_offset->editWorkingOffset($this->request->get['working_offset_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('staff/working_offset');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/working_offset');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $working_offset_id) {
				$this->model_staff_working_offset->deleteWorkingOffset($working_offset_id);
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

			$this->response->redirect($this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = '';
		}

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

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

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
			'href' => $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['add'] = $this->url->link('staff/working_offset/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('staff/working_offset/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['working_offsets'] = array();

		$this->load->model('staff/staff');
		$staff = $this->model_staff_staff->getStaffByCode($filter_code);
		$staff_id = '';
		if (!empty($staff)) {
			$staff_id = $staff['staff_id'];
		}

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
			'staff_id' => $staff_id,
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
		);

		$working_offset_total = $this->model_staff_working_offset->getTotalWorkingOffsets($filter_data);

		$results = $this->model_staff_working_offset->getWorkingOffsets($filter_data);

		foreach ($results as $result) {
			$is_friday = false;
			if (date('l', strtotime($result['date'])) == "Friday") {
				$is_friday = true;
			}

			switch ($result['kind']) {
				case 1:
					$result['kind'] = $this->language->get('text_offset');
					break;
				
				case 2:
					$result['kind'] = $this->language->get('text_absent');
					break;

				case 3:
					$result['kind'] = $this->language->get('text_over');
					break;

				case 4:
					$result['kind'] = $this->language->get('text_ab_year');
					break;
			}

			$data['working_offsets'][] = array(
				'working_offset_id'  => $result['working_offset_id'],
				'code'        => $result['code'],
				'name'        => $result['fullname'],
				'kind'        => $result['kind'],
				'date'        => $result['date'],
				'from_hour'   => $result['from_hour'],
				'to_hour'     => $result['to_hour'],
				'full_day' => $result['is_full_day'] ? $this->language->get('text_true') : $this->language->get('text_false'),
				'edit'        => $this->url->link('staff/working_offset/edit', 'token=' . $this->session->data['token'] . '&working_offset_id=' . $result['working_offset_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_code'] = $this->language->get('text_code');

		$data['column_code'] = $this->language->get('column_code');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_kind'] = $this->language->get('column_kind');
		$data['column_from_hour'] = $this->language->get('column_from_hour');
		$data['column_to_hour'] = $this->language->get('column_to_hour');
		$data['column_full_day'] = $this->language->get('column_full_day');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

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

		$data['sort_name'] = $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $working_offset_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($working_offset_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($working_offset_total - $this->config->get('config_limit_admin'))) ? $working_offset_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $working_offset_total, ceil($working_offset_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_code'] = $filter_code;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/working_offset_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['working_offset_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_offset'] = $this->language->get('text_offset');
		$data['text_absent'] = $this->language->get('text_absent');
		$data['text_over'] = $this->language->get('text_over');
		$data['text_ab_year'] = $this->language->get('text_ab_year');

		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_kind'] = $this->language->get('entry_kind');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_from_hour'] = $this->language->get('entry_from_hour');
		$data['entry_to_hour'] = $this->language->get('entry_to_hour');
		$data['entry_full_day'] = $this->language->get('entry_full_day');

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
			'href' => $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['working_offset_id'])) {
			$data['is_edit'] = false;
			$data['action'] = $this->url->link('staff/working_offset/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['is_edit'] = true;
			$data['action'] = $this->url->link('staff/working_offset/edit', 'token=' . $this->session->data['token'] . '&working_offset_id=' . $this->request->get['working_offset_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('staff/working_offset', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['working_offset_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$working_offset_info = $this->model_staff_working_offset->getWorkingOffset($this->request->get['working_offset_id']);
		}

		$data['token'] = $this->session->data['token'];

		// staff id
		if (isset($this->request->post['staff_id'])) {
			$data['staff_id'] = $this->request->post['staff_id'];
		} elseif (!empty($working_offset_info)) {
			$data['staff_id'] = $working_offset_info['staff_id'];
		} else {
			$data['staff_id'] = '';
		}
		$this->load->model('staff/staff');
		$staff = $this->model_staff_staff->getStaff($data['staff_id']);
		$data['code'] = !empty($staff) ? $staff['code'] : '';

		// kind
		if (isset($this->request->post['kind'])) {
			$data['kind'] = $this->request->post['kind'];
		} elseif (!empty($working_offset_info)) {
			$data['kind'] = $working_offset_info['kind'];
		} else {
			$data['kind'] = '';
		}

		// date
		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($working_offset_info)) {
			$data['date'] = $working_offset_info['date'];
		} else {
			$data['date'] = '';
		}

		// from_hour
		if (isset($this->request->post['from_hour'])) {
			$data['from_hour'] = $this->request->post['from_hour'];
		} elseif (!empty($working_offset_info)) {
			$data['from_hour'] = $working_offset_info['from_hour'];
		} else {
			$data['from_hour'] = '';
		}

		// to_hour
		if (isset($this->request->post['to_hour'])) {
			$data['to_hour'] = $this->request->post['to_hour'];
		} elseif (!empty($working_offset_info)) {
			$data['to_hour'] = $working_offset_info['to_hour'];
		} else {
			$data['to_hour'] = '';
		}

		// is_full_day
		if (isset($this->request->post['is_full_day'])) {
			$data['is_full_day'] = $this->request->post['is_full_day'];
		} elseif (!empty($working_offset_info)) {
			$data['is_full_day'] = $working_offset_info['is_full_day'];
		} else {
			$data['is_full_day'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/working_offset_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'staff/working_offset')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 

		if (!empty($this->request->post['code'])) {
			$this->load->model('staff/staff');
			$staffs = $this->model_staff_staff->getStaffs(array(
				'filter_code' => $this->request->post['code']
			));
			if (empty($staffs)) {
				$this->error['warning'] = $this->language->get('error_code');
			} elseif (empty($this->request->post['staff_id']) || $staffs[0]['staff_id'] != $this->request->post['staff_id']) {
				$this->request->post['staff_id'] = $staffs[0]['staff_id'];
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'staff/working_offset')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
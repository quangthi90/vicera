<?php
class ControllerStaffStaff extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		$this->getList();
	}

	public function add() {
		$this->load->language('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_staff->addStaff($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
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

			$this->response->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_staff->editStaff($this->request->get['staff_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
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

			$this->response->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $staff_id) {
				$this->model_staff_staff->DeleteStaff($staff_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['filter_code'])) {
				$url .= '&filter_code=' . $this->request->get['filter_code'];
			}

			if (isset($this->request->get['filter_department_id'])) {
				$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
			}

			if (isset($this->request->get['filter_part_id'])) {
				$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
			}

			if (isset($this->request->get['filter_gender'])) {
				$url .= '&filter_gender=' . $this->request->get['filter_gender'];
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

			$this->response->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		/*$this->load->model('staff/staff');
		$staffs = $this->model_staff_staff->getStaffs(array(
			'start' => 0,
			'limit' => 1000
		));
		$arr = array();
		$row = 1;
		foreach ($staffs as $staff) {
			if ($staff['special']) continue;
			for ($i = '2015-12-01'; $i < '2015-12-16'; $i++) {
				$arr['A' . $row] = $staff['staff_id'];
				$arr['B' . $row] = $staff['fullname'];
				$arr['C' . $row] = $i;
				$row++;
			}
		}

		$filename = 'department';
		$file = DIR_DOWNLOAD . $filename . '.xlsx';
		$sheetname = '2015-12-01 - 2015-12-16';

		$this->load->model('tool/excel');
		$this->model_tool_excel->modifyExcelFile($arr, $file, $sheetname);

		$this->response->redirect(HTTP_CATALOG . 'system/download/' . $filename . '.xlsx');

		exit;*/

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = '';
		}

		if (isset($this->request->get['filter_department_id'])) {
			$filter_department_id = $this->request->get['filter_department_id'];
		} else {
			$filter_department_id = '';
		}

		if (isset($this->request->get['filter_part_id'])) {
			$filter_part_id = $this->request->get['filter_part_id'];
		} else {
			$filter_part_id = '';
		}

		if (isset($this->request->get['filter_gender'])) {
			$filter_gender = (int)$this->request->get['filter_gender'];
		} else {
			$filter_gender = null;
		}

		if (isset($this->request->get['filter_break'])) {
			$filter_break = (int)$this->request->get['filter_break'];
		} else {
			$filter_break = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'firstname';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_break'])) {
			$url .= '&filter_break=' . $this->request->get['filter_break'];
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
			'href' => $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['add'] = $this->url->link('staff/staff/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('staff/staff/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['staffs'] = array();

		$filter_data = array(
			'filter_code' => $filter_code,
			'filter_name' => $filter_name,
			'filter_gender' => $filter_gender,
			'filter_department_id' => $filter_department_id,
			'filter_part_id' => $filter_part_id,
			'filter_break' => $filter_break,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$staff_total = $this->model_staff_staff->getTotalStaffs($filter_data);

		$results = $this->model_staff_staff->getStaffs($filter_data);

		foreach ($results as $result) {
			$data['staffs'][] = array(
				'staff_id' 	  => $result['staff_id'],
				'name'        => $result['firstname'] . ' ' . $result['lastname'],
				'code'        => $result['code'],
				'working_code' => $result['working_code'],
				'department'  => $result['department_name'],
				'part'        => $result['part_name'],
				'position'    => $result['position_name'],
				'status'      => ($result['st_status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'        => $this->url->link('staff/staff/edit', 'token=' . $this->session->data['token'] . '&staff_id=' . $result['staff_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_female'] = $this->language->get('text_female');
		$data['text_male'] = $this->language->get('text_male');
		$data['text_true'] = $this->language->get('text_true');
		$data['text_false'] = $this->language->get('text_false');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_working_code'] = $this->language->get('column_working_code');
		$data['column_department'] = $this->language->get('column_department');
		$data['column_part'] = $this->language->get('column_part');
		$data['column_position'] = $this->language->get('column_position');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_export'] = $this->language->get('button_export');

		$data['entry_gender'] = $this->language->get('entry_gender');
		$data['entry_break'] = $this->language->get('entry_break');

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_break'])) {
			$url .= '&filter_break=' . $this->request->get['filter_break'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_break'])) {
			$url .= '&filter_break=' . $this->request->get['filter_break'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $staff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($staff_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($staff_total - $this->config->get('config_limit_admin'))) ? $staff_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $staff_total, ceil($staff_total / $this->config->get('config_limit_admin')));

		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments(array(
			'start' => 0,
			'limit' => 100
		));
		$data['departments'] = array();
		foreach ($departments as $department) {
			$data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}
		$data['parts'] = array();
		if (!empty($filter_department_id)) {
			$this->load->model('department/part');
			$parts = $this->model_department_part->getParts(array(
				'filter_department_id' => $filter_department_id,
				'start' => 0,
				'limit' => 100
			));
			foreach ($parts as $part) {
				$data['parts'][] = array(
					'id' => $part['part_id'],
					'name' => $part['name']
				);
			}
		}

		$data['filter_name'] = $filter_name;
		$data['filter_code'] = $filter_code;
		$data['filter_gender'] = $filter_gender;
		$data['filter_department_id'] = $filter_department_id;
		$data['filter_part_id'] = $filter_part_id;
		$data['filter_break'] = $filter_break;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/staff_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['staff_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_male'] = $this->language->get('text_male');
		$data['text_female'] = $this->language->get('text_female');
		$data['text_single'] = $this->language->get('text_single');
		$data['text_family'] = $this->language->get('text_family');
		$data['text_true'] = $this->language->get('text_true');
		$data['text_false'] = $this->language->get('text_false');

		// General
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_working_code'] = $this->language->get('entry_working_code');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_part'] = $this->language->get('entry_part');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_insure_code'] = $this->language->get('entry_insure_code');
		$data['entry_special'] = $this->language->get('entry_special');
		$data['entry_working_change'] = $this->language->get('entry_working_change');
		// Profile
		$data['entry_gender'] = $this->language->get('entry_gender');
		$data['entry_birthday'] = $this->language->get('entry_birthday');
		$data['entry_birthplace'] = $this->language->get('entry_birthplace');
		$data['entry_nation'] = $this->language->get('entry_nation');
		$data['entry_religion'] = $this->language->get('entry_religion');
		$data['entry_married'] = $this->language->get('entry_married');
		$data['entry_id'] = $this->language->get('entry_id');
		$data['entry_id_date'] = $this->language->get('entry_id_date');
		$data['entry_id_place'] = $this->language->get('entry_id_place');
		$data['entry_address1'] = $this->language->get('entry_address1');
		$data['entry_address2'] = $this->language->get('entry_address2');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_degree'] = $this->language->get('entry_degree');
		$data['entry_technique'] = $this->language->get('entry_technique');
		$data['entry_contract_start'] = $this->language->get('entry_contract_start');
		$data['entry_contract_end'] = $this->language->get('entry_contract_end');
		$data['entry_contract_kind'] = $this->language->get('entry_contract_kind');
		$data['entry_work_start'] = $this->language->get('entry_work_start');
		$data['entry_work_end'] = $this->language->get('entry_work_end');
		$data['entry_reason_work_end'] = $this->language->get('entry_reason_work_end');
		$data['entry_atm_account'] = $this->language->get('entry_atm_account');
		$data['entry_atm_card'] = $this->language->get('entry_atm_card');
		$data['entry_tax_code'] = $this->language->get('entry_tax_code');
		$data['entry_note'] = $this->language->get('entry_note');
		$data['entry_avatar'] = $this->language->get('entry_avatar');
		$data['entry_id_image'] = $this->language->get('entry_id_image');

		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_top'] = $this->language->get('help_top');
		$data['help_column'] = $this->language->get('help_column');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_profile'] = $this->language->get('tab_profile');
		$data['tab_design'] = $this->language->get('tab_design');

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

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}
		
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . $this->request->get['filter_code'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['filter_part_id'])) {
			$url .= '&filter_part_id=' . $this->request->get['filter_part_id'];
		}

		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
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
			'href' => $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['staff_id'])) {
			$data['action'] = $this->url->link('staff/staff/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('staff/staff/edit', 'token=' . $this->session->data['token'] . '&staff_id=' . $this->request->get['staff_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['staff_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$staff_info = $this->model_staff_staff->getStaff($this->request->get['staff_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		// firstname
		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($staff_info)) {
			$data['firstname'] = $staff_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		// lastname
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($staff_info)) {
			$data['lastname'] = $staff_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		// code
		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($staff_info)) {
			$data['code'] = $staff_info['code'];
		} else {
			$data['code'] = '';
		}

		// working code
		if (isset($this->request->post['working_code'])) {
			$data['working_code'] = $this->request->post['working_code'];
		} elseif (!empty($staff_info)) {
			$data['working_code'] = $staff_info['working_code'];
		} else {
			$data['working_code'] = '';
		}

		// status
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($staff_info)) {
			$data['status'] = (bool)$staff_info['staff_status'];
		} else {
			$data['status'] = true;
		}

		// special
		if (isset($this->request->post['special'])) {
			$data['special'] = $this->request->post['special'];
		} elseif (!empty($staff_info)) {
			$data['special'] = (bool)$staff_info['special'];
		} else {
			$data['special'] = false;
		}

		// working_change
		if (isset($this->request->post['working_change'])) {
			$data['working_change'] = $this->request->post['working_change'];
		} elseif (!empty($staff_info)) {
			$data['working_change'] = (bool)$staff_info['working_change'];
		} else {
			$data['working_change'] = false;
		}

		// check position
		$this->load->model('department/position');
		if (!empty($staff_info)) {
			$position = $this->model_department_position->getPosition($staff_info['position_id']);
			$department_id = $position['department_id'];
			$part_id = $position['part_id'];
		}

		// department
		if (isset($this->request->post['department_id'])) {
			$data['department_id'] = $this->request->post['department_id'];
		} elseif (!empty($staff_info)) {
			$data['department_id'] = $department_id;
		} else {
			$data['department_id'] = '';
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

		// part
		if (isset($this->request->post['part_id'])) {
			$data['part_id'] = $this->request->post['part_id'];
		} elseif (!empty($staff_info)) {
			$data['part_id'] = $part_id;
		} else {
			$data['part_id'] = '';
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

		// position
		if (isset($this->request->post['position_id'])) {
			$data['position_id'] = $this->request->post['position_id'];
		} elseif (!empty($staff_info)) {
			$data['position_id'] = $staff_info['position_id'];
		} else {
			$data['position_id'] = '';
		}
		$data['positions'] = array();
		if (!empty($data['part_id'])) {
			$this->load->model('department/position');
			$positions = $this->model_department_position->getPositions(array(
				'start' => 0,
				'limit' => 100,
				'filter_part_id' => $data['part_id']
			));
			foreach ($positions as $position) {
				$data['positions'][] = array(
					'id' => $position['position_id'],
					'name' => $position['name']
				);
			}
		}

		if ($data['department_id'] == null) {
			$department_id = $departments[0]['department_id'];
		} else {
			$department_id = $data['department_id'];
		}

		// insure code
		if (isset($this->request->post['insure_code'])) {
			$data['insure_code'] = $this->request->post['insure_code'];
		} elseif (!empty($staff_info)) {
			$data['insure_code'] = $staff_info['insure_code'];
		} else {
			$data['insure_code'] = '';
		}

		// gender
		if (isset($this->request->post['gender'])) {
			$data['gender'] = $this->request->post['gender'];
		} elseif (!empty($staff_info)) {
			$data['gender'] = $staff_info['gender'];
		} else {
			$data['gender'] = '';
		}

		// birthday
		if (isset($this->request->post['birthday'])) {
			$data['birthday'] = $this->request->post['birthday'];
		} elseif (!empty($staff_info)) {
			$data['birthday'] = $staff_info['birthday'];
		} else {
			$data['birthday'] = '';
		}

		// birthplace
		if (isset($this->request->post['birthplace'])) {
			$data['birthplace'] = $this->request->post['birthplace'];
		} elseif (!empty($staff_info)) {
			$data['birthplace'] = $staff_info['birthplace'];
		} else {
			$data['birthplace'] = '';
		}
		$this->load->model('localisation/place');
		$places = $this->model_localisation_place->getPlaces(array(
			'start' => 0,
			'limit' => 1000
		));
		$data['places'] = array();
		foreach ($places as $place) {
			$data['places'][] = array(
				'id' => $place['place_id'],
				'name' => $place['name']
			);
		}

		// nation
		if (isset($this->request->post['nation'])) {
			$data['nation'] = $this->request->post['nation'];
		} elseif (!empty($staff_info)) {
			$data['nation'] = $staff_info['nation'];
		} else {
			$data['nation'] = '';
		}

		// religion
		if (isset($this->request->post['religion'])) {
			$data['religion'] = $this->request->post['religion'];
		} elseif (!empty($staff_info)) {
			$data['religion'] = $staff_info['religion'];
		} else {
			$data['religion'] = '';
		}

		// married
		if (isset($this->request->post['married'])) {
			$data['married'] = $this->request->post['married'];
		} elseif (!empty($staff_info)) {
			$data['married'] = $staff_info['married'];
		} else {
			$data['married'] = '';
		}

		// id
		if (isset($this->request->post['id'])) {
			$data['id'] = $this->request->post['id'];
		} elseif (!empty($staff_info)) {
			$data['id'] = $staff_info['id'];
		} else {
			$data['id'] = '';
		}

		// id date
		if (isset($this->request->post['id_date'])) {
			$data['id_date'] = $this->request->post['id_date'];
		} elseif (!empty($staff_info)) {
			$data['id_date'] = $staff_info['id_date'];
		} else {
			$data['id_date'] = '';
		}

		// id place
		if (isset($this->request->post['id_place'])) {
			$data['id_place'] = $this->request->post['id_place'];
		} elseif (!empty($staff_info)) {
			$data['id_place'] = $staff_info['id_place'];
		} else {
			$data['id_place'] = '';
		}

		// address 1
		if (isset($this->request->post['address1'])) {
			$data['address1'] = $this->request->post['address1'];
		} elseif (!empty($staff_info)) {
			$data['address1'] = $staff_info['address1'];
		} else {
			$data['address1'] = '';
		}

		// address 2
		if (isset($this->request->post['address2'])) {
			$data['address2'] = $this->request->post['address2'];
		} elseif (!empty($staff_info)) {
			$data['address2'] = $staff_info['address2'];
		} else {
			$data['address2'] = '';
		}

		// phone
		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($staff_info)) {
			$data['phone'] = $staff_info['phone'];
		} else {
			$data['phone'] = '';
		}

		// degree
		if (isset($this->request->post['degree'])) {
			$data['degree_id'] = $this->request->post['degree'];
		} elseif (!empty($staff_info)) {
			$data['degree_id'] = $staff_info['degree'];
		} else {
			$data['degree_id'] = '';
		}
		$data['degrees'] = array();
		$this->load->model('staff/degree');
		$degrees = $this->model_staff_degree->getDegrees(array(
			'start' => 0,
			'limit' => 100
		));
		foreach ($degrees as $degree) {
			$data['degrees'][] = array(
				'id' => $degree['degree_id'],
				'name' => $degree['name']
			);
		}

		// technique
		if (isset($this->request->post['technique'])) {
			$data['technique_id'] = $this->request->post['technique'];
		} elseif (!empty($staff_info)) {
			$data['technique_id'] = $staff_info['technique'];
		} else {
			$data['technique_id'] = '';
		}
		$data['techniques'] = array();
		$this->load->model('staff/technique');
		$techniques = $this->model_staff_technique->getTechniques(array(
			'start' => 0,
			'limit' => 100
		));
		foreach ($techniques as $technique) {
			$data['techniques'][] = array(
				'id' => $technique['technique_id'],
				'name' => $technique['name']
			);
		}

		// contract kind
		if (isset($this->request->post['contract_kind'])) {
			$data['contract_kind_id'] = $this->request->post['contract_kind'];
		} elseif (!empty($staff_info)) {
			$data['contract_kind_id'] = $staff_info['contract_kind'];
		} else {
			$data['contract_kind_id'] = '';
		}
		$data['contract_kinds'] = array();
		$this->load->model('staff/contract_kind');
		$contract_kinds = $this->model_staff_contract_kind->getContractKinds(array(
			'start' => 0,
			'limit' => 100
		));
		foreach ($contract_kinds as $contract_kind) {
			$data['contract_kinds'][] = array(
				'id' => $contract_kind['contract_kind_id'],
				'name' => $contract_kind['name']
			);
		}

		// contract start
		if (isset($this->request->post['contract_start'])) {
			$data['contract_start'] = $this->request->post['contract_start'];
		} elseif (!empty($staff_info)) {
			$data['contract_start'] = $staff_info['contract_start'];
		} else {
			$data['contract_start'] = '';
		}

		// contract end
		if (isset($this->request->post['contract_end'])) {
			$data['contract_end'] = $this->request->post['contract_end'];
		} elseif (!empty($staff_info)) {
			$data['contract_end'] = $staff_info['contract_end'];
		} else {
			$data['contract_end'] = '';
		}

		// work start
		if (isset($this->request->post['work_start'])) {
			$data['work_start'] = $this->request->post['work_start'];
		} elseif (!empty($staff_info)) {
			$data['work_start'] = $staff_info['work_start'];
		} else {
			$data['work_start'] = '';
		}

		// work start
		if (isset($this->request->post['work_start'])) {
			$data['work_start'] = $this->request->post['work_start'];
		} elseif (!empty($staff_info)) {
			$data['work_start'] = $staff_info['work_start'];
		} else {
			$data['work_start'] = '';
		}

		// work end
		if (isset($this->request->post['work_end'])) {
			$data['work_end'] = $this->request->post['work_end'];
		} elseif (!empty($staff_info)) {
			$data['work_end'] = $staff_info['work_end'];
		} else {
			$data['work_end'] = '';
		}

		// reason work end
		if (isset($this->request->post['reason_work_end'])) {
			$data['reason_work_end'] = $this->request->post['reason_work_end'];
		} elseif (!empty($staff_info)) {
			$data['reason_work_end'] = $staff_info['reason_work_end'];
		} else {
			$data['reason_work_end'] = '';
		}

		// atm account
		if (isset($this->request->post['atm_account'])) {
			$data['atm_account'] = $this->request->post['atm_account'];
		} elseif (!empty($staff_info)) {
			$data['atm_account'] = $staff_info['atm_account'];
		} else {
			$data['atm_account'] = '';
		}

		// atm card
		if (isset($this->request->post['atm_card'])) {
			$data['atm_card'] = $this->request->post['atm_card'];
		} elseif (!empty($staff_info)) {
			$data['atm_card'] = $staff_info['atm_card'];
		} else {
			$data['atm_card'] = '';
		}

		// tax code
		if (isset($this->request->post['tax_code'])) {
			$data['tax_code'] = $this->request->post['tax_code'];
		} elseif (!empty($staff_info)) {
			$data['tax_code'] = $staff_info['tax_code'];
		} else {
			$data['tax_code'] = '';
		}

		// note
		if (isset($this->request->post['note'])) {
			$data['note'] = $this->request->post['note'];
		} elseif (!empty($staff_info)) {
			$data['note'] = $staff_info['note'];
		} else {
			$data['note'] = '';
		}

		// avatar
		if (isset($this->request->post['avatar'])) {
			$data['avatar'] = $this->request->post['avatar'];
		} elseif (!empty($staff_info)) {
			$data['avatar'] = $staff_info['avatar'];
		} else {
			$data['avatar'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['avatar']) && is_file(DIR_IMAGE . $this->request->post['avatar'])) {
			$data['thumb_avatar'] = $this->model_tool_image->resize($this->request->post['avatar'], 100, 100);
		} elseif (!empty($staff_info) && is_file(DIR_IMAGE . $staff_info['avatar'])) {
			$data['thumb_avatar'] = $this->model_tool_image->resize($staff_info['avatar'], 100, 100);
		} else {
			$data['thumb_avatar'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		// id_image
		if (isset($this->request->post['id_image'])) {
			$data['id_image'] = $this->request->post['id_image'];
		} elseif (!empty($staff_info)) {
			$data['id_image'] = $staff_info['id_image'];
		} else {
			$data['id_image'] = '';
		}

		if (isset($this->request->post['id_image']) && is_file(DIR_IMAGE . $this->request->post['id_image'])) {
			$data['thumb_id_image'] = $this->model_tool_image->resize($this->request->post['id_image'], 100, 100);
		} elseif (!empty($staff_info) && is_file(DIR_IMAGE . $staff_info['id_image'])) {
			$data['thumb_id_image'] = $this->model_tool_image->resize($staff_info['id_image'], 100, 100);
		} else {
			$data['thumb_id_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/staff_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'staff/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 30)) {
			$this->error['warning'] = $this->language->get('error_firstname');
		
		} elseif ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 10)) {
			$this->error['warning'] = $this->language->get('error_lastname');
		
		} elseif ((utf8_strlen($this->request->post['code']) < 1) || (utf8_strlen($this->request->post['code']) > 20)) {
			$this->error['warning'] = $this->language->get('error_code');
		
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'staff/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC',
			'start'       => 0,
			'limit'       => 5
		);

		if (isset($this->request->get['filter_name'])) {
			$filter_data['filter_name'] =  $this->request->get['filter_name'];
		}

		if (!empty($this->request->get['filter_code'])) {
			$filter_data['filter_code'] =  $this->request->get['filter_code'];
		}

		$this->load->model('staff/staff');
		$results = $this->model_staff_staff->getStaffs($filter_data);

		foreach ($results as $result) {
			$json[] = array(
				'staff_id' => $result['staff_id'],
				'firstname' => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8')),
				'lastname' => strip_tags(html_entity_decode($result['lastname'], ENT_QUOTES, 'UTF-8')),
				'code' => strip_tags(html_entity_decode($result['code'], ENT_QUOTES, 'UTF-8'))
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function import() {
		$this->load->language('staff/staff');
		$this->load->model('staff/staff');

		$this->document->setTitle('Upload file DS nhân viên');

		// breadcrumbs
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home' ),
			'href'      => $this->url->link( 'common/home', 'token=' . $this->session->data['token'], 'sSL' ),
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title' ),
			'href'      => $this->url->link( 'staff/staff/import', 'token=' . $this->session->data['token'], 'sSL' ),
      		'separator' => ' :: '
   		);

   		// Heading title
		$data['heading_title'] = 'Upload file DS nhân viên';

		$data['text_form'] = 'Upload file DS nhân viên';

		$data['entry_file'] = $this->language->get('entry_file');
		$data['button_submit'] = $this->language->get('button_submit');

		// request
		if ( ($this->request->server['REQUEST_METHOD'] == 'POST') && !empty($this->request->files['file']) ){
			if ( $this->model_staff_staff->import($this->request->files['file']) ){
				$data['success'] = 'Thành công: Bạn đã Upload file DS nhân viên!';
			}else{
				$data['error_warning'] = 'Upload file bị lỗi, vui lòng liên hệ 0904 803 779';
			}
		}

		$data['action'] = $this->url->link( 'staff/staff/import', 'token=' . $this->session->data['token'], 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('staff/staff_import.tpl', $data));
	}

	public function export() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = '';
		}

		if (isset($this->request->get['filter_department_id'])) {
			$filter_department_id = $this->request->get['filter_department_id'];
		} else {
			$filter_department_id = '';
		}

		if (isset($this->request->get['filter_part_id'])) {
			$filter_part_id = $this->request->get['filter_part_id'];
		} else {
			$filter_part_id = '';
		}

		if (isset($this->request->get['filter_gender'])) {
			$filter_gender = (int)$this->request->get['filter_gender'];
		} else {
			$filter_gender = null;
		}

		if (isset($this->request->get['filter_break'])) {
			$filter_break = (int)$this->request->get['filter_break'];
		} else {
			$filter_break = '';
		}

		$filter_data = array(
			'filter_code' => $filter_code,
			'filter_name' => $filter_name,
			'filter_gender' => $filter_gender,
			'filter_department_id' => $filter_department_id,
			'filter_part_id' => $filter_part_id,
			'filter_break' => $filter_break,
			'start' => 0,
			'limit' => 10000
		);

		$this->load->model('staff/staff');

		$results = $this->model_staff_staff->getStaffs($filter_data);

		$this->load->language('staff/staff');

		$arr_data = array(
			'A1' => 'STT',
			'B1' => $this->language->get('column_name'),
			'C1' => $this->language->get('column_code'),
			'D1' => $this->language->get('column_working_code'),
			'E1' => $this->language->get('column_insure_code'),
			'F1' => $this->language->get('column_tax'),
			'G1' => $this->language->get('column_gender'),
			'H1' => $this->language->get('column_department'),
			'I1' => $this->language->get('column_part'),
			'J1' => $this->language->get('column_position'),
			'K1' => $this->language->get('column_work_start'),
			'L1' => $this->language->get('column_work_end'),
			'M1' => $this->language->get('column_reason_work_end'),
			'N1' => $this->language->get('column_address1')
		);

		$row = 1;
		foreach ($results as $result) {
			$row++;
			try {
				// STT
				$arr_data['A' . $row] = $row - 1;
				// Mã số thuế
				$arr_data['B' . $row] = $result['fullname'];
				// MS nhân viên
				$arr_data['C' . $row] = $result['code'];
				// MS Máy chấm công
				$arr_data['D' . $row] = $result['working_code'];
				// Số thẻ bảo hiểm
				$arr_data['E' . $row] = $result['insure_code'];
				// Họ tên
				$arr_data['F' . $row] = $result['tax_code'];
				// Giới tính
				$arr_data['G' . $row] = $result['gender'] == 0 ? $this->language->get('text_female') : $this->language->get('text_male');
				// Phòng ban
				$arr_data['H' . $row] = $result['department_name'];
				// Bộ phận
				$arr_data['I' . $row] = $result['part_name'];
				// Chức vụ
				$arr_data['J' . $row] = $result['position_name'];
				// Ngày vào làm
				$arr_data['K' . $row] = date('m/d/Y', strtotime($result['work_start']));
				// Ngày nghỉ việc
				$arr_data['L' . $row] = $result['work_end'];
				// Lý do nghỉ việc
				$arr_data['M' . $row] = $result['reason_work_end'];
				// Địa chỉ thường trú
				$arr_data['N' . $row] = $result['address1'];
			} catch (Exception $e) {
				print $result['name'] . '<br>';
			}
		}
		$filename = 'staffs';
		$file = DIR_DOWNLOAD . $filename . '.xlsx';
		$sheetname = 'DS Nhân viên';

		$this->load->model('tool/excel');
		$this->model_tool_excel->modifyExcelFile($arr_data, $file, $sheetname);

		print "COMPLETED!";
		$this->response->redirect(HTTP_CATALOG . 'system/download/' . $filename . '.xlsx');
	}
}
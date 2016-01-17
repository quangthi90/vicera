<?php
class ModelStaffStaff extends Model {
	public function addStaff($data) {
		$this->event->trigger('pre.admin.staff.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "staff SET working_change = '" . (bool)$data['working_change'] . "', special = '" . (bool)$data['special'] . "', working_code = '" . (string)$data['working_code'] . "', firstname = '" . (string)$data['firstname'] . "', lastname = '" . (string)$data['lastname'] . "', fullname = '" . (string)$data['firstname'] . ' ' . (string)$data['lastname'] . "', code = '" . (string)$data['code'] . "', position_id = '" . (int)$data['position_id'] . "', status = '" . (bool)$data['status'] . "', date_modified = NOW(), date_added = NOW(), work_start = DATE('" . $data['work_start'] . "'), insure_code = '" . (string)$data['insure_code'] . "', avatar = '" . (string)$data['avatar'] . "'");

		$staff_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "staff_description SET staff_id = '" . (int)$staff_id . "', gender = '" . (bool)$data['gender'] . "', birthday = DATE('" . (string)$data['birthday'] . "'), birthplace = '" . (int)$data['birthplace'] . "', nation = '" . (string)$data['nation'] . "', religion = '" . (string)$data['religion'] . "', married = '" . (bool)$data['married'] . "', id = '" . (string)$data['id'] . "', id_date = ('" . (string)$data['id_date'] . "'), id_place = '" . (int)$data['id_place'] . "', address1 = '" . (string)$data['address1'] . "', address2 = '" . (string)$data['address2'] . "', phone = '" . (string)$data['phone'] . "', degree = '" . (int)$data['degree'] . "', technique = '" . (int)$data['technique'] . "', contract_kind = '" . (int)$data['contract_kind'] . "', contract_start = DATE('" . $data['contract_start'] . "'), contract_end = DATE('" . $data['contract_end'] . "'), work_end = DATE('" . $data['work_end'] . "'), reason_work_end = '" . (string)$data['reason_work_end'] . "', atm_account = '" . (string)$data['atm_account'] . "', atm_card = '" . (string)$data['atm_card'] . "', tax_code = '" . (string)$data['tax_code'] . "', note = '" . (string)$data['note'] . "', id_image = '" . (string)$data['id_image'] . "'");

		$this->cache->Delete('staff');

		$this->event->trigger('post.admin.staff.add', $staff_id);

		return $staff_id;
	}

	public function editStaff($staff_id, $data) {
		$this->event->trigger('pre.admin.staff.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "staff SET working_change = '" . (bool)$data['working_change'] . "', special = '" . (bool)$data['special'] . "', working_code = '" . (string)$data['working_code'] . "', firstname = '" . (string)$data['firstname'] . "', lastname = '" . (string)$data['lastname'] . "', fullname = '" . (string)$data['firstname'] . ' ' . (string)$data['lastname'] . "', code = '" . (string)$data['code'] . "', position_id = '" . (int)$data['position_id'] . "', status = '" . (bool)$data['status'] . "', date_modified = NOW(), work_start = DATE('" . $data['work_start'] . "'), insure_code = '" . (string)$data['insure_code'] . "', avatar = '" . (string)$data['avatar'] . "' WHERE staff_id = '" . (int)$staff_id . "'");

		$this->db->query("UPDATE " . DB_PREFIX . "staff_description SET gender = '" . (bool)$data['gender'] . "', birthday = DATE('" . (string)$data['birthday'] . "'), birthplace = '" . (int)$data['birthplace'] . "', nation = '" . (string)$data['nation'] . "', religion = '" . (string)$data['religion'] . "', married = '" . (bool)$data['married'] . "', id = '" . (string)$data['id'] . "', id_date = ('" . (string)$data['id_date'] . "'), id_place = '" . (int)$data['id_place'] . "', address1 = '" . (string)$data['address1'] . "', address2 = '" . (string)$data['address2'] . "', phone = '" . (string)$data['phone'] . "', degree = '" . (int)$data['degree'] . "', technique = '" . (int)$data['technique'] . "', contract_kind = '" . (int)$data['contract_kind'] . "', contract_start = DATE('" . $data['contract_start'] . "'), contract_end = DATE('" . $data['contract_end'] . "'), work_end = DATE('" . $data['work_end'] . "'), reason_work_end = '" . (string)$data['reason_work_end'] . "', atm_account = '" . (string)$data['atm_account'] . "', atm_card = '" . (string)$data['atm_card'] . "', tax_code = '" . (string)$data['tax_code'] . "', note = '" . (string)$data['note'] . "', id_image = '" . (string)$data['id_image'] . "' WHERE staff_id = '" . (int)$staff_id . "'");

		$this->cache->Delete('staff');

		$this->event->trigger('post.admin.staff.edit', $staff_id);
	}

	public function deleteStaff($staff_id) {
		$this->event->trigger('pre.admin.staff.delete', $staff_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_description WHERE staff_id = '" . (int)$staff_id . "'");

		$this->cache->Delete('staff');

		$this->event->trigger('post.admin.staff.delete', $staff_id);
	}

	public function getStaff($staff_id) {
		$query = $this->db->query("SELECT *, c.status as staff_status FROM " . DB_PREFIX . "staff c LEFT JOIN staff_description sd ON c.staff_id = sd.staff_id LEFT JOIN " . DB_PREFIX . "position ps ON c.position_id = ps.position_id WHERE c.staff_id = '" . (int)$staff_id . "'");

		return $query->row;
	}

	public function getStaffByCode($code) {
		$query = $this->db->query("SELECT *, c.status as staff_status FROM " . DB_PREFIX . "staff c LEFT JOIN staff_description sd ON c.staff_id = sd.staff_id LEFT JOIN " . DB_PREFIX . "position ps ON c.position_id = ps.position_id WHERE c.code = '" . (string)$code . "'");

		return $query->row;
	}

	public function getStaffs($data = array()) {
		$sql = "SELECT *, st.staff_id AS staff_id, dpd.name AS department_name, prd.name AS part_name, psd.name AS position_name, st.status AS st_status FROM " . DB_PREFIX . "staff st 
					LEFT JOIN " . DB_PREFIX . "staff_description sd ON sd.staff_id = st.staff_id
					LEFT JOIN " . DB_PREFIX . "position ps ON ps.position_id = st.position_id 
					LEFT JOIN " . DB_PREFIX . "part pr ON pr.part_id = ps.part_id
					LEFT JOIN " . DB_PREFIX . "department dp ON dp.department_id = pr.department_id
					LEFT JOIN " . DB_PREFIX . "position_description psd ON psd.position_id = ps.position_id
					LEFT JOIN " . DB_PREFIX . "part_description prd ON prd.part_id = ps.part_id
					LEFT JOIN " . DB_PREFIX . "department_description dpd ON dpd.department_id = pr.department_id
					WHERE (st.status = '1' OR st.status = '0')";

		if (!empty($data['filter_name'])) {
			$sql .= " AND st.fullname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$sql .= " AND st.code LIKE '%" . $this->db->escape($data['filter_code']) . "%'";
		}

		if (isset($data['filter_gender']) && $data['filter_gender'] !== null) {
			$sql .= " AND sd.gender = '" . (int)$data['filter_gender'] . "'";
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND dp.department_id = '" . (int)$data['filter_department_id'] . "'";
		}

		if (!empty($data['filter_part_id'])) {
			$sql .= " AND pr.part_id = '" . (int)$data['filter_part_id'] . "'";
		}

		if (!empty($data['filter_break'])) {
			$sql .= " AND sd.work_end IS NOT NULL";
		} else {
			$sql .= " AND sd.work_end IS NULL";
		}

		$sort_data = array(
			'firstname'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY firstname";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalStaffs($data = array()) {
		$sql = "SELECT count(*) AS total FROM " . DB_PREFIX . "staff st 
					LEFT JOIN " . DB_PREFIX . "staff_description sd ON sd.staff_id = st.staff_id
					LEFT JOIN " . DB_PREFIX . "position ps ON ps.position_id = st.position_id 
					LEFT JOIN " . DB_PREFIX . "part pr ON pr.part_id = ps.part_id
					LEFT JOIN " . DB_PREFIX . "department dp ON dp.department_id = pr.department_id
					LEFT JOIN " . DB_PREFIX . "position_description psd ON psd.position_id = ps.position_id
					LEFT JOIN " . DB_PREFIX . "part_description prd ON prd.part_id = ps.part_id
					LEFT JOIN " . DB_PREFIX . "department_description dpd ON dpd.department_id = pr.department_id
					WHERE st.status = '1'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND st.firstname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$sql .= " AND st.code LIKE '%" . $this->db->escape($data['filter_code']) . "%'";
		}

		if (isset($data['filter_gender']) && $data['filter_gender'] !== null) {
			$sql .= " AND sd.gender = '" . (int)$data['filter_gender'] . "'";
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND dp.department_id = '" . (int)$data['filter_department_id'] . "'";
		}

		if (!empty($data['filter_part_id'])) {
			$sql .= " AND pr.part_id = '" . (int)$data['filter_part_id'] . "'";
		}

		if (!empty($data['filter_break'])) {
			$sql .= " AND sd.work_end IS NOT NULL";
		} else {
			$sql .= " AND sd.work_end IS NULL";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function import($files) {
		$this->load->model('tool/excel');

		$link_files = $files['tmp_name'];

		$this->load->model('staff/staff');
		$staffs = array();

		foreach ($link_files as $file) {
			$arrData = $this->model_tool_excel->readExcelFile($file);

			foreach ($arrData as $data) {
				$data[0] = str_pad($data[0], 4, '0', STR_PAD_LEFT);
				$data[1] = str_pad($data[1], 4, '0', STR_PAD_LEFT);

				/*$staff = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff WHERE code = '" . $data[0] . "'")->row;
				
				if (empty($staff)) {
					$this->db->query("INSERT INTO staff SET code = '" . trim($data[0]) . "', working_code = '" . $data[1] . "', firstname = '" . trim($data[2]) . "', lastname = '" . trim($data[3]) . "', fullname = '" . trim($data[2]) . ' ' . trim($data[3]) . "', position_id = '" . $data[4] . "', status = '1'");
					$staff_id = $this->db->getLastId();
					$this->db->query("INSERT INTO staff_description SET staff_id = '" . $staff_id . "', gender = '" . $data[5] . "', birthplace = '" . trim($data[7]) . "', nation = '" . trim($data[9]) . "', id = '" . $data[8] . "', degree = '" . $data[6] . "', address1 = '" . $this->db->escape($data[10]) . "'");
				} else {
					$this->db->query("UPDATE staff SET working_code = '" . $data[1] . "', firstname = '" . trim($data[2]) . "', lastname = '" . trim($data[3]) . "', fullname = '" . trim($data[2]) . ' ' . trim($data[3]) . "', position_id = '" . $data[4] . "', status = '1' WHERE code = '" . $data[0] . "'");
					$staff_id = $staff['staff_id'];
					$this->db->query("UPDATE staff_description SET gender = '" . $data[5] . "', birthplace = '" . trim($data[7]) . "', nation = '" . trim($data[9]) . "', id = '" . $data[8] . "', degree = '" . $data[6] . "', address1 = '" . $this->db->escape($data[10]) . "' WHERE staff_id = '" . $staff_id . "'");
				}*/
				$this->db->query("UPDATE staff SET working_code = '" . (string)$data[1] . "' WHERE code = '" . (string)$data[0] . "'");
			}
		}

		return true;
	}
}

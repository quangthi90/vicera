<?php
class ModelDepartmentDepartment extends Model {
	public function addDepartment($data) {
		$this->event->trigger('pre.admin.department.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "department SET sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");

		$department_id = $this->db->getLastId();

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->cache->Delete('department');

		$this->event->trigger('post.admin.department.add', $department_id);

		return $department_id;
	}

	public function editDepartment($department_id, $data) {
		$this->event->trigger('pre.admin.department.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "department SET sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE department_id = '" . (int)$department_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "department_description WHERE department_id = '" . (int)$department_id . "'");

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->cache->Delete('department');

		$this->event->trigger('post.admin.department.edit', $department_id);
	}

	public function deleteDepartment($department_id) {
		$this->event->trigger('pre.admin.department.Delete', $department_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "department WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_description WHERE department_id = '" . (int)$department_id . "'");

		$this->cache->Delete('department');

		$this->event->trigger('post.admin.department.delete', $department_id);
	}

	public function getDepartment($department_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "department c, " . DB_PREFIX . "department_description cd WHERE c.department_id = cd.department_id AND c.department_id = '" . (int)$department_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDepartments($data = array(), $check_private = false) {
		$sql = "SELECT c.department_id AS department_id, cd.name AS name, c.sort_order FROM " . DB_PREFIX . "department c LEFT JOIN " . DB_PREFIX . "department_description cd ON (c.department_id = cd.department_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!$check_private) {
			$sql .=  " AND c.private = '0'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY c.department_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getDepartmentDescriptions($department_id) {
		$department_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "department_description WHERE department_id = '" . (int)$department_id . "'");

		foreach ($query->rows as $result) {
			$department_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $department_description_data;
	}

	public function getTotalDepartments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "department");

		return $query->row['total'];
	}
	
	public function getTotalDepartmentsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "department_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}

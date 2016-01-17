<?php
class ModelDepartmentPart extends Model {
	public function addPart($data) {
		$this->event->trigger('pre.admin.part.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "part SET sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW(), department_id = '" . (int)$data['department_id'] . "'");

		$part_id = $this->db->getLastId();

		foreach ($data['part_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "part_description SET part_id = '" . (int)$part_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->Delete('part');

		$this->event->trigger('post.admin.part.add', $part_id);

		return $part_id;
	}

	public function editPart($part_id, $data) {
		$this->event->trigger('pre.admin.part.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "part SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), department_id = '" . (int)$data['department_id'] . "' WHERE part_id = '" . (int)$part_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "part_description WHERE part_id = '" . (int)$part_id . "'");

		foreach ($data['part_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "part_description SET part_id = '" . (int)$part_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->Delete('part');

		$this->event->trigger('post.admin.part.edit', $part_id);
	}

	public function deletePart($part_id) {
		$this->event->trigger('pre.admin.part.Delete', $part_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "part WHERE part_id = '" . (int)$part_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "part_description WHERE part_id = '" . (int)$part_id . "'");

		$this->cache->Delete('part');

		$this->event->trigger('post.admin.part.delete', $part_id);
	}

	public function getPart($part_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "part c, " . DB_PREFIX . "part_description cd WHERE c.part_id = cd.part_id AND c.part_id = '" . (int)$part_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getParts($data = array()) {
		$sql = "SELECT *, c.part_id AS part_id, cd.name AS name, c.sort_order, dd.name AS department_name FROM " . DB_PREFIX . "part c LEFT JOIN " . DB_PREFIX . "part_description cd ON (c.part_id = cd.part_id) LEFT JOIN " . DB_PREFIX . "department_description dd ON dd.department_id = c.department_id WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND c.department_id = '" . (int)$data['filter_department_id'] . "'";
		}

		$sql .= " GROUP BY c.part_id";

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

	public function getPartDescriptions($part_id) {
		$part_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "part_description WHERE part_id = '" . (int)$part_id . "'");

		foreach ($query->rows as $result) {
			$part_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}

		return $part_description_data;
	}

	public function getTotalParts() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "part");

		return $query->row['total'];
	}
	
	public function getTotalPartsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "part_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}

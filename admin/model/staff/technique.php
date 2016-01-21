<?php
class ModelStaffTechnique extends Model {
	public function addTechnique($data) {
		$this->event->trigger('pre.admin.technique.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "technique SET name = '" . $this->db->escape($data['name']) . "'");

		$this->cache->Delete('technique');

		$this->event->trigger('post.admin.technique.add', $technique_id);

		return $technique_id;
	}

	public function editTechnique($technique_id, $data) {
		$this->event->trigger('pre.admin.technique.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "technique SET name = '" . $this->db->escape($data['name']) . "' WHERE technique_id = '" . (int)$technique_id . "'");

		$this->cache->Delete('technique');

		$this->event->trigger('post.admin.technique.edit', $technique_id);
	}

	public function deleteTechnique($technique_id) {
		$this->event->trigger('pre.admin.technique.delete', $technique_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "technique WHERE technique_id = '" . (int)$technique_id . "'");

		$this->cache->Delete('technique');

		$this->event->trigger('post.admin.technique.Delete', $technique_id);
	}

	public function getTechnique($technique_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technique c WHERE c.technique_id = '" . (int)$technique_id . "'");

		return $query->row;
	}

	public function getTechniques($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "technique";

		$sql .= " GROUP BY technique_id";

		$sort_data = array(
			'name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalTechniques() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "technique");

		return $query->row['total'];
	}
}

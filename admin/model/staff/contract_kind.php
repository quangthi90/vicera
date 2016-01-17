<?php
class ModelStaffContractKind extends Model {
	public function addContractKind($data) {
		$this->event->trigger('pre.admin.contractkind.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "contract_kind SET name = '" . $this->db->escape($data['name']) . "'");

		$this->cache->Delete('contract_kind');

		$this->event->trigger('post.admin.contractkind.add', $contract_kind_id);

		return $contract_kind_id;
	}

	public function editContractKind($contract_kind_id, $data) {
		$this->event->trigger('pre.admin.contractkind.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "contract_kind SET name = '" . $this->db->escape($data['name']) . "' WHERE contract_kind_id = '" . (int)$contract_kind_id . "'");

		$this->cache->Delete('contract_kind');

		$this->event->trigger('post.admin.contractkind.edit', $contract_kind_id);
	}

	public function deleteContractKind($contract_kind_id) {
		$this->event->trigger('pre.admin.contractkind.delete', $contract_kind_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "contract_kind WHERE contract_kind_id = '" . (int)$contract_kind_id . "'");

		$this->cache->Delete('contract_kind');

		$this->event->trigger('post.admin.contractkind.delete', $contract_kind_id);
	}

	public function getContractKind($contract_kind_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contract_kind c WHERE c.contractkind_id = '" . (int)$contract_kind_id . "'");

		return $query->row;
	}

	public function getContractKinds($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contract_kind";

		$sql .= " GROUP BY contract_kind_id";

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

	public function getTotalContractKinds() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contract_kind");

		return $query->row['total'];
	}
}

<?php
class ModelReportDepartment extends Model {
	public function getDepartment($department_id, $part_id, $data = array()) {
		if (empty($data['filter_date_start']) || empty($data['filter_date_end'])) return array();

		$start = $data['start'];
		$limit = $data['limit'];

		$data['start'] = 0;
		$data['limit'] = 1000;

		$this->load->model('catalog/product');
		$products = $this->model_catalog_product->getProducts($data);

		$results = array();
		$count = -1;
		foreach ($products as $key => $product) {
			$sql = "SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "delivery WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(delivery_date) >= '" . $data['filter_date_start'] . "' AND DATE(delivery_date) <= '" . $data['filter_date_end'] . "' AND department_id = '" . (int)$department_id . "'";

			if (!empty($part_id)) {
				$sql .= " AND part_id = '" . (int)$part_id . "'";
			}
// print($sql . "<br>");
			$delivery_quantity = $this->db->query($sql)->row['total'];
// print($limit);
			if (count($results) == $limit) break;
			if ($delivery_quantity == null) continue;
			$count++;
			if ($count < $start) continue;
			
			$results[$key] = $product;
			$results[$key]['delivery_quantity'] = $delivery_quantity;
		}
// print("<pre>");
// var_dump($results);
		// exit;
		return $results;
	}

	public function getTotalDepartment($department_id, $part_id, $data = array()) {
		if (empty($data['filter_date_start']) || empty($data['filter_date_end'])) return array();

		$data['limit'] = 10000;
		$data['start'] = 0;

		$this->load->model('catalog/product');
		$products = $this->model_catalog_product->getProducts($data);

		$results = array();
		foreach ($products as $key => $product) {
			$sql = "SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "delivery WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(delivery_date) >= '" . $data['filter_date_start'] . "' AND DATE(delivery_date) <= '" . $data['filter_date_end'] . "' AND department_id = '" . (int)$department_id . "'";

			if (!empty($part_id)) {
				$sql .= " AND part_id = '" . $part_id . "'";
			}

			$delivery_quantity = $this->db->query($sql)->row['total'];

			if ($delivery_quantity == null) continue;
			
			$results[$key] = $product;

		}

		return count($results);
	}
}
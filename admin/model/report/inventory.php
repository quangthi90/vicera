<?php
class ModelReportInventory extends Model {
	public function getInventory($data = array()) {
		if (empty($data['filter_date_start']) || empty($data['filter_date_end'])) return array();

		$this->load->model('catalog/product');
		$products = $this->model_catalog_product->getProducts($data);

		foreach ($products as $key => $product) {
			$receipt_quantity_input = $this->db->query("SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "receipt WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(receipt_date) < '" . $data['filter_date_start'] . "'")->row['total'];
			if ($receipt_quantity_input == null) $receipt_quantity_input = 0;

			$delivery_quantity_input = $this->db->query("SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "delivery WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(delivery_date) < '" . $data['filter_date_start'] . "'")->row['total'];
			if ($delivery_quantity_input == null) $delivery_quantity_input = 0;

			$products[$key]['quantity_input'] = $receipt_quantity_input - $delivery_quantity_input;

			$receipt_quantity_total = $this->db->query("SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "receipt WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(receipt_date) >= '" . $data['filter_date_start'] . "' AND DATE(receipt_date) <= '" . $data['filter_date_end'] . "'")->row['total'];
			if ($receipt_quantity_total == null) $receipt_quantity_total = 0;
			$products[$key]['receipt_quantity_total'] = $receipt_quantity_total;
			
			$delivery_quantity_total = $this->db->query("SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "delivery WHERE product_id = '" . (int)$product['product_id'] . "' AND DATE(delivery_date) >= '" . $data['filter_date_start'] . "' AND DATE(delivery_date) <= '" . $data['filter_date_end'] . "'")->row['total'];
			if ($delivery_quantity_total == null) $delivery_quantity_total = 0;
			$products[$key]['delivery_quantity_total'] = $delivery_quantity_total;

			$products[$key]['quantity_inventory'] = $products[$key]['quantity_input'] + $receipt_quantity_total - $delivery_quantity_total;
		}

		return $products;
	}

	public function getTotalInventory($data = array()) {
		$this->load->model('catalog/product');
		return $this->model_catalog_product->getTotalProducts();
	}
}
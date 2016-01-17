<?php
class ModelToolString extends Model {
	var $lower = ' 
	a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z 
	|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ 
	|đ 
	|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ 
	|í|ì|ỉ|ĩ|ị 
	|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ 
	|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự 
	|ý|ỳ|ỷ|ỹ|ỵ'; 
	var $upper = ' 
	A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z 
	|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ 
	|Đ 
	|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ 
	|Í|Ì|Ỉ|Ĩ|Ị 
	|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ 
	|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự 
	|Ý|Ỳ|Ỷ|Ỹ|Ỵ';

	function lower($str){ 
		return str_replace($this->arrayUpper,$this->arrayLower,$str); 
	} 
	function upper($str){ 
		return str_replace($this->arrayLower,$this->arrayUpper,$str); 
	} 
}
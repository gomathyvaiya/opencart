<?php
class Modelmodulepdfcatalog extends Model {

	public function db_install() {

		$sql ="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "offer_pdf_catalog` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `offer_title` varchar(255) NOT NULL,
		  `file_name` varchar(255) NOT NULL,
		  `status` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		 ";


		return $this->db->query($sql);



	}


	public function db_uninstall() {

	}


	public function save($data) {
		$offer_title=$data['offer_title'];
		$file_name=$data['file_name'];
		$status=$data['status'];
		if($status==1)
		{
		$sql1="UPDATE `" . DB_PREFIX . "offer_pdf_catalog` SET status='0' where status='1' ";
		$this->db->query($sql1);
		
		$sql="insert into `" . DB_PREFIX . "offer_pdf_catalog`  (offer_title,file_name,status) VALUES ('$offer_title','$file_name','$status')";
		}
		else
		{
		$sql="insert into `" . DB_PREFIX . "offer_pdf_catalog`  (offer_title,file_name,status) VALUES ('$offer_title','$file_name','$status')";
		}
		return $this->db->query($sql);
		
		
	
		
		
		
	}
	
	public function get_data() {
		
		$sql="select * from `" . DB_PREFIX . "offer_pdf_catalog` ";
		$data=$this->db->query($sql);
		return $data->rows;
	}
	
	public function edit_data($id) {
	//echo 'hai';
		
		$sql="select * from `" . DB_PREFIX . "offer_pdf_catalog` where id='$id'";
		$data=$this->db->query($sql);
		return $data->rows;
	}


	public function edit_data_save($data){
	//print_r($data);exit;
		$offer_title=$data['offer_title'];
		$file_name=$data['file_name'];
		$status=$data['status'];
		
		$id=$data['catalog_id'];
		if($status==1)
		{
		$sql1="UPDATE `" . DB_PREFIX . "offer_pdf_catalog` SET status='0' where status='1' ";
		$this->db->query($sql1);
		
		$sql="UPDATE `" . DB_PREFIX . "offer_pdf_catalog` SET offer_title='$offer_title', file_name='$file_name', status='$status' WHERE id='$id'";
		}
		else
		{
		$sql="UPDATE `" . DB_PREFIX . "offer_pdf_catalog` SET offer_title='$offer_title', file_name='$file_name', status='$status' WHERE id='$id'";
		}
		return $this->db->query($sql);
		
	
	}
	
	public function delete_data($id){
	$sql="delete from `" . DB_PREFIX . "offer_pdf_catalog` where id='$id'";
	return $this->db->query($sql);
	
	}
}


?>

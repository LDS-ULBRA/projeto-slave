<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassificationController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->model('classification/classificationModel');
	}

	public function index()
	{
		$data['classifications'] = $this->classificationModel->get();
		$this->template->load('template/templateMenu', 'classification/classificationView', $data);
	}

	public function createForm(){
		$this->template->load('template/templateMenu', 'classification/createClassificationView');
	}

	public function create(){

		$classification = array(
			'name_classification' => $this->input->post('classificationName'),
			'classification_type' => $this->input->post('classificationType')
			);

		$this->classificationModel->create($classification);
		redirect('classification');
	}

	public function updateForm($idClassification){
		$data['classification']=$this->classificationModel->getDataClassification($idClassification); 
		$this->template->load('template/templateMenu', 'classification/updateClassificationView', $data);
	}

	public function update($id){
		$data = array(
			'id_classification' => $id,
			'name_classification' => $this->input->post('updateClasName'),
			'classification_type' => $this->input->post('updateClasType')
			);
		$this->classificationModel->update($data);
		redirect('classification','refresh');
	}

	public function delete(){
		$data = array('id_classification' => $this->input->post('idDeleteClass'));

		if(!$this->classificationModel->getItemByForeign($data)){

			if($this->classificationModel->delete($data)){
				redirect('classification','refresh');
			}else{
				echo "deu ruim";
			}
		}else{
			echo "<script>alert('A classificação está sendo utilizada.')</script>";
			redirect('classification','refresh');
		}
		
		
	}

	public function searchClassification(){
		$options ="";
        $type = $this->input->post('type');
		$classifications = $this->classificationModel->getPerType($type);
		foreach ($classifications as $classification) {			
			?>
				<option value="<?= $classification['id_classification'] ?>"><?= $classification['name_classification'] ?> </option>
			<?php
		}
	}
	
}
/* End of file classificationController.php */
/* Location: ./application/controllers/classificationController.php */
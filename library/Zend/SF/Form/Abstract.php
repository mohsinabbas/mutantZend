<?php
class SF_Form_Abstract extends Zend_Form
{
	protected $_model;
	public function setModel(SF_Model_Interface $model)
	{
		 $this->_model = $model;
	 }
	 public function getModel()
	 {
		   return $this->_model;
	 }
}
?>
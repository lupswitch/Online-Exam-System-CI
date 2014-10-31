<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parteditor_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getQuestionList($chapterid)
	{
		/*
		SELECT * FROM question_list q 
		LEFT JOIN Exam_Papers_Detail epd on q.question_id = epd.question_id 
		WHERE epd.question_id IS NULL 
		ORDER BY `q`.`question_id` ASC
		*/

		$query = $this->db
			->select(array(
				'no','question_list.question_id','question','type','status','chapter_id',
				'created_by','created_time',
				'choice1','choice2','choice3','choice4','choice5','choice6',
				'answer_choice','answer_numeric','answer_boolean','chapter_name'))
			->from('question_list')
			->join('Exam_Papers_Detail', 
				'question_list.question_id = Exam_Papers_Detail.question_id', 'left')
			->where(array(
				'Exam_Papers_Detail.question_id'=>NULL,
				'question_list.chapter_id'=>$chapterid
			))
			->get()
			->result_array();
			//die($this->db->last_query());
		return $query;
	}

}

/* End of file parteditor_model.php */
/* Location: ./application/models/parteditor_model.php */
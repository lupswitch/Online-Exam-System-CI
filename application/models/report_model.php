<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getCoursesListCount($teaid='', $keyword='', $perpage=0, $offset=0, $year=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$cause = array();
		if ($year != 0) $cause['year'] = $year;
		if ($teaid != '') $this->db->where('course_id IN', "( SELECT course_id FROM Teacher_Course_Detail WHERE tea_id = '$teaid')", false);

		$query = $this->db
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->where($cause)
			->order_by('year','desc')
			->order_by('examcount','desc')
			->order_by('code','asc')
			->get('report_courses')
			->result_array();
			// die( $this->db->last_query());
		return $query;
	}

	function countCoursesListCount($teaid='', $keyword='', $year=0)
	{

		$cause = array();
		if ($year != 0) $cause['year'] = $year;
		if ($teaid != '') $this->db->where('course_id IN', "( SELECT course_id FROM Teacher_Course_Detail WHERE tea_id = '$teaid')", false);

		$query = $this->db
			->select("count(*) as scount")
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->where($cause)
			->get('report_courses')
			->row_array();
		return $query['scount'];
	}

	function getReportCourseCalc($course_id, $paperid=null)
	{
		$criteria['course_id'] = $course_id;
		if ($paperid !== null) $criteria['paper_id'] = $paperid;
		$query = $this->db
			->where($criteria)
			->get('report_course_calc')
			->result_array();
		// die( $this->db->last_query());
		return $query;
	}

	function getStdScoreByPaper($paperid)
	{
		$query = $this->db
			->select(array('sco_id','scoreboard.stu_id','title','name','lname','course_id','paper_id','Score'))
			->from('Scoreboard')
			->join('Students','Scoreboard.stu_id = Students.stu_id','left')
			->where('paper_id', $paperid)
			->order_by('scoreboard.stu_id', 'asc')
			->get()
			->result_array();
		return $query;
	}

	function getPapersByCourseId($courseid)
	{
		$query = $this->db
			->select('*')
			->from('Exam_Papers')
			->where('course_id', $courseid)
			->get()
			->result_array();
		return $query;
	}

	function getReportByStudent($courseid)
	{
/*
SELECT stu_id, getScoreByPaperId(11,stu_id) as paper_1 FROM `Student_Enroll` WHERE `course_id` = 6
*/
		$selcol[] = "stu_id";
		foreach ($this->getPapersByCourseId($courseid) as $item) {
			$selcol[] = "getScoreByPaperId($item[paper_id],stu_id) as paper_$item[paper_id]";
		}
		$query = $this->db
			->select($selcol)
			->where('course_id', $courseid)
			->get('Student_Enroll')
			->result_array();
		return $query;
	}

}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */
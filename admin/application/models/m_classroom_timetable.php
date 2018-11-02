<?php

require_once APPPATH.'module/base_Model.php';
class M_classroom_timetable extends Base_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "classroom_timetable";
    }

    public function  getSiteInfoByTimetableId($timetable_id){
        $sql = 'select  a.*,c.classroom_name,c.classroom_people_num from classroom_timetable a 
        left join classroom_master b on a.classroom_id=b.classroom_id
        where b.status=1 and a.timetable_id='.$timetable_id;
       
        $data = $this->db->query($sql)->result_array();

        return $data;
    }
	









    
}
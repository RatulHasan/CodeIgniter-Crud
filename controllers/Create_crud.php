<?php
    /*
    *   Author= Ratul Hasan
    * email: ratuljh@gmail.com
    */
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_crud extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('create_crud_model');
    }

/**
 * [index description]
 * @return [type] [description]
 */

    public function index()
    {
        $data=array();
        $cdata=array();
        $cdata['button']="Save";
        $cdata['action']="create_crud/save";
        $cdata['edit_action']="role/update";
        $data['title']="Create CRUD";
        $data['nav']=$this->load->view('nav','',TRUE);
        $data['content']=$this->load->view('crud/crud_form',$cdata,TRUE);
        $this->load->view('home',$data);
    }
/**
 * [get_table_name description]
 * @return [type] [description]
 */
    public function get_table_name(){
        $table_name=$this->input->post('table_name',true);
        $get_table_info= $this->create_crud_model->get_table_info($table_name);
        $count=count($get_table_info);
        if($count!=0) {
            echo 1;
        }else{
            echo 0;
        }
    }

/**
 * [save description]
 * @return [type] [description]
 */
    public function save(){
        $data=array();

        $table_name=$this->input->post('table_name',true);
        $view_path=$this->input->post('view_path',true);

        $get_table_info= $this->create_crud_model->get_table_info($table_name);

        /*
         * FOR CONTROLLER
         */
        error_reporting(E_ALL);
        $controller_page=ucfirst($table_name);
        $view_page=$table_name;
        $model_class=$table_name;
        $model_name=$model_class.'_model';

        $newFileName = 'application/controllers/'.$controller_page.".php";
        $load_model='$this->load->model(\''.$model_name.'\');';

        $load='$this->load->view';
        $load_input='$this->input->';
        $data='$data';
        $id='$id';
        $table_name_by_id=$table_name."_by_id";
        $load_method='$this->'.$model_name.'->';
        $all_data='$all_data[\'all\']';
        $all_action='$all_data[\'action\']';
        $all_data_without_array='$all_data';
        $base_url="\"<?php echo base_url();?>\"";
        $edit_url="\"<?php echo base_url();?>$table_name/edit_$table_name/";
        $delete_url="\"<?php echo base_url();?>$table_name/delete_$table_name/";
        $all='$all->';
        
$newFileContent = "
<?php
    /*
    *   This page is created by auto crud generator.
    *   Author= Ratul Hasan
    */
defined('BASEPATH') OR exit('No direct script access allowed');

class $controller_page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $load_model
    }


    public function index()
    {
        $all_data=$load_method all();

        $load(\"$view_path/$view_page\",$all_data_without_array);
    }

    public function add_$table_name()
    {
        $all_action='save_$table_name';
        $load(\"$view_path/$view_page"."_form\",$all_data_without_array);
    }
    public function save_$table_name()
    {
        $data=$load_input post();

        $load_method save_$table_name($data);
        redirect(\"$table_name\");
    }

    public function edit_$table_name($id)
    {
        $all_action='update_$table_name/'.$id;
        $all_data=$load_method $table_name_by_id($id);
        $load(\"$view_path/$view_page"."_form\",$all_data_without_array);
    }

    public function update_$table_name($id)
    {
        $data=$load_input post();

        $load_method update_$table_name($data,$id);
        redirect(\"$table_name\");
    }

    public function delete_$table_name($id)
    {
        $load_method delete_$table_name($id);
        redirect(\"$table_name\");
    }

}";

        /*
         * FOR MODEL
         */
        error_reporting(E_ALL);
        $model_name = $controller_page."_Model";

        $model = 'application/models/'.$controller_page."_model.php";

        //print_r($viewFileContent);exit();
        $load_db='$this->db->';
        $query='$query_result';
        $query_result='$query_result->';
        $result='$result';
        $newFileContentModel = "
<?php
    /*
    * This page is created by auto crud generator.
    *Author= Ratul Hasan
    */
class $model_name  extends CI_Model {


    public function all(){
        $load_db select(\"*\");
        $load_db from(\"$table_name\");
        $load_db limit(20);
        $query=$load_db get();
        $result=$query_result result();
        return $result;
    }
    public function $table_name_by_id($id){
        $load_db select(\"*\");
        $load_db from(\"$table_name\");
        $load_db where('id',$id);
        $query=$load_db get();
        $result=$query_result row();
        return $result;
    }

    public function save_$table_name($data){
        $load_db insert('$table_name',$data);
    }

    public function update_$table_name($data,$id){
        $load_db where('id', $id);
        $load_db update('$table_name',$data);
    }
    public function delete_$table_name($id) {
        $load_db where('id',$id);
        $load_db delete('$table_name');
    }

}";

/*
 * FOR VIEW
 */

        if (!file_exists("application/views/$view_path")) {
            mkdir("application/views/$view_path", 0777, true);
        }
        //mkdir($view_path);
        $view = "application/views/$view_path/$view_page.php";
        $add_view = "application/views/$view_path/$view_page"."_form".".php";
        //print_r($view);exit();
        $table_head='';
        $td='';
        $td_edit='';
        $make_form='';
        $i=1;
        foreach($get_table_info as $get_table){
            $td.='<td><?php echo $v_all->'.$get_table->COLUMN_NAME.'; ?></td>
            ';
            if(($get_table->COLUMN_NAME)=='id') {
                $td_edit .= '<td><a href=' . $edit_url .'<?php echo $v_all->'.$get_table->COLUMN_NAME.';?>">Edit</a>
                &nbsp;&nbsp;&nbsp;<a href=' . $delete_url .'<?php echo $v_all->'.$get_table->COLUMN_NAME.';?>">Delete</a></td>
            ';
            }
            $column=ucfirst($get_table->COLUMN_NAME);
            $column=str_replace("_"," ","$column");
            $table_head.="<th>".$column."</th>";

            if($get_table->COLUMN_KEY!='PRI'){

                if(($get_table->CHARACTER_MAXIMUM_LENGTH)>=100){
                    if(($get_table->IS_NULLABLE)=='NO') {
                        $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label></br>
<textarea required maxlength='$get_table->CHARACTER_MAXIMUM_LENGTH' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME'><?php echo isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:''?></textarea></br>

";
                    }else{
                        $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label></br>
<textarea maxlength='$get_table->CHARACTER_MAXIMUM_LENGTH' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME'><?php echo
isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:''?></textarea></br>

";
                    }
                }else{
                    if(($get_table->IS_NULLABLE)=='NO') {
                    if(($get_table->DATA_TYPE)=='int') {
                        $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label><br>
<input required value='<?php echo isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:\"\"?>' maxlength='$get_table->CHARACTER_MAXIMUM_LENGTH' type='number' min='0' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME' /></br>
";
                    }else{
                        $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label><br>
<input required  value='<?php echo isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:\"\"?>' maxlength='$get_table->CHARACTER_MAXIMUM_LENGTH' type='text' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME' /></br>
";
                    }
                }else {
                        if (($get_table->DATA_TYPE) == 'int') {
                            $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label><br>
<input required  value='<?php echo isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:\"\"?>' type='number' min='0' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME' /></br>
";
                        }else{
                            $make_form .= "
<label for=\"$get_table->COLUMN_NAME\">$column</label><br>
<input required  value='<?php echo isset($all $get_table->COLUMN_NAME)?$all $get_table->COLUMN_NAME:\"\"?>' maxlength='$get_table->CHARACTER_MAXIMUM_LENGTH' type='text' name='$get_table->COLUMN_NAME' id='$get_table->COLUMN_NAME' /></br>
";
                        }
                    }
                }
            }

            $i++;

        }

        $viewFileContent = '
<?php
    /*
    * This page is created by auto crud generator.
    *Author= Ratul Hasan
    */
?>
<a href="<?php echo base_url();?>'.$table_name.'/add_'.$table_name.'">Add '.$table_name.'</a>
<table width="75%" border="1">
    <tr>
        '.$table_head.'<th>Action</th>
    </tr>

    <?php
        foreach($all as $v_all){
            ?><tr>
                '.$td.$td_edit.'
            </tr>
            <?php
        }
    ?>
</table>
';

        $addViewFileContent='
<?php
    /*
    * This page is created by auto crud generator.
    *Author= Ratul Hasan
    */
?>
<form action="<?php echo base_url();?>'.$table_name.'/<?php echo $action; ?>" method="post">
    <?php
        if(isset($all)){
            if($action=="update_'.$table_name.'/$all->id"){
                echo "<input type=\"hidden\" name=\"id\" value=\"$all->id\" />";
            }
        }
    ?>
    '.$make_form.'
    <br>
    <button type="submit">Save Data</button>
</form>
        ';


        /*
         * FOR VIEW
        */

        if (file_put_contents ($model,$newFileContentModel) !== false) {

            file_put_contents ($newFileName,$newFileContent);
            file_put_contents ($view,$viewFileContent);
            file_put_contents ($add_view,$addViewFileContent);

        }
        //}

        $sdata['message']="
            <script>
                $.bootstrapGrowl('<strong>Success!</strong>',{
                    type: 'success',
                    delay: 2500,
                });
            </script>";
        $this->session->set_userdata($sdata);
        redirect("create_crud");
    }

}

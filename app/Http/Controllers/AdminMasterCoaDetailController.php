<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Redirect;

class AdminMasterCoaDetailController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "master_coa_detail_name";
		$this->limit = "20";
		$this->orderby = "master_coa_id,asc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "master_coa_detail";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col[] = ["label"=>"COA Code","name"=>"master_coa_id","join"=>"master_coa,master_coa_code",'visible'=>false];
		$this->col[] = ["label"=>"COA 2 Code","name"=>"master_coa_detail_code",'visible'=>false];
		$this->col[] = ["label"=>"COA 3 Code","name"=>"id","join"=>"master_coa_third,master_coa_third_item_id"];

		$this->col[] = ["label"=>"COA Name","name"=>"master_coa_id","join"=>"master_coa,master_coa_name"];
		$this->col[] = ["label"=>"COA 2 Name","name"=>"master_coa_detail_name"];
		$this->col[] = ["label"=>"COA 3 Name","name"=>"id","join"=>"master_coa_third,master_coa_third_name"];
			# END COLUMNS DO NOT REMOVE THIS LINE

		$this->form[] = ['label'=>'COA 1',
		'name'=>'master_coa_id',
		'type'=>'datamodal',
		'datamodal_table'=>'master_coa',
		'datamodal_columns'=>'master_coa_name,master_coa_code',
		'datamodal_select_to'=>'',
		'datamodal_where'=>'',
		'datamodal_size'=>'large',
		'datamodal_columns_alias'=>'Name,Code',
		'required'=>true];

		$select_code = DB::table('master_coa_detail')->select('master_coa_detail_code')->orderBy('created_at','desc')->first();
		$max_code = isset($select_code->master_coa_detail_code) ? $select_code->master_coa_detail_code : 00;

		if ($max_code > 98) {

			Session::flash('sr_message', "Maaf Jumlah Sudah Maksimal");
			return Redirect::to('admin/master_coa_detail');


		} else {

			$next_code = $max_code + 1;

		}
		
		// $this->form[] = ['label'=>'COA 2 Code','name'=>'master_coa_detail_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10', "readonly"=>true ,'value'=>str_pad($next_code,2,'0',STR_PAD_LEFT)];
		
		$this->form[] = ['label'=>'COA 2 Code','name'=>'master_coa_detail_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10', "readonly"=>false];
		$this->form[] = ['label'=>'COA 2 Name','name'=>'master_coa_detail_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10', "readonly"=>false];

		

			# START FORM DO NOT REMOVE THIS LINE
		// $this->form = [];
		// $columns[] = ['label'=>'COA',
		// 'name'=>'master_coa_second_id',
		// 'type'=>'datamodal',
		// 'datamodal_table'=>'master_coa_detail',
		// 'datamodal_columns'=>'master_coa_detail_name,master_coa_detail_code',
		// 'datamodal_select_to'=>'',
		// 'datamodal_where'=>'',
		// 'datamodal_size'=>'large',
		// 'datamodal_columns_alias'=>'Code,Name'];

		$columns[] = ['label'=>'COA Code 3','name'=>'master_coa_third_code','type'=>'text','readonly'=>false,'required'=>true, 'validation'=>'unique:master_coa_third'];
		$columns[] = ['label'=>'COA Name 3','name'=>'master_coa_third_name','type'=>'text','readonly'=>false,'required'=>true];

		// dd($columns);

		$this->form[''] = ['label'=>'Add COA 3 Detail','name'=>'master_coa_third','type'=>'child','columns'=>$columns,'table'=>'master_coa_third','foreign_key'=>'master_coa_detail_id'];
			# END FORM DO NOT REMOVE THIS LINE


		// $columns[] = ['label'=>'COA',
		// 'name'=>'master_coa_second_id',
		// 'type'=>'datamodal',
		// 'datamodal_table'=>'master_coa',
		// 'datamodal_columns'=>'master_coa_name,master_coa_code',
		// 'datamodal_select_to'=>'master_coa_name:master_coa_third_name,master_coa_code:master_coa_second_code_id',
		// 'datamodal_where'=>'',
		// 'datamodal_size'=>'large',
		// 'datamodal_columns_alias'=>'COA Name, COA Code'];

		// $columns[] = ['label'=>'COA Parent Code','name'=>'master_coa_second_code_id','type'=>'number','readonly'=>true,'required'=>false];
		// $columns[] = ['label'=>'COA Child Code','name'=>'master_coa_third_code','type'=>'number','readonly'=>false,'required'=>false];
		// $columns[] = ['label'=>'COA Name','name'=>'master_coa_third_name','type'=>'text','readonly'=>false,'required'=>false];

		// $this->form[''] = ['label'=>'COA Child','name'=>'master_coa_third','type'=>'child','columns'=>$columns,'table'=>'master_coa_third','foreign_key'=>'master_coa_second_id'];

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Master Coa Id","name"=>"master_coa_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"master_coa,master_coa_name"];
			//$this->form[] = ["label"=>"Master Coa Detail Code","name"=>"master_coa_detail_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Master Coa Detail Name","name"=>"master_coa_detail_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();


	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here

	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    	// $coa = $postdata['master_coa_third'];

	    	// $exist = DB::table('master_coa_third')->where('master_coa_third_code', $coa)->first();

	    	// dd($coa);

	    	// if ($exist) {
	    	// 	Session::flash('sr_message', "Maaf Data COA Sudah Ada");
	    	// 	CRUDBooster::redirect('admin/master_coa_detail', '', $type='warning');
	    	// } else {

	    	// }



	    	

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here
	    	DB::table('master_coa_third')->where('master_coa_detail_id',$id)->delete();
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 
	    public function getIndex() {
  //First, Add an auth
	    	if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

   //Create your own query 
	    	$data = [];
	    	$data['page_title'] = 'Master COA';

	    	$data['result'] = DB::table('master_coa')
	    	->join('master_coa_detail', 'master_coa.id', '=', 'master_coa_detail.master_coa_id')
	    	->join('master_coa_third', 'master_coa_detail.id', '=', 'master_coa_third.master_coa_detail_id')
	    	->select('master_coa.*', 'master_coa_detail.*', 'master_coa_third.*')            
	    	->orderByRaw("master_coa.master_coa_code ASC,master_coa_detail.master_coa_detail_code ASC,master_coa_third.master_coa_third_code ASC")
	    	->paginate(20);

   //Create a view. Please use `cbView` method instead of view method from laravel.
	    	$this->cbView('accounting.master_coa_index',$data);
	    }


	}
<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Redirect;

class AdminBukuBesarController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "master_journal_coa_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = false;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "master_journal";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"COA Code","name"=>"(select master_coa_detail.master_coa_detail_code from master_coa_detail where master_coa_detail.id = master_journal_detail.master_coa_detail_id) as master_journal_coa_code"];
		$this->col[] = ["label"=>"COA Name","name"=>"(select master_coa_detail.master_coa_detail_name from master_coa_detail where master_coa_detail.id = master_journal_detail.master_coa_detail_id) as master_journal_coa_name1`"];
		$this->col[] = ["label"=>"COA Category Code","name"=>"master_journal_id",'join'=>'master_journal_detail,master_journal_detail_coa_code'];
		$this->col[] = ["label"=>"COA Category Name","name"=>"master_journal_id",'join'=>'master_journal_detail,master_journal_detail_coa_name'];
		$this->col[] = ["label"=>"Description","name"=>"master_journal_id",'join'=>'master_journal_detail,master_journal_detail_description'];
		$this->col[] = ["label"=>"Debit","name"=>"master_journal_id",'join'=>'master_journal_detail,master_journal_detail_debit'];
		$this->col[] = ["label"=>"Kredit","name"=>"master_journal_id",'join'=>'master_journal_detail,master_journal_detail_kredit'];
		$this->col[] = ["label"=>"Tanggal","name"=>"master_journal_id",'join'=>'master_journal_detail,created_at'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		// $this->form = [];
		// $this->form[] = ['label'=>'COA Name','name'=>'master_journal_coa_name','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'master_coa_third,master_coa_third_name'];
		// $this->form[] = ['label'=>'Description','name'=>'master_journal_description','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
		// $this->form[] = ['label'=>'Debit','name'=>'master_journal_debit','type'=>'money','validation'=>'integer|min:0','width'=>'col-sm-10'];
		// $this->form[] = ['label'=>'Kredit','name'=>'master_journal_kredit','type'=>'money','validation'=>'integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

		$this->form[] = ['label'=>'Jurnal Detail','name'=>'master_journal_detail','type'=>'child','columns'=>$columns,'table'=>'master_journal_detail','foreign_key'=>'master_journal_id'];	

		$this->form[] = ['label'=>'Debit Balance','name'=>'debit_balance','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];	
		$this->form[] = ['label'=>'Kredit Balance','name'=>'kredit_balance','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];	

		// $this->form[] = ['label'=>'Grand Total','name'=>'grand_total','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];	

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Master Journal Coa Code","name"=>"master_journal_coa_code","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Master Journal Coa Name","name"=>"master_journal_coa_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Master Journal Debit","name"=>"master_journal_debit","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Master Journal Description","name"=>"master_journal_description","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Master Journal Kredit","name"=>"master_journal_kredit","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
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
	        $this->script_js = "";



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
	    	$date = Carbon::now()->format('Y-m-d');
	    	$query->whereDate('master_journal_detail.created_at','LIKE',$date)->whereNotNull('master_journal.master_journal_id');
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
	    	$data['page_title'] = 'Buku Besar';

	    	$data['result'] = DB::table('master_coa_detail')
            ->select('*')
            ->orderBy('master_coa_detail_code','ASC')
            ->get();


            // $data['result'] = DB::table('master_journal_detail')
            // ->join('master_coa_detail', 'master_coa.id', '=', 'master_coa_detail.master_coa_id')
            // ->join('master_coa_third', 'master_coa_detail.id', '=', 'master_coa_third.master_coa_detail_id')
            // ->select('master_coa.*', 'master_coa_detail.*', 'master_coa_third.*')
            // ->orderBy('master_coa.master_coa_code','ASC')
            // ->paginate(20);

   //Create a view. Please use `cbView` method instead of view method from laravel.
		    	$this->cbView('fa_report.buku_besar_index',$data);
	    }


	    public function ExportBukuBesar(Request $request) {

	    	if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

	  //   	setlocale(LC_TIME, 'id_ID.UTF-8');

	  //   	$month = Input::get('month');
			// $previous_month = Carbon::createFromFormat('d', $month)->addDay(-1);
   //          $year = Input::get('year');
   //          $coa_name = Input::get('coa_name');

	    	$data = [];
	    	$data['page_title'] = 'Buku Besar';

	    	setlocale(LC_TIME, 'id_ID.UTF-8');
      		$date1 = Input::get('date1');
            $date2 = Input::get('date2');
            $coa_id = Input::get('coa_id');

	    	$data['result'] = DB::table('master_journal_detail')
              ->join('master_coa_detail', 'master_journal_detail.master_coa_detail_id', '=', 'master_coa_detail.id')
              	->join('master_coa', 'master_coa_detail.master_coa_id', '=', 'master_coa.id')
                ->select('master_journal_detail.*', 'master_coa_detail.*','master_coa.*','master_journal_detail.created_at AS master_journal_detail_date', 'master_coa.id as id_coa')
                  ->where('master_journal_detail.master_coa_detail_id',$coa_id)
                  ->whereBetween('master_journal_detail.created_at', [$date1, $date2])
                  ->orderBy('master_journal_detail.id','ASC')
                  ->get();


	    	 if ($data['result']->isEmpty()) {
    			Session::flash('message', "Maaf Data Tidak Tersedia");
				return Redirect::to('admin/buku_besar');
    		}

	   

            $this->cbView('fa_report.buku_besar_export',$data);



	    }


	}
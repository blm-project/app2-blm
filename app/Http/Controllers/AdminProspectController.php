<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminProspectController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "prospect_customer_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
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
		$this->table = "prospect";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"Prospek","name"=>"opportunity_name"];
		$this->col[] = ["label"=>"Sales Name","name"=>"sales_name_id",'join'=>'cms_users,name'];
		$this->col[] = ["label"=>"Staging","name"=>"staging"];		
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label'=>'Prospect Date','name'=>'prospect_date','type'=>'date','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false,'value'=>date('Y-m-d') ];
		$this->form[] = ['label'=>'Nama Opportunity','name'=>'opportunity_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];


		//Type Prospek
		$this->form[] = ['label'=>'Type Prospek','name'=>'prospect_type','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'New Customer;Existing Customer'];
		$this->form[] = ['label'=>'Browse Customer',
		'name'=>'master_customer_id',
		'type'=>'datamodal',
		'datamodal_table'=>'master_customer',
		'datamodal_columns'=>'master_customer_name',
		'datamodal_select_to'=>'master_customer_name:company_name',
		'datamodal_where'=>'',
		'datamodal_size'=>'large',
		'required'=>false,
		'datamodal_columns_alias'=>'Nama'];

		$this->form[] = ['label'=>'Nama Perusahaan','name'=>'company_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Telephone','name'=>'phone_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Website','name'=>'website','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];


			//PIC
		$this->form[] = ['label'=>'Nama PIC','name'=>'pic_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'PIC Contact','name'=>'pic_contact','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'PIC Email','name'=>'pic_email','type'=>'email','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Coordinate','name'=>'map_coordinate','type'=>'googlemaps','validation'=>'','width'=>'col-sm-10','readonly'=>false,'latitude'=>'lat','longitude'=>'lng'];
		$this->form[] = ['label'=>'Service Need','name'=>'service_need_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false,'datatable'=>'master_product,master_product_name'];

			//PROBABILITAS
		$this->form[] = ['label'=>'Estimasi Closing','name'=>'estimation_closing_date','type'=>'date','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false,'value'=>date('Y-m-d') ];
		$this->form[] = ['label'=>'Estimasi Nilai Project','name'=>'estimation_value','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Currency','name'=>'prospect_kurs','type'=>'select','dataenum'=>'IDR;USD', 'required'=>true];
		$this->form[] = ['label'=>'Staging','name'=>'staging','type'=>'hidden','dataenum'=>'Approace;Presentasi;Proposal', 'required'=>true];
		$this->form[] = ['label'=>'Sales Name','name'=>'sales_name_id','type'=>'hidden','value'=>CRUDBooster::myId()];

			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Prospect Number","name"=>"prospect_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Prospect Customer Name","name"=>"prospect_customer_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Prospect Service Type","name"=>"prospect_service_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
	        $this->script_js = "


	        $('#prospect_type').change(function(){ 
	        	if($('#prospect_type option:selected').val() === 'Existing Customer'){ 
	        		$('#form-group-master_customer_id').show();
	        	}
	        	else{
	        		$('#form-group-master_customer_id').hide();
	        	}
	        	});



	        $('#estimation_value').priceFormat({
	        	prefix: '',
	        	centsSeparator: '.',
	        	thousandsSeparator: ','
	        	});


	        	";


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
	         $this->style_css = "
	        #form-group-master_customer_id {
	        display: none;
	    } 

	    ";
	        
	        
	        
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
	    	$postdata['estimation_value'] = str_replace(',', '', $postdata['estimation_value']);
	    	$postdata['staging'] = "Approach";

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
	    	$postdata['estimation_value'] = str_replace(',', '', $postdata['estimation_value']);
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


	}
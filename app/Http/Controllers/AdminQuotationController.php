<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use PDF;
use Carbon\Carbon;

class AdminQuotationController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
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
		$this->table = "quotation";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"No Quotation","name"=>"quot_number"];
		$this->col[] = ["label"=>"Customer","name"=>"company_name"];
		$this->col[] = ["label"=>"Perihal","name"=>"subject"];
		$this->col[] = ["label"=>"Send By","name"=>"send_by",'join'=>'cms_users,name'];
		$this->col[] = ["label"=>"Date","name"=>"quot_date"];
		$this->col[] = ["label"=>"Quotation File","name"=>"quot_upload","download"=>true];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];

		$date_code = Carbon::now()->format('m/y');
		$select_code = DB::table('quotation')->select('quot_code')->orderBy('created_at','desc')->first();
		$max_code = isset($select_code->quot_code) ? $select_code->quot_code : 0000;
		$data = [];

		if ($max_code > 998) {
			CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Nomor Sudah Maksimal");
		} else {
			$next_code = $max_code + 1;
		}

		$quot_number= str_pad($next_code,4,'0',STR_PAD_LEFT).'/Quot/BLM/'.$date_code ;

		if(CRUDBooster::getCurrentMethod() == 'getEdit') {
		$this->form[] = ['label'=>'Upload Quotation File','name'=>'quot_upload','type'=>'upload','validation'=>'']; }

		$this->form[] = ['label'=>'No.','name'=>'quot_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>true, 'value'=>$quot_number];
		$this->form[] = ['label'=>'Code.','name'=>'quot_code','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>true, 'value'=>str_pad($next_code,4,'0',STR_PAD_LEFT)];
		$this->form[] = ['label'=>'Perihal','name'=>'subject','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
		$this->form[] = ['label'=>'Tgl. Quotation','name'=>'quot_date','type'=>'date','validation'=>'required','width'=>'col-sm-10','value'=>date('Y-m-d') ];


		//Type Quotation
		$this->form[] = ['label'=>'Browse Data',
		'name'=>'prospect_id',
		'type'=>'datamodal',
		'datamodal_table'=>'prospect',
		'datamodal_columns'=>'opportunity_name,company_name,prospect_type',
		'datamodal_select_to'=>'company_name:company_name,prospect_type:quot_type',
		'datamodal_where'=>'',
		'datamodal_size'=>'large',
		'required'=>true,
		'datamodal_columns_alias'=>'Nama Perusahaan,Tipe Prospek'];
		$this->form[] = ['label'=>'Type Quotation','name'=>'quot_type','type'=>'text','validation'=>'','width'=>'col-sm-10','readonly'=>true];

		//Surat ditujukan kepada
		$this->form[] = ['label'=>'Company Name','name'=>'company_name','type'=>'text','validation'=>'','width'=>'col-sm-10','readonly'=>true ];
		$this->form[] = ['label'=>'Kepada','name'=>'to_name','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
		$this->form[] = ['label'=>'Gender Person','name'=>'to_gender','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Laki-Laki;Perempuan'];
		$this->form[] = ['label'=>'Address','name'=>'to_address','type'=>'textarea','validation'=>'required','width'=>'col-sm-10'];

		//Produk yang ditawarkan
		$this->form[] = ['label'=>'Product/Service','name'=>'master_product_id','type'=>'select2','datatable'=>'master_product,master_product_name','datatable_ajax'=>false];

		//Sendy  by
		$this->form[] = ['label'=>'Send By','name'=>'send_by','type'=>'hidden','value'=>CRUDBooster::myId()];
			# END FORM DO NOT REMOVE THIS LINE


		//QUOTATION DETAIL TABLE

		$columns[] = ['label'=>'From','name'=>'master_interkoneksi_link_id','type'=>'select','datatable'=>'master_interkoneksi_link,name','datatable_ajax'=>false, 'required'=>false];
		$columns[] = ['label'=>'To',
		'name'=>'master_destination_id',
		'type'=>'datamodal',
		'datamodal_table'=>'master_destination',
		'datamodal_columns'=>'name',
		'datamodal_select_to'=>'name:master_destination_name,address:master_destination_address',
		'datamodal_where'=>'name IS NOT NULL',
		'datamodal_size'=>'large',
		'required'=>false,
		'datamodal_columns_alias'=>'PT Destination,Address Destination'];
		$columns[] = ['label'=>'PT Destination','name'=>'master_destination_name','type'=>'text','readonly'=>true];

		$columns[] = ['label'=>'Destination Address','name'=>'master_destination_address','type'=>'text','readonly'=>false];
		$columns[] = ['label'=>'Media','name'=>'media','type'=>'select','dataenum'=>['FO','Kabel UTP','Wireless'], 'required'=>true];
		$columns[] = ['label'=>'Capacity','name'=>'capacity','type'=>'number','readonly'=>false, 'required'=>true];
		$columns[] = ['label'=>'Unit','name'=>'master_unit_id','type'=>'select','datatable'=>'master_unit,name','datatable_ajax'=>false, 'required'=>true];
		$columns[] = ['label'=>'Charge','name'=>'charge_type','type'=>'select','dataenum'=>['Monthly Charge','Yearly Charge'], 'required'=>true];
		$columns[] = ['label'=>'Currency','name'=>'charge_kurs','type'=>'select','dataenum'=>['IDR','USD'], 'required'=>true];
		$columns[] = ['label'=>'Charge Amount','name'=>'charge_amount','type'=>'money','readonly'=>false, 'required'=>true];
		$columns[] = ['label'=>'Installation','name'=>'charge_installation','type'=>'money','readonly'=>false, 'required'=>true];

		$this->form[] = ['label'=>'Quotation Detail','name'=>'quotation_detail','type'=>'child','columns'=>$columns,'table'=>'quotation_detail','foreign_key'=>'quotation_id'];

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Quot Customer Name","name"=>"quot_customer_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Quot Customer Address","name"=>"quot_customer_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
	        $this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('print-quot/[id]'),'icon'=>'fa fa-print','color'=>'success', 'target'=>'_blank'];


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
	        $this->index_button[] = ['label'=>'Upload Quotation','url'=>("quotation_upload/add?"),"icon"=>"fa fa-upload","color"=>"danger"];



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

	        $('#master_product_id').change(function(){ 
	        	if($('#master_product_id option:selected').val() == 1){ 
	        		$('#form-group-quotationdetailmaster_interkoneksi_link_id').css('display', 'block');
	        		$('#form-group-quotationdetailmaster_destination_id').css('display', 'block');
	        		$('#form-group-quotationdetailmaster_destination_name').css('display', 'block');
	        	}
	        	else{
	        		$('#form-group-quotationdetailmaster_interkoneksi_link_id').hide();
	        		$('#form-group-quotationdetailmaster_destination_id').hide();
	        		$('#form-group-quotationdetailmaster_destination_name').hide();
	        	}
	        	});




	        	$('#quotationdetailcharge_amount, #quotationdetailcharge_installation').priceFormat({
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
	        #form-group-quotationdetailmaster_interkoneksi_link_id, #form-group-quotationdetailmaster_destination_id, #form-group-quotationdetailmaster_destination_name {
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

	        if(is_array($id) == 1) {

	    		foreach ($id as $id_selected) {
	    			DB::table('quotation_detail')->where('quotation_id',$id_selected)->delete();
	    		}


	    	} else {

	    		DB::table('quotation_detail')->where('quotation_id',$id)->delete();
	    	}

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
	    //Generate PDF
	    public function generatePDF($id)

	    {


	    	$data = [];
	    	$data['page_title'] = 'Quotation';

	    	$pdf = PDF::loadView('export.quotation', $data)->setPaper('a4', 'portrait');

	    	// return $pdf->download('laporan-pdf.pdf');
	    	return $pdf->stream();
	    }


	}
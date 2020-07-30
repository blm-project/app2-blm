<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;

class AdminIncomingPoController extends \crocodicstudio\crudbooster\controllers\CBController {

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
		$this->table = "incoming_po";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"No. Incoming PO","name"=>"incoming_po_number"];
		$this->col[] = ["label"=>"Nama Customer","name"=>"customer_id"];
		$this->col[] = ["label"=>"Tanggal","name"=>"incoming_po_date"];

			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];

		$date_code = Carbon::now()->format('m/y');
		$select_code = DB::table('incoming_po')->select('incoming_po_code')->orderBy('created_at','desc')->first();
		$max_code = isset($select_code->incoming_po_code) ? $select_code->incoming_po_code : 0000;
		$data = [];

		if ($max_code > 998) {
			CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Nomor Sudah Maksimal");
		} else {
			$next_code = $max_code + 1;
		}

		$incoming_po_number= str_pad($next_code,4,'0',STR_PAD_LEFT).'/IPO/EKADATA/'.$date_code ;


		$this->form[] = ['label'=>'No.','name'=>'incoming_po_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>true, 'value'=>$incoming_po_number];
		$this->form[] = ['label'=>'Code.','name'=>'incoming_po_code','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>true, 'value'=>str_pad($next_code,4,'0',STR_PAD_LEFT)];

		$this->form[] = ['label'=>'Tanggal PO','name'=>'incoming_po_date','type'=>'date','validation'=>'required','width'=>'col-sm-10','readonly'=>false,'value'=>date('Y-m-d') ];
		$this->form[]  = ['label'=>'Data Prospek',
		'name'=>'prospect_id',
		'type'=>'datamodal',
		'datamodal_table'=>'prospect',
		'datamodal_columns'=>'pic_name',
		'datamodal_select_to'=>'pic_name:pic_name,pic_contact:pic_phone,pic_email:pic_email',
		'datamodal_where'=>'',
		'datamodal_size'=>'large',
		'required'=>false,
		'datamodal_columns_alias'=>'Nama PIC'];

			//JENIS PERMINTAAN
		$this->form[] = ['label'=>'Jenis Permintaan','name'=>'order_type','type'=>'radio','dataenum'=>'New Installation;Upgrade;Down Grade;Other','validation'=>'required'];
		$this->form[] = ['label'=>'Other','name'=>'order_type_other','type'=>'text','validation'=>''];

			//INFORMASI PELANGGAN
		$this->form[] = ['label'=>'Nama Customer','name'=>'customer_id','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Jenis','name'=>'customer_type','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Alamat','name'=>'customer_address','type'=>'textarea','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Provinsi','name'=>'customer_province','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Email','name'=>'customer_email','type'=>'email','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'NPWP','name'=>'customer_npwp','type'=>'text','validation'=>'','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Telepon','name'=>'customer_phone','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Fax','name'=>'customer_fax','type'=>'text','validation'=>'','width'=>'col-sm-10','readonly'=>false];

			//PENANGGUNG JAWAB
		$this->form[] = ['label'=>'Nama PIC','name'=>'pic_name','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Tempat Lahir','name'=>'pic_birthplace','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Tanggal Lahir','name'=>'pic_birthdate','type'=>'date','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Phone','name'=>'pic_phone','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Kartu Identitas','name'=>'pic_idcard','type'=>'radio','dataenum'=>'KTP;KIM-S;SIM;PASPOR','validation'=>'required'];
		$this->form[] = ['label'=>'No Kartu Identitas','name'=>'pic_idcard_no','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Masa Berlaku','name'=>'pic_idcard_valid_date','type'=>'date','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Email','name'=>'pic_email','type'=>'email','validation'=>'required','width'=>'col-sm-10','readonly'=>false];

			//ALAMAT PENAGIHAN
		$this->form[] = ['label'=>'Alamat Penagihan','name'=>'billing_address','type'=>'textarea','validation'=>'required','width'=>'col-sm-10','readonly'=>false];

			//JENIS LAYANAN YANG DIMINTA
		$this->form[] = ['label'=>'Spesifikasi Layanan','name'=>'services_spec','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Total Capacity','name'=>'total_capacity','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];

			//ALAMAT INSTALASI
		$this->form[] = ['label'=>'Alamat Instalasi','name'=>'installation_address','type'=>'textarea','validation'=>'required','width'=>'col-sm-10','readonly'=>false];

			//BIAYA BERLANGGANAN
		$this->form[] = ['label'=>'Biaya Set Up','name'=>'cost_setup','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];
		$this->form[] = ['label'=>'Biaya Layanan','name'=>'cost_services','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>false];

			//TTD
		$this->form[] = ['label'=>'Upload TTD PIC','name'=>'sign_image','type'=>'upload','validation'=>'image','validation'=>''];
		$this->form[] = ['label'=>'Kelengkapan Dokumen','name'=>'document_req','type'=>'checkbox','dataenum'=>'Fotokopi KTP / Paspor;Surat Kuasa (apabila dikuasakan);Fotokopi NPWP','validation'=>'required'];
		$this->form[] = ['label'=>'Upload File Incoming PO','name'=>'incoming_po_file','type'=>'upload','validation'=>'image','validation'=>''];


			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
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
	          $this->script_js = "$('#form-group-order_type').change(function(){ 
            if($('#form-group-order_type input[type=\'radio\']:checked').val() === 'Other'){ 
              $('#form-group-order_type_other').show();

            }
            else{
              $('#form-group-order_type_other').hide();
            }
            });


            $('#cost_setup, #cost_services').priceFormat({
	        		prefix: '',
	        		centsSeparator: '.',
	        		thousandsSeparator: ','
	        		});

	        		"


	        	;


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
	        #form-group-order_type_other {
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
	        $postdata['cost_setup'] = str_replace(',', '', $postdata['cost_setup']);
	        $postdata['cost_services'] = str_replace(',', '', $postdata['cost_services']);
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
	        $postdata['cost_setup'] = str_replace(',', '', $postdata['cost_setup']);
	        $postdata['cost_services'] = str_replace(',', '', $postdata['cost_services']);

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
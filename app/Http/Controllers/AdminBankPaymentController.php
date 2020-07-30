<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;

class AdminBankPaymentController extends \crocodicstudio\crudbooster\controllers\CBController {

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
		$this->table = "bank_payment";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"No. BP","name"=>"bp_number"];
		$this->col[] = ["label"=>"Payment Date","name"=>"payment_date"];
		$this->col[] = ["label"=>"Payment Method","name"=>"payment_method",'join'=>'master_coa_third,master_coa_third_name'];
		$this->col[] = ["label"=>"Amount","name"=>"total_invoice","callback"=>function($row) {
			return number_format($row->total_invoice,2,'.',',');}];
			$this->col[] = ["label"=>"Keterangan","name"=>"description"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			$date_code = Carbon::now()->format('Ymd');
			$select_code = DB::table('bank_payment')->select('bp_code')->orderBy('created_at','desc')->first();
			$max_code = isset($select_code->bp_code) ? $select_code->bp_code : 00000;
			$data = [];

			if ($max_code > 9998) {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Nomor Sudah Maksimal");
			} else {	
				$next_code = $max_code + 1;
			}

			$bp_number= 'BP/'.$date_code.'/'.str_pad($next_code,5,'0',STR_PAD_LEFT);


			$this->form[] = ['label'=>'BP Number','name'=>'bp_number','type'=>'text','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>$bp_number ];

			$this->form[] = ['label'=>'BP Code','name'=>'bp_code','type'=>'hidden','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>$next_code ];


			$this->form[] = ['label'=>'Payment Date','name'=>'payment_date','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'readonly' => false ];


			$this->form[] = ['label'=>'Payment Method',
			'name'=>'payment_method',
			'type'=>'datamodal',
			'datamodal_table'=>'master_coa_third',
			'datamodal_columns'=>'master_coa_third_name,master_coa_third_code',
			'datamodal_select_to'=>'id:master_coa_third_id,master_coa_detail_id:master_coa_detail_id,master_coa_third_name:master_journal_detail_coa_name,master_coa_third_code:master_journal_detail_coa_code',
			'datamodal_where'=>'master_coa_third_name REGEXP "Bank"',
			'datamodal_size'=>'large',
			'datamodal_columns_alias'=>'Name,Code',
			'required'=>true];

			$date = Carbon::now()->format('Y-m-d');
			$this->form[] = ['label'=>'COA Code Category','name'=>'master_journal_detail_coa_code','type'=>'number','readonly'=>true,'required'=>true];
			$this->form[] = ['label'=>'COA Detail','name'=>'master_coa_detail_id','type'=>'number','readonly'=>true,'required'=>true];
			$this->form[] = ['label'=>'COA Name','name'=>'master_journal_detail_coa_name','type'=>'text','readonly'=>true,'required'=>true];
			$this->form[] = ['label'=>'Amount','name'=>'total_invoice','type'=>'text','validation'=>'required','width'=>'col-sm-9', 'readonly'=>false];
			$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','validation'=>'','width'=>'col-sm-9'];



			$journal[] = ['label'=>'COA',
			'name'=>'master_coa_third_id',
			'type'=>'datamodal',
			'datamodal_table'=>'master_coa_third',
			'datamodal_columns'=>'master_coa_third_name,master_coa_third_code',
			'datamodal_select_to'=>'master_coa_detail_id:master_coa_detail_id,master_coa_third_name:master_journal_detail_coa_name,master_coa_third_code:master_journal_detail_coa_code',
			'datamodal_where'=>'master_coa_third_name IS NOT NULL',
			'datamodal_size'=>'large',
			'datamodal_columns_alias'=>'COA Name,COA Code'];

			$date = Carbon::now()->format('Y-m-d');
			$journal[] = ['label'=>'COA Code Category','name'=>'master_journal_detail_coa_code','type'=>'hidden','readonly'=>true,'required'=>true];
			$journal[] = ['label'=>'COA Detail','name'=>'master_coa_detail_id','type'=>'hidden','readonly'=>true,'required'=>true];
			$journal[] = ['label'=>'COA Name','name'=>'master_journal_detail_coa_name','type'=>'hidden','readonly'=>true,'required'=>true];
			$journal[] = ['label'=>'Deskripsi','name'=>'master_journal_detail_description','type'=>'textarea','readonly'=>false,'required'=>false];
			$journal[] = ['label'=>'Debit','name'=>'master_journal_detail_debit','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10'];
			$journal[] = ['label'=>'Tanggal','name'=>'created_at','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'readonly'=>true];

			$this->form[] = ['label'=>'Jurnal Detail','name'=>'master_journal_detail','type'=>'child','columns'=>$journal,'table'=>'master_journal_detail','foreign_key'=>'bp_id'];


			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'No Faktur','name'=>'no_faktur','type'=>'text','validation'=>'required','width'=>'col-sm-9'];
			//
			//$this->form[] = ['label'=>'PO Number',
			//'name'=>'po_id',
			//'type'=>'datamodal',
			//'datamodal_table'=>'purchase_order',
			//'datamodal_columns'=>'po_number,po_date',
			//'datamodal_select_to'=>'',
			//'datamodal_where'=>'po_status LIKE "CLOSE"',
			//'datamodal_size'=>'large',
			//'datamodal_columns_alias'=>'PO Number,PO Date',
			//'required'=>true];
			//
			//
			//
			//$this->form[] = ['label'=>'Kode Supplier',
			//'name'=>'kode_supplier',
			//'type'=>'datamodal',
			//'datamodal_table'=>'master_supplier',
			//'datamodal_columns'=>'master_supplier_code,master_supplier_name',
			//'datamodal_select_to'=>'master_supplier_code:kode_supplier,master_supplier_name:nama_supplier,master_supplier_tempo:tempo_faktur',
			//'datamodal_where'=>'',
			//'datamodal_size'=>'large',
			//'datamodal_columns_alias'=>'Name,Code',
			//'required'=>true];
			//
			//// $this->form[] = ['label'=>'Kode Supplier','name'=>'kode_supplier','type'=>'select2','validation'=>'required','width'=>'col-sm-9','datatable'=>'master_supplier,master_supplier_code'];
			//$this->form[] = ['label'=>'Nama Supplier','name'=>'nama_supplier','type'=>'text','validation'=>'required','width'=>'col-sm-9', 'readonly'=>true];
			//$this->form[] = ['label'=>'Tgl Faktur','name'=>'tgl_faktur','type'=>'date','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Tukar Faktur','name'=>'tukar_faktur','type'=>'date','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Tempo Faktur','name'=>'tempo_faktur','type'=>'date','width'=>'col-sm-9','readonly'=>true];
			//$this->form[] = ['label'=>'Sub Invoice','name'=>'sub_invoice','type'=>'money','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Disc Invoice','name'=>'disc_invoice','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Ppn Invoice','name'=>'ppn_invoice','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Total Invoice','name'=>'total_invoice','type'=>'number','validation'=>'required','width'=>'col-sm-9'];
			//$this->form[] = ['label'=>'Status Invoice','name'=>'status_invoice','type'=>'hidden','validation'=>'required','width'=>'col-sm-9','value'=>'UNPAID'];
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

	        $().ready(function() {
	        	$('#payment_date').autofill({
	        		fieldId : 'jurnaldetailcreated_at',
	        		overrideFieldEverytime : true
	        		});
	        		});


	        $('#jurnaldetailmaster_journal_detail_kredit, #jurnaldetailmaster_journal_detail_debit, #total_invoice').priceFormat({
	        			prefix: '',
	        			centsSeparator: '.',
	        			thousandsSeparator: ','
	        			});


	        			$('#jurnaldetailcreated_at').prop('disabled', true);





	        // $(function() {
	        // 	$('#sub_invoice, #disc_invoice, #tax_invoice').on('change', sum);
	        // 	function sum() {
	        // 		$('#total_invoice').val(Number($('#sub_invoice').val()) - (Number($('#disc_invoice').val()) + Number($('#tax_invoice').val())) );
	        // 	}
	        // 	});


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

	        	#form-group-master_journal_detail_coa_code, #form-group-master_coa_detail_id, #form-group-master_journal_detail_coa_name {
	        display: none;
	    } 


	    td.master_journal_detail_coa_code {
	    	display: none;
	    }

	    th.COACodeCategory {
	    	display: none;
	    }


	    td.master_coa_detail_id {
	    	display: none;
	    }

	    th.COADetail {
	    	display: none;
	    }


	    td.master_journal_detail_coa_name {
	    	display: none;
	    }

	    th.COAName {
	    	display: none;
	    }



	    "

	    ;



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
	    	$postdata['total_invoice'] = str_replace(',', '', $postdata['total_invoice']);

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
	    	$postdata['total_invoice'] = str_replace(',', '', $postdata['total_invoice']);
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
	    			DB::table('master_journal_detail')->where('bp_id',$id_selected)->delete();
	    		}


	    	} else {

	    		DB::table('master_journal_detail')->where('bp_id',$id)->delete();
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


	}
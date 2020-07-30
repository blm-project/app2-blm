<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class AdminReceivablePaymentController extends \crocodicstudio\crudbooster\controllers\CBController {

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
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "receivable_payment";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"No. Receivable Payment","name"=>"receivable_number"];
		$this->col[] = ["label"=>"Grand Total","name"=>"grand_total",'callback_php'=>'number_format($row->grand_total, 2, ".", ",")'];

			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];


		$date_code = Carbon::now()->format('Ymd');
		$select_code = DB::table('receivable_payment')->select('receivable_code')->orderBy('created_at','desc')->first();
		$max_code = isset($select_code->receivable_code) ? $select_code->receivable_code : 00000;
		$data = [];

		if ($max_code > 9998) {
			CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Nomor Sudah Maksimal");
		} else {
			$next_code = $max_code + 1;
		}

		$receivable_number= 'RVB/'.$date_code.'/'.str_pad($next_code,5,'0',STR_PAD_LEFT);




		$this->form[] = ['label'=>'No. Receivable Payment','name'=>'receivable_number','type'=>'text','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>$receivable_number ];

		$this->form[] = ['label'=>'No. Receivable CODE','name'=>'receivable_code','type'=>'hidden','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>$next_code ];

		$this->form[] = ['label'=>'Tanggal Payment','name'=>'receivable_date','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'readonly' => false,'value'=>date('Y-m-d') ];



		$columns[] = ['label'=>'Account Receivable',
		'name'=>'account_receivable_id',
		'type'=>'datamodal',
		'datamodal_table'=>'account_receivable',
		'datamodal_columns'=>'ar_number,master_customer_name_id,description,total_invoice',
		'datamodal_select_to'=>'master_customer_name_id:master_customer_name_id,description:description,total_invoice:total_invoice',
		'datamodal_where'=>'status_invoice LIKE "UNPAID"',
		'datamodal_size'=>'large',
		'datamodal_columns_alias'=>'No. AR,Nama Customer,Keterangan,Total Invoice',
		'required'=>true];

		$columns[] = ['label'=>'Nama Customer','name'=>'master_customer_name_id','type'=>'text','readonly'=>true,'required'=>true];
		$columns[] = ['label'=>'Keterangan','name'=>'description','type'=>'textarea','readonly'=>true,'required'=>false];
		$columns[] = ['label'=>'Total Invoice','name'=>'total_invoice','type'=>'text','readonly'=>true,'required'=>false];

		$this->form[] = ['label'=>'Receivable Payment Form','name'=>'receivable_payment_detail','type'=>'child','columns'=>$columns,'table'=>'receivable_payment_detail','foreign_key'=>'receivable_payment_id'];

		$this->form[] = ['label'=>'Grand Total','name'=>'grand_total','type'=>'text','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];


		$this->form[] = ['label'=>'Payment Method',
		'name'=>'master_coa_third_id',
		'type'=>'datamodal',
		'datamodal_table'=>'master_coa_third',
		'datamodal_columns'=>'master_coa_third_name,master_coa_third_code',
		'datamodal_select_to'=>'id:master_coa_third_id,master_coa_detail_id:master_coa_detail_id,master_coa_third_name:master_journal_detail_coa_name,master_coa_third_code:master_journal_detail_coa_code',
		'datamodal_where'=>'master_coa_third_name REGEXP "BANK"',
		'datamodal_size'=>'large',
		'datamodal_columns_alias'=>'Name,Code',
		'required'=>true];

		$this->form[] = ['label'=>'COA Code Category','name'=>'master_journal_detail_coa_code','type'=>'number','readonly'=>true,'required'=>true];
		$this->form[] = ['label'=>'COA Detail','name'=>'master_coa_detail_id','type'=>'number','readonly'=>true,'required'=>true];
		$this->form[] = ['label'=>'COA Name','name'=>'master_journal_detail_coa_name','type'=>'text','readonly'=>true,'required'=>true];



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
	        // $this->button_selected[] = ['label'=>'Pay Account','icon'=>'fa fa-check','name'=>'set_paid','url'=>"javascript:showCustomExport()"];


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
	        // $this->index_button[] = ['label'=>'Export Custom','url'=>"javascript:showCustomExport()",'icon'=>'fa fa-download'];	



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

	        $('#jurnaldetailmaster_journal_detail_debit, #total_invoice, #grand_total').priceFormat({
	        	prefix: '',
	        	centsSeparator: '.',
	        	thousandsSeparator: ','
	        	});



	        	$(function() {


	        		setInterval(function() {

	        			var grand_total = 0;
	        			$('#panel-form-receivablepaymentform tbody .total_invoice').each(function() {
	        				var amount = parseFloat($(this).text().replace(/\,/g,'') || 0);
	        				grand_total += amount;

	        				})
	        				$('#grand_total').val(grand_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
	        				},500  )
	        				})


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
	        $this->post_index_html = NULL;
	        
	        
	        
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

	         //$id_selected is an array of id 
  //$button_name is a name that you have set at button_selected 

  // if($button_name == 'set_paid') {	
  //   DB::table('account_payable')->whereIn('id',$id_selected)->update(['status_invoice'=>'PAID']);
  //   dd($id_selected);
  // }


	    }




	    /*x`
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	        // $query->where('status_invoice',"UNPAID");

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
	    	$postdata['grand_total'] = str_replace(',', '', $postdata['grand_total']);
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




	}
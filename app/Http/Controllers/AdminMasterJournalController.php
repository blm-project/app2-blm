<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;

class AdminMasterJournalController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "master_journal_coa_name";
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
		$this->table = "master_journal";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"Ref Number","name"=>"ref_number"];
		$this->col[] = ["label"=>"Journal Date","name"=>"journal_date",'callback_php'=>'date("d/m/Y",strtotime($row->journal_date))'];
		$this->col[] = ["label"=>"Debit","name"=>"debit_balance",'callback_php'=>'number_format($row->debit_balance, 2, ".", ",")'];
		$this->col[] = ["label"=>"Kredit","name"=>"kredit_balance",'callback_php'=>'number_format($row->kredit_balance, 2, ".", ",")'];
		$this->col[] = ["label"=>"Memo","name"=>"Memo"];
		
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		// $this->form = [];
		// $this->form[] = ['label'=>'COA Name','name'=>'master_journal_coa_name','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'master_coa_third,master_coa_third_name'];
		// $this->form[] = ['label'=>'Description','name'=>'master_journal_description','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
		// $this->form[] = ['label'=>'Debit','name'=>'master_journal_debit','type'=>'money','validation'=>'integer|min:0','width'=>'col-sm-10'];
		// $this->form[] = ['label'=>'Kredit','name'=>'master_journal_kredit','type'=>'money','validation'=>'integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

		$po_date = Carbon::now()->format('Y-m-d');

		$date_code = Carbon::now()->format('Ymd');
		$select_code = DB::table('master_journal')->select('ref_code')->orderBy('created_at','desc')->first();
		$max_code = isset($select_code->ref_code) ? $select_code->ref_code : 00000;
		$data = [];

		if ($max_code > 9998) {
			CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Nomor Sudah Maksimal");
		} else {
			$next_code = $max_code + 1;
		}

		$ref_number= 'REF/'.$date_code.'/'.str_pad($next_code,5,'0',STR_PAD_LEFT);


		$this->form[] = ['label'=>'Ref Code','name'=>'ref_number','type'=>'text','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>$ref_number ];
		$this->form[] = ['label'=>'Ref Next Code','name'=>'ref_code','type'=>'hidden','validation'=>'required','width'=>'col-sm-10', 'readonly' => false, 'value'=>str_pad($next_code,5,'0',STR_PAD_LEFT) ];
		$this->form[] = ['label'=>'Journal Date','name'=>'journal_date','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'readonly' => false ];


		$columns[] = ['label'=>'COA',
		'name'=>'master_coa_third_id',
		'type'=>'datamodal',
		'datamodal_table'=>'master_coa_third',
		'datamodal_columns'=>'master_coa_third_name,master_coa_third_code',
		'datamodal_select_to'=>'master_coa_detail_id:master_coa_detail_id,master_coa_third_name:master_journal_detail_coa_name,master_coa_third_code:master_journal_detail_coa_code',
		'datamodal_where'=>'master_coa_third_name IS NOT NULL',
		'datamodal_size'=>'large',
		'datamodal_columns_alias'=>'COA Name,COA Code'];
		

		$columns[] = ['label'=>'COA Code Category','name'=>'master_journal_detail_coa_code','type'=>'hidden','readonly'=>true,'required'=>true];
		$columns[] = ['label'=>'COA Detail','name'=>'master_coa_detail_id','type'=>'hidden','readonly'=>true,'required'=>true];
		$columns[] = ['label'=>'COA Name','name'=>'master_journal_detail_coa_name','type'=>'hidden','readonly'=>true,'required'=>true];
		$columns[] = ['label'=>'Description','name'=>'master_journal_detail_description','type'=>'textarea','readonly'=>false,'required'=>false];
		$columns[] = ['label'=>'Debit','name'=>'master_journal_detail_debit','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10'];
		$columns[] = ['label'=>'Kredit','name'=>'master_journal_detail_kredit','type'=>'money','validation'=>'required|min:1','width'=>'col-sm-10'];
		$columns[] = ['label'=>'Created At','name'=>'created_at','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'readonly'=>true];
		
		$this->form[] = ['label'=>'Jurnal Detail','name'=>'master_journal_detail','type'=>'child','columns'=>$columns,'table'=>'master_journal_detail','foreign_key'=>'master_journal_id'];

		

		$this->form[] = ['label'=>'Debit Balance','name'=>'debit_balance','type'=>'text','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];	
		$this->form[] = ['label'=>'Kredit Balance','name'=>'kredit_balance','type'=>'text','validation'=>'required|min:1','width'=>'col-sm-10', 'readonly' => true, ];	

		$this->form[] = ['label'=>'Memo','name'=>'memo','type'=>'textarea','validation'=>'','width'=>'col-sm-10', 'readonly' => false];	

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
	        $this->script_js = "




	        $().ready(function() {
	        	$('#journal_date').autofill({
	        		fieldId : 'jurnaldetailcreated_at',
	        		overrideFieldEverytime : true
	        		});
	        		});


	        		$('#jurnaldetailcreated_at').prop('disabled', true);



	        		$('#jurnaldetailmaster_journal_detail_kredit, #jurnaldetailmaster_journal_detail_debit').priceFormat({
	        			prefix: '',
	        			centsSeparator: '.',
	        			thousandsSeparator: ','
	        			});



	        			$(function() {


	        				setInterval(function() {

	        					var debit_balance = 0;
	        					$('#panel-form-jurnaldetail tbody .master_journal_detail_debit').each(function() {
	        						var amount = parseFloat($(this).text().replace(/\,/g,'') || 0);
	        						if (isNaN(amount)) amount = 0;
	        						debit_balance += amount;

	        						})



	        						$('#debit_balance').val(debit_balance.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
	        						},500  )
	        						})



	        						$(function() {


	        							setInterval(function() {

	        								var kredit_balance = 0;
	        								$('#panel-form-jurnaldetail tbody .master_journal_detail_kredit').each(function() {
	        									var amount = parseFloat($(this).text().replace(/\,/g,'') || 0);
	        									if (isNaN(amount)) amount = 0;
	        									kredit_balance += amount;

	        									})



	        									$('#kredit_balance').val(kredit_balance.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
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
	    	$date = Carbon::now()->format('Y-m-d');
	    	// $query->whereDate('master_journal_detail.created_at','LIKE',$date)->whereNotNull('master_journal.master_journal_id');
	    	// $query->orderBy('master_journal_detail.master_journal_detail_coa_code','ASC')->whereNotNull('master_journal.master_journal_id');

	    	$query->whereNotNull('ref_number');
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
	    		// $postdata['previous_balance'] = $previous_balance->previous_balance;

	    	// $date_code = Carbon::now()->format('Ymd');
	    	// $select_code = DB::table('master_journal')->select('ref_code')->orderBy('created_at','desc')->first();
	    	// $max_code = isset($select_code->ref_code) ? $select_code->ref_code : 00000;
	    	// $data = [];

	    	// if ($max_code > 9998) {

	    	// 	CRUDBooster::redirect(CRUDBooster::mainpath(""),"Maaf Jumlah Product Category Sudah Maksimal");


	    	// } else {

	    	// 	$next_code = $max_code + 1;

	    	// }


	    	// $postdata['ref_number'] = 'REF/'.$date_code.'/'.str_pad($next_code,5,'0',STR_PAD_LEFT);
	    	// $postdata['ref_code'] = str_pad($next_code,5,'0',STR_PAD_LEFT);


	    	$postdata['debit_balance'] = str_replace(',', '', $postdata['debit_balance']);
	    	$postdata['kredit_balance'] = str_replace(',', '', $postdata['kredit_balance']);

	    	// $postdata['debit_balance'] = str_replace('.', '.', $postdata['debit_balance']);
	    	// $postdata['kredit_balance'] = str_replace('.', '.', $postdata['kredit_balance']);




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
	    	$postdata['debit_balance'] = str_replace(',', '', $postdata['debit_balance']);
	    	$postdata['kredit_balance'] = str_replace(',', '', $postdata['kredit_balance']);
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

	        // dd(is_array($id));

	    	if(is_array($id) == 1) {

	    		foreach ($id as $id_selected) {
	    			DB::table('master_journal_detail')->where('master_journal_id',$id_selected)->delete();
	    		}


	    	} else {

	    		DB::table('master_journal_detail')->where('master_journal_id',$id)->delete();
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


	}
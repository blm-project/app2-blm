<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\CoaDetail;
use App\CoaThird;
use App\CoaJournal;
use PDF;

class AdminNeracaLajurController extends \crocodicstudio\crudbooster\controllers\CBController {

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
	        $this->script_js = "

	        $(function() {


	        	setInterval(function() {

	        		var debit_balance = 0;
	        		$('#panel-form-jurnaldetail tbody .master_journal_detail_debit').each(function() {
	        			var amount = parseInt($(this).text());
	        			if (isNaN(amount)) amount = 0;
	        			debit_balance += amount;

	        			})

	        			

	        			$('#debit_balance').val(debit_balance)
	        			},500  )
	        			})



	        			$(function() {


	        				setInterval(function() {

	        					var kredit_balance = 0;
	        					$('#panel-form-jurnaldetail tbody .master_journal_detail_kredit').each(function() {
	        						var amount = parseInt($(this).text());
	        						if (isNaN(amount)) amount = 0;
	        						kredit_balance += amount;

	        						})

	        						

	        						$('#kredit_balance').val(kredit_balance)
	        						},500  )
	        						})



	        						$(document).ready(function(){             

	        							$('.date1').datepicker({
	        								format: 'yyyy-mm-dd',
	        								autoclose: true,
	        								}).on('changeDate', function (selected) {
	        									var startDate = new Date(selected.date.valueOf());
	        									$('.date2').datepicker('setStartDate', startDate);
	        									}).on('clearDate', function (selected) {
	        										$('.date2').datepicker('setStartDate', null);
	        										});
	        										$('.date1').datepicker('update', new Date());

	        										$('.date2').datepicker({
	        											format: 'yyyy-mm-dd',
	        											autoclose: true,
	        											}).on('changeDate', function (selected) {
	        												var endDate = new Date(selected.date.valueOf());
	        												$('.date1').datepicker('setEndDate', endDate);
	        												}).on('clearDate', function (selected) {
	        													$('.date1').datepicker('setEndDate', null);
	        													});
	        													$('.date2').datepicker('update', new Date());

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
	    	$data['page_title'] = 'Neraca Lajur';

	    	$data['result'] = DB::table('master_coa_detail')
	    	->select('*')
	    	->orderBy('master_coa_detail_name','ASC')
	    	->get();


   //Create a view. Please use `cbView` method instead of view method from laravel.
	    	$this->cbView('fa_report.neraca_lajur_index',$data);
	    }


	    public function ExportNeraca(Request $request) {

	    	if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

	    	
	    	$data = [];

	    	setlocale(LC_TIME, 'id_ID.UTF-8');
	    	$month = Input::get('month');
	    	$year = Input::get('year');
	    	$data['month'] = Input::get('month');
	    	$data['year']= Input::get('year');
	    	// $data['curr_date'] = Carbon::now()->format('Y-m');
	    	$data['selected_date'] = $year."-".$month;
	    	$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    	$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    	$coa_id = Input::get('coa_id');

	    	$data['page_title'] = 'Neraca Lajur';


	    	// $data['result'] = DB::table('master_journal_detail')
      //         			->join('master_coa_detail', 'master_journal_detail.master_coa_detail_id', '=', 'master_coa_detail.id')
      //         			->join('master_coa', 'master_coa_detail.master_coa_id', '=', 'master_coa.id')
      //           		->select('master_journal_detail.*', 'master_coa_detail.*','master_coa.*','master_journal_detail.created_at AS master_journal_detail_date', 'master_coa.id as id_coa')
      //           		->where('master_journal_detail.master_coa_detail_id',$coa_id)
      //       			->whereMonth('master_journal_detail.created_at', $month)
      //       			->whereYear('master_journal_detail.created_at', $year)
      //       			->groupBy('master_journal_detail.master_journal_detail_coa_name')
      //       			->orderBy('master_journal_detail.id','DESC')
      //       			->get();

	    	$data['coa_name'] =DB::table('master_coa_detail')
	    	->select('master_coa_detail_name')
	    	->where('id',$coa_id)
	    	->first();


	    	// AKTIvA LANCAR
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['aktiva'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])
	    	->where('master_coa_id',1)	    
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	// AKTIVA TETAP
	    	// DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	// $data['aktiva_tetap'] = DB::table('fix_asset_detail')
	    	// ->join('master_category_asset','fix_asset_detail.asset_category_id','=','master_category_asset.id')
	    	// ->select('fix_asset_detail.*','master_category_asset.category_name AS asset_category',
	    	// 	DB::raw('(SUM(asset_price)) AS asset_price_total'),
	    	// 	DB::raw('(SUM(akumulasi_penyusutan)) AS akumulasi_penyusutan_total'),
	    	// 	DB::raw('(SUM(harga_buku)) AS harga_buku_total'))
	    	// ->whereMonth('fix_asset_detail.created_at', $month)
	    	// ->whereYear('fix_asset_detail.created_at', $year)
	    	// ->groupBy('fix_asset_detail.asset_category_id')
	    	// ->orderBy('fix_asset_detail.asset_name','ASC')
	    	// ->get();



	    	// HUTANG
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['hutang'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	// MODAL
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['modal'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',3)
	    	->where('master_coa_detail_name','!=','OPENING BALANCE EQUITY')
	    	->where('master_coa_detail_name','!=','RETAINED EARNINGS')
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	//PENDAPATAN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['pendapatan_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',4)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['pendapatan_query'] as $p_q){
	    		foreach($p_q->coajournal as $sub_p_q){
	    			$data['pendapatan'] = $total += $sub_p_q->balance;
	    		}
	    	}



	    	//OP PENDAPATAN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_pendapatan_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',4)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_pendapatan_query'] as $op_p_q){
	    		foreach($op_p_q->coajournal as $op_sub_p_q){
	    			$data['op_pendapatan'] = $total += $op_sub_p_q->balance;
	    		}
	    	}


	    	//STOCK
	    	// DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	// $data['stock_on_hand_awal'] = DB::table('stock_card')
	    	// ->join('master_product_item','master_product_item.product_item_id','stock_card.product_code')
	    	// ->select('stock_card.*','master_product_item.*','stock_card.created_at AS stock_card_date',
	    	// 	DB::raw('SUM(stock_card.stock_in) AS stock_in'),
	    	// 	DB::raw('SUM(stock_card.stock_out) AS stock_out'),
	    	// 	DB::raw('(SELECT SUM(stock_card.stock_in) - SUM(stock_card.stock_out) FROM stock_card WHERE MONTH(created_at) = '.$previous_month.' OR YEAR(created_at) = '.$previous_year.') as stock_onhand_awal'))
	    	// ->whereMonth('stock_card.created_at',$month)
	    	// ->whereYear('stock_card.created_at',$year)
	    	// ->groupBy('stock_card.product_code')
	    	// ->first();

	    	// $data['price_awal'] = DB::table('purchase_order_detail')
	    	// ->select('*')
	    	// ->whereMonth('created_at',$previous_month)
	    	// ->orwhereYear('created_at',$previous_year)
	    	// ->sum('price_unit');


	    	// $data['stock_on_hand_akhir'] = DB::table('stock_card')
	    	// ->join('master_product_item','master_product_item.product_item_id','stock_card.product_code')
	    	// ->select('stock_card.*','master_product_item.*','stock_card.created_at AS stock_card_date',
	    	// 	DB::raw('SUM(stock_card.stock_in) AS stock_in'),
	    	// 	DB::raw('SUM(stock_card.stock_out) AS stock_out'),
	    	// 	DB::raw('(SELECT SUM(stock_card.stock_in) - SUM(stock_card.stock_out) FROM stock_card WHERE MONTH(created_at) = '.$month.' OR YEAR(created_at) = '.$year.') as stock_onhand_akhir'))
	    	// ->whereMonth('stock_card.created_at',$month)
	    	// ->whereYear('stock_card.created_at',$year)
	    	// ->groupBy('stock_card.product_code')
	    	// ->first();

	    	// $data['price_akhir'] = DB::table('purchase_order_detail')
	    	// ->select('*')
	    	// ->whereMonth('created_at',$month)
	    	// ->orwhereYear('created_at',$year)
	    	// ->sum('price_unit');	



	    	// BEBAN BIAYA
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['bebanbiaya_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',6)
	    	->orWhere('master_coa_id',7)
	    	->orWhere('master_coa_id',8)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	foreach($data['bebanbiaya_query'] as $bb_q){
	    		foreach($bb_q->coajournal as $sub_bb_q){
	    			$data['bebanbiaya'] = $total += $sub_bb_q->balance;
	    		}
	    	}




	    	// OP BEBAN BIAYA
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_bebanbiaya_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',6)
	    	->orWhere('master_coa_id',7)
	    	->orWhere('master_coa_id',8)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	foreach($data['op_bebanbiaya_query'] as $op_bb_q){
	    		foreach($op_bb_q->coajournal as $op_sub_bb_q){
	    			$data['op_bebanbiaya'] = $total += $op_sub_bb_q->balance;
	    		}
	    	}




	    	// PENDAPATAN LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['pendapatan_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',1)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['pendapatan_lain_query'] as $pl_q){
	    		foreach($pl_q->coajournal as $sub_pl_q){
	    			$data['pendapatan_lain'] = $total += $sub_pl_q->balance;
	    		}
	    	}




	    	// OP PENDAPATAN LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_pendapatan_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',1)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_pendapatan_lain_query'] as $op_pl_q){
	    		foreach($op_pl_q->coajournal as $op_sub_pl_q){
	    			$data['op_pendapatan_lain'] = $total += $op_sub_pl_q->balance;
	    		}
	    	}
	    	



	    	// BIAYA LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['biaya_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['biaya_lain_query'] as $bl_q){
	    		foreach($bl_q->coajournal as $sub_bl_q){
	    			$data['biaya_lain'] = $total += $sub_bl_q->balance;
	    		}
	    	}





	    	// OP BIAYA LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_biaya_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_biaya_lain_query'] as $op_bl_q){
	    		foreach($op_bl_q->coajournal as $op_sub_bl_q){
	    			$data['op_biaya_lain'] = $total += $op_sub_bl_q->balance;
	    		}
	    	}



	    	// AKTIVA TETAP LABA RUGI
	    	// $data['aktiva_tetap_labarugi_query'] = DB::table('fix_asset_detail')
	    	// ->join('master_category_asset','fix_asset_detail.asset_category_id','=','master_category_asset.id')
	    	// ->select('fix_asset_detail.*','master_category_asset.category_name AS asset_category',
	    	// 	DB::raw('(SUM(penyusutan)) AS penyusutan_total'))
	    	// ->whereMonth('fix_asset_detail.created_at', $month)
	    	// ->whereYear('fix_asset_detail.created_at', $year)
	    	// ->groupBy('fix_asset_detail.asset_category_id')
	    	// ->orderBy('fix_asset_detail.asset_name','ASC')
	    	// ->get();

	    	// foreach ($data['aktiva_tetap_labarugi_query'] as $atl_q) {
	    	// 	$data['aktiva_tetap_labarugi'] = $total += $atl_q->penyusutan_total;
      //       	// return $data['bebanbiaya'];
	    	// }



	    	// if ($data['aktiva']->isEmpty() OR $data['hutang']->isEmpty() OR $data['modal']->isEmpty()) {
	    	// 	Session::flash('message', "Maaf Data Tidak Tersedia");
	    	// 	return Redirect::to('admin/neraca_lajur');
	    	// }



	    	$this->cbView('fa_report.neraca_lajur_export',$data);



	    }


	    //Generate PDF
	    public function generatePDF(Request $request)

	    {


	    	$data = [];
	    	$data['page_title'] = 'Detail Data';


	    	setlocale(LC_TIME, 'id_ID.UTF-8');
	    	$month = Input::get('month');
	    	$year = Input::get('year');
	    	// $data['curr_date'] = Carbon::now()->format('Y-m');
	    	$data['selected_date'] = $year."-".$month;
	    	$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    	$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    	$coa_id = Input::get('coa_id');

	    	$data['page_title'] = 'Neraca Lajur';


	    	// $data['result'] = DB::table('master_journal_detail')
      //         			->join('master_coa_detail', 'master_journal_detail.master_coa_detail_id', '=', 'master_coa_detail.id')
      //         			->join('master_coa', 'master_coa_detail.master_coa_id', '=', 'master_coa.id')
      //           		->select('master_journal_detail.*', 'master_coa_detail.*','master_coa.*','master_journal_detail.created_at AS master_journal_detail_date', 'master_coa.id as id_coa')
      //           		->where('master_journal_detail.master_coa_detail_id',$coa_id)
      //       			->whereMonth('master_journal_detail.created_at', $month)
      //       			->whereYear('master_journal_detail.created_at', $year)
      //       			->groupBy('master_journal_detail.master_journal_detail_coa_name')
      //       			->orderBy('master_journal_detail.id','DESC')
      //       			->get();

	    	$data['coa_name'] =DB::table('master_coa_detail')
	    	->select('master_coa_detail_name')
	    	->where('id',$coa_id)
	    	->first();


	    	// AKTIvA LANCAR
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['aktiva'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])
	    	->where('master_coa_id',1)	    
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	// AKTIVA TETAP
	    	// DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	// $data['aktiva_tetap'] = DB::table('fix_asset_detail')
	    	// ->join('master_category_asset','fix_asset_detail.asset_category_id','=','master_category_asset.id')
	    	// ->select('fix_asset_detail.*','master_category_asset.category_name AS asset_category',
	    	// 	DB::raw('(SUM(asset_price)) AS asset_price_total'),
	    	// 	DB::raw('(SUM(akumulasi_penyusutan)) AS akumulasi_penyusutan_total'),
	    	// 	DB::raw('(SUM(harga_buku)) AS harga_buku_total'))
	    	// ->whereMonth('fix_asset_detail.created_at', $month)
	    	// ->whereYear('fix_asset_detail.created_at', $year)
	    	// ->groupBy('fix_asset_detail.asset_category_id')
	    	// ->orderBy('fix_asset_detail.asset_name','ASC')
	    	// ->get();



	    	// HUTANG
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['hutang'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	// MODAL
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['modal'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',3)
	    	->where('master_coa_detail_name','!=','OPENING BALANCE EQUITY')
	    	->where('master_coa_detail_name','!=','RETAINED EARNINGS')
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	//PENDAPATAN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['pendapatan_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',4)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['pendapatan_query'] as $p_q){
	    		foreach($p_q->coajournal as $sub_p_q){
	    			$data['pendapatan'] = $total += $sub_p_q->balance;
	    		}
	    	}



	    	//OP PENDAPATAN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_pendapatan_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',4)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_pendapatan_query'] as $op_p_q){
	    		foreach($op_p_q->coajournal as $op_sub_p_q){
	    			$data['op_pendapatan'] = $total += $op_sub_p_q->balance;
	    		}
	    	}


	    	//STOCK
	    	// DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	// $data['stock_on_hand_awal'] = DB::table('stock_card')
	    	// ->join('master_product_item','master_product_item.product_item_id','stock_card.product_code')
	    	// ->select('stock_card.*','master_product_item.*','stock_card.created_at AS stock_card_date',
	    	// 	DB::raw('SUM(stock_card.stock_in) AS stock_in'),
	    	// 	DB::raw('SUM(stock_card.stock_out) AS stock_out'),
	    	// 	DB::raw('(SELECT SUM(stock_card.stock_in) - SUM(stock_card.stock_out) FROM stock_card WHERE MONTH(created_at) = '.$previous_month.' OR YEAR(created_at) = '.$previous_year.') as stock_onhand_awal'))
	    	// ->whereMonth('stock_card.created_at',$month)
	    	// ->whereYear('stock_card.created_at',$year)
	    	// ->groupBy('stock_card.product_code')
	    	// ->first();

	    	// $data['price_awal'] = DB::table('purchase_order_detail')
	    	// ->select('*')
	    	// ->whereMonth('created_at',$previous_month)
	    	// ->orwhereYear('created_at',$previous_year)
	    	// ->sum('price_unit');


	    	// $data['stock_on_hand_akhir'] = DB::table('stock_card')
	    	// ->join('master_product_item','master_product_item.product_item_id','stock_card.product_code')
	    	// ->select('stock_card.*','master_product_item.*','stock_card.created_at AS stock_card_date',
	    	// 	DB::raw('SUM(stock_card.stock_in) AS stock_in'),
	    	// 	DB::raw('SUM(stock_card.stock_out) AS stock_out'),
	    	// 	DB::raw('(SELECT SUM(stock_card.stock_in) - SUM(stock_card.stock_out) FROM stock_card WHERE MONTH(created_at) = '.$month.' OR YEAR(created_at) = '.$year.') as stock_onhand_akhir'))
	    	// ->whereMonth('stock_card.created_at',$month)
	    	// ->whereYear('stock_card.created_at',$year)
	    	// ->groupBy('stock_card.product_code')
	    	// ->first();

	    	// $data['price_akhir'] = DB::table('purchase_order_detail')
	    	// ->select('*')
	    	// ->whereMonth('created_at',$month)
	    	// ->orwhereYear('created_at',$year)
	    	// ->sum('price_unit');	



	    	// BEBAN BIAYA
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['bebanbiaya_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',6)
	    	->orWhere('master_coa_id',7)
	    	->orWhere('master_coa_id',8)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	foreach($data['bebanbiaya_query'] as $bb_q){
	    		foreach($bb_q->coajournal as $sub_bb_q){
	    			$data['bebanbiaya'] = $total += $sub_bb_q->balance;
	    		}
	    	}




	    	// OP BEBAN BIAYA
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_bebanbiaya_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',6)
	    	->orWhere('master_coa_id',7)
	    	->orWhere('master_coa_id',8)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();


	    	foreach($data['op_bebanbiaya_query'] as $op_bb_q){
	    		foreach($op_bb_q->coajournal as $op_sub_bb_q){
	    			$data['op_bebanbiaya'] = $total += $op_sub_bb_q->balance;
	    		}
	    	}




	    	// PENDAPATAN LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['pendapatan_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',1)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['pendapatan_lain_query'] as $pl_q){
	    		foreach($pl_q->coajournal as $sub_pl_q){
	    			$data['pendapatan_lain'] = $total += $sub_pl_q->balance;
	    		}
	    	}




	    	// OP PENDAPATAN LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_pendapatan_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable + (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=',$month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',1)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_pendapatan_lain_query'] as $op_pl_q){
	    		foreach($op_pl_q->coajournal as $op_sub_pl_q){
	    			$data['op_pendapatan_lain'] = $total += $op_sub_pl_q->balance;
	    		}
	    	}
	    	



	    	// BIAYA LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['biaya_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['biaya_lain_query'] as $bl_q){
	    		foreach($bl_q->coajournal as $sub_bl_q){
	    			$data['biaya_lain'] = $total += $sub_bl_q->balance;
	    		}
	    	}





	    	// OP BIAYA LAIN
	    	DB::statement(DB::raw('SET @variable = 0')); $total = 0;
	    	$data['op_biaya_lain_query'] = CoaDetail::with([
	    		'coathird' => function ($query){
	    			$query->select('*');
	    		},
	    		'coajournal' => function ($query) use ($ProviderName) {
	    			$month = Input::get('month');
	    			$year = Input::get('year');
	    			$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    			$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');
	    			$query->select('*',
	    				DB::raw('@variable := @variable - (SUM(master_journal_detail_kredit) - SUM(master_journal_detail_debit)) AS balance'))
	    			->groupBy('master_journal_detail_coa_name')
	    			->whereMonth('created_at','!=', $month)
	    			->orWhereMonth('created_at', $previous_month)
	    			->whereYear('created_at', $year)
	    			->orWhereYear('created_at', $previous_year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();

	    	foreach($data['op_biaya_lain_query'] as $op_bl_q){
	    		foreach($op_bl_q->coajournal as $op_sub_bl_q){
	    			$data['op_biaya_lain'] = $total += $op_sub_bl_q->balance;
	    		}
	    	}

	    	$pdf = PDF::loadView('fa_report.neraca_lajur_export_pdf', $data);

	    	// return $pdf->download('laporan-pdf.pdf');
	    	return $pdf->stream();
	    }





	}
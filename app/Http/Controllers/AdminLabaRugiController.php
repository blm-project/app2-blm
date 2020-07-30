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

class AdminLabarugiController extends \crocodicstudio\crudbooster\controllers\CBController {

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
	    	$data['page_title'] = 'Laba Rugi';

	    	$data['result'] = DB::table('master_journal_detail')		
	    	->join('master_coa_detail', 'master_journal_detail.master_coa_detail_id', '=', 'master_coa_detail.id')
	    	->join('master_coa', 'master_coa_detail.master_coa_id', '=', 'master_coa.id')
	    	->select('master_journal_detail.*', 'master_coa_detail.*','master_coa.*','master_journal_detail.created_at AS master_journal_detail_date')
	    	->orderBy('master_journal_detail.id','ASC')
	    	->get();


   //Create a view. Please use `cbView` method instead of view method from laravel.
	    	$this->cbView('fa_report.laba_rugi_index',$data);
	    }


	    public function ExportLabarugi(Request $request) {

	    	if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

	    	setlocale(LC_TIME, 'id_ID.UTF-8');
	    	$month = Input::get('month');
	    	$year = Input::get('year');

	    	$previous_month = Carbon::createFromFormat('m', $month )->addMonth(-1)->format('m');	
	    	$previous_year = Carbon::createFromFormat('Y', $year )->addYear(-1)->format('Y');	

	    	$coa_name = Input::get('coa_name');


	    	$data = [];
	    	$data['page_title'] = 'Laba Rugi';


	    	//PENDAPATAN
	    	DB::statement(DB::raw('SET @variable = 0'));
	    	$data['pendapatan'] = CoaDetail::with([
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
	    			->whereYear('created_at', $year);
	    		},
	    	])	
	    	->where('master_coa_id',4)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	// PEMBELIAN
	    	DB::statement(DB::raw('SET @variable = 0'));
	    	$data['pembelian'] = CoaDetail::with([
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
	    			->whereYear('created_at', $year);
	    		},
	    	])	
	    	->where('master_coa_id',5)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



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


           //BEBAN BIAYA
	    	DB::statement(DB::raw('SET @variable = 0'));
	    	$data['bebanbiaya'] = CoaDetail::with([
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
	    			->whereYear('created_at', $year);
	    		},
	    	])	
	    	->where('master_coa_id',6)
	    	->orWhere('master_coa_id',7)
	    	->orWhere('master_coa_id',8)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	//PENDAPATAN LAIN
	    	DB::statement(DB::raw('SET @variable = 0'));
	    	$data['pendapatan_lain'] = CoaDetail::with([
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
	    			->whereYear('created_at', $year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',1)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	// BIAYA LAIN
	    	DB::statement(DB::raw('SET @variable = 0'));
	    	$data['biaya_lain'] = CoaDetail::with([
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
	    			->whereYear('created_at', $year);
	    		},
	    	])	
	    	->where('master_coa_id',9)
	    	->where('master_coa_detail_code',2)
	    	->orderBy('master_coa_detail_code','ASC')
	    	->get();



	    	//AKTIVA TETAP DETAIL
	    	// $data['aktiva_tetap'] = DB::table('fix_asset_detail')
	    	// ->join('master_category_asset','fix_asset_detail.asset_category_id','=','master_category_asset.id')
	    	// ->select('fix_asset_detail.*','master_category_asset.category_name AS asset_category',
	    	// 	DB::raw('(SUM(penyusutan)) AS penyusutan_total'))
	    	// ->whereMonth('fix_asset_detail.created_at', $month)
	    	// ->whereYear('fix_asset_detail.created_at', $year)
	    	// ->groupBy('fix_asset_detail.asset_category_id')
	    	// ->orderBy('fix_asset_detail.asset_name','ASC')
	    	// ->get();


    //       if ($data['penjualan']->isEmpty()) {
    // 			Session::flash('message', "Maaf Data Tidak Tersedia");
				// return Redirect::to('admin/master_buku_besar');
    // 		}


	    	$this->cbView('fa_report.laba_rugi_export',$data);



	    }


	}
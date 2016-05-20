@extends('layouts.page')

@section('other_styles_1')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('styles/util.css') }}">
@endsection

@section('left_add_space')

@endsection

@section('right_add_space')

@endsection


@section('main_content')
<div style="height:100%; width:100%;">

<div class="small_header dark_grey" >
	<label style="margin-left: 1vw;" >Books</label>
</div>

<form id="book_filter_form" action="/books" method="post" >
	<input id="category" name="category" value="{{$category}}" hidden>
	<input id="price_range" name="price_range" value="{{$price_range}}" hidden>
	<input id="sell_type" name="sell_type" value="{{$sell_type}}" hidden>
	<input id="lang" name="lang" value="{{$lang}}" hidden>
	<input id="print_type" name="print_type" value="{{$print_type}}" hidden>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">


<script type="text/javascript">
	function filter_books(cat,price,sell,lang,print)
	{
		if(cat.localeCompare("-")!=0) document.getElementById("category").value=cat;
		if(price.localeCompare("-")!=0) document.getElementById("price_range").value=price;
		if(sell.localeCompare("-")!=0) document.getElementById("sell_type").value=sell;
		if(lang.localeCompare("-")!=0) document.getElementById("lang").value=lang;
		if(print.localeCompare("-")!=0) document.getElementById("print_type").value=print;

		document.getElementById("book_filter_form").submit();
	}
</script>

<div class="small_options_bar dark_grey">
	<select name="category" class="small_options_btn" 
		oninput="filter_books(this.value,'-','-','-','-')">
		<option class="small_dropdown_option"selected disabled hidden>Categories</option>
		<option class="small_dropdown_option" value="all">All</option>
	  	<option class="small_dropdown_option" value="novel">Novels</option>
	  	<option class="small_dropdown_option" value="poetry">Poetry</option>
	  	<option class="small_dropdown_option" value="story">Story Books</option>
	  	<option class="small_dropdown_option" value="comic">Comics</option>
	</select>
	<select name="price_range" class="small_options_btn"
	oninput="filter_books('-',this.value,'-','-','-')">
		<option class="small_dropdown_option"selected disabled hidden>Price range</option>
		<option class="small_dropdown_option" value="all"> All prices</option>
		<option class="small_dropdown_option" value="pr_1"> &lt;250 </option>
	  	<option class="small_dropdown_option" value="pr_2">250-500</option>
	  	<option class="small_dropdown_option" value="pr_3">501-1000</option>
	  	<option class="small_dropdown_option" value="pr_4">1001-2000</option>
	</select>
	<select name="sell_type" class="small_options_btn"
	oninput="filter_books('-','-',this.value,'-','-')">
		<option class="small_dropdown_option"selected disabled hidden>Sell type</option>
		<option class="small_dropdown_option" value="all">All</option>
		<option class="small_dropdown_option" value="direct">Direct</option>
	  	<option class="small_dropdown_option" value="auction">Auction</option>
	</select>
	<select name="lang" class="small_options_btn"
	oninput="filter_books('-','-','-',this.value,'-')">
		<option class="small_dropdown_option"selected disabled hidden>Language</option>
		<option class="small_dropdown_option" value="all">All</option>
		<option class="small_dropdown_option" value="bangla">Bangla</option>
	  	<option class="small_dropdown_option" value="english">English</option>
	</select>
	<select name="print_type" class="small_options_btn"
	oninput="filter_books('-','-','-','-',this.value)">
		<option class="small_dropdown_option"selected disabled hidden>Print Type</option>
		<option class="small_dropdown_option" value="all">All</option>
		<option class="small_dropdown_option" value="original">Original</option>
		<option class="small_dropdown_option" value="printed copy">Printed Copy</option>
	  	<option class="small_dropdown_option" value="photocopy">Photocopy</option>
	</select>
</div>

<?php
	$all_books = App\Books::all();
?>
<div style="box-shadow: 0 0 15px 1px #d6d6d6;min-height:100vw;"> 

<!-- 
	search bar 
-->
<div style="width:100%;height:3vw;margin-bottom: 10px;">
	
	<input type="book_search_bar" name="book_search_bar" style="margin: 5px 5px 0 0 ;
	float:right;width:15vw;height:2.5vw;
	border: 1px #86abc8 solid;
	border-radius: 3px;" />

	<img style="margin: 5px 5px 0 0;float:right;width:2.3vw;height:2.3vw;"
		src="{{URL::asset('images/searchicon.png')}}" 
	/>

</div>



<!-- 
adding all books from database 
-->
<?php
	foreach ($all_books as $book) {
		$img_src= "/images/bookpics/".$book->id.".jpg";

		//filter here by comparing the filter values
		if( strcmp(strtolower($category), "all")!= 0 
			&& strcmp(strtolower($category), strtolower($book->category))!= 0) continue;

		if( strcmp(strtolower($sell_type), "all")!= 0 
			&& strcmp(strtolower($sell_type), strtolower($book->sell_type))!= 0) continue;

		if( strcmp(strtolower($lang), "all")!= 0 
			&& strcmp(strtolower($lang), strtolower($book->language))!= 0) continue;

		if( strcmp(strtolower($print_type), "all")!= 0 
			&& strcmp(strtolower($print_type), strtolower($book->print))!= 0) continue;
		if( strcmp(strtolower($price_range), "all") != 0)
		{
			if(strcmp($price_range, "pr_1")===0 && $book->price >= 250) continue;
			else if(strcmp($price_range, "pr_2")===0 && 
				($book->price < 250 || $book->price>500)
				) continue;
			else if(strcmp($price_range, "pr_3")===0 && 
				($book->price < 501 || $book->price>1000)
				) continue;
			else if(strcmp($price_range, "pr_4")===0 && 
				($book->price < 1001)
				) continue;
		}
		// endfilter

		?>
	<div class="small_book_view">
		<div style="width: 32%;height:100%;background-color: white;float: left;">
			<img style="border:none;width:100%;height:100%;" 
			src="{{URL::asset($img_src)}}" 
			/>	
		
		</div>
		<div style="width: 66%;height:100%;margin-left:2%;float: right;">
			
			<table style="width:100%;height:100%;">
				<tr><td style="font-weight: bold;">{{$book->name}}</td></tr>
				<tr><td>Author: {{$book->author}}</td></tr>
				<tr><td>Print: {{$book->print}}</td></tr>
				<tr><td>Price: {{$book->price}}</td></tr>
				<tr><td> <button >Add to cart</button> </td></tr>
			</table>
			
		</div>
	</div>
		<?php
	}
?>
	


</div>
</form>
</div>
@endsection


@section('footer')
f
@endsection
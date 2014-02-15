<?php

/*
Plugin Name: Webmaster.Net Post Quality Analyzer
Plugin URI: http://triagis.com 
Description: Liteweight backend solution to quickly analyze the quality of your Wordpress posts 
Version: 1.04 
Author: Webmaster.Net 
Author URI: http://webmaster.net
Author Email: contact@webmaster.net
*/



		

$order = @$_GET['order'];

$sort = @$_GET['sort'];

if ($sort == 'asc')

	{

		$sortlnk = 'desc';

	}else{

		$sortlnk = 'asc';

		}

		

$date_class = 'date';

$count_class = 'count';

$cimg_class = 'cimg';

$head_class = 'head';

$para_class = 'para';

$count_sort = 'asc';

$cimg_sort = 'asc';

$head_sort = 'asc';

$para_sort = 'asc';

$date_sort = 'asc';



switch($order)

{

	case 'word_count':

	$count_class = 'count_'.$_GET['sort'];

	$count_sort = $sortlnk;

	break;

	

	case 'no_images':

	$cimg_class = 'cimg_'.$_GET['sort'];

	$cimg_sort = $sortlnk;

	break;

	

	case 'headlines':

	$head_class = 'head_'.$_GET['sort'];

	$head_sort = $sortlnk;

	

	break;

	

	case 'paragraph':

	$para_class = 'para_'.$_GET['sort'];

	$para_sort = $sortlnk;

	break;

	

	case 'date_updated':

		$date_class = 'date_'.$_GET['sort'];

		$date_sort = $sortlnk;

	break;

	

	default:

		$sort = 'asc';

		$order = 'pa_id';

	break;

	}

	

	$arr_word = unserialize(get_option('post_analyzer_word'));

	$arr_img = unserialize(get_option('post_analyzer_img'));

	$arr_head = unserialize(get_option('post_analyzer_head'));

	$arr_para = unserialize(get_option('post_analyzer_para'));

	$arr_date = unserialize(get_option('post_analyzer_date'));

	



	

	

		global $wpdb;

		$paged = (@$_REQUEST['paged']) ? @$_REQUEST['paged'] : 1;

		$query ="select * from ".$wpdb->prefix."post_analyzer order by ".$order." ".$sort;

		  		  

		$total = $wpdb->get_var( "SELECT COUNT(1) FROM (${query}) AS combined_table" );

		$items_per_page = 20;

		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;

		$offset = ( $page * $items_per_page ) - $items_per_page;

		  

		$pageposts =$wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );

		

if (isset($_POST['g_csv']) && $_POST['g_csv']=="g_csv")

{

	$csv_data = $wpdb->get_results( $query );

	$CSV_string = array ("Post ID", "Post Name", "Word Count", "Images" , "Headlines" , "Paragraphs", "Freshness", "link");
	$csv_name = date('Y-m-d'); //Make a random int number between 1 to 50.

	$file = WP_PLUGIN_DIR."/post-analyzer/csv/".$csv_name.".csv"; //For avoiding cache in the client and on the server

	$fh = fopen($file, 'w');
	fputcsv($fh, $CSV_string);
	foreach ($csv_data as $key=>$post){
		if ($post->date_updated >= $arr_date['min_value'] &&  $post->date_updated <= $arr_date['middle_value']){
			$date = "New";
		}elseif ($post->date_updated > $arr_date['middle_value'] && $post->date_updated < $arr_date['max_value']){
			$date = "middle";
		}elseif ($post->date_updated > $arr_date['max_value']){
			$date = "outdated";
		}
		//$CSV_string_0 = ;	
			fputcsv($fh, array($post->post_id,get_the_title($post->post_id), $post->word_count, $post->no_images, $post->headlines,$post->paragraph,$date,get_permalink( $post->post_id )));
		}

		
	

	//fputcsv($fh , $CSV_string , ","  , "\n" );

	fclose($fh);

		

	//savecsv($CSV_string);

	

	

	

	}





	?> 

<link href="<?php echo plugins_url( 'css/mystyle.css' , dirname(__FILE__) )?>" type="text/css">

<style>

.pagination {

clear:both;

padding:20px 0;

position:relative;

font-size:11px;

line-height:13px;

}

 

.pagination span, .pagination a {

display:block;

float:left;

margin: 2px 2px 2px 0;

padding:6px 9px 5px 9px;

text-decoration:none;

width:auto;

color:#fff;

background: #555;

}

 

.pagination a:hover{

color:#fff;

background: #3279BB;

}

 

.pagination .current{

padding:6px 9px 5px 9px;

background: #3279BB;

color:#fff;

}



.check-column { padding:10px 5px !important;}

.DataTables_sort_icon { background:url("<? echo plugins_url()?>/post-analyzer/images/ui-icons_888888_256x240.png");  float:right; height:16px; width:18px; margin-right:10px;}

.analyzer_posts{border-collapse:collapse; color:#000 !important}

.analyzer_posts th { border:1px solid #ccc;}



.analyzer_posts td { border:1px solid #ccc; padding:10px;  color:#000 !important}



.date, .count, .cimg, .head, .para {background-position:-128px 0;}



.date_asc, .count_asc, .cimg_asc, .head_asc, .para_asc{background-position:-64px -16px}

.date_desc, .count_desc, .cimg_desc, .head_desc, .para_desc{background-position:-0px -16px}

.pagging  { margin:10px 0 0px 0; float:left;}

.pagging .page-numbers { padding:5px 8px; border:1px solid #21759B; border-radius:15px; text-decoration:none; background:linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;}

#cb { width:80px;}

</style>



<div class='wrap' id="wrap-statigram">

<div id="icon-themes" class="icon32"><br>

</div>

<h2>Post Review</h2>

<br>

<div class="widget-liquid-left">

  <div style="display:none; text-align:left; padding-left:20px;" id="debug_message" class="update-nag"></div>

  <div class="wrap">

  <div style="margin:0 0 20px 0; float:right;">

  <form method="post" action="" id="csv_frm" style="float:right">

  <input type="hidden" value="g_csv" name="g_csv" />

  	<input type="button" name="csv_btn" id="csv_btn" style="float:right; font-weight:bold;" value="Generate csv" class="button-primary" /> 

  </form>

  <input type="button" name="submit" id="img-snaper-btn" style="float:right; font-weight:bold; margin:0 10px;" class="button-primary" value="Analyze Posts">

  <span id="img-snaper-loader" style="display:none; float:right;"><img src="<?php echo plugin_dir_url(__FILE__)?>ajax-loader.gif" /></span>

  <span id="post-res"></span>

  </div>

<div class="pagging">

	<?php 

	

		echo paginate_links( array(

    'base' => add_query_arg( 'cpage', '%#%' ),

    'format' => '',

    'prev_text' => __('&laquo;'),

    'next_text' => __('&raquo;'),

    'total' => ceil($total / $items_per_page),

    'current' => $page

));

?>

</div>

  <table cellspacing="0" class="wp-list-table widefat fixed posts analyzer_posts">

  <thead>

    <tr>

	  <th class="manage-column column-cb check-column" id="cb" scope="col">Edit link </th>

      <th style="" class="manage-column column-title" id="title" scope="col">Post Name</th>

      <th style="" class="manage-column column-title" id="title" scope="col">

     Word Count

      <a href="?page=panalyzer_main_menu&order=word_count&sort=<?php echo $count_sort;?>">

      <span class="DataTables_sort_icon <?php echo $count_class;?>"></span></a>

      </th>  

      

      <th style="" class="manage-column column-title" id="title" scope="col">

      Images

      <a href="?page=panalyzer_main_menu&order=no_images&sort=<?php echo $cimg_sort;?>">

      <span class="DataTables_sort_icon <?php echo $cimg_class;?>"></span></a>

      </th> 

      

      <th style="" class="manage-column column-title" id="title" scope="col">

      Headlines

     <a href="?page=panalyzer_main_menu&order=headlines&sort=<?php echo $head_sort;?>">

      <span class="DataTables_sort_icon <?php echo $head_class;?>"></span></a>

      </th> 

      

      <th style="" class="manage-column column-title" id="title" scope="col">

      Paragraphs

       <a href="?page=panalyzer_main_menu&order=paragraph&sort=<?php echo $para_sort;?>">

      <span class="DataTables_sort_icon <?php echo $para_class;?>"></span></a>

      </th> 

      <th style="" class="manage-column column-title" id="title" scope="col">

      Freshness

        <a href="?page=panalyzer_main_menu&order=date_updated&sort=<?php echo $date_sort;?>">

        <span class="DataTables_sort_icon <?php echo $date_class;?>"></span></a>

      </th>

	  </tr>

  </thead>

  

  <tbody id="the-list">

<?php 

foreach ($pageposts as $key=>$data){

	$cont_td ="";
	$img_td  ="";
	$head_td ="";
	$para_td  ="";
	$date ="";
	$date_td ="";
	if ($data->word_count >= $arr_word['min_value'] &&  $data->word_count <= $arr_word['middle_value']){
		$cont_td = "red";
	}elseif ($data->word_count > $arr_word['middle_value'] && $data->word_count < $arr_word['max_value']){
		$cont_td  = "orange";
	}elseif ($data->word_count > $arr_word['max_value']){
		$cont_td = "green";		
	}else{
		$cont_td = "red";
	}
	if ($data->no_images >= $arr_img['min_value'] &&  $data->no_images <= $arr_img['middle_value']){
		$img_td = "red";
	}elseif ($data->no_images > $arr_img['middle_value'] && $data->no_images < $arr_img['max_value']){
		$img_td  = "orange";
	}elseif ($data->no_images > $arr_img['max_value']){
		$img_td = "green";		
	}else{
		$img_td = "red";
	}

	if ($data->headlines >= $arr_head['min_value'] &&  $data->headlines <= $arr_head['middle_value']){
		$head_td = "red";
	}elseif ($data->headlines > $arr_head['middle_value'] && $data->headlines < $arr_head['max_value']){
		$head_td  = "orange";
	}elseif ($data->headlines > $arr_head['max_value']){
		$head_td = "green";		
	}else{
		$head_td = "red";
	}

	
	if ($data->paragraph >= $arr_para['min_value'] &&  $data->paragraph <= $arr_para['middle_value']){
		$para_td = "red";
	}elseif ($data->paragraph > $arr_para['middle_value'] && $data->paragraph < $arr_para['max_value']){
		$para_td  = "orange";
	}elseif ($data->paragraph > $arr_para['max_value']){
		$para_td = "green";		
	}else{
		$para_td = "red";
	}

	if ($data->date_updated >= $arr_date['min_value'] &&  $data->date_updated <= $arr_date['middle_value']){
		$date = "New";
		$date_td = "green";
	}elseif ($data->date_updated > $arr_date['middle_value'] && $data->date_updated < $arr_date['max_value']){
		$date = "middle";
		$date_td = "orange";
	}elseif ($data->date_updated > $arr_date['max_value']){
		$date = "Outdated";
		$date_td = "red";	
	}else{
		$date = "New";
		$date_td = "green";
	}

	



?>

     <tr valign="top" class="alternate author-self status-publish format-default iedit" style="border:1px solid red; " id="<?php echo 'post_'.$data->post_id;?>">

	  <td class="categories column-categories">

      <strong><a href="<?php echo get_admin_url();?>/post.php?post=<?php echo $data->post_id;?>&action=edit">Edit</a></strong></td>

	  <td class="title"><strong><?php echo get_the_title($data->post_id); ?> </strong></td>

	  <td class="author column-author" style="background:<?php echo $cont_td; ?>">

      	<strong><?php echo $data->word_count ?></strong></td> 

      <td class="author column-author" style="background:<?php echo $img_td; ?>">

      	<strong><?php echo $data->no_images ?></strong></td> 

      <td class="author column-author" style="background:<?php echo $head_td; ?>">

      	<strong><?php echo $data->headlines ?></strong></td> 

      <td class="author column-author" style="background:<?php echo $para_td; ?>">

      	<strong><?php echo $data->paragraph ?></strong></td> 

	  <td class="date column-date" style="background:<?php echo $date_td; ?>">

      	<strong><?php echo $date."::".$data->date_updated;?></strong></td> 

	  

      

     </tr>

<? }?>

	

	

	

	<?php // if(function_exists('wp_pagenavi')) :  wp_pagenavi();  endif; wp_reset_query();?>	

  </tbody>

</table>



  <br class="clear">

</div>

</div>

<script language="javascript">



(function ($){

	$(document).ready(function(e) {

		

        $("#img-snaper-btn").click(function (){

			$('#img-snaper-loader').css('display', 'block');

			$.post(ajaxurl, {action : 'analyze_post'}, function (result){

				$('#img-snaper-loader').css('display', 'none');

				window.location.reload();

				}, type='json');

		});

		

		 $("#csv_btn").click(function (){

			 $('#csv_frm').submit();

			 

		 });

    });

})(jQuery);



</script>
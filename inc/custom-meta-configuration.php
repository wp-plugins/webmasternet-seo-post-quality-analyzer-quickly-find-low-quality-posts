<?php //require_once( GS_PDF_PLUGIN_DIR . "dompdf/dompdf_config.inc.php"); ?>

<div class="wrap">
  <h2>Post Analyzer Setting</h2>
  <?php 	
 
    
  	if(isset($_POST['analyzer_btn']))
	{
		update_option('post_analyzer_word',serialize($_POST['word']));
		update_option('post_analyzer_img',serialize($_POST['img']));
		update_option('post_analyzer_head',serialize($_POST['head']));
		update_option('post_analyzer_para',serialize($_POST['para']));
		update_option('post_analyzer_date',serialize($_POST['date']));
	}	
$arr_word = unserialize(get_option('post_analyzer_word'));
$arr_img = unserialize(get_option('post_analyzer_img'));
$arr_head = unserialize(get_option('post_analyzer_head'));
$arr_para = unserialize(get_option('post_analyzer_para'));
$arr_date = unserialize(get_option('post_analyzer_date'));
	


?>
<style>	
.count_header { color:#21759B;}
</style>
<form action="" method="post" id="" name="url_form">
   
    <table class="widefat">
      <thead>
      
      <tr>
        <th width="927">&nbsp;</th>
      </tr>
        </thead>
      
      <tfoot>
        <tr>
          <th>&nbsp;</th>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <td style="padding:10px 25px;font-family:Verdana, Geneva, sans-serif;color:#666;"><strong></strong>
            <table width="100%"  border="1">
            <tr>
            	<td colspan="3"><strong class="count_header">Word Count</strong></td>
            </tr>
            <tr> 
             <td ><p>Low Quality Value: </p></td>
             <td  width="80%">
             <input type="text" name="word[min_value]"  id="img_grab_url" value="<?php echo @$arr_word['min_value']; ?>"  size=50/> </td>
            
              </tr>
              <tr>
             <td ><p>Medium Value:</p></td>
             <td  width="80%">
           <input type="text" name="word[middle_value]"  id="img_grab_url" value="<?php echo @$arr_word['middle_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Optimal Value:</p></td>
             <td  width="80%">
          <input type="text" name="word[max_value]"  id="img_grab_url" value="<?php echo @$arr_word['max_value']; ?>"  size=50/> </td>
            
              
            </table>
            <table width="100%"  border="1">
            <tr>
            	<td colspan="3"><strong class="count_header">Image Count</strong></td>
            </tr>
            <tr>
             <td ><p>Low Quality Value: </p></td>
             <td  width="80%">
            <input type="text" name="img[min_value]"  id="img_grab_url" value="<?php echo @$arr_img['min_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Medium Value:</p></td>
             <td  width="80%">
           <input type="text" name="img[middle_value]"  id="img_grab_url" value="<?php echo @$arr_img['middle_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Optimal Value:</p></td>
             <td  width="80%">
           <input type="text" name="img[max_value]"  id="img_grab_url" value="<?php echo @$arr_img['max_value']; ?>"  size=50/> </td>
           
              
            </table>
            <table width="100%"  border="1">
            <tr>
            	<td colspan="3"><strong class="count_header">Headlines Count</strong></td>
            </tr>
            <tr>
             <td ><p>Low Quality Value: </p></td>
             <td  width="80%">
             <input type="text" name="head[min_value]"  id="img_grab_url" value="<?php echo @$arr_head['min_value']; ?>"  size=50/> </td>
            
              </tr>
              <tr>
             <td ><p>Medium Value:</p></td>
             <td  width="80%">
            <input type="text" name="head[middle_value]"  id="img_grab_url" value="<?php echo @$arr_head['middle_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Optimal Value:</p></td>
             <td  width="80%">
       <input type="text" name="head[max_value]"  id="img_grab_url" value="<?php echo @$arr_head['max_value']; ?>"  size=50/> </td>
            
              
            </table>
             <table width="100%"  border="1">
            <tr>
            	<td colspan="3"><strong class="count_header">Paragraphs Count</strong></td>
            </tr>
            <tr>
             <td ><p>Low Quality Value: </p></td>
             <td  width="80%">
             <input type="text" name="para[min_value]"  id="img_grab_url" value="<?php echo @$arr_para['min_value']; ?>"  size=50/> </td>
              
              </tr>
              <tr>
             <td ><p>Medium Value:</p></td>
             <td  width="80%">
            <input type="text" name="para[middle_value]"  id="img_grab_url" value="<?php echo @$arr_para['middle_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Optimal Value:</p></td>
             <td  width="80%">
            <input type="text" name="para[max_value]"  id="img_grab_url" value="<?php echo @$arr_para['max_value']; ?>"  size=50/> </td>
             
              </tr>
              
            </table>
            
            <table width="100%"  border="1">
            <tr>
            	<td colspan="3"><strong class="count_header">Date Count</strong></td>
            </tr>
            <tr>
             <td ><p>High Quality Value (When was it last updated - in days): </p></td>
             <td  width="80%">
             <input type="text" name="date[min_value]"  id="img_grab_url" value="<?php echo @$arr_date['min_value']; ?>"  size=50/> </td>
            
              </tr>
              <tr>
             <td ><p>Medium Value:</p></td>
             <td  width="80%">
             <input type="text" name="date[middle_value]"  id="img_grab_url" value="<?php echo @$arr_date['middle_value']; ?>"  size=50/> </td>
             
              </tr>
              <tr>
             <td ><p>Low Value:</p></td>
             <td  width="80%">
            <input type="text" name="date[max_value]"  id="img_grab_url" value="<?php echo @$arr_date['max_value']; ?>"  size=50/> </td>
             
              </tr>
               <td colspan="2">
               <input type="submit" name="analyzer_btn" value="Submit" class="button-primary" /></td>
              </tr>
            </table>
            </td>
        </tr>
        
        
      </tbody>
    </table>
  </form>
  
    
   
</div>

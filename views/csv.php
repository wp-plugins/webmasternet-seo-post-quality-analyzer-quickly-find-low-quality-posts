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

?>
<div class='wrap' id="wrap-statigram">
    <div id="icon-themes" class="icon32"><br></div>
    <h2>CSV List</h2>
    <br>
    <p class="submit">
           
            <span id="img-snaper-loader" style="display:none; float:left;"><img src="<?php echo plugin_dir_url(__FILE__)?>ajax-loader.gif" /></span> 	</p>
    <div class="widget-liquid-left">
        <div id="widgets-left">
            <div class="widgets-holder-wrap">
               <?php 
					// SPECIFY THE DIRECTORY
					$dir = WP_PLUGIN_DIR."/post-analyzer/csv/";
					// OPEN THE DIRECTORY
					$dirHandle = opendir($dir); 
					// LOOP OVER ALL OF THE  FILES
					echo "<div class='video_list'><ul>";
					while ($file = readdir($dirHandle)) { 
						  // IF IT IS NOT A FOLDER, AND ONLY IF IT IS A .JPG WE ACCESS IT
						  if(!is_dir($file) && strpos($file, '.csv')>0) { 
							 echo "<li><a href='".WP_PLUGIN_URL."/post-analyzer/csv/".$file."'>".$file."</a></li>";
						  }
						  
					}
					echo "</ul></div>";
					// CLOSE THE DIRECTORY
					closedir($dirHandle); 
					?>
									
                <br class="clear">
            </div>
        </div>
    </div>
    
    
  
   

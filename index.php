<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>samko</title>

        <!-- Make the page take the full width of the device-->
        <meta name="viewport"  content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0" />

        <!-- The stylesheet -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/touchTouch/touchTouch.css" />

        <!-- Google Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Dancing+Script" />

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body>


        
				<?php
	ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

	 $directory = "images/";
	 $thumbdir = $directory."thumbnails/";
	 $prefix="thumb_";
	 $max=50;
	 
    $tmp=glob($directory.'*',GLOB_ONLYDIR);
    if(isset($_GET['gallery']))$gallery=($_GET['gallery']);
    else $gallery='';
    $gallery=basename($gallery);
    
    $galleries=array();
    foreach($tmp as $dir){
			$dir=trim($dir,'/');
			if($dir==trim($thumbdir,'/'))continue;
			$dir=basename($dir);
			$galleries[]=$dir;
	}
    if($galleries && !$gallery){
		foreach($galleries as $gall){
			$images = glob($directory.$gall . "/*.*");
			$image=$images[rand(0,count($images)-1)];
			echo '<div class="thumbs2" data-gallery="'.$gall.'" >';
			echo '<a href="?gallery='.$gall.'" title="'.$gall.'" style="background-image:url('.$image.')" ></a>';
			echo '</div>';
		}
	}
    else{
		$gallery=($gallery) ? $gallery.'/' : '';
		$directory.=$gallery;
		$images = glob($directory  . "*.*");
	    $total=count($images);
	    if(isset($_GET['page']))$page=intval($_GET['page']);
	    else $page=1;
	    
	    echo '<div style="text-align:center;"><div><a href="?" class="btn btn-primary btn-sm" role="button" style="color:white;">Home</a></div><ul class="pagination pagination-lg">
	  <li><a href="?page='.max($page-1, 1).'&gallery='.$gallery.'">&laquo;</a></li>';
	  for($i=1;$i<=max(1,intval($total/$max)+1);$i++){
		  //$style='width:42px;height:30px;';
		  $style="";
		  if($i==$page) echo '<li class="active"><a style="'.$style.'" href="?page='.$i.'&gallery='.$gallery.'">'.$i.' <span class="sr-only">(current)</span></a></li>';
		  else  echo ' <li><a style="'.$style.'&gallery='.$gallery.'" href="?page='.$i.'&gallery='.$gallery.'">'.$i.'</a></li>';
	  }
	  echo ' <li><a href="?page='.intval($page+1).'&gallery='.$gallery.'">&raquo;</a></li>
	</ul></div>';
	    echo '<div class="thumbs">';
	    $thumbnails = glob ($thumbdir . "*.*");
	    $thumbnails=($thumbnails) ? $thumbnails : array();
	    foreach($thumbnails as $key=>$thumb){
			$thumbnails[$key]=basename($thumb);
			}
			
			$counter=0;
			$from=$page*$max - $max;
	    foreach($images as $key=>$image){
			$counter++;
			$images[$key]=basename($image);
			$image=basename($image);
				if(!in_array($prefix.$image,$thumbnails)){
					  $img = imagecreatefromjpeg( $directory.$image );
				      $width = imagesx( $img );
				      $height = imagesy( $img );
				
				      // calculate thumbnail size
				      $new_width = 120;
				      $new_height = floor( $height * ( $new_width / $width ) );
				
				      // create a new temporary image
				      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
				
				      // copy and resize old image into new image 
				      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
				
				      // save thumbnail into a file
				      imagejpeg( $tmp_img, $thumbdir.$prefix.$image );
			}
	    $name=$directory.$image;
	    $thumb=$thumbdir.$prefix.$image;
	    $title=substr($image,0,-4);
	    if($counter>=$from && $counter<$page*$max)
	    echo '
	    <a href="'.$name.'" title="'.$title.'" style="background-image:url('.$thumb.')"></a>
	    ';
	}

echo '     </div>';
 echo '<div style="text-align:center;"><ul class="pagination pagination-lg">
  <li><a href="?page='.max($page-1, 1).'&gallery='.$gallery.'">&laquo;</a></li>';
  for($i=1;$i<=max(1,intval($total/$max)+1);$i++){
	  //$style='width:42px;height:30px;';
	  $style="";
	  if($i==$page) echo '<li class="active"><a style="'.$style.'" href="?page='.$i.'&gallery='.$gallery.'">'.$i.' <span class="sr-only">(current)</span></a></li>';
	  else  echo ' <li><a style="'.$style.'" href="?page='.$i.'&gallery='.$gallery.'">'.$i.'</a></li>';
	  }
  echo ' <li><a href="?page='.intval($page+1).'&gallery='.$gallery.'">&raquo;</a></li>
</ul></div>';
}
?>
	        



        <!-- JavaScript includes - jQuery, turn.js and our own script.js -->
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="assets/touchTouch/touchTouch.jquery.js"></script>
		<script src="assets/js/script.js"></script>



    </body>
</html>

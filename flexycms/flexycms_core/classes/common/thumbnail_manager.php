<?php
class thumbnail_manager{ 
		var $CROP_LEFT_TOP = 0;
		var $CROP_LEFT_BOTTOM = 1;
		var $CROP_RIGHT_TOP = 2;
		var $CROP_RIGHT_BOTTOM = 3;
		var $CROP_CENTER_TOP = 4;
		var $CROP_CENTER_BOTTOM = 5;
		var $CROP_MIDDLE_LEFT = 6;
		var $CROP_MIDDLE_RIGHT = 7;
		var $CROP_ALL = 8;
		var $quality = 100;
		
	function thumbnail_manager($src,$target='',$width=0,$height=0,$left=0,$top=0){
		$this->src = $src;
		if($target){
			$this->target = $target;
			copy($src,$target);
			chmod($this->target,0777);			
		}else{
			$this->target = $src;		
		}
		$this->width = $width;
		$this->height = $height;
		$this->left = $left;
		$this->top = $top;
	}
	
	function set_quality($quality){
		if($quality){
			$this->quality = $quality;
		}else{
			echo "<br>Thumbnail Manganager Error: Quality is set to null.<hr>";		
		}				
	}
	
	function set_parameters($src,$target='',$width=0,$height=0,$left=0,$top=0){
		if($target){
			$this->target = $target;
			copy($src,$target);
			chmod($this->target,0644);						
		}else{
			$this->target = $src;		
		}
		$this->width = $width;
		$this->height = $height;
	}
	
	function set_target($target){
		if($target){
			$this->target = $target;
			copy($this->src,$target);
			chmod($this->target,0644);						
		}else{
			$this->target = $this->src;		
		}
		if(!$this->target){
			echo "<br>Thumbnail Manganager Error: Target is set to null.<br>
					Both source and target can't be null.<hr>";					
		}
	}

	function set_source($src){
		$this->src = $src;
		if($this->target){
			copy($this->src,$this->target);
			chmod($this->target,0644);		
		}
		if(!$this->src){
			echo "<br>Thumbnail Manganager Error: Source is set to null.<hr>";					
		}		
	}
	
	function set_files($src,$target){
		$this->src = $src;
		if($target){
			$this->target = $target;
			copy($src,$target);
			chmod($this->target,0644);						
		}else{
			$this->target = $src;		
		}
		if(!$this->target){
			echo "<br>Thumbnail Manganager Error: Target is set to null.<br>
					Both source and target can't be null.<hr>";					
		}		
	}
	
	function set_dimension($width=0,$height=0){
		$this->width = $width;
		$this->height = $height;
		if(!$this->width && !$this->height){
			echo "<br>Thumbnail Manganager Error: Dimension is set to null.<br>
					Both width and height can't be null.<hr>";
		}
	}
	
	function set_area($left=0,$top=0,$right=0,$bottom=0){
		$this->left = $left;
		$this->top = $top;
	}
	
	function get_exact_thumb($width=0,$height=0,$left=0,$top=0){
		print "This function is not in used. Please use get_container_thumb()";exit;
		$this->height = $height?$height:$this->height;
		$this->width = $height?$width:$this->width;		
		$this->left = $left?$left:$this->left;
		$this->top = $top?$top:$this->top;
		//return 	$this->height.'--'.$this->width;
		$cmd = "/usr/bin/mogrify -quality {$this->quality} -resize '{$this->width}x{$this->height}!+{$this->left}+{$this->top}'  {$this->target}";
		exec($cmd);
		chmod($this->target,0644);
		
	}

	/////////////SET FUNCTION FOR LIBARY DEPENDENT ////////////////saswati
	function get_container_thumb($width=0,$height=0,$left=0,$top=0,$path="/usr/bin/mogrify"){
		if(is_array($GLOBALS['conf']['IMAGE_HANDLER'])){			
			$fun_name="image_creation_".$GLOBALS['conf']['IMAGE_HANDLER']['library'];
			$this->$fun_name($width,$height,$left,$top);	
		}else{
			$this->image_creation_im($width,$height,$left,$top,$path);	
		}
	}
	///////////////// Image /magic /////////////////////////////////
	function image_creation_im($width=0,$height=0,$left=0,$top=0,$path="/usr/bin/mogrify"){
		$this->height = $height?$height:$this->height;
		$this->width = $height?$width:$this->width;		
		$this->left = $left?$left:$this->left;
		$this->top = $top?$top:$this->top;	
		$cmd = "{$path} -quality {$this->quality} -resize '{$this->width}x{$this->height}>+{$this->left}+{$this->top}' {$this->target}";
		exec($cmd);
		chmod($this->target,0644);
			
	}
	////////////////// GD Library //////////////////////////////
	//function gd_resizeimage($src,$target,$w,$h,$type=''){
	function image_creation_gd($width=0,$height=0,$left=0,$top=0){
		ini_set("memory_limit", "30M");
		$this->height = $height?$height:$this->height;
		$this->width = $height?$width:$this->width;		
		$this->left = $left?$left:$this->left;
		$this->top = $top?$top:$this->top;
		$type = substr(strrchr($this->src,"."),1);
		$left=0;
		$top=0;
		list($owidth, $oheight) = getimagesize($this->src);
		$ar_image = $owidth / $oheight;
		$ar_container = $this->width / $this->height;

		if($owidth > $oheight && $ar_image > $ar_container){
			if($owidth > $this->width){
				$newwidth = $this->width;
			}else{
				$newwidth = $owidth;
			}
			$newheight = ($newwidth/$owidth) * $oheight;
		}else{
			if($oheight > $this->height){
				$newheight=$this->height;
			}else{
				$newheight=$oheight;
			}
			$newwidth = ($newheight/$oheight) * $owidth;
		}
		/*$ar_image = $owidth / $oheight;
		$ar_container = $this->width / $this->height;
		if ($ar_image > $ar_container) { // meaning the image's aspectratio is "wider" than the container, thus limited by width
		$newwidth = intval($this->width);
		$newheight = intval($oheight * ($this->width/$owidth));
		}else{ // else its limited by height
		$newheight = intval($this->height);
		$newwidth = intval($owidth * ($this->height/$oheight));
		}*/
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		if($type=='jpg' || $type=='pjpeg' || $type=='JPG')
			$type="jpeg";
		if($type=='x-png')
			$type="png";
		$var = "imagecreatefrom".$type;
		$source = $var($this->src); 
//		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $owidth, $oheight);
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $owidth, $oheight);
		imagejpeg($thumb,$this->target,$this->quality);
	}

	
	//////////////////////////End of library dependent function//////////
	
	function get_cropped_thumb($type=8,$width=0,$height=0){
		//print_r($this);exit;	
		$this->height = $height?$height:$this->height;
		$this->width = $width?$width:$this->width;
		list($owidth, $oheight, $otype, $oattr) = getimagesize($this->target);
		$thumb_ratio = $this->width/$this->height;
		$image_ratio = $owidth / $oheight;
		if ($image_ratio > $thumb_ratio ) {
			$geometry_height = $this->height;
		} else {
			$geometry_width = $this->width;
		}			
		if (!( $geometry_height+$geometry_width)) {
			return;
		}
		$cmd =  "/usr/bin/mogrify -quality {$this->quality} -resize '{$geometry_width}x{$geometry_height}>' {$this->target}";
		error_log('File :'.__FILE__ . ' Line : '.__LINE__ . $cmd);
		exec($cmd);
		$extra_width = 0;
		$extra_height = 0;
		list($cwidth, $cheight, $ctype, $cattr) = getimagesize($this->target);
		if ($geometry_width) {  // meaning that the image has to be cropped vertically)
			$extra_height=($cheight - $this->height);
		} else {
			$extra_width=($cwidth - $this->width);
		}
	
		$shave_width_left = 0;
		$shave_width_right = 0;	
		$shave_height_top = 0;
		$shave_height_bottom = 0;	
		switch($type){
			case $this->CROP_ALL: 
				if($extra_width){
					if($extra_width % 2){
						$extra_width++;
						$shave_width_left = $extra_width/2;					
						$shave_width_right = $shave_width_left - 1;
					}else{
						$shave_width_left = $shave_width_right = $extra_width/2;								
					}
				}
				if($extra_height){
					if($extra_height % 2){
						$extra_height++;
						$shave_height_top = $extra_height/2;
						$shave_height_bottom = $shave_height_top - 1;
					}else{
						$shave_height_top = $shave_height_bottom = $extra_height/2;								
					}		
				}
				break;
			case $this->CROP_LEFT_TOP:
				$shave_width_left = $extra_width;
				$shave_height_top = $extra_height;
				break;
			case $this->CROP_LEFT_BOTTOM:
				$shave_width_left = $extra_width;					
				$shave_height_bottom = $extra_height;
				break;
			case $this->CROP_RIGHT_TOP:
				$shave_width_right = $extra_width;					
				$shave_height_top = $extra_height;
				break;
			case $this->CROP_RIGHT_BOTTOM:
				$shave_width_right = $extra_width;					
				$shave_height_bottom = $extra_height;
				break;
			case $this->CROP_CENTER_TOP:
				if($extra_width){
					if($extra_width % 2){
						$extra_width++;
						$shave_width_left = $extra_width/2;					
						$shave_width_right = $shave_width_left - 1;
					}else{
						$shave_width_left = $shave_width_right = $extra_width/2;								
					}
				}
				$shave_height_top = $extra_height;
				break;
				
			case $this->CROP_CENTER_BOTTOM:
				if($extra_width){
					if($extra_width % 2){
						$extra_width++;
						$shave_width_left = $extra_width/2;					
						$shave_width_right = $shave_width_left - 1;
					}else{
						$shave_width_left = $shave_width_right = $extra_width/2;								
					}
				}
				$shave_height_bottom = $extra_height;
				break;
			case $this->CROP_MIDDLE_LEFT:
				$shave_width_left = $extra_width;
				if($extra_height){
					if($extra_height % 2){
						$extra_height++;
						$shave_height_top = $extra_height/2;
						$shave_height_bottom = $shave_height_top - 1;
					}else{
						$shave_height_top = $shave_height_bottom = $extra_height/2;								
					}		
				}
		
				break;
			case $this->CROP_MIDDLE_RIGHT:
				$shave_width_right = $extra_width;
				if($extra_height){
					if($extra_height % 2){
						$extra_height++;
						$shave_height_top = $extra_height/2;
						$shave_height_bottom = $shave_height_top - 1;
					}else{
						$shave_height_top = $shave_height_bottom = $extra_height/2;								
					}		
				}
		
				break;
			default:
				if($extra_width){
					if($extra_width % 2){
						$extra_width++;
						$shave_width_left = $extra_width/2;					
						$shave_width_right = $shave_width_left - 1;
					}else{
						$shave_width_left = $shave_width_right = $extra_width/2;								
					}
				}
				if($extra_height){
					if($extra_height % 2){
						$extra_height++;
						$shave_height_top = $extra_height/2;
						$shave_height_bottom = $shave_height_top - 1;
					}else{
						$shave_height_top = $shave_height_bottom = $extra_height/2;								
					}		
				}
		
		}
		$ccmd = "/usr/bin/mogrify -quality {$this->quality} -crop '+{$shave_width_left}-{$shave_height_bottom}'  -crop '-{$shave_width_right}+{$shave_height_top}'  {$this->target}";
		//usr/bin/mogrify -quality 70 -crop '+38-0' -crop '-0+0' /var/www/html/ppl/image/thumb/126_11_Picture_4.png
		//print "Type : $type : extra_width : $extra_width extra_height $extra_height CCMD $ccmd";exit;
		
		exec($ccmd);

		chmod($this->target,0644);		
	}
}

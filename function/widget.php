<?php
class getjsonapi_cycle_widget extends WP_Widget {
    function getjsonapi_cycle_widget() {
        parent::__construct( false, 'getjsonapi' );
		$widget_ops = array( 'classname' => 'getjsonapi','description' => __( 'Slideshow thumbnail and url of posts', 'getjsonapi' ) );
        $this->WP_Widget( 'getjsonapi', "Get Json Api Cycle", $widget_ops );
    }
    function widget( $args, $instance ) {
        extract($args);
        echo $before_widget;
        $title = apply_filters( 'getjsonapi' , $instance['title'] );
		$num = apply_filters( 'getjsonapi', $instance['num'], $instance );
		$filter = apply_filters( 'getjsonapi', $instance['filter'], $instance );
		$url = apply_filters( 'getjsonapi', $instance['url'], $instance );
        if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		if ($filter=="CYCLE")
			echo  getjsonapi_cycle($num,$url);
		if ($filter=="LIST")
			echo  getjsonapi_list($num,$url);
        echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
    	$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num'] = strip_tags( $new_instance['num'] );
        $instance['filter'] = strip_tags( $new_instance['filter'] );
        $instance['url'] = strip_tags( $new_instance['url'] );
		return $instance;
    }
    function form( $instance ) {
        $defaults = array( 'num' => 5, 'url' => '' , 'filter'=>'');
        $instance = wp_parse_args( (array) $instance, $defaults ); 
	   if (isset($instance['title'] ))
        	$title = apply_filters( 'getjsonapi' , $instance['title'] );
		else
			$title = __('Last','getjsonapi');
		if ((isset($instance['num']) && $instance['num']!=""))
        	$num = apply_filters( 'getjsonapi' , $instance['num'] );
		else
			$num = 5;
		if ((isset($instance['url']) && $instance['url']!=""))
        	$url = apply_filters( 'getjsonapi' , $instance['url'] );
		else
			$url = "";
		if ((isset($instance['filter']) && $instance['filter']!=""))
        	$filter = apply_filters( 'getjsonapi' , $instance['filter'] );
		else
			$filter = "CYCLE";
        ?>
        
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e("Title");?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e("Number","getjsonapi");?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" type="text" value="<?php echo esc_attr( $num ); ?>" /> 

		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e("Url http://","getjsonapi");?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" /> 

			
        <label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e("Type","getjsonapi");?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>">
				<option value="CYCLE" <?php if ($filter=="CYCLE") echo "selected='selected'"; ?>><?php _e("Slideshow","getjsonapi");?></option>
				<option value="LIST" <?php if ($filter=="LIST") echo "selected='selected'"; ?>><?php _e("List","getjsonapi");?></option>
			</select>   
        <?php
    }
}

function getjsonapi_widget() {
    register_widget( "getjsonapi_cycle_widget" );
}
add_action( 'widgets_init', 'getjsonapi_widget' );
?>

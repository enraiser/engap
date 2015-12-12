<?php

class ENGAP_Posts {
	/**
	 * Server object
	 *
	 * @var ENGAP_ResponseHandler
	 */
	protected $server;

	/**
	 * Constructor
	 *
	 * @param ENGAP_ResponseHandler $server Server object
	 */
	public function __construct(ENGAP_ResponseHandler $server) {
		$this->server = $server;

		$this->comments = new ENGAP_Comments();
	}

	/**
	 * Register the post-related routes
	 *
	 * @param array $routes Existing routes
	 * @return array Modified routes
	 */
	public function register_routes( $routes ) {
		$post_routes = array(
			// Post endpoints
			'/posts' => array(
				array( array( $this, 'get_posts' ),      ENGAP_Server::READABLE ),
				array( array( $this, 'create_post' ),    ENGAP_Server::CREATABLE | ENGAP_Server::ACCEPT_JSON ),
			),

			'/posts/(?P<id>\d+)' => array(
				array( array( $this, 'get_post' ),       ENGAP_Server::READABLE ),
				array( array( $this, 'edit_post' ),      ENGAP_Server::EDITABLE | ENGAP_Server::ACCEPT_JSON ),
				array( array( $this, 'delete_post' ),    ENGAP_Server::DELETABLE ),
			),
		);
		$post_routes = $this->comments->register_routes( $post_routes );
		return array_merge( $routes, $post_routes );
	}
    
public function Retrieve_post($optr,$select,$where,$refguid,$limit){
global $wp,$wpdb;
        if($optr =='gt')$where .= " AND $wpdb->posts.ID > ".$refguid;
        elseif($optr =='lt')$where .= " AND $wpdb->posts.ID < ".$refguid;
    
        $querystr = $select.$where." ORDER BY $wpdb->posts.ID ASC LIMIT ".$limit;
        $posts_list = $wpdb->get_results($querystr);
 
		error_log("query - ".$querystr);
		$struct = array();
        if ( ! $posts_list ) {
			return $struct;
		}

		foreach ( $posts_list as $post ) {
            //error_log("post id ".$post['ID']);
			$post = get_object_vars( $post );

			// Do we have permission to read this post?
			if ( ! json_check_post_permission( $post, 'read' ) ) {
				continue;
			}
//error_log('the post  '. serialize($post));
			$post_data["guid"] = $post['ID'];
			$post_data["title"] = $post['post_title'];
            $the_excerpt = $post['post_content'];
            $the_excerpt = substr($the_excerpt, 0, 100);
            $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
    
			$post_data["description"]  = $the_excerpt;
            $authorid  = get_the_author_id($post);
            $post_data["iconurl"] = get_avatar_url($authorid);
            //$post_data["icontime"] = $post['post_title'];
            $post_data["time"] = get_post_modified_time('U',false,$post,false);

            
			if ( is_wp_error( $post_data ) ) {
				continue;
			}
			//error_log("ajaay".serialize($post));
			$struct[] = $post_data;
		}
        return $struct;

}
public function Sync_post($select,$where,$refguid,$limit){
global $wp,$wpdb;
        $where .= " AND $wpdb->posts.ID < ".$refguid;
        $querystr = $select.$where." ORDER BY $wpdb->posts.ID ASC LIMIT ".$limit;
        $posts_list = $wpdb->get_results($querystr);
 
		error_log("Sync - ".$querystr);

		$struct = array();
        if ( ! $posts_list ) {
			return $struct;
		}

		foreach ( $posts_list as $post ) {
            //error_log("post id ".$post['ID']);
			$post = get_object_vars( $post );

			// Do we have permission to read this post?
			if ( ! json_check_post_permission( $post, 'read' ) ) {
				continue;
			}

			$post_data["guid"] = $post['ID'];
			$post_data["title"] = $post['post_title'];
			$post_data["description"] = strip_tags($post['post_content']);
            $authorid  = get_the_author_id($post);
            $post_data["iconurl"] = get_avatar_url($authorid);
            //$post_data["icontime"] = $post['post_title'];
            $post_data["time"] = get_post_modified_time('U',false,$post,false);

            
			if ( is_wp_error( $post_data ) ) {
				continue;
			}
			//error_log("ajaay".serialize($post));
			$struct[] = $post_data;
		}
        return $struct;

}
	/**
	 * Retrieve posts.
	 *
	 * @since 3.4.0
	 *
	 * The optional $filter parameter modifies the query used to retrieve posts.
	 * Accepted keys are 'post_type', 'post_status', 'number', 'offset',
	 * 'orderby', and 'order'.
	 *
	 * @uses wp_get_recent_posts()
	 * @see get_posts() for more on $filter values
	 *
	 * @param array $filter Parameters to pass through to `WP_Query`
	 * @param string $context The context; 'view' (default) or 'edit'.
	 * @param string|array $type Post type slug, or array of slugs
	 * @param int $page Page number (1-indexed)
	 * @return stdClass[] Collection of Post entities
	 */
	public function get_posts( $filter = array(), $context = 'view', $type = 'post', $page = 1, $limit = 3) {
		$query = array();

        error_log("filters ".serialize($filter));
        $refguid = $filter[refguid];
        $optr = $filter[optr];
        if($refguid=='none')$refguid='0';
        $taxonomy = $filter[taxonomy];
        $tagid = $filter[tagid];
        error_log("limit ".$limit);
		// Validate post types and permissions
		$query['post_type'] = array();

		foreach ( (array) $type as $type_name ) {
			$post_type = get_post_type_object( $type_name );

			if ( ! ( (bool) $post_type ) || ! $post_type->show_in_json ) {
				return new WP_Error( 'json_invalid_post_type', sprintf( __( 'The post type "%s" is not valid' ), $type_name ), array( 'status' => 403 ) );
			}

			$query['post_type'][] = $post_type->name;
		}

		global $wp,$wpdb;
         $my_select_q = "SELECT * FROM $wpdb->posts";
        
        $my_where_q = " WHERE  $wpdb->posts.post_type = '".$type."'";

        if($tagid !='all'){
            //$category = get_term_by('name', 'elgg', $taxonomy);
        
            $my_select_q .= " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";
            $my_where_q .=" AND $wpdb->term_taxonomy.taxonomy = '".$taxonomy."'";
        
                //$tag_ids = "(".explode(",",$tagid).")";
               
                //$term_ids = "('3', '13')";
                //if term has childrens then try to include them too. get_term_children( $cata, $taxonomy );
                // $my_where_q .= "' AND $wpdb->term_taxonomy.term_id IN $tag_ids";
                $my_where_q .= " AND $wpdb->term_taxonomy.term_id = $tagid";
        }
        /*
            get rid of icon time from client side

        */
        if($refguid!=0  and $optr!='lt'){
         $return['sync'] = $this->Sync_post($my_select_q,$my_where_q,$refguid,$limit);
        }
        if($optr =='gt'  or $optr=='lt')
        $result[$optr] = $this->Retrieve_post($optr,$my_select_q,$my_where_q,$refguid,$limit);


        $return = array('status'=>'0','result'=>$result);
        $response   = new ENGAP_Response();

		$response->set_data( $return );

		return $response;
	}
}

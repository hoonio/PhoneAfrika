<?php
/***********************************************************************
* Class: csl_mobile_listener
*
* The slplus service creation object
*
* This handles the creation of the mobile listener service
*
************************************************************************/

if (! class_exists('csl_mobile_listener')) {
    class csl_mobile_listener {
        
            /*************************************
             * The Constructor
             */
            function __construct($params) {
                foreach ($params as $name => $sl_value) {            
                    $this->$name = $sl_value;
                }

                $this->DoHeaders();
                $this->CheckErrors();
                $this->PerformSearch();
            }

            function GetLocations() {
                import_request_variables("gp");
                global $slplus_plugin;

                //set the callback
                if (!isset($_REQUEST['callback'])) {
                    $callback = '';
                }
                else {
                    $callback = $_REQUEST['callback'];
                }

                if (!isset($_REQUEST['max'])) {
                    $max = $slplus_plugin->options_nojs['max_results_returned'];
                }
                else {
                    $max = $_REQUEST['max'];
                }
                
                //set a latitude
                if (!isset($_REQUEST['lat'])) {
                    $lat = '';
                }
                else {
                    $lat = $_REQUEST['lat'];
                }

                //set a longitude
                if (!isset($_REQUEST['lng'])) {
                    $lng = '';
                }
                else {
                    $lng = $_REQUEST['lng'];
                }

                //set a radius
                if (!isset($_REQUEST['radius'])) {
                    $radius = 40000;
                }
                else {
                    $radius = $_REQUEST['radius'];
                }

                //set tags
                if (!isset($_REQUEST['tags'])) {
                    $tags = '';
                }
                else {
                    $tags = $_REQUEST['tags'];
                }

                //set a name
                if (!isset($_REQUEST['name'])) {
                    $name = '';
                }
                else {
                    $name = $_REQUEST['name'];
                }

                //create a params object
                $params = array(
                    'center_lat' => $lat,
                    'center_lng' => $lng,
                    'radius' => $radius,
                    'tags' => $tags,
                    'name' => $name,
                    'callback' => $callback,
                    'max' => $max,
                    'apiKey' => ''
                );
                $response = new csl_mobile_listener($params);
            }

            function CheckErrors() {
                if ($this->callback == '') {
                    die (0);
                }

                if ($this->center_lat == '') {
                    $this->Respond(false, __('no latitude passed','csa-slplus'));
                }

                if ($this->center_lng == '') {
                    $this->Respond(false, __('no longitude passed','csa-slplus'));
                }
            }

            function Respond($status, $complete) {
                die(''.$this->callback.'('.json_encode(array('success' => $status, 'response' => $complete)).');');
            }

            function DoHeaders() {
                header('Content-Type: application/json; charset=' . get_option('blog_charset'), true);
            }

            function PerformSearch() {
                global $wpdb;
                global $slplus;
	            $username=DB_USER;
	            $password=DB_PASSWORD;
	            $database=DB_NAME;
	            $host=DB_HOST;
	            $dbPrefix = $wpdb->prefix;

	            //-----------------
	            // Set the active MySQL database
	            //
	            $connection=mysql_connect ($host, $username, $password);
	            if (!$connection) { die(json_encode( array('success' => false, 'response' => 'Not connected : ' . mysql_error()))); }
	            $db_selected = mysql_select_db($database, $connection);
	            mysql_query("SET NAMES utf8");
	            if (!$db_selected) {
		            $this->Respond( 'Can\'t use db : ' . mysql_error());
	            }

	            // If tags are passed filter to just those tags
	            //
	            $tag_filter = ''; 
	            if (
		            isset($this->tags) && ($this->tags != '')
	            ){
		            $posted_tag = preg_replace('/^\s+(.*?)/','$1',$this->tags);
		            $posted_tag = preg_replace('/(.*?)\s+$/','$1',$posted_tag);
		            $tag_filter = " AND ( sl_tags LIKE '%%". $posted_tag ."%%') ";
	            }

	            $this->name_filter = '';
	            if(isset($this->name) && ($this->name != ''))
	            {
		            $posted_name = preg_replace('/^\s+(.*?)/','$1',$this->name);
		            $posted_name = preg_replace('/(.*?)\s+$/','$1',$posted_name);
		            $name_filter = " AND (sl_store LIKE '%%".$posted_name."%%')";
	            }

                // Radian multiplier to get linear distance
                $multiplier=(get_option('sl_distance_unit',__('miles', 'csa-slplus'))==__('km'    ,'csa-slplus'))? 6371 : 3959;
	            $max = $slplus_plugin->options_nojs['max_results_returned'];
                if ($this->max < $max) {
                    $max = $this->max;
                }

                //for ($rad = $this->radius; $rad < 40000; $rad += 100) {
		            //Select all the rows in the markers table
		            $query = sprintf(
			            "SELECT *,".
			            "( $multiplier * acos( cos( radians('%s') ) * cos( radians( sl_latitude ) ) * cos( radians( sl_longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( sl_latitude ) ) ) ) AS sl_distance ".
			            "FROM ${dbPrefix}store_locator ".
			            "WHERE sl_longitude<>'' %s %s ".
			            "HAVING (sl_distance < '%s') OR (sl_distance IS NULL) ".
			            'ORDER BY sl_distance ASC '.
			            'LIMIT %s',
			            mysql_real_escape_string($this->center_lat),
			            mysql_real_escape_string($this->center_lng),
			            mysql_real_escape_string($this->center_lat),
			            $tag_filter,
			            $name_filter,
			            mysql_real_escape_string($this->radius),
			            mysql_real_escape_string($max)
		            );
		
		            $result = mysql_query($query);
		            if (!$result) {
			            $this->Respond( false, 'Invalid query: ' . mysql_error() . '- '.$query);
		            }
		
		            // Start the response string
		            $response = array();
					$resultRowids = array();
		            // Iterate through the rows, printing XML nodes for each
		            while ($row = @mysql_fetch_assoc($result)){
			            // ADD to array of markers
			
			            $marker = array(
				            //'test' => stuff
                            'id' => esc_attr($row['sl_id']),
				            'name' => esc_attr($row['sl_store']),
				            'address' => esc_attr($row['sl_address']),
				            'address2' => esc_attr($row['sl_address2']),
				            'city' => esc_attr($row['sl_city']),
				            'state' => esc_attr($row['sl_state']),
				            'zip' => esc_attr($row['sl_zip']),
				            'lat' => $row['sl_latitude'],
				            'lng' => $row['sl_longitude'],
				            'description' => html_entity_decode($row['sl_description']),
				            'url' => esc_attr($row['sl_url']),
				            'sl_pages_url' => esc_attr($row['sl_pages_url']),
				            'email' => esc_attr($row['sl_email']),
				            'hours' => esc_attr($row['sl_hours']),
				            'phone' => esc_attr($row['sl_phone']),
				            'fax' => esc_attr($row['sl_fax']),
                            'units' => get_option('sl_distance_unit',__('miles', 'csa-slplus')),
				            'image' => esc_attr($row['sl_image']),
				            'distance' => $row['sl_distance'],
				            'tags' => esc_attr($row['sl_tags'])
			            );
						$response[] = $marker;
						$resultRowids[] = $row['sl_id'];
			
					}
					// Do report work
					//
					$queryParams = array();
					$queryParams['QUERY_STRING'] = $_SERVER['QUERY_STRING'];
		            $queryParams['tags'] = $this->tags;
		            $queryParams['address'] = $_POST['address'];
					$queryParams['radius'] = $this->radius;

					do_action('slp_report_query_result', $queryParams, $resultRowids);

	            $this->Respond(true, $response);
            }
    }
}

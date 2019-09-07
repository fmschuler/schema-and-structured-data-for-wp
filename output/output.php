<?php
/**
 * Output Page
 *
 * @author   Magazine3
 * @category Frontend
 * @path  output/output
 * @version 1.0
 */
if (! defined('ABSPATH') ) exit;
/**
 * Function generates knowledge graph schema
 * @global type $sd_data
 * @return type json
 */
function saswp_kb_schema_output() {
    
	global $sd_data;   
        $input     = array();    
        $site_url  = get_site_url();
	// Social profile
	$sd_social_profile = array();

	$sd_facebook = array();
        
	if(isset($sd_data['sd_facebook']) && !empty($sd_data['sd_facebook']) && isset($sd_data['saswp-facebook-enable']) &&  $sd_data['saswp-facebook-enable'] ==1){
		$sd_facebook[] = $sd_data['sd_facebook'];
		$sd_social_profile[] = $sd_facebook;
	}
	$sd_twitter = array();
	if(isset($sd_data['sd_twitter']) && !empty($sd_data['sd_twitter']) && isset($sd_data['saswp-twitter-enable']) &&  $sd_data['saswp-twitter-enable'] ==1 ){
		$sd_twitter[] = $sd_data['sd_twitter'];
		$sd_social_profile[] = $sd_twitter;
	}
	
	$sd_instagram = array();
	if(isset($sd_data['sd_instagram']) && !empty($sd_data['sd_instagram']) && isset($sd_data['saswp-instagram-enable']) &&  $sd_data['saswp-instagram-enable'] ==1 ){
		$sd_instagram[] = $sd_data['sd_instagram'];
		$sd_social_profile[] = $sd_instagram;
        }

	$sd_youtube = array();
	if(isset($sd_data['sd_youtube']) && !empty($sd_data['sd_youtube']) && isset($sd_data['saswp-youtube-enable']) &&  $sd_data['saswp-youtube-enable'] ==1){
		$sd_youtube[] = $sd_data['sd_youtube'];
		$sd_social_profile[] = $sd_youtube;
	}

	$sd_linkedin = array();
	if(isset($sd_data['sd_linkedin']) && !empty($sd_data['sd_linkedin']) && isset($sd_data['saswp-linkedin-enable']) &&  $sd_data['saswp-linkedin-enable'] ==1 ){
		$sd_linkedin[] = $sd_data['sd_linkedin'];
		$sd_social_profile[] = $sd_linkedin;
	}

	$sd_pinterest = array();
	if(isset($sd_data['sd_pinterest']) && !empty($sd_data['sd_pinterest']) && isset($sd_data['saswp-pinterest-enable']) &&  $sd_data['saswp-pinterest-enable'] ==1){
		$sd_pinterest[] = $sd_data['sd_pinterest'];
		$sd_social_profile[] = $sd_pinterest;
	}

	$sd_soundcloud = array();
	if(isset($sd_data['sd_soundcloud']) && !empty($sd_data['sd_soundcloud']) && isset($sd_data['saswp-soundcloud-enable']) &&  $sd_data['saswp-soundcloud-enable'] ==1){
		$sd_soundcloud[] = $sd_data['sd_soundcloud'];
		$sd_social_profile[] = $sd_soundcloud;
	}

	$sd_tumblr = array();
	if(isset($sd_data['sd_tumblr']) && !empty($sd_data['sd_tumblr']) && isset($sd_data['saswp-tumblr-enable']) &&  $sd_data['saswp-tumblr-enable'] ==1){
		$sd_tumblr[] = $sd_data['sd_tumblr'];
		$sd_social_profile[] = $sd_tumblr;
	}

	$platform = array();
        
	foreach ($sd_social_profile as $key => $value) {
		$platform[] = $value; 
	}
	
	// Organization Schema 

	if ( saswp_remove_warnings($sd_data, 'saswp_kb_type', 'saswp_string')  ==  'Organization' ) {
            
                $logo          = '';
                $height        = '';
                $width         = '';
                $contact_info  = array();
                
                $service_object     = new saswp_output_service();
                $default_logo       = $service_object->saswp_get_publisher(true);
                
                if(!empty($default_logo)){
                 
                $logo   = $default_logo['url'];	
                $height = $default_logo['height'];
                $width  = $default_logo['width'];    
                
                }
                                		
                $contact_info = array();
                                
		$contact_1   = saswp_remove_warnings($sd_data, 'saswp_contact_type', 'saswp_string');
		$telephone_1 = saswp_remove_warnings($sd_data, 'saswp_kb_telephone', 'saswp_string');
                $contact_url = saswp_remove_warnings($sd_data, 'saswp_kb_contact_url', 'saswp_string');
                                		
		
                if($contact_1 && ($telephone_1 || $contact_url)){
                
                    $contact_info = array(
                    
	 		'contactPoint' => array(
                                        '@type'        => 'ContactPoint',
                                        'contactType'  => esc_attr($contact_1),
                                        'telephone'    => esc_attr($telephone_1),
                                        'url'          => esc_attr($contact_url),
			)
                    
                    );
                    
                }
	 	
		$input = array(
                        '@context'		=> saswp_context_url(),
                        '@type'			=> (isset($sd_data['saswp_organization_type']) && $sd_data['saswp_organization_type'] !='')? $sd_data['saswp_organization_type']:'Organization',
                        '@id'                   => $site_url.'#Organization',
                        'name'			=> saswp_remove_warnings($sd_data, 'sd_name', 'saswp_string'),
                        'url'			=> saswp_remove_warnings($sd_data, 'sd_url', 'saswp_string'),
                        'sameAs'		=> $platform,                                        		
		);
                
                if($logo !='' && $width !='' && $height !=''){
                    
                    $input['logo']['@type']  = 'ImageObject';
                    $input['logo']['url']    = esc_url($logo);
                    $input['logo']['width']  = esc_attr($width);
                    $input['logo']['height'] = esc_attr($height);
                 
                }
		                    
		$input = array_merge($input, $contact_info);
                        		                
}				
		// Person

	if ( saswp_remove_warnings($sd_data, 'saswp_kb_type', 'saswp_string')  ==  'Person' ) {
            
               $image  = ''; 
               $height = '';
               $width  = '';
               
               if(isset($sd_data['sd-person-image'])){
                   
                   $image  = $sd_data['sd-person-image']['url'];
		   $height = $sd_data['sd-person-image']['height'];
		   $width  = $sd_data['sd-person-image']['width'];
                   
               }
		
		if( '' ==  $image && empty($image) && isset($sd_data['sd_default_image'])){
			$image = $sd_data['sd_default_image']['url'];
		}
		
		if( '' ==  $height && empty($height) && isset($sd_data['sd_default_image_height'])){
			$height = $sd_data['sd_default_image_height'];
		}
		
		if( '' ==  $width && empty($width) && isset($sd_data['sd_default_image_width'])){
			$width = $sd_data['sd_default_image_width'];
		}
	
		$input = array(
			'@context'		=> saswp_context_url(),
			'@type'			=> esc_attr($sd_data['saswp_kb_type']),
			'name'			=> esc_attr($sd_data['sd-person-name']),
			'url'			=> esc_url($sd_data['sd-person-url']),
			'image' 		=> array(
                                                        '@type'	 => 'ImageObject',
                                                        'url'	 => esc_url($image),
                                                        'width'	 => esc_attr($width),
                                                        'height' => esc_attr($height),
                                                    ),
			'telephone'		=> esc_attr($sd_data['sd-person-phone-number']),
			);
	}
                
	return apply_filters('saswp_modify_organization_output', $input);	             
}

/**
 * Function generates json markup for the all added schema type in the list
 * @global type $sd_data
 * @return type json
 */
function saswp_schema_output() {     
    
	global $sd_data;

	$Conditionals = saswp_get_all_schema_posts();           
        
	if(!$Conditionals){
		return ;
	}
        
        $all_schema_output = array();
        $recipe_json       = array();
        
        foreach($Conditionals as $schemaConditionals){
        
        $schema_options = array();    
            
        if(isset($schemaConditionals['schema_options'])){
            $schema_options = $schemaConditionals['schema_options'];
        }   
        	        
	$schema_type      = saswp_remove_warnings($schemaConditionals, 'schema_type', 'saswp_string');         
        $schema_post_id   = saswp_remove_warnings($schemaConditionals, 'post_id', 'saswp_string');        
           
        $input1         = array();
        $logo           = ''; 
        $height         = '';
        $width          = '';        
        $site_name      = get_bloginfo();    
        
        $service_object     = new saswp_output_service();
        $default_logo       = $service_object->saswp_get_publisher(true);
        $publisher          = $service_object->saswp_get_publisher();
        
        if(!empty($default_logo)){
            
            $logo   = $default_logo['url'];
            $height = $default_logo['height'];
            $width  = $default_logo['width'];
            
        }
        
        if(isset($sd_data['sd_name']) && $sd_data['sd_name'] !=''){            
            $site_name = $sd_data['sd_name'];            
        }                                                                   
	
			   		                                                                                           		
			$image_id 	= get_post_thumbnail_id();
			$image_details 	= wp_get_attachment_image_src($image_id, 'full');						
			$date 		= get_the_date("Y-m-d\TH:i:s\Z");
			$modified_date 	= get_the_modified_date("Y-m-d\TH:i:s\Z");
			$author_name 	= get_the_author();
                        $author_id      = get_the_author_meta('ID');   
                        
                        if(!$author_name){
				
                        $author_id    = get_post_field('post_author', $schema_post_id);
		        $author_name = get_the_author_meta( 'display_name' , $author_id ); 
                        
			}
                                                
                        $saswp_review_details   = esc_sql ( get_post_meta(get_the_ID(), 'saswp_review_details', true)); 
                        
                        $aggregateRating        = array();                                                
                        $saswp_over_all_rating  = '';
                        
                        if(isset($saswp_review_details['saswp-review-item-over-all'])){
                            
                        $saswp_over_all_rating = $saswp_review_details['saswp-review-item-over-all'];  
                        
                        }
                        
                        $saswp_review_item_enable = 0;
                        
                        if(isset($saswp_review_details['saswp-review-item-enable'])){
                            
                        $saswp_review_item_enable =  $saswp_review_details['saswp-review-item-enable'];  
                         
                        }  
                        
                        $saswp_review_count = "1";
                       
                        
                        if($saswp_over_all_rating && $saswp_review_count && $saswp_review_item_enable ==1 && isset($sd_data['saswp-review-module']) && $sd_data['saswp-review-module'] ==1){
                            
                           $aggregateRating =       array(
                                                            "@type"       => "AggregateRating",
                                                            "ratingValue" => $saswp_over_all_rating,
                                                            "reviewCount" => $saswp_review_count
                                                         ); 
                           
                        }
                                                                        
                        $service_object     = new saswp_output_service();
                        
                        $extra_theme_review = array();                        
                        $extra_theme_review = $service_object->saswp_extra_theme_review_details(get_the_ID());
                        
                        if( 'FAQ' === $schema_type){
                                                                                    
                            $input1 = array();
                                                                                                                                                                                                                               
                         }
                       
                        if( 'VideoGame' === $schema_type){
                                                                                    
                            $input1['@context']                     = saswp_context_url();
                            $input1['@type']                        = 'VideoGame';
                            $input1['@id']                          = trailingslashit(get_permalink()).'#VideoGame';                             
                            $input1['author']['@type']              = 'Organization';                                                        
                            $input1['offers']['@type']              = 'Offer';   
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                                                                                                                                                                                               
                            }
                        
                        if( 'MedicalCondition' === $schema_type){
                            
                            $input1['@context']                     = saswp_context_url();
                            $input1['@type']                        = 'MedicalCondition';
                            $input1['@id']                          = trailingslashit(get_permalink()).'#MedicalCondition';                                                                                                             
                            $input1['associatedAnatomy']['@type']   = 'AnatomicalStructure';                                                                                    
                            $input1['code']['@type']                = 'MedicalCode';
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                                                                                                                                                                                               
                            }
                        
                        if( 'TVSeries' === $schema_type){
                                                        
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'TVSeries';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#TVSeries';                                                                                                                                
                            $input1['author']['@type']       = 'Person';                            
                                                                           
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                
                            }
                        
                        if( 'HowTo' === $schema_type){
                                                         
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'HowTo';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#HowTo';                                                                                                                  
                            $input1['estimatedCost']['@type']   = 'MonetaryAmount';    
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                            }
                        
                        if( 'Trip' === $schema_type){
                                                                                   
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'Trip';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#Trip';    
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                           }
                        
                        if( 'SingleFamilyResidence' === $schema_type){
                                                                                                                                            
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'SingleFamilyResidence';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#SingleFamilyResidence';                            
                            $input1['address']['@type']      = 'PostalAddress';
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                            }
                        
                        if( 'House' === $schema_type){
                                                                            
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'House';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#House';
                            $input1['address']['@type']      = 'PostalAddress';
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                             
                            }
                            
                        if( 'Apartment' === $schema_type){
                                                                                   
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'Apartment';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#Apartment';                                                                                                                                                                            
                            $input1['address']['@type']      = 'PostalAddress';    
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                            }
                        
                        if( 'TouristDestination' === $schema_type){
                                                                                                                
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'TouristDestination';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#TouristDestination';                                                                                   
                            $input1['address']['@type']             = 'PostalAddress';
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                        
                            }
                        
                        if( 'TouristAttraction' === $schema_type){
                                                   
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'TouristAttraction';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#TouristAttraction';                              
                            $input1['address']['@type']      = 'PostalAddress';   
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                                                   
                            }
                        
                        if( 'LandmarksOrHistoricalBuildings' === $schema_type){
                                                   
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'LandmarksOrHistoricalBuildings';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#LandmarksOrHistoricalBuildings';                                                        
                            $input1['address']['@type']      = 'PostalAddress';   
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                        
                            }
                        
                        if( 'HinduTemple' === $schema_type){
                                                                                   
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'HinduTemple';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#HinduTemple';
                            $input1['address']['@type']             = 'PostalAddress';  
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                                                   
                           }
                        
                        if( 'Church' === $schema_type){
                                                                                  
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'Church';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#Church';                            
                            $input1['address']['@type']      = 'PostalAddress';
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                    
                            }
                        
                        if( 'Mosque' === $schema_type){
                                                                                                                
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'Mosque';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#Mosque';                            
                            $input1['address']['@type']      = 'PostalAddress';  
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                                                   
                            }
                        
                        if( 'JobPosting' === $schema_type){
                                                                                   
                            $input1['@context']                        = saswp_context_url();
                            $input1['@type']                           = 'JobPosting';
                            $input1['@id']                             = trailingslashit(get_permalink()).'#JobPosting';                                                          
                            $input1['hiringOrganization']['@type']     = 'Organization';                                                                                                                
                            $input1['jobLocation']['@type']            = 'Place';
                            $input1['jobLocation']['address']['@type'] = 'PostalAddress';                                                                                   
                            $input1['baseSalary']['@type']             = 'MonetaryAmount';                            
                            $input1['baseSalary']['value']['@type']    = 'QuantitativeValue';     
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                                                        
                            }
                        
                        if( 'Person' === $schema_type){
                                                                                                                                                                     
                            $input1['@context']              = saswp_context_url();
                            $input1['@type']                 = 'Person';
                            $input1['@id']                   = trailingslashit(get_permalink()).'#Person';                                                        
                            $input1['address']['@type']      = 'PostalAddress';             
                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                         }
                        
                        if( 'Course' === $schema_type){
                            
                        $description = saswp_get_the_excerpt();

                        if(!$description){
                            $description = get_bloginfo('description');
                        }
                         
                        $input1 = array(
			'@context'			=> saswp_context_url(),
			'@type'				=> $schema_type ,
                        '@id'				=> trailingslashit(get_permalink()).'#course',    
			'name'			        => saswp_get_the_title(),
			'description'                   => $description,			
			'url'				=> trailingslashit(get_permalink()),
			'datePublished'                 => esc_html($date),
			'dateModified'                  => esc_html($modified_date),
			'provider'			=> array(
                                                            '@type' 	        => 'Organization',
                                                            'name'		=> get_bloginfo(),
                                                            'sameAs'		=> get_home_url() 
                                                        )											
                            );
                                                                 
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                   $input1['comment'] = saswp_get_comments(get_the_ID());
                                }
                            
                            $input1 = apply_filters('saswp_modify_course_schema_output', $input1 );    
                        }
                                                
                        if( 'DiscussionForumPosting' === $schema_type){
                                                     
                            if(isset($sd_data['saswp-bbpress']) && $sd_data['saswp-bbpress'] == 1 && is_plugin_active('bbpress/bbpress.php')){                                                                                                                                                                                            
                                $input1 = array(
                                '@context'			=> saswp_context_url(),
                                '@type'				=> 'DiscussionForumPosting' ,
                                '@id'				=> bbp_get_topic_permalink().'#discussionforumposting',
                                'mainEntityOfPage'              => bbp_get_topic_permalink(), 
                                'headline'			=> bbp_get_topic_title(get_the_ID()),
                                'description'                   => saswp_get_the_excerpt(),
                                "articleSection"                => bbp_get_forum_title(),
                                "articleBody"                   => saswp_get_the_excerpt(),    
                                'url'				=> bbp_get_topic_permalink(),
                                'datePublished'                 => esc_html($date),
                                'dateModified'                  => esc_html($modified_date),
                                'author'			=> saswp_get_author_details(),                                    
                                'interactionStatistic'          => array(
                                                                    '@type'                     => 'InteractionCounter',
                                                                    'interactionType'		=> saswp_context_url().'/CommentAction',
                                                                    'userInteractionCount'      => bbp_get_topic_reply_count(),
                                        )    
                                );
                                
                            }else{
                                
                                $input1 = array(
                                '@context'			=> saswp_context_url(),
                                '@type'				=> 'DiscussionForumPosting' ,
                                '@id'				=> trailingslashit(get_permalink()).'#blogposting',    			
                                'url'				=> trailingslashit(get_permalink()),
                                'mainEntityOfPage'              => get_permalink(),       
                                'headline'			=> saswp_get_the_title(),
                                'description'                   => saswp_get_the_excerpt(),			                                
                                'datePublished'                 => esc_html($date),
                                'dateModified'                  => esc_html($modified_date),
                                'author'			=> saswp_get_author_details()											
                                );
                                
                            }                                                                                                    
                                if(!empty($publisher)){

                                     $input1 = array_merge($input1, $publisher);   

                                 }
                                 
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] == 1){
                                   $input1['comment'] = saswp_get_comments(get_the_ID());
                                }
                            
                                $input1 = apply_filters('saswp_modify_d_forum_posting_schema_output', $input1 ); 
                        }
                        
                        if( 'Blogposting' === $schema_type){
                         
                        $input1 = array(
			'@context'			=> saswp_context_url(),
			'@type'				=> 'BlogPosting' ,
                        '@id'				=> trailingslashit(get_permalink()).'#blogposting',    
			'mainEntityOfPage'              => trailingslashit(get_permalink()),
			'headline'			=> saswp_get_the_title(),
			'description'                   => saswp_get_the_excerpt(),
                        'articleBody'                   => saswp_get_the_content(), 
                        'keywords'                      => saswp_get_the_tags(),    
			'name'				=> saswp_get_the_title(),
			'url'				=> trailingslashit(get_permalink()),
			'datePublished'                 => esc_html($date),
			'dateModified'                  => esc_html($modified_date),
			'author'			=> saswp_get_author_details()											
                        );
                                if(!empty($publisher)){
                            
                                     $input1 = array_merge($input1, $publisher);   
                         
                                 }
                                 
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] == 1){
                                   $input1['comment'] = saswp_get_comments(get_the_ID());
                                }
                            
                                $input1 = apply_filters('saswp_modify_blogposting_schema_output', $input1 ); 
                        }
                        
                        if( 'AudioObject' === $schema_type){
                                                                                                     
                        $input1 = array(
			'@context'			=> saswp_context_url(),
			'@type'				=> $schema_type ,	
                        '@id'				=> trailingslashit(get_permalink()).'#audioobject',     			
			'datePublished'                 => esc_html($date),
			'dateModified'                  => esc_html($modified_date),
			'author'			=> saswp_get_author_details()			
                            );
                                if(!empty($publisher)){
                            
                                     $input1 = array_merge($input1, $publisher);   
                         
                                }
                                 
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                    $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }   
                                
                                $input1 = apply_filters('saswp_modify_audio_object_schema_output', $input1 );
                        }
                        
                        if( 'Event' === $schema_type){
                                                   
                        if(!saswp_non_amp() && is_plugin_active('the-events-calendar/the-events-calendar.php') && isset($sd_data['saswp-the-events-calendar']) && $sd_data['saswp-the-events-calendar'] == 1  ){
                            
                            $input1            = Tribe__Events__JSON_LD__Event::instance()->get_data();  
                            
                            if(!empty($input1)){
                                
                                $input1            = array_values( $input1 );
                                $input1            = json_encode($input1);
                                $input1            = json_decode($input1, true); 
                                $input1            = $input1[0];
                            }                                                                                    
                                                       
                        }else{
                           
                        if ( isset($sd_data['saswp-the-events-calendar']) && $sd_data['saswp-the-events-calendar'] == 0 ) {
                                                        
                                $input1['@context'] =  saswp_context_url();
                                $input1['@type']    =  $schema_type;
                                $input1['@id']      =  trailingslashit(get_permalink()).'#event';
                                                       
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                   $input1['comment'] = saswp_get_comments(get_the_ID());
                                }                            
                                
                            } 
                            
                        }    
                            
                        $input1 = apply_filters('saswp_modify_event_schema_output', $input1 );
                        
                        }
                        
                        if( 'SoftwareApplication' === $schema_type){
                                                                                                           
                                $input1 = array(
                                '@context'			=> saswp_context_url(),
                                '@type'				=> $schema_type ,
                                '@id'				=> trailingslashit(get_permalink()).'#softwareapplication',         						                        
                                'datePublished'                 => esc_html($date),
                                'dateModified'                  => esc_html($modified_date),
                                'author'			=> saswp_get_author_details()			
                                );
                        
                                                                  
                                if(!empty($publisher)){
                            
                                     $input1 = array_merge($input1, $publisher);   
                         
                                 }
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }                               
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                            $input1['comment'] = saswp_get_comments(get_the_ID());
                                }    
                                
                                $input1 = apply_filters('saswp_modify_software_application_schema_output', $input1 );
                        }
			
			if( 'WebPage' === $schema_type){                            				
                                
                                $service = new saswp_output_service();
                                $input1 = $service->saswp_schema_markup_generator($schema_type);
				
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }                                
                                if(!empty($aggregateRating)){
                                    $input1['mainEntity']['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                             $input1 = apply_filters('saswp_modify_webpage_schema_output', $input1 );   
			}	
		
			if( 'Article' === $schema_type ){
                            
                                $service = new saswp_output_service();
                                $input1 = $service->saswp_schema_markup_generator($schema_type);
				
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                                $input1 = apply_filters('saswp_modify_article_schema_output', $input1 );  
			}
                        
                        if( 'TechArticle' === $schema_type ){
                                
                                $service = new saswp_output_service();
                                $input1 = $service->saswp_schema_markup_generator($schema_type);
				
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] == 1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                                $input1 = apply_filters('saswp_modify_tech_article_schema_output', $input1 );
			}
		      
			if( 'Recipe' === $schema_type){
                        
                            if(isset($sd_data['saswp-wp-recipe-maker']) && $sd_data['saswp-wp-recipe-maker'] == 1){
                                                              
                                $recipe_ids = saswp_get_ids_from_content_by_type('wp_recipe_maker');
                                                                
                                if($recipe_ids){

                                    foreach($recipe_ids as $recipe){

                                        if(class_exists('WPRM_Recipe_Manager')){
                                            $recipe_arr    = WPRM_Recipe_Manager::get_recipe( $recipe );
                                            $recipe_json[] = saswp_wp_recipe_schema_json($recipe_arr);                                            
                                        }

                                    }  
                                    
                                 }
                                
                                 
                            }else{
                                
                               if(empty($image_details[0]) || $image_details[0] === NULL ){
					$image_details[0] = $sd_data['sd_logo']['url'];
				}
                                
				$input1 = array(
				'@context'			=> saswp_context_url(),
				'@type'				=> $schema_type ,
                                '@id'				=> trailingslashit(get_permalink()).'#recipe',    
				'url'				=> trailingslashit(get_permalink()),
				'name'			        => saswp_get_the_title(),
				'datePublished'                 => esc_html($date),
				'dateModified'                  => esc_html($modified_date),
				'description'                   => saswp_get_the_excerpt(),
				'mainEntity'                    => array(
						'@type'				=> 'WebPage',
						'@id'				=> trailingslashit(get_permalink()),
						'author'			=> saswp_get_author_details()						                                                                                    
					),                                        					
				
				);
                                
                                if(!empty($publisher)){
                            
                                     $input1['mainEntity'] = array_merge($input1['mainEntity'], $publisher);   
                         
                                 }
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }                                 
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                                
                            }
                            				                                
                               $input1 = apply_filters('saswp_modify_recipe_schema_output', $input1 );
			}
                       
                        if( 'qanda' === $schema_type){
                            
                            
                            if(isset($sd_data['saswp-dw-question-answer']) && $sd_data['saswp-dw-question-answer'] ==1){
                            
                                $service_object = new saswp_output_service();
                                $input1  = $service_object->saswp_dw_question_answers_details(get_the_ID()); 
                                
                            }

                            if(isset($sd_data['saswp-bbpress']) && $sd_data['saswp-bbpress'] ==1){
                            
                                $service_object = new saswp_output_service();
                                $input1  = $service_object->saswp_bb_press_topic_details(get_the_ID()); 
                                
                            }
                                                                                                                                            
                            if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                            }
                            
                            $input1 = apply_filters('saswp_modify_qanda_schema_output', $input1 );
			}
                                                                      
			if( 'Product' === $schema_type){
                            		                                                                
                                $service = new saswp_output_service();
                                $product_details = $service->saswp_woocommerce_product_details(get_the_ID());  
                               
                                if((isset($sd_data['saswp-woocommerce']) && $sd_data['saswp-woocommerce'] == 1) && !empty($product_details)){
                                    
                                    $input1 = array(
                                    '@context'			        => saswp_context_url(),
                                    '@type'				=> 'Product',
                                    '@id'				=> trailingslashit(get_permalink()).'#product',     
                                    'url'				=> trailingslashit(get_permalink()),
                                    'name'                              => saswp_remove_warnings($product_details, 'product_name', 'saswp_string'),
                                    'sku'                               => saswp_remove_warnings($product_details, 'product_sku', 'saswp_string'),    
                                    'description'                       => saswp_remove_warnings($product_details, 'product_description', 'saswp_string'),                                    
                                    'offers'                            => array(
                                                                                '@type'	=> 'Offer',
                                                                                'availability'      => saswp_remove_warnings($product_details, 'product_availability', 'saswp_string'),
                                                                                'price'             => saswp_remove_warnings($product_details, 'product_price', 'saswp_string'),
                                                                                'priceCurrency'     => saswp_remove_warnings($product_details, 'product_currency', 'saswp_string'),
                                                                                'url'               => trailingslashit(get_permalink()),
                                                                                'priceValidUntil'   => saswp_remove_warnings($product_details, 'product_priceValidUntil', 'saswp_string'),
                                                                             ),
                                        
				  );
                                    
                                  if(isset($product_details['product_image'])){
                                    $input1 = array_merge($input1, $product_details['product_image']);
                                  }  
                                    
                                  if(isset($product_details['product_gtin8']) && $product_details['product_gtin8'] !=''){
                                    $input1['gtin8'] = esc_attr($product_details['product_gtin8']);  
                                  }
                                  if(isset($product_details['product_mpn']) && $product_details['product_mpn'] !=''){
                                    $input1['mpn'] = esc_attr($product_details['product_mpn']);  
                                  }
                                  if(isset($product_details['product_isbn']) && $product_details['product_isbn'] !=''){
                                    $input1['isbn'] = esc_attr($product_details['product_isbn']);  
                                  }
                                  if(isset($product_details['product_brand']) && $product_details['product_brand'] !=''){
                                    $input1['brand'] =  array('@type'=>'Thing','name'=> esc_attr($product_details['product_brand']));  
                                  }                                     
                                  if(isset($product_details['product_review_count']) && $product_details['product_review_count'] >0 && isset($product_details['product_average_rating']) && $product_details['product_average_rating'] >0){
                                       $input1['aggregateRating'] =  array(
                                                                        '@type'         => 'AggregateRating',
                                                                        'ratingValue'	=> esc_attr($product_details['product_average_rating']),
                                                                        'reviewCount'   => (int)esc_attr($product_details['product_review_count']),       
                                       );
                                  }                                      
                                  if(!empty($product_details['product_reviews'])){
                                      
                                      $reviews = array();
                                      
                                      foreach ($product_details['product_reviews'] as $review){
                                          
                                          $reviews[] = array(
                                                                        '@type'	=> 'Review',
                                                                        'author'	=> esc_attr($review['author']),
                                                                        'datePublished'	=> esc_html($review['datePublished']),
                                                                        'description'	=> $review['description'],  
                                                                        'reviewRating'  => array(
                                                                                '@type'	=> 'Rating',
                                                                                'bestRating'	=> '5',
                                                                                'ratingValue'	=> esc_attr($review['reviewRating']),
                                                                                'worstRating'	=> '1',
                                                                        )  
                                          );
                                          
                                      }
                                      $input1['review'] =  $reviews;
                                  }
                                  
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                    
                                }                                  
                                }else{
                                    
                                    $input1['@context']              = saswp_context_url();
                                    $input1['@type']                 = 'Product';
                                    $input1['@id']                   = trailingslashit(get_permalink()).'#Product';                                                                                                                                                                                                                 

                                    if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){                                   
                                            $service = new saswp_output_service();
                                            $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                    }
                                    
                                }                                                                
                                
                                $input1 = apply_filters('saswp_modify_product_schema_output', $input1 );
			}
                        
                        if( 'NewsArticle' === $schema_type ){                              
                            
                            $category_detail = get_the_category(get_the_ID());//$post->ID
                            $article_section = '';
                            
                            foreach($category_detail as $cd){
                                
                                $article_section =  $cd->cat_name;
                            
                            }
                                $word_count = saswp_reading_time_and_word_count();
				$input1 = array(
					'@context'			=> saswp_context_url(),
					'@type'				=> $schema_type ,
                                        '@id'				=> trailingslashit(get_permalink()).'#newsarticle',
					'url'				=> trailingslashit(get_permalink()),
					'headline'			=> saswp_get_the_title(),
                                        'mainEntityOfPage'	        => get_the_permalink(),            
					'datePublished'                 => esc_html($date),
					'dateModified'                  => esc_html($modified_date),
					'description'                   => saswp_get_the_excerpt(),
                                        'articleSection'                => $article_section,            
                                        'articleBody'                   => saswp_get_the_content(), 
                                        'keywords'                      => saswp_get_the_tags(),
					'name'				=> saswp_get_the_title(), 					
					'thumbnailUrl'                  => saswp_remove_warnings($image_details, 0, 'saswp_string'),
                                        'wordCount'                     => saswp_remove_warnings($word_count, 'word_count', 'saswp_string'),
                                        'timeRequired'                  => saswp_remove_warnings($word_count, 'timerequired', 'saswp_string'),            
					'mainEntity'                    => array(
                                                                            '@type' => 'WebPage',
                                                                            '@id'   => trailingslashit(get_permalink()),
						), 
					'author'			=> saswp_get_author_details()					                                                    
					);
                                if(!empty($publisher)){
                            
                                     $input1 = array_merge($input1, $publisher);   
                         
                                 }
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                }
                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                    $input1['comment'] = saswp_get_comments(get_the_ID());
                                }                
                                                                
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                                $input1 = apply_filters('saswp_modify_news_article_schema_output', $input1 );
				}
                                                
                        if( 'Service' === $schema_type ){  
                                                                                                 
				$input1['@context'] =  saswp_context_url();
                                $input1['@type']    =  $schema_type;
                                $input1['@id']      =  trailingslashit(get_permalink()).'#service';
                                                                
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] == 1){
                                    
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                    
                                } 
                                                                                                
                                if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                }                                
                                if(!empty($extra_theme_review)){
                                   $input1 = array_merge($input1, $extra_theme_review);
                                }
                                
                                $input1 = apply_filters('saswp_modify_service_schema_output', $input1 );
				}  
                        
                        if( 'Review' === $schema_type ){  
                                 
                        
                         if(isset($sd_data['saswp-tagyeem']) && $sd_data['saswp-tagyeem'] == 1 && (is_plugin_active('taqyeem/taqyeem.php') || get_template() != 'jannah') ){                                                                                                      
                           
                             remove_action( 'TieLabs/after_post_entry',  'tie_article_schemas' );
                             
                            $input1 = array(
                                    '@context'       => saswp_context_url(),
                                    '@type'          => 'Review',
                                    '@id'	     => trailingslashit(get_permalink()).'#review',
                                    'dateCreated'    => esc_html($date),
                                    'datePublished'  => esc_html($date),
                                    'dateModified'   => esc_html($modified_date),
                                    'headline'       => saswp_get_the_title(),
                                    'name'           => saswp_get_the_title(),
                                    'keywords'       => tie_get_plain_terms( get_the_ID(), 'post_tag' ),
                                    'url'            => trailingslashit(get_permalink()),
                                    'description'    => saswp_get_the_excerpt(),
                                    'articleBody'    => saswp_get_the_content(),
                                    'copyrightYear'  => get_the_time( 'Y' ),                                                                                                           
                                    'author'	     => saswp_get_author_details()                                                        
                                
                                    );
                                    
                                    $total_score = (int) get_post_meta( get_the_ID(), 'taq_review_score', true );
                                    
                                    if( ! empty( $total_score ) && $total_score > 0 ){
                                        
                                        $total_score = round( ($total_score*5)/100, 1 );
                                    
                                    }
                                    
                                    $input1['itemReviewed'] = array(
                                            '@type' => 'Thing',
                                            'name'  => saswp_get_the_title(),
                                    );

                                    $input1['reviewRating'] = array(
                                        '@type'       => 'Rating',
                                        'worstRating' => 1,
                                        'bestRating'  => 5,
                                        'ratingValue' => esc_attr($total_score),
                                        'description' => get_post_meta( get_the_ID(), 'taq_review_summary', true ),
                                     );    
                                                                                   
                         } else {
                             
                             $schema_data = saswp_get_schema_data($schema_post_id, 'saswp_review_schema_details');  
                                                        
                            if(isset($schema_data['saswp_review_schema_item_type'])){
                                                                                                                                                                                            
                                $input1['@context']                     = saswp_context_url();
                                $input1['@type']                        = esc_attr($schema_type);
                                $input1['url']                          = trailingslashit(get_permalink());                                
                                $input1['datePublished']                = esc_html($date);
                                $input1['dateModified']                 = esc_html($modified_date);
                                $input1['reviewBody']                   = saswp_get_the_excerpt();
                                $input1['description']                  = saswp_get_the_excerpt();
                                $input1['itemReviewed']['@type']        = esc_attr($schema_data['saswp_review_schema_item_type']);   
                             
                                $service = new saswp_output_service();
                            
                                
                            switch ($schema_data['saswp_review_schema_item_type']) {
                                
                                case 'Article':
                                    
                                    $markup = $service->saswp_schema_markup_generator($schema_data['saswp_review_schema_item_type']);                                    
                                    $input1['itemReviewed'] = $markup;
                                    
                                    break;
                                case 'Adultentertainment':
                                    $input1 = $input1;
                                    break;
                                case 'Blog':
                                    $input1 = $input1;
                                    break;
                                case 'Book':
                                    
                                    if(isset($schema_data['saswp_review_schema_isbn'])){
                                        
                                        $input1['itemReviewed']['isbn'] = $schema_data['saswp_review_schema_isbn'];
                                                
                                    }
                                    if($review_author)   {
                                        
                                    $input1['itemReviewed']['author']['@type']              = 'Person';      
                                    $input1['itemReviewed']['author']['name']               = esc_attr($review_author);
                                    $input1['itemReviewed']['author']['sameAs']             = esc_url($schema_data['saswp_review_schema_author_sameas']);   
                                    
                                    }                                                                          
                                    break;                                
                                case 'Movie':                                                                                                           
                                    if($review_author){                                    
                                        $input1['author']['sameAs']   = trailingslashit(get_permalink());                                        
                                    }                                                                        
                                    break;                                
                                case 'WebPage':                                     
                                    $markup = $service->saswp_schema_markup_generator($schema_data['saswp_review_schema_item_type']);                                                                       
                                    $input1['itemReviewed'] = $markup;                                    
                                    break;
                                case 'WebSite':
                                    break;
                                default:
                                    $input1 = $input1;
                                 break;
                            }
                                
                               if(!empty($publisher)){                            
                                     $input1 = array_merge($input1, $publisher);                            
                                }
                                
                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                    
                                    $service = new saswp_output_service();
                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                    
                                }                                                            
                            }
                             
                         }  
                              
                         $input1 = apply_filters('saswp_modify_review_schema_output', $input1 );
		        }          
                                			
			if( 'VideoObject' === $schema_type){
                            
                                            if(empty($image_details[0]) || $image_details[0] === NULL ){

                                                    if(isset($sd_data['sd_logo'])){
                                                        $image_details[0] = $sd_data['sd_logo']['url'];
                                                    }

                                            }				
                                                $description = saswp_get_the_excerpt();

                                                if(!$description){
                                                    $description = get_bloginfo('description');
                                                }                                                                                                                        
						$input1 = array(
						'@context'			=> saswp_context_url(),
						'@type'				=> 'VideoObject',
                                                '@id'                           => trailingslashit(get_permalink()).'#videoobject',        
						'url'				=> trailingslashit(get_permalink()),
						'headline'			=> saswp_get_the_title(),
						'datePublished'                 => esc_html($date),
						'dateModified'                  => esc_html($modified_date),
						'description'                   => $description,
						'name'				=> saswp_get_the_title(),
						'uploadDate'                    => esc_html($date),
						'thumbnailUrl'                  => isset($image_details[0]) ? esc_url($image_details[0]):'',
						'mainEntity'                    => array(
								'@type'				=> 'WebPage',
								'@id'				=> trailingslashit(get_permalink()),
								), 
						'author'			=> saswp_get_author_details()						                                                                                                      
						);
                                                 if(!empty($publisher)){
                            
                                                    $input1 = array_merge($input1, $publisher);   
                         
                                                 }
                                                if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] ==1){
                                                    $service = new saswp_output_service();
                                                    $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);
                                                }
                                                if(isset($sd_data['saswp_comments_schema']) && $sd_data['saswp_comments_schema'] ==1){
                                                 $input1['comment'] = saswp_get_comments(get_the_ID());
                                                }                                                
                                                if(!empty($aggregateRating)){
                                                       $input1['aggregateRating'] = $aggregateRating;
                                                 }                                               
                                                if(!empty($extra_theme_review)){
                                                  $input1 = array_merge($input1, $extra_theme_review);
                                                 }
					
                                        $input1 = apply_filters('saswp_modify_video_object_schema_output', $input1 );
				}
                        
                        if( 'local_business' === $schema_type){
                            
                                $business_type    = esc_sql ( get_post_meta($schema_post_id, 'saswp_business_type', true)  );                                 
                                $business_name    = esc_sql ( get_post_meta($schema_post_id, 'saswp_business_name', true)  );                                                                
                                                                                                
                                if($business_name){
                                    
                                $local_business = $business_name;    
                                
                                }else if($business_type){
                                    
                                $local_business = $business_type;        
                                
                                }else{
                                    $local_business = 'LocalBusiness';
                                } 
                                
				$input1 = array(
                                    '@context'			=> saswp_context_url(),
                                    '@type'				=> esc_attr($local_business),
                                    '@id'                           => trailingslashit(get_permalink()).'#'. strtolower(esc_attr($local_business)),                                            
                                    'url'				=> trailingslashit(get_permalink()),								
				);  
                                    if(isset($schema_options['enable_custom_field']) && $schema_options['enable_custom_field'] == 1){                                        
                                        $service = new saswp_output_service();
                                        $input1 = $service->saswp_replace_with_custom_fields_value($input1, $schema_post_id);                                    
                                    }                                         
                                    if(!empty($aggregateRating)){
                                    $input1['aggregateRating'] = $aggregateRating;
                                    }                                    
                                    if(!empty($extra_theme_review)){
                                    $input1 = array_merge($input1, $extra_theme_review);
                                    }
                                                                                                            
                                    $input1 = apply_filters('saswp_modify_local_business_schema_output', $input1 );
			}
                                                
                        //Speakable schema
                        
                        if($schema_type == 'TechArticle' || $schema_type == 'Article' || $schema_type == 'Blogposting' || $schema_type == 'NewsArticle' || $schema_type == 'WebPage'){
                                           
                              $speakable_status = get_post_meta($schema_post_id, 'saswp_enable_speakable_schema', true);
                            
                              if($speakable_status){
                            
                                  $input1['speakable']['@type'] = 'SpeakableSpecification';
                                  $input1['speakable']['xpath'] = array(
                                         "/html/head/title",
                                         "/html/head/meta[@name='description']/@content"
                                    );
                                  
                              }
                            
                           
                        }
                        
                        if($schema_type !='Review' || (isset($sd_data['saswp-the-events-calendar']) && $sd_data['saswp-the-events-calendar'] == 0) || (isset($sd_data['saswp-woocommerce']) && $sd_data['saswp-woocommerce'] == 0)){
                            
                            //kk star rating 
                        
                                $kkstar_aggregateRating = saswp_extract_kk_star_ratings();
                                
                                if(!empty($kkstar_aggregateRating)){
                                    $input1['aggregateRating'] = $kkstar_aggregateRating; 
                                }

                                //wp post-rating star rating 

                                $wp_post_rating_ar = saswp_extract_wp_post_ratings();

                                if(!empty($wp_post_rating_ar)){
                                    $input1['aggregateRating'] = $wp_post_rating_ar; 
                                }                            
                            
                        }                                                
                                
                        //Check for Featured Image
                        
                         if( !empty($input1) && !isset($input1['image'])){
                             
                             $service_object     = new saswp_output_service();
                             $input2             = $service_object->saswp_get_fetaure_image();
                             
                             if(!empty($input2)){
                                 
                               $input1 = array_merge($input1,$input2); 
                               
                             }                                                                    
                        }
               
		if(isset($schema_options['notAccessibleForFree']) && $schema_options['notAccessibleForFree'] == 1){

			add_filter( 'amp_post_template_data', 'saswp_structure_data_access_scripts');			
                        
			$paywall_class_name  = $schema_options['paywall_class_name'];
			$isAccessibleForFree = isset($schema_options['isAccessibleForFree'])? $schema_options['isAccessibleForFree']: False;

			if($paywall_class_name != ""){
                            
				if(strpos($paywall_class_name, ".") == -1){
                                    
					$paywall_class_name = ".".$paywall_class_name;
                                        
				}
                                
				$paywallData = array("isAccessibleForFree"=> $isAccessibleForFree,
                                                     "hasPart"=>array(
                                                                "@type"               => "WebPageElement",
                                                                "isAccessibleForFree" => esc_attr($isAccessibleForFree),
                                                                "cssSelector"         => '.'.esc_attr($paywall_class_name)
                                                              )
                                                          );
                                
				$input1 = array_merge($input1,$paywallData);
			}
		} 
                
                $input1 = apply_filters('saswp_modify_woocommerce_membership_schema', $input1);
                
                if(!empty($input1)){
                    $all_schema_output[] = $input1;		                    
                }                
               
        }   
                
        if($recipe_json){
            foreach($recipe_json as $json){
                array_push($all_schema_output, $json);
            }
        }
        
        return apply_filters('saswp_modify_schema_output', $all_schema_output);
}
/**
 * Function generates breadcrumbs schema markup
 * @global type $sd_data
 * @param type $sd_data
 * @return type
 */
function saswp_schema_breadcrumb_output(){
    
	global $sd_data;        
        
	if(isset($sd_data['saswp_breadcrumb_schema']) && $sd_data['saswp_breadcrumb_schema'] == 1){
				       				
        if(is_single() || is_page() ||is_archive()){
            
        $bread_crumb_list =   saswp_list_items_generator();  
        
        if(!empty($bread_crumb_list)){   
            
                $input = array(
					'@context'			=> saswp_context_url(),
					'@type'				=> 'BreadcrumbList' ,
                                        '@id'				=>  trailingslashit(get_permalink()).'#breadcrumb' ,
					'itemListElement'	        => $bread_crumb_list,
			); 
           
                return apply_filters('saswp_modify_breadcrumb_output', $input);  
         
             }
               
           }         
	
	}
}

/**
 * Function generates website schema markup
 * @return type json
 */
function saswp_kb_website_output(){
    	        
                global $sd_data;
                
                $input = array();
                
                if(isset($sd_data['saswp_website_schema']) && $sd_data['saswp_website_schema'] == 1 || !isset($sd_data['saswp_website_schema'])){
                 
                $site_url  = get_site_url();
		$site_name = get_bloginfo();
                
                if($site_url && $site_name){
                 
                    $input = array(
                            '@context'	          => saswp_context_url(),
                            '@type'		  => 'WebSite',
                            '@id'		  => $site_url.'#website',
                            'headline'		  => $site_name,                            
                            'name'		  => $site_name,
                            'description'	  => get_bloginfo('description'),
                            'url'		  => $site_url,
			);  
                    
                    if(isset($sd_data['saswp_search_box_schema']) && $sd_data['saswp_search_box_schema'] == 1 || !isset($sd_data['saswp_search_box_schema'])){
                        
                        $input['potentialAction']['@type']       = 'SearchAction';
                        $input['potentialAction']['target']      = esc_url($site_url).'/?s={search_term_string}';
                        $input['potentialAction']['query-input'] = 'required name=search_term_string';
                        
                    }
                  }                                        
                }                		                		
	
	return apply_filters('saswp_modify_website_output', $input);       
}	

/**
 * Function generates archive page schema markup in the form of CollectionPage schema type
 * @global type $query_string
 * @global type $sd_data
 * @return type json
 */
function saswp_archive_output(){
    
	global $query_string, $sd_data;   
        
        $site_name ='';
        
        if(isset($sd_data['sd_name']) && $sd_data['sd_name'] !=''){
          $site_name = $sd_data['sd_name'];  
        }else{
          $site_name = get_bloginfo();    
        } 	
        	
	if(isset($sd_data['saswp_archive_schema']) && $sd_data['saswp_archive_schema'] == 1){
            
        $schema_type        =  $sd_data['saswp_archive_schema_type'];   
            
        $service_object     = new saswp_output_service();
        $logo               = $service_object->saswp_get_publisher(true);    
            					
	if ( is_category() ) {
            
		$category_posts = array();
                $item_list      = array();                
                
                $i = 1;
		$category_loop = new WP_Query( $query_string );
		if ( $category_loop->have_posts() ):
			while( $category_loop->have_posts() ): $category_loop->the_post();
				$image_id 		= get_post_thumbnail_id();
                                
                                $archive_image = array();
				$image_details 	        = wp_get_attachment_image_src($image_id, 'full');  
                                
                                if(!empty($image_details)){
                                
                                        $archive_image['@type']  = 'ImageObject';
                                        $archive_image['url']    = esc_url($image_details[0]);
                                        $archive_image['width']  = esc_attr($image_details[1]);
                                        $archive_image['height'] = esc_attr($image_details[2]);                                 
                                    
                                }else{
                                    
                                    if(isset($sd_data['sd_default_image'])){
                                        
                                        $archive_image['@type']  = 'ImageObject';
                                        $archive_image['url']    = esc_url($sd_data['sd_default_image']['url']);
                                        $archive_image['width']  = esc_attr($sd_data['sd_default_image_width']);
                                        $archive_image['height'] = esc_attr($sd_data['sd_default_image_height']);                                  
                                    }
                                                                        
                                }
                                                                
                                $publisher_info['type']  = 'Organization';                                
                                $publisher_info['name']  = esc_attr($site_name);
                                $publisher_info['logo']['@type']  = 'ImageObject';
                                $publisher_info['logo']['url']    = isset($logo['url'])    ? esc_attr($logo['url']):'';
                                $publisher_info['logo']['width']  = isset($logo['width'])  ? esc_attr($logo['width']):'';
                                $publisher_info['logo']['height'] = isset($logo['height']) ? esc_attr($logo['height']):'';
                                                                                                                                								                               
                                $schema_properties['@type']            = esc_attr($schema_type);
                                $schema_properties['headline']         = saswp_get_the_title();
                                $schema_properties['url']              = get_the_permalink();                                                                                                
                                $schema_properties['datePublished']    = get_the_date('c');
                                $schema_properties['dateModified']     = get_the_modified_date('c');
                                $schema_properties['mainEntityOfPage'] = get_the_permalink();
                                $schema_properties['author']           = get_the_author();
                                $schema_properties['publisher']        = $publisher_info;                                
                                                                                                
                                if(!empty($archive_image['url'])){                                
                                    $schema_properties['image']            = $archive_image;                                    
                                }
                                                                                                
                                $category_posts[] =  $schema_properties;
                                                                                                                                                                                                
                                $item_list[] = array(
                                         '@type' 		=> 'ListItem',
                                         'position' 		=> $i,
                                         'url' 		        => get_the_permalink(),
                                         
                                );
                                
				$i++;
	        endwhile;

		wp_reset_postdata();
			
		$category 		= get_the_category(); 		
		$category_id 		= intval($category[0]->term_id); 
                $category_link 		= get_category_link( $category_id );
		$category_link          = get_term_link( $category[0]->term_id , 'category' );
                $category_headline 	= single_cat_title( '', false ) . __(' Category', 'schema-wp');	
                
		$collection_page = array
       		(
				'@context' 		=> saswp_context_url(),
				'@type' 		=> "CollectionPage",
                                '@id' 		        => trailingslashit(esc_url($category_link)).'#CollectionPage',
				'headline' 		=> esc_attr($category_headline),
				'description' 	        => strip_tags(category_description()),
				'url'		 	=> esc_url($category_link),				
				'hasPart' 		=> $category_posts
       		);
                
                $blog_page = array
       		(
				'@context' 		=> saswp_context_url(),
				'@type' 		=> "Blog",
                                '@id' 		        => trailingslashit(esc_url($category_link)).'#Blog',
				'headline' 		=> esc_attr($category_headline),
				'description' 	        => strip_tags(category_description()),
				'url'		 	=> esc_url($category_link),				
				'blogPost' 		=> $category_posts
       		);
                                
                $item_list_schema['@context']        = saswp_context_url();
                $item_list_schema['@type']           = 'ItemList';
                $item_list_schema['itemListElement'] = $item_list;
                                
                if($schema_type == 'BlogPosting'){
                    $output = array($item_list_schema, $collection_page, $blog_page);
                }else{
                    $output = array($item_list_schema, $collection_page, array());
                }
                                                                
		return apply_filters('saswp_modify_archive_output', $output);
                
	endif;				
	}
	} 
}

/**
 * Function generates author schema markup
 * @global type $post
 * @global type $sd_data
 * @return type json
 */ 
function saswp_author_output(){
    
	global $post, $sd_data;   
        $post_id ='';
        
	if(isset($sd_data['saswp_archive_schema']) && $sd_data['saswp_archive_schema'] == 1){
            
        if(is_object($post)){
        
            $post_id = $post->ID;
            
        }    
            	
	if(is_author() && $post_id){
		// Get author from post content
		$post_content	= get_post($post_id);                
		$post_author	= get_userdata($post_content->post_author);		
		$input = array (
			'@type'	=> 'Person',
			'name'	=> get_the_author_meta('display_name'),
			'url'	=> esc_url( get_author_posts_url( $post_author->ID ) ),

		);

		$sd_website 	= esc_attr( stripslashes( get_the_author_meta( 'user_url', $post_author->ID ) ) );
		$sd_googleplus  = esc_attr( stripslashes( get_the_author_meta( 'googleplus', $post_author->ID ) ) );
		$sd_facebook 	= esc_attr( stripslashes( get_the_author_meta( 'facebook', $post_author->ID) ) );
		$sd_twitter 	= esc_attr( stripslashes( get_the_author_meta( 'twitter', $post_author->ID ) ) );
		$sd_instagram 	= esc_attr( stripslashes( get_the_author_meta( 'instagram', $post_author->ID ) ) );
		$sd_youtube 	= esc_attr( stripslashes( get_the_author_meta( 'youtube', $post_author->ID ) ) );
		$sd_linkedin 	= esc_attr( stripslashes( get_the_author_meta( 'linkedin', $post_author->ID ) ) );
		$sd_pinterest 	= esc_attr( stripslashes( get_the_author_meta( 'pinterest', $post_author->ID ) ) );
		$sd_soundcloud  = esc_attr( stripslashes( get_the_author_meta( 'soundcloud', $post_author->ID ) ) );
		$sd_tumblr 	= esc_attr( stripslashes( get_the_author_meta( 'tumblr', $post_author->ID ) ) );
		
		$sd_sameAs_links = array( $sd_website, $sd_googleplus, $sd_facebook, $sd_twitter, $sd_instagram, $sd_youtube, $sd_linkedin, $sd_pinterest, $sd_soundcloud, $sd_tumblr);
		
		$sd_social = array();
		
		// Remove empty fields
		foreach( $sd_sameAs_links as $sd_sameAs_link ) {
			if ( '' != $sd_sameAs_link ) $sd_social[] = $sd_sameAs_link;
		}
		
		if ( ! empty($sd_social) ) {
			$input["sameAs"] = $sd_social;
		}

		if ( get_the_author_meta( 'description', $post_author->ID ) ) {
			$input['description'] = strip_tags( get_the_author_meta( 'description', $post_author->ID ) );
		}
		return apply_filters('saswp_modify_author_output', $input);
	}
 }
}

/**
 * Function generates about page schema markup
 * @global type $sd_data
 * @return type json
 */
function saswp_about_page_output(){

	global $sd_data;   
        $feature_image = array();
        $publisher     = array();
        
	if((isset($sd_data['sd_about_page'])) && $sd_data['sd_about_page'] == get_the_ID()){   
            
                        $service_object     = new saswp_output_service();
                        $feature_image      = $service_object->saswp_get_fetaure_image();
                        $publisher          = $service_object->saswp_get_publisher();
                        
			$input = array(
				"@context" 	   => saswp_context_url(),
				"@type"		   => "AboutPage",
				"mainEntityOfPage" => array(
                                                            "@type"           => "WebPage",
                                                            "@id"             => trailingslashit(get_permalink()),
						),
				"url"		   => trailingslashit(get_permalink()),
				"headline"	   => saswp_get_the_title(),								
				'description'	   => saswp_get_the_excerpt(),
			);
                        
			if(!empty($feature_image)){
                            
                            $input = array_merge($input, $feature_image);   
                         
                        }
                        if(!empty($publisher)){
                            
                            $input = array_merge($input, $publisher);   
                         
                        }
			return apply_filters('saswp_modify_about_page_output', $input);                       
	}
	
}

/**
 * Function generates contact page schema markup
 * @global type $sd_data
 * @return type json
 */
function saswp_contact_page_output(){
    
	global $sd_data;	        	        
        $feature_image = array();
        $publisher     = array();
        
	if(isset($sd_data['sd_contact_page']) && $sd_data['sd_contact_page'] == get_the_ID()){
                        
                        $service_object     = new saswp_output_service();
                        $feature_image      = $service_object->saswp_get_fetaure_image();
                        $publisher          = $service_object->saswp_get_publisher();
                        			
			$input = array(
                            
				"@context" 	    => saswp_context_url(),
				"@type"		    => "ContactPage",
				"mainEntityOfPage"  => array(
							"@type" => "WebPage",
							"@id" 	=> trailingslashit(get_permalink()),
							),
				"url"		   => trailingslashit(get_permalink()),
				"headline"	   => saswp_get_the_title(),								
				'description'	   => saswp_get_the_excerpt(),
			);
                        
                        if(!empty($feature_image)){
                            
                             $input = array_merge($input, $feature_image);   
                         
                        }
                        
                        if(!empty($publisher)){
                            
                            $input = array_merge($input, $publisher);   
                         
                        }
			return apply_filters('saswp_modify_contact_page_output', $input);
                         
	}
	
}

/**
 * SiteNavigation Schema Markup 
 * @global type $sd_data
 * @return type array
 */
function saswp_site_navigation_output(){
            
            global $sd_data;
            $input = array();    

            $navObj = array();          
            
            if(isset($sd_data['saswp_site_navigation_menu']) &&  $sd_data['saswp_site_navigation_menu'] == 1 ){
              
                $input = saswp_site_navigation_fallback();
                
            }else{
            
                if(isset($sd_data['saswp_site_navigation_menu'])){
                
                $menu_id   = $sd_data['saswp_site_navigation_menu'];                
                $menuItems = wp_get_nav_menu_items($menu_id);
                $menu_name = wp_get_nav_menu_object($menu_id);
                                             
                if($menuItems){
                   
                        foreach($menuItems as $items){
                 
                              $navObj[] = array(
                                     "@context"  => saswp_context_url(),
                                     "@type"     => "SiteNavigationElement",
                                     "@id"       => trailingslashit(get_home_url()).'#'.$menu_name->name,
                                     "name"      => esc_attr($items->title),
                                     "url"       => esc_url($items->url)
                              );

                        }                                                                                                                                                                                   
                    }
            }
                                    
            if($navObj){

                $input['@context'] = saswp_context_url(); 
                $input['@graph']   = $navObj; 

            }
                
            }
            
    return apply_filters('saswp_modify_sitenavigation_output', $input);
}      

function saswp_site_navigation_fallback(){
            
    global $sd_data;
    $input = array();    
                                                    
        $navObj = array();
        
        $menuLocations = get_nav_menu_locations();
        
        if(!empty($menuLocations)){
         
            foreach($menuLocations as $type => $id){
            
            $menuItems = wp_get_nav_menu_items($id);
                      
            if(isset($sd_data['saswp-'.$type])){
                
               if($menuItems){
                
                if(!saswp_non_amp()){
                                     
                    if($type == 'amp-menu' || $type == 'amp-footer-menu'){
                        
                        foreach($menuItems as $items){
                 
                              $navObj[] = array(
                                     "@context"  => saswp_context_url(),
                                     "@type"     => "SiteNavigationElement",
                                     "@id"       => trailingslashit(get_home_url()).$type,
                                     "name"      => esc_attr($items->title),
                                     "url"       => esc_url($items->url)
                              );

                        }
                        
                    }                    
                    
                }else{
                    
                    if($type != 'amp-menu'){
                        
                        foreach($menuItems as $items){
                 
                            $navObj[] = array(
                                    "@context"  => saswp_context_url(),
                                    "@type"     => "SiteNavigationElement",
                                    "@id"       => trailingslashit(get_home_url()).$type,
                                    "name"      => esc_attr($items->title),
                                    "url"       => esc_url($items->url)
                            );
                    
                         }
                                                
                    }
                    
                }                                                                    
                
              }
            
            }
                                                
            }
            
        }        
              
        if($navObj){
            
            $input['@context'] = saswp_context_url(); 
            $input['@graph']   = $navObj; 
            
        }
              
    
        
    return  $input;
} 
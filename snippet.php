if ( !function_exists('wpai_pmxi_before_xml_import') ) : 

function wpai_pmxi_before_xml_import( $importID ) {

    // Retrieve import object.
    $import = new PMXI_Import_Record();
	$import->getById( $importID );
	
	// Ensure import object is valid.
    if ( ! $import->isEmpty() ) {

        // Retrieve history file object.
        $history_file = new PMXI_File_Record();
		$history_file->getBy( 'import_id', $importID );

        // Ensure history file object is valid.
        if ( !$history_file->isEmpty() ) {

            // Retrieve import file path.
            $file_to_import = wp_all_import_get_absolute_path( $history_file->path );

            // Load import file as SimpleXml.
			$file = simplexml_load_file( $file_to_import );

			/***
			 * 
			 *  Add here your strings which you need to find in data
			 */
			$searches = ['Fish Blanket', 'Digi Plaid', 'Rasta'];

			/***
			 * 
			 *  Add here your strings which you need to repalce with in data
			 */
			$replacements = ['Shrimp Blanket', 'Sgt Bilko Brown', 'Pasta'];

			$newXml = simplexml_load_string( str_replace( $searches, $replacements, $file->asXML() ) );
			
			// Save updated file.
			$updated_file = $newXml->asXML( $file_to_import );

        }
            
     }
}

add_action( 'pmxi_before_xml_import', 'wpai_pmxi_before_xml_import', 10, 1 );

endif; // !function_exists('wpai_pmxi_before_xml_import')

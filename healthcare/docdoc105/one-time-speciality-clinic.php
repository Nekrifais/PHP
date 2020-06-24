<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
	require_once(dirname(__FILE__).'/login-password.php');
	$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/speciality/city/1/onlySimple/0');


$obj = json_decode($json);

	
	$all_spec_one = get_field('выгрузить_все_специальности', 'option');

	
	if($all_spec_one == 0){
		$speciality_to_import = get_field('выбор_специальностей', 'option');
	}
	


foreach($obj->SpecList as $value){
		if(in_array($value->Id, $speciality_to_import) or $speciality_to_import == ""){
			
	

	$term = wp_insert_term (
		$value->BranchName, // the term 
		'clinic-speciality', // the taxonomy
			array(
				'description'=> '',
				'slug' => $value->BranchAlias
			)
	);

if (! is_wp_error( $term )){

	$term_id = $term[term_id];
	
	$Id = $value->Id;
	$Alias = $value->Alias;
	$NameGenitive = $value->NameGenitive;
	$NamePlural = $value->NamePlural;
	$NamePluralGenitive = $value->NamePluralGenitive;
	$IsSimple = $value->IsSimple;
	$BranchName = $value->BranchName;
	$BranchAlias = $value->BranchAlias;
	
	
	
	update_field('Id', $Id, 'clinic-speciality_' . $term_id ); 
	update_field('alias', $Alias, 'clinic-speciality_' . $term_id ); 
	update_field('namegenitive', $NameGenitive, 'clinic-speciality_' . $term_id ); 
	update_field('nameplural', $NamePlural, 'clinic-speciality_' . $term_id ); 
	update_field('namepluralgenitive', $NamePluralGenitive, 'clinic-speciality_' . $term_id ); 
	update_field('issimple', $IsSimple, 'clinic-speciality_' . $term_id ); 
	update_field('branchname', $BranchName, 'clinic-speciality_' . $term_id ); 
	update_field('branchalias', $BranchAlias, 'clinic-speciality_' . $term_id ); 
	
	
	echo 'Специальности ' . $value->Name . ' нет в базе. <br> <span style="color:green;"> Создаём. </span> <br> <br>';

} else { 

		echo 'Специальность ' . $value->Name . ' уже есть в базе. <br> <span style="color:grey;"> Пропускаем. </span> <br><br>';
	
}

} else {
	
	echo 'Специальность ' . $value->Name . ' не выбрана в настройках плагина для обработки. <br> <span style="color:grey;"> Пропускаем. </span> <br> <br>';
	
}
}
?>
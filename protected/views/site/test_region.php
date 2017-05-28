<?php
/* @var $this SiteController */
foreach($dataProvider->getData() as $record) {
	echo $record->description;
}
?>

<?php
$installer = $this;
$installer->startSetup();
/*$installer->run("create table klimaire_contactus(contact_id int not null auto_increment, name varchar(100),address varchar(100),city varchar(100),state varchar(100),country varchar(100),zipcode varchar(100),company_name varchar(100),phone varchar(100),email varchar(100),topic varchar(100),model_number varchar(100),serial_number varchar(100),contractor_plumber_name varchar(100),contractor_plumber_phone varchar(100),comment varchar(255)");
*/
//demo 
Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 
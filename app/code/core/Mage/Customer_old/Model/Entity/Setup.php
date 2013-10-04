<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Customer resource setup model
 *
 * @category   Mage
 * @package    Mage_Customer
 */
class Mage_Customer_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{

    /**
     * Prepare customer attribute values to save
     *
     * @param array $attr
     * @return array
     */
    protected function _prepareValues($attr)
    {
        $data = parent::_prepareValues($attr);
        $data = array_merge($data, array(
            'is_visible'                => $this->_getValue($attr, 'visible', 1),
            'is_visible_on_front'       => $this->_getValue($attr, 'visible_on_front', 0),
            'input_filter'              => $this->_getValue($attr, 'input_filter', ''),
            'lines_to_divide_multiline' => $this->_getValue($attr, 'lines_to_divide', 0),
            'min_text_length'           => $this->_getValue($attr, 'min_text_length', 0),
            'max_text_length'           => $this->_getValue($attr, 'max_text_length', 0)
        ));
        return $data;
    }

    public function getDefaultEntities()
    {
        return array(
            'customer' => array(
                'entity_model'          =>'customer/customer',
                'table'                 => 'customer/entity',
                'increment_model'       => 'eav/entity_increment_numeric',
                'increment_per_store'   => false,
                'additional_attribute_table' => 'customer/eav_attribute',
                'entity_attribute_collection' => 'customer/attribute_collection',
                'attributes' => array(
//                    'entity_id'         => array('type'=>'static'),
//                    'entity_type_id'    => array('type'=>'static'),
//                    'attribute_set_id'  => array('type'=>'static'),
//                    'increment_id'      => array('type'=>'static'),
//                    'created_at'        => array('type'=>'static'),
//                    'updated_at'        => array('type'=>'static'),
//                    'is_active'         => array('type'=>'static'),

                    'website_id' => array(
                        'type'          => 'static',
                        'label'         => 'Associate to Website',
                        'input'         => 'select',
                        'source'        => 'customer/customer_attribute_source_website',
                        'backend'       => 'customer/customer_attribute_backend_website',
                        'sort_order'    => 10,
                    ),
                    'store_id' => array(
                        'type'          => 'static',
                        'label'         => 'Create In',
                        'input'         => 'select',
                        'source'        => 'customer/customer_attribute_source_store',
                        'backend'       => 'customer/customer_attribute_backend_store',
                        'visible'       => false,
                        'sort_order'    => 20,
                    ),
                    'created_in' => array(
                        'type'          => 'varchar',
                        'label'         => 'Created From',
                        'sort_order'    => 30,
                    ),
                    'prefix' => array(
                        'label'         => 'Prefix',
                        'required'      => false,
                        'sort_order'    => 37,
                    ),
                    'firstname' => array(
                        'label'         => 'First Name',
                        'sort_order'    => 40,
                    ),
                    'middlename' => array(
                        'label'         => 'Middle Name/Initial',
                        'required'      => false,
                        'sort_order'    => 43,
                    ),
                    'lastname' => array(
                        'label'         => 'Last Name',
                        'sort_order'    => 50,
                    ),
                    'suffix' => array(
                        'label'         => 'Suffix',
                        'required'      => false,
                        'sort_order'    => 53,
                    ),
                    'email' => array(
                        'type'          => 'static',
                        'label'         => 'Email',
                        'class'         => 'validate-email',
                        'sort_order'    => 60,
                    ),
					
					//vishal
					
					'regi_fax' => array(
					     'label'		=> 'regi_fax',
					     'required'		=> false,
					     'sort_order'	=> 67,
					),
					
					'regi_title' => array(
					     'label'		=> 'regi_title',
					     'required'		=> false,
					     'sort_order'	=> 68,
					),

					'regi_company_name' => array(
					     'label'		=> 'regi_company_name',
					     'required'		=> false,
					     'sort_order'	=> 69,
					),
					'regi_country' => array(
					     'label'		=> 'regi_country',
					     'required'		=> false,
					     'sort_order'	=> 71,
					),

					'regi_address' => array(
					     'label'		=> 'regi_address',
					     'required'		=> false,
					     'sort_order'	=> 62,
					),

					'regi_city' => array(
					     'label'		=> 'regi_city',
					     'required'		=> false,
					     'sort_order'	=> 73,
					),

					'regi_state' => array(
					     'label'		=> 'regi_state',
					     'required'		=> false,
					     'sort_order'	=> 74,
					),

					'regi_zip' => array(
					     'label'		=> 'regi_zip',
					     'required'		=> false,
					     'sort_order'	=> 75,
					),

					'products_of_interest_klimaire' => array(
					     'label'		=> 'products_of_interest_klimaire',
					     'required'		=> false,
					     'sort_order'	=> 76,
					),

					'products_of_interest_maxwell' => array(
					     'label'		=> 'products_of_interest_maxwell',
					     'required'		=> false,
					     'sort_order'	=> 77,
					),

					'hvac_brands_currently_carried' => array(
					     'label'		=> 'hvac_brands_currently_carried',
					     'required'		=> false,
					     'sort_order'	=> 78,
					),

					'territory_of_interest' => array(
					     'label'		=> 'territory_of_interest',
					     'required'		=> false,
					     'sort_order'	=> 79,
					),

					'regi_phone' => array(
					     'label'		=> 'regi_phone',
					     'required'		=> false,
					     'sort_order'	=> 81,
					),

					'regi_mobile' => array(
					     'label'		=> 'regi_mobile',
					     'required'		=> false,
					     'sort_order'	=> 82,
					),

					'website' => array(
					     'label'		=> 'website',
					     'required'		=> false,
					     'sort_order'	=> 83,
					),

					'regi_business_type' => array(
					     'label'		=> 'regi_business_type',
					     'required'		=> false,
					     'sort_order'	=> 84,
					),
					
					'contrctor_license_number' => array(
					     'label'		=> 'contrctor_license_number',
					     'required'		=> false,
					     'sort_order'	=> 85,
					),
					
					'epa_certification_number' => array(
					     'label'		=> 'epa_certification_number',
					     'required'		=> false,
					     'sort_order'	=> 86,
					),
					
					'regi_description' => array(
					     'label'		=> 'regi_description',
					     'required'		=> false,
					     'sort_order'	=> 87,
					),
					
					'regi_salutation' => array(
					     'label'		=> 'regi_salutation',
					     'required'		=> false,
					     'sort_order'	=> 88,
					),

					
					//vishal
					
					
                    'phone' => array(
                        'label'         => 'Phone Number',
                        'required'      => false,
                        'sort_order'    => 61,
                    ),
					'user_name' => array(
						'label' => 'User Name',
						'required' => false,
						'sort_order' => 64,
					),  					
					'group_id' => array(
                        'type'          => 'static',
                        'input'         => 'select',
                        'label'         => 'Group',
                        'source'        => 'customer/customer_attribute_source_group',
                        'sort_order'    => 70,
                    ),
                    'dob' => array(
                        'type'          => 'datetime',
                        'input'         => 'date',
                        'backend'       => 'eav/entity_attribute_backend_datetime',
                        'required'      => false,
                        'label'         => 'Date Of Birth',
                        'sort_order'    => 80,
                    ),
                    'password_hash' => array(
                        'input'         => 'hidden',
                        'backend'       => 'customer/customer_attribute_backend_password',
                        'required'      => false,
                    ),
                    'default_billing' => array(
                        'type'          => 'int',
                        'visible'       => false,
                        'required'      => false,
                        'backend'       => 'customer/customer_attribute_backend_billing',
                    ),
                    'default_shipping' => array(
                        'type'          => 'int',
                        'visible'       => false,
                        'required'      => false,
                        'backend'       => 'customer/customer_attribute_backend_shipping',
                    ),
                    'taxvat' => array(
                        'label'         => 'Tax/VAT Number',
                        'visible'       => true,
                        'required'      => false,
                    ),
                    'confirmation' => array(
                        'label'         => 'Is Confirmed',
                        'visible'       => false,
                        'required'      => false,
                    ),
                    'created_at' => array(
                        'type'          => 'static',
                        'label'         => 'Created At',
                        'visible'       => false,
                        'required'      => false,
                        'input'         => 'date',
                    ),
					'central_air_conditioners' => array(
                        'label'         => 'Central Air Conditioners',
                       	'required' => false,
						'sort_order' => 91,
                    ),
					'central_heat_pump' => array(
                        'label'         => 'Central Heat Pump',
                        'required' => false,
						'sort_order' => 92,
                    ),
					'commercial_units_package_units' => array(
                        'label'         => 'Commercial Units',
                        'required' => false,
						'sort_order' => 93,
                    ),
					'ductless_air_conditioners' => array(
                        'label'         => 'Ductless Air Conditioners',
                        'required' => false,
						'sort_order' => 94,
                    ),
					'gas_furnaces_cooling_coils' => array(
                        'label'         => 'Gas Furnacess Cooling Coils',
                        'required' => false,
						'sort_order' => 95,
                    ),
					'indoor_air_quality_products' => array(
                        'label'         => 'Indoor Air Quality Products',
                        'required' => false,
						'sort_order' => 96,
                    ),
					'package_terminal_systems' => array(
                        'label'         => 'package_terminal_systems',
                        'required' => false,
						'sort_order' => 97,
                    ),
					'package_water_source_heat_pump' => array(
                        'label'         => 'package_water_source_heat_pump',
                        'required' => false,
						'sort_order' => 98,
                    ),
					'VRF' => array(
                        'label'         => 'VRF',
                        'required' => false,
						'sort_order' => 99,
                    ),
					'air_curtains' => array(
                        'label'         => 'air_curtains',
                        'required' => false,
						'sort_order' => 100,
                    ),
					'boilers_space_heaters' => array(
                        'label'         => 'boilers_space_heaters',
                        'required' => false,
						'sort_order' => 101,
                    ),
					'electric_tankless_water_heaters' => array(
                        'label'         => 'electric_tankless_water_heaters',
                        'required' => false,
						'sort_order' => 102,
                    ),
					'gas_tankless_water_heaterss' => array(
                        'label'         => 'gas_tankless_water_heaterss',
                        'required' => false,
						'sort_order' => 103,
                    ),
					
					
                ),
            ),

            'customer_address'=>array(
                'entity_model'  =>'customer/customer_address',
                'table' => 'customer/address_entity',
                'additional_attribute_table' => 'customer/eav_attribute',
                'entity_attribute_collection' => 'customer/address_attribute_collection',
                'attributes' => array(
//                    'entity_id'         => array('type'=>'static'),
//                    'entity_type_id'    => array('type'=>'static'),
//                    'attribute_set_id'  => array('type'=>'static'),
//                    'increment_id'      => array('type'=>'static'),
//                    'parent_id'         => array('type'=>'static'),
//                    'created_at'        => array('type'=>'static'),
//                    'updated_at'        => array('type'=>'static'),
//                    'is_active'         => array('type'=>'static'),

                    'prefix' => array(
                        'label'         => 'Prefix',
                        'required'      => false,
                        'sort_order'    => 7,
                    ),
                    'firstname' => array(
                        'label'         => 'First Name',
                        'sort_order'    => 10,
                    ),
                    'middlename' => array(
                        'label'         => 'Middle Name/Initial',
                        'required'      => false,
                        'sort_order'    => 13,
                    ),
                    'lastname' => array(
                        'label'         => 'Last Name',
                        'sort_order'    => 20,
                    ),
                    'suffix' => array(
                        'label'         => 'Suffix',
                        'required'      => false,
                        'sort_order'    => 23,
                    ),
                    'company' => array(
                        'label'         => 'Company',
                        'required'      => false,
                        'sort_order'    => 30,
                    ),
                    'street' => array(
                        'type'          => 'text',
                        'backend'       => 'customer_entity/address_attribute_backend_street',
                        'input'         => 'multiline',
                        'label'         => 'Street Address',
                        'sort_order'    => 40,
                    ),
                    'city' => array(
                        'label'         => 'City',
                        'sort_order'    => 50,
                    ),
                    'country_id' => array(
                        'type'          => 'varchar',
                        'input'         => 'select',
                        'label'         => 'Country',
                        'class'         => 'countries',
                        'source'        => 'customer_entity/address_attribute_source_country',
                        'sort_order'    => 60,
                    ),
                    'region' => array(
                        'backend'       => 'customer_entity/address_attribute_backend_region',
                        'label'         => 'State/Province',
                        'class'         => 'regions',
                        'sort_order'    => 70,
                    ),
                    'region_id' => array(
                        'type'          => 'int',
                        'input'         => 'hidden',
                        'source'        => 'customer_entity/address_attribute_source_region',
                        'required'      => 'false',
                        'sort_order'    => 80,
                        'label'         => 'State/Province'
                    ),
                    'postcode' => array(
                        'label'         => 'Zip/Postal Code',
                        'sort_order'    => 90,
                    ),
                    'telephone' => array(
                        'label'         => 'Telephone',
                        'sort_order'    => 100,
                    ),
                    'fax' => array(
                        'label'         => 'Fax',
                        'required'      => false,
                        'sort_order'    => 110,
                    ),
                ),
            ),
        );
    }

}

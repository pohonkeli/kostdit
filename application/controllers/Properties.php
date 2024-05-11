<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Roles (RolesController)
 * Roles Class to control role related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 22 Jan 2021
 */
class Properties extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_model', 'rm');
        $this->isLoggedIn();
        $this->module = 'Properties';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('properties/propertyListing');
    }

    function propertyListing()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Ambil data properties dari database
            $propertyRecords = array();

            // Load database
            $this->load->database();

            // Query untuk mengambil data kategori dan properti
            $query = $this->db->query("SELECT 
                                    m_category.category_code AS CategoryCode, 
                                    m_category.category_name AS CategoryName, 
                                    m_category.keterangan AS Keterangan, 
                                    m_property.property_code AS PropertyCode, 
                                    m_property.property_name AS PropertyName, 
                                    m_type.type_name AS TypeName, 
                                    m_property.keterangan AS KeteranganProperti, 
                                    m_status.status_name AS StatusName 
                                  FROM 
                                    m_property 
                                  INNER JOIN 
                                    m_category ON m_property.category_code = m_category.category_code 
                                  INNER JOIN 
                                    m_type ON m_property.type_code = m_type.type_code 
                                  INNER JOIN 
                                    m_status ON m_property.status_code = m_status.status_code");

            // Perulangan untuk mengisi $propertyRecords dengan hasil query
            foreach ($query->result_array() as $row) {
                $propertyRecords[$row['CategoryCode']]['CategoryCode'] = $row['CategoryCode'];
                $propertyRecords[$row['CategoryCode']]['CategoryName'] = $row['CategoryName'];
                $propertyRecords[$row['CategoryCode']]['Keterangan'] = $row['Keterangan'];
                $propertyRecords[$row['CategoryCode']]['Properties'][] = array(
                    'PropertyCode' => $row['PropertyCode'],
                    'PropertyName' => $row['PropertyName'],
                    'TypeName' => $row['TypeName'],
                    'Keterangan' => $row['KeteranganProperti'],
                    'StatusName' => $row['StatusName']
                );
            }

            $data['propertyRecords'] = $propertyRecords;

            $this->loadViews("properties/list", $this->global, $data, NULL);
        }
    }
}


?>
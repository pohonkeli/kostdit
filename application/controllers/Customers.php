<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Customers extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'Customers';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('customers/customerListing');
    }

    function customerListing()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {

            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->custListingCount($searchText);

            $returns = $this->paginationCompress("customers/customerListing/", $count, 10);

            $data['customerRecords'] = $this->custListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'MamahTias : User Listing';

            $this->loadViews("customers/list", $this->global, $data, NULL);
        }
    }

    //Helper to DB
    function custListingCount($searchText)
    {
        $this->db->select('a.*');
        $this->db->from('m_customer as a');
        if (!empty($searchText)) {
            $likeCriteria = "
            (
                a.customer_code  LIKE '%" . $searchText . "%' OR
                a.customer_name  LIKE '%" . $searchText . "%'
            )";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();

        return $query->num_rows();
    }

    function custListing($searchText, $page, $segment)
    {
        $this->db->select('a.*');
        $this->db->from('m_customer as a');
        if (!empty($searchText)) {
            $likeCriteria = "
            (
                a.customer_code  LIKE '%" . $searchText . "%' OR
                a.customer_name  LIKE '%" . $searchText . "%'
            )";
            $this->db->where($likeCriteria);
        }
        // $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('a.customer_code', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }





}


?>
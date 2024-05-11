<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Automations extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'Automations';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */

    // public function index()
    // {
    //     redirect('automations/autoCreateRental');
    // }

    /* public function getPeriode()
    {
        // Generate list of periods
        $periodes = array();
        $currentYear = date('Y');
        $currentMonth = date('m');

        for ($i = $currentMonth; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $periodes[] = $currentYear . '-' . $month;
        }

        // Return the list of periods as JSON
        echo json_encode($periodes);
    } */

    public function getPeriode()
    {
        // Generate list of periods
        $periodes = array();
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Loop through months from January to December
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $periodes[] = $currentYear . '-' . $month;
        }

        // Return the list of periods as JSON
        echo json_encode($periodes);
    }
    public function autoCreateRental()
    {
        $this->loadViews("automations/autoCreateRental", $this->global, NULL, NULL);
    }

    public function CreateRentalByPeriode()
    {
        header("Access-Control-Allow-Origin: *");
        $this->output->set_content_type('application/json');

        $periode = $this->input->post('periode');

        $this->load->database();

        // Ambil data dari tabel m_member
        $query = $this->db->select('m_member.*, m_property.*')
            ->from('m_member')
            ->where('m_member.is_used', 1)
            ->order_by('m_member.member_code', 'ASC')
            ->join('m_property', 'm_property.property_code = m_member.property_code', 'inner')
            ->get();


        if ($query->num_rows() > 0) {
            $counter = 1; // Inisialisasi counter untuk rental_code
            foreach ($query->result() as $row) {

                // Hitung tanggal awal dan akhir rental
                $tanggal_awal_rental = date('Y-m-d', strtotime($periode . '-' . $row->tanggal_start));
                $tanggal_akhir_rental = date('Y-m-d', strtotime($tanggal_awal_rental . ' +1 month'));

                // Cek apakah customer_code sudah ada dalam t_rental untuk periode tersebut
                $existing_rental = $this->db->where('customer_code', $row->customer_code)
                    ->where('tanggal_awal_rental', $tanggal_awal_rental)
                    ->where('tanggal_akhir_rental <=', $tanggal_akhir_rental)
                    ->get('t_rental');

                if ($existing_rental->num_rows() > 0) {
                    continue;
                    //return json_encode(["success" => false, "message" => "Customer dengan code {$row->customer_code} sudah memiliki rental pada periode tersebut, akan diabaikan"]);
                }

                // Ambil data terakhir dari tabel t_rental untuk periode tersebut
                $last_rental = $this->db->where('rental_code LIKE', "RENT_" . str_replace('-', '_', $periode) . "_%")
                    ->order_by('rental_code', 'DESC')
                    ->limit(1)
                    ->get('t_rental')
                    ->row();

                if ($last_rental) {
                    // Ambil nomor dari rental_code terakhir dan tambahkan 1
                    $last_rental_number = (int) substr($last_rental->rental_code, -5);
                    $counter = $last_rental_number + 1;
                } else {
                    // Jika tidak ada data sebelumnya, gunakan nomor 1
                    $counter = 1;
                }

                // Generate rental_code
                $rental_code = 'RENT_' . str_replace('-', '_', $periode) . '_' . str_pad($counter, 5, '0', STR_PAD_LEFT);

                // Insert data ke tabel t_rental
                $data = array(
                    'rental_code' => $rental_code,
                    'tanggal_transaksi' => date('Y-m-d H:i:s'),
                    'tanggal_awal_rental' => $tanggal_awal_rental,
                    'tanggal_akhir_rental' => $tanggal_akhir_rental,
                    'total_harga_sewa' => $row->property_harga_dasar,
                    'total_sudah_bayar' => 0,
                    'total_kurang_bayar' => $row->property_harga_dasar,
                    'status_rental' => 'BELUM LUNAS',
                    'property_code' => $row->property_code,
                    'customer_code' => $row->customer_code,
                    'is_used' => 1,
                    'is_active' => 1,
                    'created_by' => 'system',
                    'created_date' => date('Y-m-d H:i:s')
                );

                $this->db->insert('t_rental', $data);

                $counter++; // Increment counter untuk rental_code
            }

            //return "success";
            $response = ["is_error" => false, "message" => "Data rental berhasil dimasukkan"];
        } else {
            $response = ["is_error" => true, "message" => "Tidak ada data m_member yang ditemukan"];
        }


        echo json_encode($response);
    }

}


?>
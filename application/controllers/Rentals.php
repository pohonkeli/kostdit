<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Rentals extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'Rentals';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('rentals/rentalListing');
    }

    function rentalListing()
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

            $count = $this->rentListingCount($searchText);

            $returns = $this->paginationCompress("rentals/rentalListing/", $count, 50);

            $data['rentalRecords'] = $this->rentListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'MamahTias : Rental Listing';

            $this->loadViews("rentals/list", $this->global, $data, NULL);
        }
    }

    //Helper to DB
    function rentListingCount($searchText)
    {
        // Native SQL query
        $sql = "SELECT 
                    COUNT(a.rental_code) AS count 
                FROM 
                    t_rental a
                JOIN
                    m_customer b on b.customer_code = a.customer_code
                JOIN 
                    m_property c on c.property_code = a.property_code 
                JOIN 
                    m_category d on d.category_code = c.category_code 
                JOIN 
                    m_type e on e.type_code = c.type_code 
                ";

        if (!empty($searchText)) {
            $sql .= " WHERE a.rental_code LIKE '%" . $searchText . "%' OR
                            b.customer_name LIKE '%" . $searchText . "%' OR
                            d.keterangan LIKE '%" . $searchText . "%' OR
                            c.property_name LIKE '%" . $searchText . "%' OR
                            e.type_name LIKE '%" . $searchText . "%' OR
                            a.status_rental = '" . $searchText . "' OR
                            CONCAT(YEAR(a.tanggal_awal_rental), '-', MONTHNAME(a.tanggal_awal_rental)) LIKE '%" . $searchText . "%' OR
                            DATE_FORMAT(a.tanggal_awal_rental, '%Y-%m') LIKE '%" . $searchText . "%'
                    ";
        }

        // Jalankan query
        $query = $this->db->query($sql);

        // Ambil hasil query
        $result = $query->row();

        // Ambil jumlah baris
        $count = isset($result->count) ? $result->count : 0;

        return $count;
    }


    function rentListing($searchText, $page, $segment)
    {
        if ($segment == "" || $segment == "rentalListing") {
            $segment = 0;
        }

        $sql = "SELECT 
                    a.rental_code,
                    CONCAT(YEAR(a.tanggal_awal_rental), '-', MONTHNAME(a.tanggal_awal_rental)) AS periode,
                    a.tanggal_awal_rental,
                    a.tanggal_akhir_rental,
                    b.customer_name,
                    d.keterangan,
                    c.property_name ,
                    e.type_name ,
                    a.status_rental 
                FROM 
                    t_rental a
                JOIN
                    m_customer b on b.customer_code = a.customer_code
                join 
                    m_property c on c.property_code = a.property_code 
                join 
                    m_category d on d.category_code = c.category_code 
                join 
                    m_type e on e.type_code = c.type_code 
                ";
        if (!empty($searchText)) {
            $sql .= " WHERE a.rental_code LIKE '%" . $searchText . "%' OR
                            b.customer_name LIKE '%" . $searchText . "%' OR
                            d.keterangan LIKE '%" . $searchText . "%' OR
                            c.property_name LIKE '%" . $searchText . "%' OR
                            e.type_name LIKE '%" . $searchText . "%' OR
                            a.status_rental = '" . $searchText . "' OR
                            CONCAT(YEAR(a.tanggal_awal_rental), '-', MONTHNAME(a.tanggal_awal_rental)) LIKE '%" . $searchText . "%' OR
                            DATE_FORMAT(a.tanggal_awal_rental, '%Y-%m') LIKE '%" . $searchText . "%'
                    ";
        }
        $sql .= " ORDER BY a.rental_code DESC";
        $sql .= " LIMIT $segment, $page";

        $query = $this->db->query($sql);

        $result = $query->result();
        return $result;
    }



    function create()
    {
        $this->loadViews("rentals/create", $this->global, NULL, NULL);
    }

    function edit($rental_code = null)
    {
        $this->global['pageTitle'] = 'MamahTias : Transaksi Rental';

        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Load database
            $this->load->database();

            // Ambil data dari tabel t_rental
            $query = $this->db->query("SELECT 
                                        a.*,
                                        b.*,
                                        c.*,
                                        d.*,
                                        e.*,
                                        f.*
                                    FROM 
                                        t_rental a
                                    JOIN
                                        m_customer b on b.customer_code = a.customer_code
                                    JOIN
                                        m_property c on c.property_code = a.property_code
                                    JOIN
                                        m_category d on d.category_code = c.category_code
                                    JOIN
                                        m_type e on e.type_code = c.type_code
                                    JOIN
                                        m_member f on f.customer_code = a.customer_code
                                    WHERE a.rental_code = ?", array($rental_code));

            $queryPembayaran = $this->db->query("SELECT 
                                                    a.*
                                                FROM 
                                                    t_rental_payment a
                                                WHERE 
                                                    a.rental_code = ?
                                                order by
                                                    a.payment_code", array($rental_code));

            // Proses hasil query menjadi array
            $rentalHeader = $query->row_array(); // Menggunakan row_array() untuk mendapatkan satu baris data
            $rentalPayment = $queryPembayaran->result_array();

            if (empty($rentalHeader)) {
                // Jika data tidak ditemukan, Anda dapat menangani kasus ini di sini, misalnya dengan menampilkan pesan kesalahan atau mengarahkan pengguna ke halaman lain.
                // Contoh: echo "Data rental dengan rental code $rental_code tidak ditemukan";
                // Atau: redirect('halaman_error');
            } else {
                // Mengirim data ke tampilan
                $data['rental_header'] = $rentalHeader;
                $data['rental_payment'] = $rentalPayment;

                // Mengirim data ke tampilan
                $this->loadViews("rentals/edit", $this->global, $data, NULL);
            }
        }
    }


    function PostUpdateRental()
    {
        header("Access-Control-Allow-Origin: *");
        $this->output->set_content_type('application/json');

        // Mengambil data dari input post
        $rental_code = $this->input->post('rental_code');
        $total_harga_sewa = $this->input->post('total_harga_sewa');
        $total_sudah_bayar = $this->input->post('total_sudah_bayar');
        $total_kurang_bayar = $this->input->post('total_kurang_bayar');
        $status_rental = $this->input->post('status_rental');

        //details
        $details_payment = $this->input->post('details_payment');

        // Memperbarui data dalam tabel t_rental
        $this->db->where('rental_code', $rental_code);
        $data = array(
            'total_harga_sewa' => $total_harga_sewa,
            'total_sudah_bayar' => $total_sudah_bayar,
            'total_kurang_bayar' => $total_kurang_bayar,
            'status_rental' => $status_rental
        );
        $this->db->update('t_rental', $data);


        // Insert data ke tabel t_rental_payment
        foreach ($details_payment as $payment) {
            $payment_code = $payment['payment_code'];
            $tanggal_transaksi = $payment['tanggal_transaksi'];
            $jumlah_bayar = $payment['jumlah_bayar'];
            $keterangan = $payment['keterangan'];

            if ($payment_code == 'PAY_XXXXXX') {
                $payment_data = array(
                    'payment_code' => $this->generatePaymentCode(),
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'jumlah_bayar' => $jumlah_bayar,
                    'keterangan' => $keterangan,
                    'rental_code' => $rental_code,
                    'created_by' => $this->session->userdata('name')
                );

                $this->db->insert('t_rental_payment', $payment_data);
            }
        }

        // Menyiapkan pesan balasan
        $response = array(
            'success' => true,
            'message' => 'Data rental berhasil diperbarui'
        );

        // Mengembalikan respon dalam format JSON
        echo json_encode($response);
    }

    function generatePaymentCode()
    {
        // Query untuk mendapatkan kode pembayaran terbaru
        $this->db->select('payment_code');
        $this->db->from('t_rental_payment');
        $this->db->order_by('payment_code', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        // Jika terdapat data, maka kita dapatkan nomor berikutnya
        if ($query->num_rows() > 0) {
            // Mendapatkan kode pembayaran terbaru
            $last_payment_code = $query->row()->payment_code;

            // Membagi kode pembayaran menjadi prefix dan nomor
            $parts = explode('_', $last_payment_code);
            $prefix = $parts[0]; // Mengambil prefix dari kode pembayaran terakhir
            $last_number = (int) $parts[1]; // Mengambil nomor dari kode pembayaran terakhir

            // Menghasilkan nomor berikutnya
            $next_number = $last_number + 1;

            // Membuat kode pembayaran baru dengan format PREFIX_NOMOR
            $next_payment_code = $prefix . "_" . sprintf("%06d", $next_number);
        } else {
            // Jika tidak ada data, kita mulai dengan nomor 1
            $next_payment_code = "PAY_000001";
        }

        return $next_payment_code;
    }






}


?>
<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'Dashboard';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        $this->global['pageTitle'] = 'MamahTias : Dashboard';

        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Load database
            $this->load->database();

            $query = $this->db->query(" select 
                                            ROW_NUMBER() OVER () as nomor,
                                            concat('Penghuni ',c.type_name,' atas nama ','<b>', d.customer_name,'</b>', ' (',e.keterangan ,',',' Nama Property ',b.property_name , ')', ' sudah berakhir masa sewanya pada ', '<b>' ,DATE_FORMAT(a.tanggal_awal_rental , '%d %M %Y'),'<br/>', '</b>', ' TOTAL BIAYA SEWA ','<b>Rp ',  FORMAT(a.total_harga_sewa, 0), '</b>' '<br/> TOTAL YANG SUDAH BAYAR', '<b> Rp ', FORMAT(a.total_sudah_bayar , 0),'</b>' ,'<br/> TOTAL KURANG BAYAR',
                   '<b> Rp ',               FORMAT(a.total_kurang_bayar, 0), '</b>' ) as peringatan
                                        from 
                                            t_rental a
                                        join 
                                            m_property b on b.property_code = a.property_code 
                                        join 
                                            m_type c on c.type_code = b.type_code 
                                        join 
                                            m_customer d on d.customer_code = a.customer_code 
                                        join 
                                            m_category e on e.category_code = b.category_code 
                                        where 
                                            a.tanggal_awal_rental <= cast(now() as date) and
                                            a.status_rental = 'BELUM LUNAS'
                                        order by
                                            a.tanggal_awal_rental;");


            $queryPropertyKosong = $this->db->query(
                "
                                        SELECT 
                                            ROW_NUMBER() OVER () as nomor,
                                            concat('Bulan ini ','<b>',CONCAT(YEAR(NOW()), '-', MONTHNAME(NOW())),'</b>', ', ',c.keterangan,' ( ',d.type_name, ' ',a.property_name, ' )', ' Masih Kosong, ', 'Segera buat iklan dengan Harga Sewa ','<b>', concat('Rp ',  FORMAT(a.property_harga_dasar , 0)),'</b>') as property_kosong
                                        FROM 
                                            m_property a
                                        LEFT JOIN 
                                            t_rental b ON a.property_code = b.property_code and
                                                        b.tanggal_awal_rental between (LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 day) and (LAST_DAY(NOW()))
                                        join 
                                            m_category c on c.category_code = a.category_code 
                                        join 
                                            m_type d on d.type_code = a.type_code 
                                        where
                                            b.property_code IS null and 
                                            a.is_used <> 0 and 
                                            a.is_active  <> 0
                                        order by
                                            a.property_code                                       
                                        ;"
            );

            $queryKeuanganBulanIni = $this->db->query(
                                            "
                                            select 
                                                ROW_NUMBER() OVER () as nomor,
                                                c.customer_name ,
                                                concat(CONCAT(DAY(a.tanggal_transaksi)),' ',CONCAT(monthname(a.tanggal_transaksi)),' ',CONCAT(YEAR(a.tanggal_transaksi))) as tanggal_bayar,
                                                a.jumlah_bayar 
                                            from 
                                                t_rental_payment a
                                            join
                                                t_rental b on b.rental_code = a.rental_code
                                            join 
                                                m_customer c on c.customer_code = b.customer_code 
                                            where b.tanggal_awal_rental  
                                            between 
                                                cast(DATE_SUB(NOW(), INTERVAL DAYOFMONTH(NOW()) - 1 DAY) as date) and 
                                                LAST_DAY(NOW())
                                            order by
                                                c.customer_code                                  
                                            ;"
            );


            $queryKeuanganPerPeriode = $this->db->query(
            "
            select 
                year(CONVERT_TZ(a.tanggal_transaksi, '+00:00', '+07:00')) as tahun,
                monthname(CONVERT_TZ(a.tanggal_transaksi, '+00:00', '+07:00')) as bulan,
                SUM(a.jumlah_bayar) as total_pemasukan
            from 
                t_rental_payment a
            join
                t_rental b on b.rental_code = a.rental_code
            join 
                m_customer c on c.customer_code = b.customer_code
            group by 
                1,2                     
            ;"
            );


            // Proses hasil query menjadi array
            $daftar_peringatan = $query->result_array();
            $daftar_property_kosong = $queryPropertyKosong->result_array();
            $daftar_keuangan_bulan_ini = $queryKeuanganBulanIni->result_array();
            $daftar_keuangan_per_periode = $queryKeuanganPerPeriode->result_array();


            // Mengirim data ke tampilan
            $data['daftar_peringatan'] = $daftar_peringatan;
            $data['daftar_property_kosong'] = $daftar_property_kosong;
            $data['daftar_keuangan_bulan_ini'] = $daftar_keuangan_bulan_ini;
            $data['daftar_keuangan_per_periode'] = $daftar_keuangan_per_periode;


            // Mengirim data ke tampilan
            $this->loadViews("general/dashboard", $this->global, $data, NULL);
        }
    }



}


?>
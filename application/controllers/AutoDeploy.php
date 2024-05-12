<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class AutoDeploy extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'AutoDeploy';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        $this->loadViews("autoDeploy/list", $this->global, NULL, NULL);
        //redirect('autoDeploy/createDeploy');
    }

    function PostUpload()
    {
        $this->load->library('ftp');

        // Konfigurasi koneksi FTP
        $config['hostname'] = 'ftpupload.net'; // Ganti dengan hostname FTP Anda
        $config['username'] = 'if0_36529392'; // Ganti dengan username FTP Anda
        $config['password'] = 'Kacang90'; // Ganti dengan password FTP Anda
        $config['port'] = 21; // Port FTP (biasanya 21)
        $config['debug'] = true; // Ganti ke TRUE jika Anda ingin menampilkan debug

        $this->ftp->connect($config);

        // Path sumber file
        $sourcePath = 'C:/xampp/htdocs/kostdit/';
        $destinationFTP = '/htdocs/';


        $this->ftp->mirror($sourcePath, $destinationFTP);

        $this->ftp->close();


        redirect('dashboard');
    }

    function PostUploadApplicationView()
    {
        $this->load->library('ftp');

        // Konfigurasi koneksi FTP
        $config['hostname'] = 'ftpupload.net'; // Ganti dengan hostname FTP Anda
        $config['username'] = 'if0_36529392'; // Ganti dengan username FTP Anda
        $config['password'] = 'Kacang90'; // Ganti dengan password FTP Anda
        $config['port'] = 21; // Port FTP (biasanya 21)
        $config['debug'] = true; // Ganti ke TRUE jika Anda ingin menampilkan debug

        $this->ftp->connect($config);


        // Path sumber file
        $sourcePath = 'C:/xampp/htdocs/kostdit/application/views/';
        $destinationFTP = '/htdocs/application/views/';

        //bikin folder di ftp server
        $this->ftp->mkdir('/htdocs/application/', DIR_WRITE_MODE);
        //$this->ftp->mkdir($destinationFTP, DIR_WRITE_MODE);

        $this->ftp->mirror($sourcePath, $destinationFTP);


        redirect('dashboard');
    }


    // function PostUpload()
    // {
    //     $this->load->library('ftp');

    //     // Konfigurasi koneksi FTP
    //     $config['hostname'] = 'ftpupload.net'; // Ganti dengan hostname FTP Anda
    //     $config['username'] = 'if0_36529392'; // Ganti dengan username FTP Anda
    //     $config['password'] = 'Kacang90'; // Ganti dengan password FTP Anda
    //     $config['port'] = 21; // Port FTP (biasanya 21)
    //     $config['debug'] = true; // Ganti ke TRUE jika Anda ingin menampilkan debug

    //     // Detail file yang diunggah
    //     $fileName = $_FILES['fileToUpload']['name'];
    //     $sourceLocation = $_POST['sourceLocation'];
    //     $destinationLocation = $_POST['destinationLocation'];

    //     // Memeriksa apakah koneksi FTP berhasil
    //     if ($this->ftp->connect($config)) {
    //         // Proses upload file ke server FTP
    //         if ($this->ftp->upload($_FILES['fileToUpload']['tmp_name'], $destinationLocation, 'binary')) {
    //             // Proses upload file berhasil

    //             // Lakukan operasi lain, seperti menyimpan detail file ke database
    //             // atau menampilkan pesan berhasil

    //             // Redirect ke halaman lain atau tampilkan pesan berhasil
    //             redirect('dashboard');
    //         } else {
    //             // Proses upload file ke server FTP gagal
    //             // Tampilkan pesan error atau lakukan operasi yang sesuai

    //             // Redirect ke halaman lain atau tampilkan pesan error
    //             redirect('upload/error');
    //         }

    //         // Tutup koneksi FTP setelah selesai
    //         $this->ftp->close();
    //     } else {
    //         // Koneksi ke server FTP gagal
    //         // Tampilkan pesan error atau lakukan operasi yang sesuai

    //         // Redirect ke halaman lain atau tampilkan pesan error
    //         redirect('upload/error');
    //     }
    // }
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Auto Deploy To Server
        </h1>

        <!-- Form untuk memilih file -->
        <form action="<?php echo base_url('AutoDeploy/PostUpload'); ?>" method="post" enctype="multipart/form-data"
            onsubmit="return confirmUpload();">
            <div class="form-group">
                <label for="fileToUpload">Pilih File:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="sourceLocation">Source Location:</label>
                <input type="text" name="sourceLocation" id="sourceLocation" class="form-control">
            </div>
            <div class="form-group">
                <label for="fileName">File Name:</label>
                <input type="text" name="fileName" id="fileName" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="fixSourceLocation">Fix Source Location:</label>
                <input type="text" name="fixSourceLocation" id="fixSourceLocation" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="destinationLocation">Destination Location:</label>
                <input type="text" name="destinationLocation" id="destinationLocation" class="form-control"
                    placeholder="/remote/path/">
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </section>
</div>

<script>
    //ketika selesai pilih file
    document.getElementById("fileToUpload").addEventListener("change", function () {
        var fileName = this.files[0].name;
        document.getElementById("fileName").value = fileName;
    });


    document.getElementById("sourceLocation").addEventListener("change", function () {
        var sourceLocation = this.value;
        var fileName = document.getElementById("fileName").value;

        // Fix Source Location
        var fixSourceLocation = sourceLocation + "\\" + fileName;
        document.getElementById("fixSourceLocation").value = fixSourceLocation;


        //destination;

        // Temukan indeks dari string "kostdit\\"
        var startIndex = fixSourceLocation.indexOf("kostdit\\");
        if (startIndex !== -1) { // Pastikan string ditemukan
            // Ambil semua nilai setelah "kostdit\\"
            var destinationLocation = fixSourceLocation.substring(startIndex + 8);
            // Ganti semua "\" dengan "/"
            destinationLocation = "/htdocs/" + destinationLocation.replace(/\\/g, "/");
            document.getElementById("destinationLocation").value = destinationLocation;
        }
    });

    // Fungsi untuk menampilkan pesan konfirmasi
    function confirmUpload() {
        return confirm("Apakah Anda yakin ingin mengunggah file?");
    }
</script>
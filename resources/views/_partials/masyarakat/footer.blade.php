</div>
<!-- End of Main Content -->
<!-- Footer -->
<footer class="sticky-footer bg-gradient-info text-white mt-3">
    <div class="container my-auto">
        <div class="copyright text-center my-auto font-weight-bold">
            <span>&copy; ILHAM SHUBKHI</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
</div>

<!-- Bootstrap core JavaScript-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.1.slim.js"
    integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script> --}}

{{-- <script src="{{ url('assets/admin/js/sweetalert.min.js') }}"></script> --}}
<script src="{{ url('assets/admin/js/7fdd60d3a4.js') }}"></script>
<script src="{{ url('assets/admin/js/jquery-3.6.1.slim.js') }}"></script>
<script src="{{ url('assets/admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ url('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ url('assets/admin/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ url('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('assest/js/demo/datatables-demo.js') }}"></script>

<script>
// DATATABLES
$(document).ready(function () {
    $('#dataTable').DataTable();
});
    // Alert Delete Data
    // function confirmDelete(url) {
    //     const isConfirm = confirm('Apakah Anda yakin ingin MENGHAPUS DATA ini?');
    //     if (!isConfirm) return false;
    //     location.href = url;
    // }

    // Menghitung Detik
    function fixNumClock(num) {
        return num < 10 ? '0' + num : num;
    }

    // Membaca Nama Bulan dengan Alpabhet
    function monthNumToString(num) {
        switch (num) {
            case 1:
                return 'Januari';
            case 2:
                return 'Februari';
            case 3:
                return 'Maret';
            case 4:
                return 'April';
            case 5:
                return 'Mei';
            case 6:
                return 'Juni';
            case 7:
                return 'Juli';
            case 8:
                return 'Agustus';
            case 9:
                return 'September';
            case 10:
                return 'Oktober';
            case 11:
                return 'November';
            case 12:
                return 'Desember';
        }
    }

    function initClock() {
        setInterval(() => {
            const dateInstance = new Date();
            const year = dateInstance.getFullYear();
            const month = monthNumToString((dateInstance.getMonth() < 11 ? dateInstance.getMonth() + 1 :
                dateInstance.getMonth()));
            const date = fixNumClock(dateInstance.getDate());
            const hours = fixNumClock(dateInstance.getHours());
            const minutes = fixNumClock(dateInstance.getMinutes());
            const seconds = fixNumClock(dateInstance.getSeconds());

            const currentDatetime = `${date} ${month} ${year} ${hours}:${minutes}:${seconds} WIB`;
            $('#clock-realtime').html(currentDatetime);
        }, 1000);
    }
    initClock();

    // Preview Tambah Gambar
    $(document).ready(function (e) {
       $('#foto_barang').change(function(){     
        let reader = new FileReader();
        reader.onload = (e) => { 
          $('#preview-image-before-upload').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
       });  
    });

    // Preview Edit Gambar
    $(document).ready(function (e) {
       $('#foto_barang-2').change(function(){     
        let reader = new FileReader();
        reader.onload = (e) => { 
          $('#preview-image-before-upload-2').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
       });  
    });
</script>
</body>
</html>
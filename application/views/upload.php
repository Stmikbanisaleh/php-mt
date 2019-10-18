  <!-- Page -->
  <div class="page">
    
    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Manajemen Pengajuan Paten</h3>
        </div>
        <div class="panel-body container-fluid">
          <div class="row row-lg">
            <div class="col-xl">
            <h2>Multiple Upload</h2>
    <form action="<?php echo base_url().'upload/aksi_upload'?>" method="post" enctype="multipart/form-data">
            <input type="text" name="judul" class="form-control">
            <input type="text" name="no_permohonan" class="form-control">

            <input type="text" name="dokumen[1][NAMA]" class="form-control">

            <input type="hidden" name="jenis1" value="jenis1">

            <?php for ($i=1; $i <=3 ; $i++) :?>
              <input type="file" name="berkas<?php echo $i;?>"><br/>
            <?php endfor;?>

            <?php ?>
       
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Panel Tabs -->
      
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );
} );
</script>
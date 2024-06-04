        <footer class="footer">
            © 2021 DSO Esports
        </footer>
    </div>

    <script>
        var site_url = '<?php echo base_url(); ?>';
    </script>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/waves.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/sidebarmenu.js"></script>

    <script src="<?php echo base_url(); ?>assets/admin/js/datatables/jquery.dataTables.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/admin/js/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/morrisjs/morris.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/dashboard3.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/admin/js/typeahead-init.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/admin/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-simple-upload.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.multi-select.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/custom.js"></script>

    <script src="<?php echo base_url(); ?>assets/admin/js/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }
    </script>
</body>

</html>
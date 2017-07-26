<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add CRUD </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" action="<?php echo base_url().$action ; ?>">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="table_name">Table Name <span
                                    class="required">*</span>
                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="table_name" autocomplete="off" autofocus required id="table_name" class="form-control col-md-7 col-xs-12"><span id="search"></span>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="view_path"> View path<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" required name="view_path" id="view_path" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" id="button" class="btn btn-success"><?php echo $button;?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(function(){

        var typingTimer;
        var doneTypingInterval = 200;

        $('#table_name').keyup(function(){
            clearTimeout(typingTimer);
            if ($('#table_name').val) {
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        });

        function doneTyping () {
            var table_name=$('#table_name').val();
            //alert(branch_code);
            $.ajax({
                type: 'POST',
                url:  '<?php echo base_url();?>create_crud/get_table_name',
                data: {'table_name' : table_name},
                success: function (f) {
                    if (f==1) {
                        $('#search').html("<strong style='color:green'><i class='fa fa-check'></i>  Table name Matched</strong>");
                        $("#button").removeAttr("disabled");
                    } else {
                        $('#search').html("<strong style='color:red'><i class='fa fa-times'></i>  Table name not Matched</strong>");
                        $("#button").attr("disabled", "disabled");
                    }

                }
            });
        }
    });
</script>

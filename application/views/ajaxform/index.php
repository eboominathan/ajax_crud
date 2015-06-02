<script>
function submit_data(){
    var idemp = $("#idemp").val();
    var emp_name = $("#emp_name").val();
    var emp_gender = $("#emp_gender").val();
    var emp_blood = $("#emp_blood").val();
    var emp_phone = $("#emp_phone").val();
    var emp_address = $("#emp_address").val();
    var submit = $("#form_add").attr('action');   

    $.ajax({
        type: "POST",
        url: submit,
        data: {"idemp":idemp,"emp_name":emp_name
                ,"emp_gender":emp_gender,"emp_blood":emp_blood,"emp_phone":emp_phone
                ,"emp_address":emp_address},
        success: function(resp){   
            var obj = jQuery.parseJSON(resp);
            $("#myResponDeptLabel").html(obj.msg);
            if(obj.stat==="1"){
                $('#mod_add_emp').modal('hide');
                location.reload();
            }
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function cancel(){
    $("#idemp").val('');      
    $("#emp_name").val('');
    $("#emp_gender").val('');
    $("#emp_blood").val('');
    $("#emp_phone").val('');
    $("#emp_address").val('');
}

function set_data(idemp){
    $.ajax({
        type: "POST",
        url: "<?=site_url('ajaxform/set_data');?>",
        data: {"idemp":idemp},
        success: function(resp){
            var obj = jQuery.parseJSON(resp);
            $("#idemp").val(obj.idemp);      
            $("#emp_name").val(obj.emp_name);
            $("#emp_gender").val(obj.emp_gender);
            $("#emp_blood").val(obj.emp_blood);
            $("#emp_phone").val(obj.emp_phone);
            $("#emp_address").val(obj.emp_address);

            $('#mod_add_emp').modal({
                backdrop: 'static'
              });
            $('#mod_add_emp').modal('show'); 
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function del_data(idemp){
    var r=confirm("Are you sure to Delete data ?");
    if (r===true)
      {
          $.ajax({
                type: "POST",
                url: "<?=site_url('ajaxform/submit');?>",
                data: {"idemp":idemp,"stat":"hapus"},
                success: function(resp){
                    var obj = jQuery.parseJSON(resp);
                    alert(obj.msg);
                    if(obj.stat==="1"){
                        location.reload();
                    }
                },
                error:function(event, textStatus, errorThrown) {
                    $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
      }
}
</script>

<div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Employee Data</h3>
    </div><!-- /.box-header -->
      <div class="box-body">
          <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td style="width: 10px;">Id</td>
                    <td style="width: 250px;">Name</td>
                    <td style="width: 10px;">Gender</td>
                    <td style="width: 10px;">Blood</td>
                    <td style="width: 75px;">Phone</td>
                    <td>Address</td>
                    <td style="width: 10px;">Edit</td>
                    <td style="width: 10px;">Delete</td>
                </tr>
              </thead>
              <tbody>
                  <?php
                  $i=1;
                    if(!empty($tabel)){
                        foreach ($tabel as $val){
                            echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".$val->emp_name."</td>";
                                echo "<td>".$val->emp_gender."</td>";
                                echo "<td>".$val->emp_blood."</td>";
                                echo "<td>".$val->emp_phone."</td>";
                                echo "<td>".$val->emp_address."</td>";
                                echo "<td><button data-toggle=\"modal\" data-target=\"#mod_add_emp\" data-backdrop=\"static\" "
                                    . " class=\"btn btn-default btn-sm btn-block\" onclick=\"set_data(".$val->idemp.");\">Edit</button></td>";
                                echo "<td><button class=\"btn btn-danger btn-sm btn-block\" onclick=\"del_data(".$val->idemp.");\">Delete</button></td>";
                            echo "</tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button data-toggle="modal" data-target="#mod_add_emp" data-backdrop="static" class="btn btn-primary">Add</button>
        <button class="btn btn-default" onclick="location.reload();">Refresh</button>
    </div>
  </div><!-- /.box -->
  
  <div class="modal fade" id="mod_add_emp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <?php
            $attributes = array('role' => 'form'
                , 'id' => 'form_add', 'name' => 'form_add');
            echo form_open('ajaxform/submit',$attributes); 
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLocationLabel">
              <i class="fa fa-fw fa-user"></i>
              Employee Form
          </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-xs-12">
                    <div id="myResponDeptLabel" class=" animated fadeInDown"></div>
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">  
                    <input type="hidden" id="idemp" name="idemp" />
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="emp_name">Employee Name</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-user"></i>
                            </div>
                            <input type="text" class="form-control" id="emp_name" name="emp_name" 
                                     placeholder="Employee Name" >
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="emp_gender">Gender</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                  <i class="fa fa-fw fa-check"></i>
                              </div>
                                <select class="form-control" id="emp_gender" name="emp_gender">
                                    <option value="Male" selected="selected">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="emp_blood">Blood</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                  <i class="fa fa-fw fa-plus-square"></i>
                              </div>
                                <select class="form-control" id="emp_blood" name="emp_blood">
                                    <option value="A" selected="selected">A</option>
                                    <option value="B" >B</option>
                                    <option value="AB">AB</option>
                                    <option value="O" >O</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="emp_phone">Phone</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" id="emp_phone" name="emp_phone" 
                                     placeholder="Phone" >
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="emp_address">Address</label>
                            <textarea style="resize: vertical;" class="form-control" 
                                    id="emp_address" name="emp_address" 
                                    placeholder="Address"></textarea>
                        </div>
                    </div>
                    
                </div>  
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" onclick="submit_data();">Submit</button>
            <button class="btn btn-default" type="button" data-dismiss="modal" aria-hidden="true" onclick="cancel();">Cancel</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
</div>
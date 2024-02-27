
@extends('layout.home')
@section('title', 'Management Inventory')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

@section('content')
     <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Management Inventory</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Management Inventory</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Management Barang Inventory
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
                
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalManagementInventory">
                  Tambah
                </button>

                <table class="table table-striped mt-4" id="table-inventory">
                    <thead>
                      <tr>
                      <th scope="col">#</th>
                        <th scope="col">No Inventory</th>
                        <th scope="col">ID Product</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </section>
          <!-- /.Left col -->

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- Modal -->
<div class="modal fade" id="modalManagementInventory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title lbl-modal" id="exampleModalLabel">Tambah Inventory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-inventory">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12">
            <label> No Inventory</label>
            <input type="text" class="form-control" name="inventory_number" id="inventory_number" />
          </div>
          <div class="col-md-12">
            <label> Tgl Inventory</label>
            <input type="text" min="1" class="form-control" name="inventory_date" id="inventory_date" />
          </div>
          <div class="col-md-12">
            <label> No Referensi [opt]</label>
            <input type="text" min="1" class="form-control" name="inventory_reference_number" id="inventory_reference_number" />
          </div>
          <div class="col-md-12">
            <label> Note </label>
            <textarea name="inventory_notes" class="form-control" id="inventory_notes"></textarea>
          </div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped mt-4" id="table-detail-inventory"> 
                <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Product</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Aksi</th>
                        <th scope="col"> <button type="button" class="btn btn-sm btn-info" id="btn-add-detail-inv"> <i class="fa fa-plus" aria-hidden="true"></i></button></th>
                      </tr>
                </thead>
                <tbody id="tbody">
                      
                </tbody>
            </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-save">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>

      </form>
    </div>
  </div>
</div>

<script>
    var product_id
    var description
    var qty
    $(document).ready(function () {

        // setup start date
        $('#inventory_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        getInventory()

        // clear form
        $(".btn-add").on("click", function(e){
          e.preventDefault()
          $(".lbl-modal").text("Tambah Inventory")
          $(".btn-save").text("Simpan")
        })

        // form table
        $("#btn-add-detail-inv").on("click", function(e){
            e.preventDefault()
            getProduct()
            let count = $('#table-detail-inventory tr').length
            let row = `<tr><td>`+count+`</td><td><select name=product_id[] class="form-control product_id"><option value=""> Pilih Product</option></select></td> <td><input type="text" name="description" class="form-control description"/></td> <td><input type="number" min="0" name="qty" class="form-control qty" /></td> <td><button type="button" class="btn btn-sm btn-danger delete-row"><i class="fa fa-minus" aria-hidden="true"></i></button> </td> </tr>`
            $('#tbody').append(row);
           
        })

        // remove row form table
        $("#tbody").on("click", '.delete-row',function(e){
            e.preventDefault()
            $(this).parent('td').parent('tr').remove(); 
        })

        // submit form
        $("#frm-inventory").on("submit", function(e){
          e.preventDefault()

          var products = []
          $("#table-detail-inventory tbody tr").each(function(index){
                product_ids = $(this).find('.product_id option:selected').val();
                descriptions = $(this).find('.description').val();
                qtys = $(this).find('.qty').val();
                products.push({product_id : product_ids, description:descriptions, qty:qtys})
          })

          $.ajax({
            type: "POST",
            url: "/inventories/save",
            data: {
              id : $("#id").val(),
              inventory_number : $("#inventory_number").val(),
              inventory_date: $("#inventory_date").val(),
              inventory_reference_number: $("#inventory_reference_number").val(),
              inventory_notes: $("#inventory_notes").val(),
              products : products
            },
            dataType: "JSON",
            success: function (response) {
              if(response.status == 422){
                alert("Mohon Lengkapi form !")
              }
              if(response.status == 200){
                  window.location.href = '/management-inventory'
              }
            }
          });
        })
    });

    function getInventory(){
        $.ajax({
          type: "GET",
          url: "/inventories",
          data: "data",
          dataType: "JSON",
          success: function (response) {
            var data = response.data
            var row = ""
            var number = 1
            var product_id = ""
            var description = ""
            var qty = ""
            $("#table-inventory").find("tr:gt(0)").remove();
            $.each(data, function (i, val) {
                var products = JSON.parse(val.products)
               
                $.each(products, function (idx, value) { 
                    product_id += "Product ID : "+ value.product_id + " , "
                    description += "Desc: "+ value.description + " , "
                    qty += "Quantity : " + value.qty + " , "
                });
                row += "<tr><td>"+ (number++) +"</td> <td>"+val.inventory_number+"</td><td> "+product_id+" </td><td>"+description+"</td><td>"+qty+"</td> <td><button type='button' class='btn btn-sm btn-info' onclick='detailInventory("+val.id+")'> Ubah </button>  </td></tr>"
            });
            $("#table-inventory > tbody:last-child").append(row); 
          }
        });
    }

    function getProduct(){
        $.ajax({
            type: "GET",
            url: "/products",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $(".product_id").html("")
                $.each(data, function (i, val) { 
                     option += "<option value="+val.product_code+"> "+val.product_code+" - "+val.product_name+"  </option>" 
                });
                $(".product_id").append(option)

            }
        });
    }

    function detailInventory(id = null){
      $.ajax({
        type: "GET",
        url: "/inventories/detail",
        data: {
          id : id
        },
        dataType: "JSON",
        success: function (response) {
            var data = response.data
            var products = JSON.parse(data.products)
            //console.log(products)
            if(products != null){
                detailProduct(products)
            }

            $("#id").val(data.id)
            $("#inventory_number").val(data.inventory_number)
            $("#inventory_date").val(data.inventory_date)
            $("#inventory_reference_number").val(data.inventory_reference_number)
            $("#inventory_notes").val(data.inventory_notes)
           
            $(".lbl-modal").text("Ubah Data")
            $(".btn-save").text("Update")

            $("#modalManagementInventory").modal('show');
        }
      });
    }

    function detailProduct(data){
        var tbody = $('#table-detail-inventory tbody');
        let count = 1 
        // Clear existing rows
        tbody.empty();

        // Populate table with received data
        data.forEach(function(item) {
            var row = $('<tr>');
            row.append($('<td>').text(count++));
            row.append($('<td>').text(item.product_id));
            row.append($('<td>').text(item.description));
            row.append($('<td>').text(item.qty));
            row.append($('<td>').html("<input type='checkbox' />"));
            row.append($('<td>').html("<button type='button' class='btn btn-sm btn-danger delete-row'><i class='fa fa-minus' aria-hidden=true'></i></button>"));
            tbody.append(row);
        });
    }

    function deleteInventory(id = null){
      $.confirm({
          title: 'Pesan!',
          content: 'Apa anda yakin menghapus data ini ?',
          buttons: {
              confirm: function () {
                 $.ajax({
                   type: "POST",
                   url: "/inventories/delete",
                   data: {
                     id : id
                   },
                   dataType: "JSON",
                   success: function (response) {
                      if(response.status == 200){
                        $.confirm("Data berhasil dihapus.")
                      }
                      window.location.href = '/management-inventory'
                   }
                 });
              },
              cancel: function () {
              },
          }
      });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

@endsection
@section('pagespecificscripts')
   
@stop
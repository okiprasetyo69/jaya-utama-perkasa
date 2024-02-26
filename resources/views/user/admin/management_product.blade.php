
@extends('layout.home')
@section('title', 'Management Product')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

@section('content')
     <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Management Product Item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Management Product Item</li>
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
                  Management Product Item
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
                
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalManagementProduct">
                  Tambah
                </button>

                <table class="table table-striped mt-4" id="table-product-item">
                    <thead>
                      <tr>
                      <th scope="col">#</th>
                        <th scope="col">ID Kategory</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Nama Product</th>
                        <th scope="col">Action</th>
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
<div class="modal fade" id="modalManagementProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title lbl-modal" id="exampleModalLabel">Tambah Product Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-product-item">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12">
            <label> ID Product</label>
            <input type="text" class="form-control" name="product_code" id="product_code" />
          </div>
          <div class="col-md-12">
            <label> Nama Kategori</label>
            <select name="category_id" class="form-control" id="category_id"> 
                <option value=""> - Pilih Kategori - </option>
            </select>
          </div>
          <div class="col-md-12">
            <label> Nama Product</label>
            <input type="text" min="1" class="form-control" name="product_name" id="product_name" />
          </div>
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

    $(document).ready(function () {

        getProductItem()
        getCategory()

        // celar form
        $(".btn-add").on("click", function(e){
          e.preventDefault()
          $(".lbl-modal").text("Tambah Product Item")
          $(".btn-save").text("Simpan")
          $("#product_code").attr("readonly", false)
          $("#product_code").val("")
          $("#product_name").val("")
          $("#category_id").val()
        })
        // submit form
        $("#frm-product-item").on("submit", function(e){
          e.preventDefault()
          $.ajax({
            type: "POST",
            url: "/product/save",
            data: {
              id : $("#id").val(),
              category_id: $("#category_id option:selected").val(),
              product_name: $("#product_name").val(),
              product_code: $("#product_code").val(),
            },
            dataType: "JSON",
            success: function (response) {
              if(response.status == 422){
                alert("Mohon Lengkapi form !")
              }
              if(response.status == 200){
                  window.location.href = '/management-product'
              }
            }
          });
        })
    });

    function getProductItem(category_code = null, product_name = null){
        $.ajax({
          type: "GET",
          url: "/products",
          data: {
            category_code : category_code,
            product_name : product_name,
          },
          dataType: "JSON",
          success: function (response) {
            var data = response.data
            var row = ""
            var number = 1
            $("#table-product-item").find("tr:gt(0)").remove();
            $.each(data, function (i, val) {
                row += "<tr><td>"+ (number++) +"</td> <td>"+val.categories.category_code+"</td><td> "+val.categories.category_name+" </td><td>"+val.product_name+"</td><td><button type='button' class='btn btn-sm btn-info' onclick='detailProduct("+val.id+")'> Ubah </button> <button class='btn btn-sm btn-danger' onclick='deleteProduct("+val.id+")'> Hapus </td></tr>"
            });
            $("#table-product-item > tbody:last-child").append(row); 
          }
        });
    }

    function getCategory(){
        $.ajax({
          type: "GET",
          url: "/categories",
          data: "data" ,
          dataType: "JSON",
          success: function (response) {
            var data = response.data
            var option = ""
            $("#category_id").html()

            $.each(data, function (i, val) {
                option += "<option value="+val.id+"> "+val.category_code+" - "+val.category_name+" <option>"
            });
            $("#category_id").append(option); 
          }
        });
    }

    function detailProduct(id = null){
      $.ajax({
        type: "GET",
        url: "/product/detail",
        data: {
          id : id
        },
        dataType: "JSON",
        success: function (response) {
            var data = response.data
            $("#id").val(data.id)
            $("#product_code").val(data.product_code)
            $("#product_code").attr("readonly", true)
            $("#category_id option[value="+data.category_id+"]").prop("selected", true)
            $("#product_name").val(data.product_name)

            $(".lbl-modal").text("Ubah Data")
            $(".btn-save").text("Update")

            $("#modalManagementProduct").modal('show');
        }
      });
    }

    function deleteProduct(id = null){
      $.confirm({
          title: 'Pesan!',
          content: 'Apa anda yakin menghapus data ini ?',
          buttons: {
              confirm: function () {
                 $.ajax({
                   type: "POST",
                   url: "/product/delete",
                   data: {
                     id : id
                   },
                   dataType: "JSON",
                   success: function (response) {
                      if(response.status == 200){
                        $.confirm("Data berhasil dihapus.")
                      }
                      window.location.href = '/management-product'
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
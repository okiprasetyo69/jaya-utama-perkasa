
@extends('layout.home')
@section('title', 'Management Kategori')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

@section('content')
     <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Management Kategori</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Management Kategori</li>
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
                  Management Kategori
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
                
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalManagementCategory">
                  Tambah
                </button>

                <table class="table table-striped mt-4" id="table-items">
                    <thead>
                      <tr>
                      <th scope="col">#</th>
                        <th scope="col">ID Kategory</th>
                        <th scope="col">Nama Kategori</th>
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
<div class="modal fade" id="modalManagementCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title lbl-modal" id="exampleModalLabel">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-category">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12">
            <label> ID Category</label>
            <input type="text" class="form-control" name="category_code" id="category_code" />
          </div>
          <div class="col-md-12">
            <label> Nama Kategori</label>
            <input type="text" min="1" class="form-control" name="category_name" id="category_name" />
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

        getCategory()

        // celar form
        $(".btn-add").on("click", function(e){
          e.preventDefault()
          $(".lbl-modal").text("Tambah Kategori")
          $(".btn-save").text("Simpan")
          $("#category_code").attr("readonly", false)
          $("#category_code").val("")
          $("#category_name").val("")
        })
        // submit form
        $("#frm-category").on("submit", function(e){
          e.preventDefault()
          $.ajax({
            type: "POST",
            url: "/categories/save",
            data: {
              id : $("#id").val(),
              category_code: $("#category_code").val(),
              category_name: $("#category_name").val(),
            },
            dataType: "JSON",
            success: function (response) {
              if(response.status == 422){
                alert("Mohon Lengkapi form !")
              }
              if(response.status == 200){
                  window.location.href = '/management-category'
              }
            }
          });
        })
    });

    function getCategory(category_code = null, category_name = null){
        $.ajax({
          type: "GET",
          url: "/categories",
          data: {
            category_code : category_code,
            category_name : category_name,
          },
          dataType: "JSON",
          success: function (response) {
            var data = response.data
            var row = ""
            var number = 1
            $("#table-items").find("tr:gt(0)").remove();
            $.each(data, function (i, val) {
                row += "<tr><td>"+ (number++) +"</td> <td>"+val.category_code+"</td><td> "+val.category_name+" </td><td><button type='button' class='btn btn-sm btn-info' onclick='detailCategory("+val.id+")'> Ubah </button> <button class='btn btn-sm btn-danger' onclick='deleteCategory("+val.id+")'> Hapus </td></tr>"
            });
            $("#table-items > tbody:last-child").append(row); 
          }
        });
    }

    function detailCategory(id = null){
      $.ajax({
        type: "GET",
        url: "/categories/detail",
        data: {
          id : id
        },
        dataType: "JSON",
        success: function (response) {
            var data = response.data
            $("#id").val(data.id)
            $("#category_code").val(data.category_code)
            $("#category_code").attr("readonly", true)
            $("#category_name").val(data.category_name)

            $(".lbl-modal").text("Ubah Data")
            $(".btn-save").text("Update")

            $("#modalManagementCategory").modal('show');
        }
      });
    }

    function deleteCategory(id = null){
      $.confirm({
          title: 'Pesan!',
          content: 'Apa anda yakin menghapus data ini ?',
          buttons: {
              confirm: function () {
                 $.ajax({
                   type: "POST",
                   url: "/categories/delete",
                   data: {
                     id : id
                   },
                   dataType: "JSON",
                   success: function (response) {
                      if(response.status == 200){
                        $.confirm("Data berhasil dihapus.")
                      }
                      window.location.href = '/management-category'
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
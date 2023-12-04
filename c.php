<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <h1 class="my-3">Edit Product</h1>
    <form id="productForm">
      <div id="errors"></div>
      <input type="hidden" id="id" name="id">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <input type="text" id="description" name="description" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="text" id="price" name="price" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="text" id="image" name="image" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      var id = new URLSearchParams(window.location.search).get('edit_id');
      $('#id').val(id);

      $.ajax({
        url: 'services/products/' + id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
          $('#name').val(data.name);
          $('#description').val(data.description);
          $('#price').val(data.price);
          $('#image').val(data.image);
        },
        error: function () {
          alert('Unable to fetch product.');
        }
      });

      $('#productForm').on('submit', function (e) {
        e.preventDefault();

        var id = $('#id').val();
        var name = $('#name').val();
        var description = $('#description').val();
        var price = $('#price').val();
        var image = $('#image').val();

        $.ajax({
          url: 'services/products/' + id,
          type: 'put',
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify({
            name: name,
            description: description,
            price: price,
            image: image
          }),
          success: function (data) {
            if (data.success) {
              location.href = 'a.php';
            } else {
              var errors = $('<div>').addClass('alert alert-danger');
              $.each(data.errors, function (key, error) {
                errors.append($('<p>').text(error));
              });
              $('#errors').html(errors);
            }
          },
          error: function () {
            alert('Unable to update product.');
          }
        });
      });
    });
  </script>
</body>

</html>
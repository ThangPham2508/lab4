<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <h1 class="my-3">Delete Product</h1>
    <form id="productForm">
      <input type="hidden" id="id" name="id">
      <button type="submit" class="btn btn-danger">Confirm Delete</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      var id = new URLSearchParams(window.location.search).get('delete_id');
      $('#id').val(id);

      $('#productForm').on('submit', function (e) {
        e.preventDefault();

        var id = $('#id').val();

        $.ajax({
          url: 'services/products/' + id,
          type: 'delete',
          dataType: 'json',
          success: function (data) {
            if (data.success) {
              location.href = 'a.php';
            } else {
              alert('Unable to delete product.');
            }
          },
          error: function () {
            alert('Unable to delete product.');
          }
        });
      });
    });
  </script>
</body>

</html>
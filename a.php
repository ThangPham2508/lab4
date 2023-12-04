<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read Products</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    <h1 class="my-3">Read Products</h1>
    <form action="b.php" method="GET">
      <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
    <h2 class="my-3">Products</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="productTable">
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $.ajax({
        url: 'services/products',
        type: 'get',
        dataType: 'json',
        success: function (data) {
          $.each(data, function (key, product) {
            var row = $('<tr>');
            row.append($('<td>').text(product.id));
            row.append($('<td>').text(product.name));
            row.append($('<td>').text(product.description));
            row.append($('<td>').text(product.price));
            row.append($('<td>').text(product.image));
            var actions = $('<td>');
            actions.append($('<form>').attr({ method: 'GET', action: 'c.php' })
              .append($('<input>').attr({ type: 'hidden', name: 'edit_id', value: product.id }))
              .append($('<button>').attr({ type: 'submit', name: 'edit_product' }).addClass('btn btn-secondary').text('Edit')));
            actions.append($('<form>').attr({ method: 'GET', action: 'd.php' })
              .append($('<input>').attr({ type: 'hidden', name: 'delete_id', value: product.id }))
              .append($('<button>').attr({ type: 'submit', name: 'delete_product' }).addClass('btn btn-danger').text('Delete')));
            row.append(actions);
            $('#productTable').append(row);
          });
        },
        error: function () {
          alert('Unable to fetch data.');
        }
      });
    });
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <h2 class="m-5">Add product</h2>
  <form id="productForm" class="form-group m-5">
    <div id="errors"></div>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" class="form-control"><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" class="form-control"></textarea><br>

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" class="form-control"><br>

    <label for="image">Image:</label>
    <input type="text" id="image" name="image" class="form-control"><br>

    <input type="submit" value="Add" class="btn btn-primary">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
  <script>
    $(document).ready(function () {
      $('#productForm').on('submit', function (e) {
        e.preventDefault();

        var name = $('#name').val();
        var description = $('#description').val();
        var price = $('#price').val();
        var image = $('#image').val();

        $.ajax({
          url: 'services/products',
          type: 'post',
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
            alert('Unable to add product.');
          }
        });
      });
    });
  </script>
</body>

</html>
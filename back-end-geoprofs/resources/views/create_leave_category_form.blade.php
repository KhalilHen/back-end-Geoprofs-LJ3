<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Leave Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Create Leave Category</h2>
        <form action="/create_leave_category" method="POST">

            @csrf
            <div class="form-group" >
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
       <form action="/leave-category">

       <button  >  Retrieve Category</button> 
       </form>  displayLeaveCategory
    </div>
</body>

</html>
</div>
</body>

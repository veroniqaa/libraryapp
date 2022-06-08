<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit book</title>
</head>

<style>
    body {
        font-size: 22px;
    }
    a {
        text-decoration: none;
        color: blue;
        cursor: pointer;
    }
    .container {
        width: 530px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
    input {
        width: 80px;
    }
    .form-field {
        height: 50px; 
        width: 500px;
    }
    button[type="submit"] {
        font-size: 22px;
        background-color: green;
        color: white;
        width: 100px;
        height: 50px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<?php $book_id = $_GET['id']; ?> 

<body>
    <a href="http://localhost:8000/frontend/">MAIN PAGE</a>
    <div class="container">
        <h1>Edit this book</h1>
        <form onsubmit="return false;">
            <div class="form-field">
                Name: <input type="text" name="name" id="name">
            </div>
            <div class="form-field">
                Publisher: <input type="text" name="publisher" id="publisher">
            </div>
            <div class="form-field">
                Page amount: <input type="number" name="pageAmount" id="pageAmount">
            </div>
            <button type="submit" name="updateBook" id="updateBook">Update</button>
            </br></br>
            <button type="submit" style="background-color: red" name="deleteBook" id="deleteBook">Delete</button>
        </form>
    </div>
</body>

</html>

<script>

    window.onload = function() {
        var data = {
            id: <?= $book_id; ?>
        }
        
        fetch("http://localhost:8000/book/get/", {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-Type":"application/json; charset=UTF-8",
            }
        })
        .then((response) => response.json())
        .then((data) => { 
            var book = JSON.parse(data['message']);
            console.log(book);
            document.getElementById("name").value = book['name'];
            document.getElementById("publisher").value = book['publisher'];
            document.getElementById("pageAmount").value = book['page_amount'];
        })
        .catch((data) => {console.error("ERROR: ", data.message)});

     };

     document.getElementById("updateBook").addEventListener('click', function() {
        var data = {
            id: <?= $book_id; ?>,
            name: document.getElementById("name").value,
            publisher: document.getElementById("publisher").value,
            pageAmount: document.getElementById("pageAmount").value
        }
        
        fetch("http://localhost:8000/book/update/", {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-Type":"application/json; charset=UTF-8",
            }
        })
        .then((response) => response.json())
        .then((data) => { 
            console.log(data);
            if(data.error == false) alert("The book was updated :)");
            else alert("The book cannot be updated :(");
        })
        .catch((data) => {console.error("ERROR: ", data.message)});

        window.location.href = "http://localhost:8000/frontend";
    });
    
    document.getElementById("deleteBook").addEventListener('click', function() {
        var data = {
            id: <?= $book_id; ?>
        }
        
        fetch("http://localhost:8000/book/delete/", {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-Type":"application/json; charset=UTF-8",
            }
        })
        .then((response) => response.json())
        .then((data) => { 
            console.log(data);
            if(data.error == false) alert("The book was deleted :)");
            else alert("The book cannot be deleted :(");
        })
        .catch((data) => {console.error("ERROR: ", data.message)});

        window.location.href = "http://localhost:8000/frontend";

    });

</script>

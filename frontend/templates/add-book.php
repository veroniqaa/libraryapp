<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add new book</title>
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

<body>
    <a href="http://localhost:8000/frontend/">MAIN PAGE</a>
    <div class="container">
        <h1>Add book</h1>
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
            <button type="submit" name="addBook" id="addBook">Add</button>
        </form>
    </div>
</body>

</html>

<script>
    
    document.getElementById("addBook").addEventListener('click', function() {
        var data = {
            name: document.getElementById("name").value,
            publisher: document.getElementById("publisher").value,
            pageAmount: document.getElementById("pageAmount").value
        }
        
        fetch("http://localhost:8000/book/add/", {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-Type":"application/json; charset=UTF-8",
            }
        })
        .then((response) => response.json())
        .then((data) => { 
            if(data.error == false) alert("The book was added :)");
            else alert("The book was not added :(");
        })
        .catch((data) => {console.error("ERROR: ", data.message)});

        window.location.href = "http://localhost:8000/frontend";

    });
</script>


document.getElementById("show-books").addEventListener('click', function() {
 
    fetch("http://localhost:8000/book/show/", {
        method: "GET"
    })
    .then((response) => response.json())
    .then((data) => { 
        var books = JSON.parse(data['message']);
        console.log(books);
        var text = '';
        books.forEach(function(item, index, array) {
            var book = '<a href="http://localhost:8000/frontend/templates/update-book.php?id=' + item[0] + '"> ' + item[1] + '</a> - ' + item[2] + ' -> ' + item[3] + ' pages' + "<br>";
            text = text.concat(book);
        })
        document.getElementById("display-window").innerHTML = text;
    })
    .catch((data) => {console.error("ERROR: ", data.message)});
});
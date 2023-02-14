function toggleForm(id) {
    //show/hide form
    var form = document.getElementById(id);
    form.toggleAttribute("hidden");

    var commentButton = document.getElementById(id + "Btn");
    (commentButton.innerText == "Comment") ? commentButton.innerText = "Hide" :commentButton.innerText = "Comment";
}

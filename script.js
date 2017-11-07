function openList(evt, listname) {
    // Declare all variables
    var i, listContent, listTab;

    // Get all elements with class listContent and hide them
    listContent = document.getElementsByClassName("listContent");
    for (i = 0; i < listContent.length; i++) {
        listContent[i].style.display = "none";
    }

    // Get all elements with class listTab and remove the class "active"
    listTab = document.getElementsByClassName("listTab");
    for (i = 0; i < listTab.length; i++) {
        listTab[i].className = listTab[i].className.replace("active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementsByClassName(listContent).style.display = "block";
    evt.currentTarget.className += "active";
}

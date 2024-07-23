window.onload = function() {
    var popup = document.getElementById('popupMessage');
    popup.style.display = 'block';

    setTimeout(function() {
        popup.style.display = 'none';
    }, 3000);
};

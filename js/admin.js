function openTab(tabName) {
    var i, tabContent;
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";
}

// 1 Запрос
$(document).ready(function() {
    $('#searchForm1').submit(function(e) {
        e.preventDefault();
        var email = $('#email').val();

        $.ajax({
            url: 'php/search1.php',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                $('.tbody-1').html(response);
            }
        });
    });
});

// 2 Запрос
$(document).ready(function() {
    $("#engineer-request").on('change', function() {
        var engineer = $(this).val();
        
        $.ajax({
            method: "POST",
            url: "php/search2.php",
            data: { engineer : engineer },
            success: function(response) {
                $(".tbody-2").html(response);
            }
        });
    });
});

// 5 Запрос
$(document).ready(function() {
    $("#engineer-request-2").on('change', function() {
        var engineer = $(this).val();
        
        $.ajax({
            method: "POST",
            url: "php/search5.php",
            data: { engineer : engineer },
            success: function(response) {
                $(".tbody-5").html(response);
            }
        });
    });
});


// 6 запрос
$(document).ready(function () {
    $('#searchForm6').submit(function (e) {
        e.preventDefault();

        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();

        $.ajax({
            url: 'php/search6.php',
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                $('.tbody-6').html(response);
            },
            error: function () {
                console.log('Ошибка выполнения AJAX запроса');
            }
        });
    });
});

// 7 запрос
$(document).ready(function() {
    $('#searchForm7').submit(function(e) {
        e.preventDefault();
        var component = $('#component1').val();

        $.ajax({
            url: 'php/search7.php',
            type: 'POST',
            data: { component: component },
            success: function(response) {
                $('.tbody-7').html(response);
            }
        });
    });
});

// 10 Запрос
$(document).ready(function() {
    $('#searchForm10').submit(function(e) {
        e.preventDefault();
        var manufacturer = $('#manufacturer1').val();

        $.ajax({
            url: 'php/search10.php',
            type: 'POST',
            data: { manufacturer: manufacturer },
            success: function(response) {
                $('.tbody-10').html(response);
            }
        });
    });
});
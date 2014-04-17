$(document).ready(function(){

    $(".collapse").collapse();
    $('.time-input, .command-preset, .time-menu, .log-preset').tooltip({

    });

    var presets = {
        'yearly' : ['0', '0', '1', '1', '*'],
        'monthly': ['0', '0', '1', '*', '*'],
        'weekly' : ['0', '0', '*', '*', '0'],
        'daily'  : ['0', '0', '*', '*', '*'],
        'hourly' : ['0', '*', '*', '*', '*']
    };

    $('.time-preset').on('click', function(e){
        e.preventDefault();
        var $link = $(this);

        var preset = presets[$link.attr('id')];

        $('#cron_minute').val(preset[0]);
        $('#cron_hour').val(preset[1]);
        $('#cron_dayOfMonth').val(preset[2]);
        $('#cron_month').val(preset[3]);
        $('#cron_dayOfWeek').val(preset[4]);
    });

    $('.command-preset').on('click', function(){
        $('#cron_command').val($(this).attr('value'));
    });

    $('.log-preset').on('click', function(){
        var $button = $(this);

        $button.parent().parent().find('input').val($button.attr('value'));
    });

    $('.modal-link').on('click', function (e) {
        e.preventDefault();
        var $link = $(this);
        $.getJSON($link.attr('href'), function(data){
            var $modal = $('#modal');
            $modal.find('.modal-header h3').text(data.file);
            $modal.find('.modal-body pre').text(data.content);
            $modal.modal({
                backdrop: true,
                keyboard: true
            });
        });
    });
});

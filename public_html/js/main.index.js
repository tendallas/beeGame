var mainIndex = (function() {
    var inited = false, o = {};
    var block;

    function init()
    {
        block = $('.cover');
        block.on('click', '.start-game', function() {
            core.ajax(o.url, {act: 'start'}, function(resp) {
                render(resp);
            });

            return false;
        });

        block.on('click', '.hit', function() {
            core.ajax(o.url, {act: 'hit'}, function(resp) {
                render(resp);
            });

            return false;
        });

        function render(resp)
        {
            if (resp && resp.template) {
                block.fadeOut(500, function() {
                    block.html(resp.template);
                    block.fadeIn(500);
                    if (resp.reload) {
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            }
        }
    }

    return {
        init: function(options)
        {
            if(inited) return; inited = true;
            o = $.extend(o, options || {});
            init();
        }
    };
}());